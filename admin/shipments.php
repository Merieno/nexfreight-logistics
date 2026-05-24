<?php

require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$search = '';
$statusFilter = '';
$limit = 10;

$page = isset($_GET['page'])
    ? (int)$_GET['page']
    : 1;

$start = ($page - 1) * $limit;
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

if (isset($_GET['status'])) {
    $statusFilter = $_GET['status'];
}

$query = "
    SELECT * FROM shipments
    WHERE (

        tracking_number LIKE '%$search%'
        OR sender_name LIKE '%$search%'
        OR receiver_name LIKE '%$search%'
        OR shipment_status LIKE '%$search%'
        OR origin LIKE '%$search%'
        OR destination LIKE '%$search%'
        OR shipping_method LIKE '%$search%'
        OR current_location LIKE '%$search%'

    )
";

/*
|--------------------------------------------------------------------------
| STATUS FILTER
|--------------------------------------------------------------------------
*/

if (!empty($statusFilter)) {

    $query .= " AND shipment_status='$statusFilter'";

}

/*
|--------------------------------------------------------------------------
| ORDER + PAGINATION
|--------------------------------------------------------------------------
*/

$query .= " ORDER BY id DESC LIMIT $start, $limit";

/*
|--------------------------------------------------------------------------
| RESULTS
|--------------------------------------------------------------------------
*/

$result = mysqli_query($conn, $query);
$totalQuery = "
    SELECT * FROM shipments
    WHERE (
        tracking_number LIKE '%$search%'
        OR sender_name LIKE '%$search%'
        OR receiver_name LIKE '%$search%'
        OR shipment_status LIKE '%$search%'
    )
";

if (!empty($statusFilter)) {
    $totalQuery .= " AND shipment_status='$statusFilter'";
}

$totalResult = mysqli_query($conn, $totalQuery);

$totalRows = mysqli_num_rows($totalResult);

