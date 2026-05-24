<?php

require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

/* TOTAL SHIPMENTS */
$totalShipments = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM shipments")
);

/* ACTIVE SHIPMENTS */
$activeShipments = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM shipments
     WHERE shipment_status != 'Delivered'")
);

/* DELIVERED SHIPMENTS */
$deliveredShipments = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM shipments
     WHERE shipment_status='Delivered'")
);
/* RECENT SHIPMENTS */
$recentShipments = mysqli_query($conn,
    "SELECT * FROM shipments
     ORDER BY id DESC
     LIMIT 5");
     /* STATUS ANALYTICS */
$processingCount = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM shipments
     WHERE shipment_status='Processing'")
);

$transitCount = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM shipments
     WHERE shipment_status='In Transit'")
);

$outDeliveryCount = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM shipments
     WHERE shipment_status='Out For Delivery'")
);

$deliveredCount = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM shipments
     WHERE shipment_status='Delivered'")
);
/*
|--------------------------------------------------------------------------
| DELIVERY PERFORMANCE
|--------------------------------------------------------------------------
*/

/* DELAYED SHIPMENTS */
$delayedShipments = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM shipments
     WHERE estimated_delivery < CURDATE()
     AND shipment_status != 'Delivered'")
);

/* ON-TIME DELIVERIES */
$onTimeDeliveries = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM shipments
     WHERE shipment_status='Delivered'")
);

/* SUCCESS RATE */
$successRate = 0;

