<?php

require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$shipment_id = $_GET['shipment_id'];

$query = mysqli_query($conn,
    "SELECT * FROM shipments WHERE id='$shipment_id'");

$shipment = mysqli_fetch_assoc($query);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $status_title = $_POST['status_title'];
    $status_description = $_POST['status_description'];

    $insert = mysqli_query($conn,
        "INSERT INTO shipment_history (
            shipment_id,
            status_title,
            status_description
        ) VALUES (
            '$shipment_id',
            '$status_title',
            '$status_description'
        )");

    if ($insert) {
        $message = "Timeline update added successfully";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Add Timeline Update</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

    <?php include 'includes/sidebar.php'; ?>

    <main class="w-full lg:ml-72 mt-24 lg:mt-0 p-4 lg:p-10 overflow-x-hidden">

        <?php include 'includes/topbar.php'; ?>

        <div class="flex justify-between items-center mb-8">

            <div>

                <h1 class="text-4xl font-bold text-slate-800">
                    Shipment Timeline Update
                </h1>

                <p class="text-slate-500 mt-2">
                    <?= $shipment['tracking_number'] ?>
                </p>

            </div>

            <a href="shipments.php"
               class="bg-slate-200 px-6 py-4 rounded-xl font-semibold">

                Back

            </a>

        </div>

        <div class="bg-white rounded-2xl shadow-sm p-10 max-w-3xl">

            <?php if($message): ?>

                <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                    <?= $message ?>
                </div>

            <?php endif; ?>

            <form method="POST" class="space-y-6">

                <div>

                    <label class="block mb-2 font-medium">
                        Status Title
                    </label>

                    <input type="text"
                           name="status_title"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Status Description
                    </label>

                    <textarea name="status_description"
                              rows="5"
                              required
                              class="w-full border border-slate-300 rounded-xl px-5 py-4"></textarea>

                </div>

                <button type="submit"
                        class="bg-blue-900 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-800 transition">

                    Add Timeline Update

                </button>

            </form>

        </div>

    </main>

</body>
</html>