$totalPages = ceil($totalRows / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manage Shipments</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

    <?php include 'includes/sidebar.php'; ?>

    

    <!-- CONTENT -->
<main class="w-full lg:ml-72 mt-24 lg:mt-0 p-4 lg:p-10 overflow-x-hidden">

   <?php include 'includes/topbar.php'; ?>

<!-- PAGE HEADER -->
<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-4xl font-bold text-slate-800">
            Manage Shipments
        </h1>

        <p class="text-slate-500 mt-2">
            View and manage all shipment records.
        </p>

    </div>

    <a href="create-shipment.php"
       class="bg-blue-900 text-white px-6 py-4 rounded-xl font-semibold hover:bg-blue-800 transition">

        + Create Shipment

    </a>

</div>

<!-- SEARCH -->
<div class="bg-white rounded-2xl shadow-sm p-6 mb-8">

    <form method="GET"
          class="grid md:grid-cols-3 gap-4">

        <!-- SEARCH INPUT -->
        <input type="text"
               name="search"
               value="<?= $search ?>"
               placeholder="Search by tracking number, sender, receiver or status..."
               class="border border-slate-300 rounded-xl px-5 py-4 focus:outline-none focus:border-blue-700">

        <!-- STATUS FILTER -->
        <select name="status"
                class="border border-slate-300 rounded-xl px-5 py-4 focus:outline-none focus:border-blue-700">

            <option value="">
                All Statuses
            </option>

            <option value="Processing"
                <?= $statusFilter == 'Processing' ? 'selected' : '' ?>>

                Processing

            </option>

            <option value="In Transit"
                <?= $statusFilter == 'In Transit' ? 'selected' : '' ?>>

                In Transit

            </option>

            <option value="Out For Delivery"
                <?= $statusFilter == 'Out For Delivery' ? 'selected' : '' ?>>

                Out For Delivery

            </option>

            <option value="Delivered"
                <?= $statusFilter == 'Delivered' ? 'selected' : '' ?>>

                Delivered

            </option>

        </select>

        <!-- BUTTON -->
        <button type="submit"
                class="bg-blue-900 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-800 transition">

            Search

        </button>

    </form>

</div>
        <!-- SHIPMENTS TABLE -->
<section class="bg-white rounded-[2rem] shadow-sm overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 lg:p-8 border-b border-slate-100">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>

                <h2 class="text-3xl font-black text-slate-900">
                    Shipment Operations
                </h2>

                <p class="text-slate-500 mt-2">
                    Manage freight operations, shipment activity,
                    tracking workflows, and delivery logistics.
                </p>

            </div>

            <!-- COUNTERS -->
            <div class="flex flex-wrap gap-4">

                <div class="bg-slate-100 px-5 py-3 rounded-2xl">

                    <span class="text-slate-500 text-sm">
                        Total Results
                    </span>

                    <h3 class="text-2xl font-black text-slate-900 mt-1">
                        <?= $totalRows ?>
                    </h3>

                </div>

                <div class="bg-blue-100 px-5 py-3 rounded-2xl">

                    <span class="text-blue-700 text-sm">
                        Current Page
                    </span>

                    <h3 class="text-2xl font-black text-blue-900 mt-1">
                        <?= $page ?>
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">

        <table class="min-w-[1200px] w-full">

            <thead class="bg-slate-50 border-b border-slate-100">

                <tr>

                    <th class="text-left p-6 text-xs uppercase tracking-wider text-slate-400">
                        Tracking
                    </th>

                    <th class="text-left p-6 text-xs uppercase tracking-wider text-slate-400">
                        Customer
                    </th>

                    <th class="text-left p-6 text-xs uppercase tracking-wider text-slate-400">
                        Route
                    </th>

                    <th class="text-left p-6 text-xs uppercase tracking-wider text-slate-400">
                        Shipping
                    </th>

                    <th class="text-left p-6 text-xs uppercase tracking-wider text-slate-400">
                        Status
                    </th>

                    <th class="text-left p-6 text-xs uppercase tracking-wider text-slate-400">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody>

                <?php if(mysqli_num_rows($result) > 0): ?>

                    <?php while($shipment = mysqli_fetch_assoc($result)): ?>

                        <?php

                        $statusClass = 'bg-slate-100 text-slate-700';

                        if ($shipment['shipment_status'] == 'Processing') {
                            $statusClass = 'bg-yellow-100 text-yellow-700';
                        }
                        elseif ($shipment['shipment_status'] == 'In Transit') {
                            $statusClass = 'bg-blue-100 text-blue-700';
                        }
                        elseif ($shipment['shipment_status'] == 'Out For Delivery') {
                            $statusClass = 'bg-purple-100 text-purple-700';
                        }
                        elseif ($shipment['shipment_status'] == 'Delivered') {
                            $statusClass = 'bg-green-100 text-green-700';
                        }

                        ?>

                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                            <!-- TRACKING -->
                            <td class="p-6">

                                <a href="view-shipment.php?id=<?= $shipment['id'] ?>"
                                   class="font-black text-blue-900 hover:underline text-lg">

                                    <?= $shipment['tracking_number'] ?>

                                </a>

                                <p class="text-slate-400 text-sm mt-2">
                                    <?= $shipment['current_location'] ?>
                                </p>

                            </td>

                            <!-- CUSTOMER -->
                            <td class="p-6">

                                <h3 class="font-bold text-slate-900">

                                    <?= $shipment['receiver_name'] ?>

                                </h3>

                                <p class="text-slate-500 text-sm mt-2">

                                    <?= $shipment['receiver_email'] ?>

                                </p>

                            </td>

                            <!-- ROUTE -->
                            <td class="p-6">

                                <div class="space-y-3">

                                    <div>

                                        <span class="text-slate-400 text-xs uppercase">
                                            Origin
                                        </span>

                                        <p class="font-semibold text-slate-800 mt-1">
                                            <?= $shipment['origin'] ?>
                                        </p>

                                    </div>

                                    <div>

                                        <span class="text-slate-400 text-xs uppercase">
                                            Destination
                                        </span>

                                        <p class="font-semibold text-slate-800 mt-1">
                                            <?= $shipment['destination'] ?>
                                        </p>

                                    </div>

                                </div>

                            </td>

                            <!-- SHIPPING -->
                            <td class="p-6">

                                <div class="bg-slate-100 inline-flex px-4 py-2 rounded-full text-sm font-semibold text-slate-700">

                                    <?= $shipment['shipping_method'] ?>

                                </div>

                            </td>

                            <!-- STATUS -->
                            <td class="p-6">

                                <span class="<?= $statusClass ?> inline-flex items-center gap-2 px-5 py-3 rounded-full text-sm font-semibold">

                                    <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>

                                    <?= $shipment['shipment_status'] ?>

                                </span>

                            </td>

                            <!-- ACTIONS -->
                            <td class="p-6">

                                <div class="flex flex-wrap gap-3">

                                    <!-- VIEW -->
                                    <a href="view-shipment.php?id=<?= $shipment['id'] ?>"
                                       class="bg-slate-900 text-white px-5 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 transition">

                                        View

                                    </a>

                                    <!-- EDIT -->
                                    <a href="edit-shipment.php?id=<?= $shipment['id'] ?>"
                                       class="bg-blue-900 text-white px-5 py-3 rounded-xl text-sm font-semibold hover:bg-blue-800 transition">

                                        Edit

                                    </a>

                                    <!-- TIMELINE -->
                                    <a href="add-history.php?shipment_id=<?= $shipment['id'] ?>"
                                       class="bg-green-600 text-white px-5 py-3 rounded-xl text-sm font-semibold hover:bg-green-700 transition">

                                        Timeline

                                    </a>

                                    <!-- PDF -->
                                    <a href="export-pdf.php?id=<?= $shipment['id'] ?>"
                                       class="bg-black text-white px-5 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 transition">

                                        PDF

                                    </a>

                                </div>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <!-- EMPTY -->
                    <tr>

                        <td colspan="6" class="p-20 text-center">

                            <div class="max-w-xl mx-auto">

                                <div class="text-7xl mb-6">
                                    📦
                                </div>

                                <h2 class="text-4xl font-black text-slate-900">
                                    No Shipments Found
                                </h2>

                                <p class="text-slate-500 mt-6 text-lg leading-relaxed">

                                    No shipment records matched your current
                                    search or filter criteria.

                                </p>

                            </div>

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->
    <div class="p-6 lg:p-8 border-t border-slate-100">

        <div class="flex flex-wrap gap-3">

            <?php for($i = 1; $i <= $totalPages; $i++): ?>

                <a href="?page=<?= $i ?>&search=<?= $search ?>&status=<?= $statusFilter ?>"
                   class="px-5 py-3 rounded-2xl font-semibold transition
                   <?= $page == $i
                       ? 'bg-blue-900 text-white'
                       : 'bg-slate-100 text-slate-700 hover:bg-slate-200' ?>">

                    <?= $i ?>

                </a>

            <?php endfor; ?>

        </div>

    </div>

</section>
    </main>

</body>
</html>