if ($totalShipments > 0) {

    $successRate = round(
        ($deliveredShipments / $totalShipments) * 100
    );

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>NexFreight Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

    <!-- SIDEBAR -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
   <main class="w-full lg:ml-80 mt-28 lg:mt-0 min-h-screen bg-slate-100 p-5 lg:p-10 overflow-x-hidden">

    <!-- TOPBAR -->
    <?php include 'includes/topbar.php'; ?>

    <!-- HERO -->
    <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-white p-10 lg:p-14 shadow-2xl">

        <!-- GLOW -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/20 blur-3xl rounded-full"></div>

        <div class="relative z-10 grid lg:grid-cols-2 gap-10 items-center">

            <!-- LEFT -->
            <div>

                <div class="inline-flex items-center gap-3 bg-white/10 border border-white/10 px-5 py-3 rounded-full backdrop-blur-xl">

                    <span class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></span>

                    <span class="text-sm text-blue-100">
                        NexFreight Admin Control Center
                    </span>

                </div>

                <h1 class="text-5xl lg:text-6xl font-black leading-tight mt-8">

                    Logistics
                    <span class="text-blue-400">
                        Dashboard
                    </span>

                </h1>

                <p class="text-slate-300 text-lg leading-relaxed mt-8 max-w-2xl">

                    Manage global shipments, customer freight operations,
                    logistics tracking, quote approvals, and delivery analytics
                    from your premium NexFreight control center.

                </p>

                <!-- ACTIONS -->
                <div class="flex flex-wrap gap-4 mt-10">

                    <a href="create-shipment.php"
                       class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-4 rounded-2xl font-semibold transition shadow-2xl shadow-blue-500/30">

                        Create Shipment

                    </a>

                    <a href="shipments.php"
                       class="border border-white/10 bg-white/5 backdrop-blur-xl hover:bg-white/10 px-8 py-4 rounded-2xl font-semibold transition">

                        Manage Shipments

                    </a>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="grid grid-cols-2 gap-5">

                <!-- CARD -->
                <div class="bg-white/10 border border-white/10 backdrop-blur-xl rounded-3xl p-6">

                    <p class="text-slate-300 uppercase text-sm">
                        Total Shipments
                    </p>

                    <h2 class="text-5xl font-black mt-5">
                        <?= $totalShipments ?>
                    </h2>

                </div>

                <!-- CARD -->
                <div class="bg-white/10 border border-white/10 backdrop-blur-xl rounded-3xl p-6">

                    <p class="text-slate-300 uppercase text-sm">
                        Active Shipments
                    </p>

                    <h2 class="text-5xl font-black text-blue-400 mt-5">
                        <?= $activeShipments ?>
                    </h2>

                </div>

                <!-- CARD -->
                <div class="bg-white/10 border border-white/10 backdrop-blur-xl rounded-3xl p-6">

                    <p class="text-slate-300 uppercase text-sm">
                        Delivered
                    </p>

                    <h2 class="text-5xl font-black text-green-400 mt-5">
                        <?= $deliveredShipments ?>
                    </h2>

                </div>

                <!-- CARD -->
                <div class="bg-white/10 border border-white/10 backdrop-blur-xl rounded-3xl p-6">

                    <p class="text-slate-300 uppercase text-sm">
                        In Transit
                    </p>

                    <h2 class="text-5xl font-black text-cyan-400 mt-5">
                        <?= $transitCount ?>
                    </h2>

                </div>

            </div>

        </div>

    </section>


<!-- ANALYTICS + CHARTS -->
<section class="grid grid-cols-1 2xl:grid-cols-3 gap-8 mt-10">
    <!-- LEFT -->
    <div class="2xl:col-span-2">
        <!-- STATUS CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <!-- PROCESSING -->
            <a href="shipments.php?status=Processing"
               class="group block bg-white rounded-3xl shadow-sm p-6 hover:shadow-2xl hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-sm uppercase tracking-wider">
                            Processing
                        </p>
                        <h2 class="text-5xl font-black mt-5 text-yellow-500">
                            <?= $processingCount ?>
                        </h2>
                    </div>
                    <div class="w-20 h-20 rounded-3xl bg-yellow-100 flex items-center justify-center text-4xl group-hover:scale-110 transition">
                        ⏳
                    </div>
                </div>
            </a>
            <!-- IN TRANSIT -->
            <a href="shipments.php?status=In+Transit"
               class="group block bg-white rounded-3xl shadow-sm p-6 hover:shadow-2xl hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-sm uppercase tracking-wider">
                            In Transit
                        </p>
                        <h2 class="text-5xl font-black mt-5 text-blue-700">
                            <?= $transitCount ?>
                        </h2>
                    </div>
                    <div class="w-20 h-20 rounded-3xl bg-blue-100 flex items-center justify-center text-4xl group-hover:scale-110 transition">
                        🚚
                    </div>
                </div>
            </a>
            <!-- OUT FOR DELIVERY -->
            <a href="shipments.php?status=Out+For+Delivery"
               class="group block bg-white rounded-3xl shadow-sm p-6 hover:shadow-2xl hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-sm uppercase tracking-wider">
                            Out For Delivery
                        </p>
                        <h2 class="text-5xl font-black mt-5 text-purple-600">
                            <?= $outDeliveryCount ?>
                        </h2>
                    </div>
                    <div class="w-20 h-20 rounded-3xl bg-purple-100 flex items-center justify-center text-4xl group-hover:scale-110 transition">
                        📦
                    </div>
                </div>
            </a>
            <!-- DELIVERED -->
            <a href="shipments.php?status=Delivered"
               class="group block bg-white rounded-3xl shadow-sm p-6 hover:shadow-2xl hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-sm uppercase tracking-wider">
                            Delivered
                        </p>
                        <h2 class="text-5xl font-black mt-5 text-green-600">
                            <?= $deliveredCount ?>
                        </h2>
                    </div>
                    <div class="w-20 h-20 rounded-3xl bg-green-100 flex items-center justify-center text-4xl group-hover:scale-110 transition">
                        ✅
                    </div>
                </div>
            </a>
        </div>
        <!-- SHIPMENT ANALYTICS -->
        <div class="bg-white rounded-[2rem] shadow-sm p-8 mt-8">
            <div class="flex justify-between items-center flex-wrap gap-5 mb-10">
                <div>
                    <h2 class="text-3xl font-black text-slate-900">
                        Shipment Analytics
                    </h2>
                    <p class="text-slate-500 mt-2">
                        Real-time logistics operations overview.
                    </p>
                </div>
                <div class="bg-slate-100 px-5 py-3 rounded-2xl text-sm font-semibold text-slate-600">
                    Live Status Distribution
                </div>
            </div>
            <!-- CHART -->
            <div class="space-y-8">
                <!-- PROCESSING -->
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="font-semibold text-slate-700">
                            Processing
                        </span>
                        <span class="font-bold text-yellow-500">
                            <?= $processingCount ?>
                        </span>
                    </div>
                    <div class="w-full h-5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="bg-yellow-400 h-full rounded-full"
                             style="width: <?= $totalShipments > 0 ? ($processingCount / $totalShipments) * 100 : 0 ?>%">
                        </div>
                    </div>
                </div>
                <!-- TRANSIT -->
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="font-semibold text-slate-700">
                            In Transit
                        </span>
                        <span class="font-bold text-blue-700">
                            <?= $transitCount ?>
                        </span>
                    </div>
                    <div class="w-full h-5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="bg-blue-600 h-full rounded-full"
                             style="width: <?= $totalShipments > 0 ? ($transitCount / $totalShipments) * 100 : 0 ?>%">
                        </div>
                    </div>
                </div>
                <!-- DELIVERY -->
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="font-semibold text-slate-700">
                            Out For Delivery
                        </span>
                        <span class="font-bold text-purple-600">
                            <?= $outDeliveryCount ?>
                        </span>
                    </div>
                    <div class="w-full h-5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="bg-purple-500 h-full rounded-full"
                             style="width: <?= $totalShipments > 0 ? ($outDeliveryCount / $totalShipments) * 100 : 0 ?>%">
                        </div>
                    </div>
                </div>
                <!-- DELIVERED -->
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="font-semibold text-slate-700">
                            Delivered
                        </span>
                        <span class="font-bold text-green-600">
                            <?= $deliveredCount ?>
                        </span>
                    </div>
                    <div class="w-full h-5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="bg-green-500 h-full rounded-full"
                             style="width: <?= $totalShipments > 0 ? ($deliveredCount / $totalShipments) * 100 : 0 ?>%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- RIGHT SIDE PANEL -->
    <div class="space-y-8">
        <!-- SYSTEM STATUS -->
         <!-- PERFORMANCE -->
<div class="bg-white rounded-[2rem] shadow-sm p-8">

    <div class="flex justify-between items-center">

        <div>

            <h2 class="text-3xl font-black text-slate-900">
                Performance
            </h2>

            <p class="text-slate-500 mt-2">
                Delivery operation metrics.
            </p>

        </div>

        <div class="text-4xl">
            📈
        </div>

    </div>

    <!-- STATS -->
    <div class="space-y-6 mt-10">

        <!-- SUCCESS RATE -->
        <div>

            <div class="flex justify-between mb-3">

                <span class="font-semibold text-slate-700">
                    Success Rate
                </span>

                <span class="font-black text-green-600">
                    <?= $successRate ?>%
                </span>

            </div>

            <div class="w-full h-4 bg-slate-100 rounded-full overflow-hidden">

                <div class="bg-green-500 h-full rounded-full"
                     style="width: <?= $successRate ?>%">

                </div>

            </div>

        </div>

        <!-- ON TIME -->
        <div class="bg-green-50 rounded-2xl p-5">

            <p class="text-green-700 text-sm uppercase">
                On-Time Deliveries
            </p>

            <h3 class="text-4xl font-black text-green-600 mt-3">
                <?= $onTimeDeliveries ?>
            </h3>

        </div>

        <!-- DELAYED -->
        <div class="bg-red-50 rounded-2xl p-5">

            <p class="text-red-700 text-sm uppercase">
                Delayed Shipments
            </p>

            <h3 class="text-4xl font-black text-red-600 mt-3">
                <?= $delayedShipments ?>
            </h3>

        </div>

    </div>

</div>
        <div class="bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-white rounded-[2rem] p-8 shadow-2xl overflow-hidden relative">
            <div class="absolute top-0 right-0 w-72 h-72 bg-blue-500/20 blur-3xl rounded-full"></div>
            <div class="relative z-10">
                <div class="inline-flex items-center gap-3 bg-white/10 px-5 py-3 rounded-full">
                    <span class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></span>
                    <span class="text-sm">
                        System Active
                    </span>
                </div>
                <h2 class="text-4xl font-black mt-8 leading-tight">
                    Logistics
                    Intelligence
                </h2>
                <p class="text-slate-300 mt-6 leading-relaxed">
                    NexFreight shipment infrastructure is actively processing
                    customer freight operations globally.
                </p>
                <div class="grid grid-cols-2 gap-5 mt-10">
                    <div class="bg-white/10 rounded-2xl p-5">
                        <p class="text-slate-300 text-sm">
                            Active
                        </p>
                        <h3 class="text-3xl font-black mt-3">
                            <?= $activeShipments ?>
                        </h3>
                    </div>
                    <div class="bg-white/10 rounded-2xl p-5">
                        <p class="text-slate-300 text-sm">
                            Delivered
                        </p>
                        <h3 class="text-3xl font-black mt-3">
                            <?= $deliveredShipments ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- OPERATIONS -->
        <div class="bg-white rounded-[2rem] shadow-sm p-8">
            <h2 class="text-3xl font-black text-slate-900">
                Operations
            </h2>
            <p class="text-slate-500 mt-3">
                Quick logistics management actions.
            </p>
            <div class="space-y-4 mt-8">
                <a href="create-shipment.php"
                   class="flex items-center justify-between bg-blue-900 text-white px-6 py-5 rounded-2xl hover:bg-blue-800 transition">
                    <span class="font-semibold">
                        Create Shipment
                    </span>
                    <span class="text-2xl">
                        →
                    </span>
                </a>
                <a href="quotes.php"
                   class="flex items-center justify-between bg-slate-100 text-slate-800 px-6 py-5 rounded-2xl hover:bg-slate-200 transition">
                    <span class="font-semibold">
                        Quote Requests
                    </span>
                    <span class="text-2xl">
                        →
                    </span>
                </a>
                <a href="notifications.php"
                   class="flex items-center justify-between bg-slate-100 text-slate-800 px-6 py-5 rounded-2xl hover:bg-slate-200 transition">
                    <span class="font-semibold">
                        Notifications
                    </span>
                    <span class="text-2xl">
                        →
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>

    <!-- QUICK ACTIONS -->
    <section class="bg-white rounded-[2rem] p-8 lg:p-10 shadow-sm mt-10">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

            <div>

                <h2 class="text-3xl font-black text-slate-900">
                    Quick Actions
                </h2>

                <p class="text-slate-500 mt-3">
                    Manage freight operations quickly from the admin dashboard.
                </p>

            </div>

            <div class="flex flex-wrap gap-4">

                <a href="create-shipment.php"
                   class="bg-blue-900 hover:bg-blue-800 text-white px-8 py-4 rounded-2xl font-semibold transition">

                    Create Shipment

                </a>

                <a href="quotes.php"
                   class="bg-slate-200 hover:bg-slate-300 text-slate-900 px-8 py-4 rounded-2xl font-semibold transition">

                    Quote Requests

                </a>

                <a href="shipments.php"
                   class="bg-slate-900 hover:bg-slate-800 text-white px-8 py-4 rounded-2xl font-semibold transition">

                    Manage Shipments

                </a>

            </div>

        </div>

    </section>

  
<!-- RECENT SHIPMENTS -->
<div class="bg-white rounded-3xl shadow-sm p-6 lg:p-8 mt-10">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">
                Recent Shipments
            </h2>
            <p class="text-slate-500 mt-2">
                Latest shipment operations and logistics activity.
            </p>
        </div>
        <a href="shipments.php"
           class="bg-blue-900 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-800 transition text-center">
            View All Shipments
        </a>
    </div>
    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="min-w-[900px] w-full">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="text-left py-5 px-2 text-sm uppercase tracking-wider text-slate-400">
                        Tracking No
                    </th>
                    <th class="text-left py-5 px-2 text-sm uppercase tracking-wider text-slate-400">
                        Receiver
                    </th>
                    <th class="text-left py-5 px-2 text-sm uppercase tracking-wider text-slate-400">
                        Destination
                    </th>
                    <th class="text-left py-5 px-2 text-sm uppercase tracking-wider text-slate-400">
                        Status
                    </th>
                    <th class="text-left py-5 px-2 text-sm uppercase tracking-wider text-slate-400">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php while($shipment = mysqli_fetch_assoc($recentShipments)): ?>
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
                        <td class="py-5 px-2">
                            <a href="view-shipment.php?id=<?= $shipment['id'] ?>"
                               class="font-bold text-blue-900 hover:underline">
                                <?= $shipment['tracking_number'] ?>
                            </a>
                        </td>
                        <!-- RECEIVER -->
                        <td class="py-5 px-2 text-slate-700">
                            <?= $shipment['receiver_name'] ?>
                        </td>
                        <!-- DESTINATION -->
                        <td class="py-5 px-2 text-slate-700">
                            <?= $shipment['destination'] ?>
                        </td>
                        <!-- STATUS -->
                        <td class="py-5 px-2">
                            <span class="<?= $statusClass ?> inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold">
                                <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                                <?= $shipment['shipment_status'] ?>
                            </span>
                        </td>
                        <!-- ACTIONS -->
                        <td class="py-5 px-2">
                            <div class="flex flex-wrap gap-3">
                                <a href="view-shipment.php?id=<?= $shipment['id'] ?>"
                                   class="bg-slate-200 text-slate-800 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-300 transition">
                                    View
                                </a>
                                <a href="edit-shipment.php?id=<?= $shipment['id'] ?>"
                                   class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800 transition">
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>