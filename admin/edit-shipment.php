<?php

require_once '../config/db.php';
require_once '../config/countries.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($conn,
    "SELECT * FROM shipments WHERE id='$id'");

$shipment = mysqli_fetch_assoc($query);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $shipment_status = $_POST['shipment_status'];
    $current_location = $_POST['current_location'];
    $estimated_delivery = $_POST['estimated_delivery'];

    // AUTO MAP COORDINATES
    $locationKey = strtolower(trim($current_location));

    if (isset($countries[$locationKey])) {

        $current_lat = $countries[$locationKey]['lat'];
        $current_lng = $countries[$locationKey]['lng'];

    } else {

        // DEFAULT FALLBACK
        $current_lat = 6.5244;
        $current_lng = 3.3792;
    }

    $update = mysqli_query($conn,
        "UPDATE shipments SET

        shipment_status='$shipment_status',
        current_location='$current_location',
        estimated_delivery='$estimated_delivery',

        current_lat='$current_lat',
        current_lng='$current_lng'

        WHERE id='$id'");

    if ($update) {

    /*
    |--------------------------------------------------------------------------
    | EMAIL UPDATE
    |--------------------------------------------------------------------------
    */

    require_once '../config/mail.php';

    $receiver_email = $shipment['receiver_email'];

    $tracking_number = $shipment['tracking_number'];

    $subject = "Shipment Update - NexFreight";

    $emailMessage = "

    <h2>NexFreight Shipment Update</h2>

    <p>Your shipment status has been updated.</p>

    <p>
    <strong>Tracking Number:</strong>
    {$tracking_number}
    </p>

    <p>
    <strong>Current Status:</strong>
    {$shipment_status}
    </p>

    <p>
    <strong>Current Location:</strong>
    {$current_location}
    </p>

    <p>
    <strong>Estimated Delivery:</strong>
    {$estimated_delivery}
    </p>

    <p>
    Track your shipment anytime using NexFreight tracking services.
    </p>

    ";

    sendShipmentEmail(
        $receiver_email,
        $subject,
        $emailMessage
    );
$statusTitle = $shipment_status;

$statusDescription = "Shipment status updated to {$shipment_status} at {$current_location}.";

mysqli_query($conn,
    "INSERT INTO shipment_history (
        shipment_id,
        status_title,
        status_description
    ) VALUES (
        '{$shipment['id']}',
        '$statusTitle',
        '$statusDescription'
    )");
    /*
    |--------------------------------------------------------------------------
    | ADMIN NOTIFICATION
    |--------------------------------------------------------------------------
    */

    $notifyTitle = "Shipment Updated";

    $notifyMessage = "Shipment {$tracking_number} status updated to {$shipment_status}.";

    mysqli_query($conn,
        "INSERT INTO notifications (
            title,
            message,
            type
        ) VALUES (
            '$notifyTitle',
            '$notifyMessage',
            'shipment'
        )");

    /*
    |--------------------------------------------------------------------------
    | SUCCESS MESSAGE
    |--------------------------------------------------------------------------
    */

    $message = "Shipment updated successfully";

    /*
    |--------------------------------------------------------------------------
    | REFRESH SHIPMENT
    |--------------------------------------------------------------------------
    */

    $query = mysqli_query($conn,
        "SELECT * FROM shipments WHERE id='$id'");

    $shipment = mysqli_fetch_assoc($query);

}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Shipment</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

    <?php include 'includes/sidebar.php'; ?>



<main class="w-full lg:ml-72 mt-24 lg:mt-0 p-4 lg:p-10 overflow-x-hidden">

    <?php include 'includes/topbar.php'; ?>

    <!-- PAGE HEADER -->
    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-4xl font-bold text-slate-800">
                Edit Shipment
            </h1>

            <p class="text-slate-500 mt-2">
                Update shipment status and delivery information.
            </p>

        </div>

        <a href="shipments.php"
           class="bg-slate-200 px-6 py-4 rounded-xl font-semibold hover:bg-slate-300 transition">

            Back

        </a>

    </div>

    <div class="max-w-3xl">

    <div class="bg-white rounded-2xl shadow-sm p-10">

        <?php if($message): ?>

            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                <?= $message ?>
            </div>

        <?php endif; ?>

        <form method="POST" class="space-y-6">

            <div>

                <label class="block mb-2 font-medium">
                    Shipment Status
                </label>

                <select name="shipment_status"
        class="w-full border border-slate-300 rounded-xl px-5 py-4">

    <option value="Processing"
        <?= $shipment['shipment_status'] == 'Processing' ? 'selected' : '' ?>>
        Processing
    </option>

    <option value="In Transit"
        <?= $shipment['shipment_status'] == 'In Transit' ? 'selected' : '' ?>>
        In Transit
    </option>

    <option value="Out For Delivery"
        <?= $shipment['shipment_status'] == 'Out For Delivery' ? 'selected' : '' ?>>
        Out For Delivery
    </option>

    <option value="Delivered"
        <?= $shipment['shipment_status'] == 'Delivered' ? 'selected' : '' ?>>
        Delivered
    </option>

</select>

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Current Location
                </label>

                <input type="text"
                       name="current_location"
                       value="<?= $shipment['current_location'] ?>"
                       class="w-full border border-slate-300 rounded-xl px-5 py-4">

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Estimated Delivery
                </label>

                <input type="date"
                       name="estimated_delivery"
                       value="<?= $shipment['estimated_delivery'] ?>"
                       class="w-full border border-slate-300 rounded-xl px-5 py-4">

            </div>

            <button type="submit"
                    class="bg-blue-900 text-white px-8 py-4 rounded-xl font-semibold">

                Update Shipment

            </button>

        </form>

    </div>
</div>
</main>

</body>
</html>