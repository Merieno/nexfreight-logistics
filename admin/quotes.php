<?php

require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$result = mysqli_query($conn,
    "SELECT * FROM quotes ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Quote Requests</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

<?php include 'includes/sidebar.php'; ?>

<main class="w-full lg:ml-72 mt-24 lg:mt-0 p-4 lg:p-10 overflow-x-hidden">

    <?php include 'includes/topbar.php'; ?>

    <!-- HEADER -->
    <div class="mb-8">

        <h1 class="text-4xl font-bold text-slate-800">
            Quote Requests
        </h1>

        <p class="text-slate-500 mt-2">
            Customer shipping quote inquiries.
        </p>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-200">

                    <tr>

                        <th class="text-left p-5">Name</th>
                        <th class="text-left p-5">Email</th>
                        <th class="text-left p-5">Route</th>
                        <th class="text-left p-5">Weight</th>
                        <th class="text-left p-5">Method</th>
<th class="text-left p-5">Price</th>
<th class="text-left p-5">Status</th>
<th class="text-left p-5">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while($quote = mysqli_fetch_assoc($result)): ?>

                        <tr class="border-t">

                            <td class="p-5 font-semibold">
                                <?= $quote['full_name'] ?>
                            </td>

                            <td class="p-5">
                                <?= $quote['email'] ?>
                            </td>

                            <td class="p-5">
                                <?= $quote['origin_country'] ?>
                                →
                                <?= $quote['destination_country'] ?>
                            </td>

                            <td class="p-5">
                                <?= $quote['cargo_weight'] ?>
                            </td>

                            <td class="p-5">
    <?= $quote['shipping_method'] ?>
</td>

<td class="p-5 font-semibold text-blue-900">

    <?= $quote['price'] ?: 'Not Set' ?>

</td>

<td class="p-5">

    <span class="px-4 py-2 rounded-full text-sm font-semibold
    <?=
        $quote['status'] == 'Approved'
        ? 'bg-green-100 text-green-700'
        : (
            $quote['status'] == 'Rejected'
            ? 'bg-red-100 text-red-700'
            : 'bg-yellow-100 text-yellow-700'
        )
    ?>">

        <?= $quote['status'] ?>

    </span>

</td>

<td class="p-5">

    <a href="edit-quote.php?id=<?= $quote['id'] ?>"
       class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm">

        Manage

    </a>

</td>

                        </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</main>

</body>
</html>