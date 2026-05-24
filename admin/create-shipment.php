<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/db.php';
require_once '../config/countries.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$message = '';
$generatedTracking = 'NXF' . rand(100000, 999999);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tracking_number = $_POST['tracking_number'];
    $sender_name = $_POST['sender_name'];
    $receiver_name = $_POST['receiver_name'];
$receiver_email = $_POST['receiver_email'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];

    $shipping_method = $_POST['shipping_method'];

    $shipment_status = $_POST['shipment_status'];

    $current_location = $_POST['current_location'];

    $estimated_delivery = $_POST['estimated_delivery'];
/*
|--------------------------------------------------------------------------
| AUTO MAP COORDINATES
|--------------------------------------------------------------------------
*/

$origin_lat = $countries[$origin]['lat'] ?? 0;
$origin_lng = $countries[$origin]['lng'] ?? 0;

$destination_lat = $countries[$destination]['lat'] ?? 0;
$destination_lng = $countries[$destination]['lng'] ?? 0;

$latitude = $countries[$current_location]['lat'] ?? 0;
$longitude = $countries[$current_location]['lng'] ?? 0;
    $shipment_date = $_POST['shipment_date'];

    $query = "INSERT INTO shipments (
        tracking_number,
sender_name,
receiver_name,
receiver_email,
origin,
destination,
shipping_method,
shipment_status,
current_location,
estimated_delivery,
shipment_date,
latitude,
longitude,
origin_lat,
origin_lng,
destination_lat,
destination_lng
    ) VALUES (
        '$tracking_number',
'$sender_name',
'$receiver_name',
'$receiver_email',
'$origin',
'$destination',
'$shipping_method',
'$shipment_status',
'$current_location',
'$estimated_delivery',
'$shipment_date',
'$latitude',
'$longitude',
'$origin_lat',
'$origin_lng',
'$destination_lat',
'$destination_lng'
    )";

    if (mysqli_query($conn, $query)) {

    require_once '../config/mail.php';

    $subject = "Shipment Created - NexFreight";

    $messageEmail = "
    <h2>NexFreight Shipment Confirmation</h2>

    <p>Your shipment has been created successfully.</p>

    <p>
    <strong>Tracking Number:</strong>
    $tracking_number
    </p>

    <p>
    You can now track your shipment using NexFreight tracking services.
    </p>

    <p>
    Thank you for choosing NexFreight Logistics.
    </p>
    ";

    sendShipmentEmail(
        $receiver_email,
        $subject,
        $messageEmail
    );
$notifyTitle = "New Shipment Created";

$notifyMessage = "Shipment {$tracking_number} was created for {$receiver_name}.";

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
    $message = "Shipment created successfully";

} else {

    $message = "Something went wrong";

}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Create Shipment</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

    <?php include 'includes/sidebar.php'; ?>

    

    <!-- FORM -->
  <main class="w-full lg:ml-72 mt-24 lg:mt-0 p-4 lg:p-10 overflow-x-hidden">

    <?php include 'includes/topbar.php'; ?>

    <div class="max-w-5xl">

        <div class="bg-white rounded-2xl shadow-sm p-10">

            <?php if($message): ?>

                <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                    <?= $message ?>
                </div>

            <?php endif; ?>

            <form method="POST"
                  class="grid md:grid-cols-2 gap-6">

                <div>

                    <label class="block mb-2 font-medium">
                        Tracking Number
                    </label>

                    <input type="text"
       name="tracking_number"
       value="<?= $generatedTracking ?>"
       readonly
       class="w-full border border-slate-300 rounded-xl px-5 py-4 bg-slate-100 font-semibold">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Sender Name
                    </label>

                    <input type="text"
                           name="sender_name"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Receiver Name
                    </label>

                    <input type="text"
                           name="receiver_name"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>
<div>

    <label class="block mb-2 font-medium">
        Receiver Email
    </label>

    <input type="email"
           name="receiver_email"
           required
           class="w-full border border-slate-300 rounded-xl px-5 py-4">

</div>
                <div>

                    <label class="block mb-2 font-medium">
                        Origin
                    </label>

                    <input type="text"
                           name="origin"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Destination
                    </label>

                    <input type="text"
                           name="destination"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Shipping Method
                    </label>

                    <input type="text"
                           name="shipping_method"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Shipment Status
                    </label>

                    <input type="text"
                           name="shipment_status"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Current Location
                    </label>

                    <input type="text"
                           name="current_location"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Shipment Date
                    </label>

                    <input type="date"
                           name="shipment_date"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Estimated Delivery
                    </label>

                    <input type="date"
                           name="estimated_delivery"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div class="md:col-span-2">

                    <button type="submit"
                            class="bg-blue-900 text-white px-8 py-4 rounded-xl font-semibold">

                        Create Shipment

                    </button>

                </div>

            </form>

        </div>
</div>
    </main>

</body>
</html>