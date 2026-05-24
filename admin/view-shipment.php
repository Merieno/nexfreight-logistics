<?php

require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {

    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($conn,
    "SELECT * FROM shipments
     WHERE id='$id'");

$shipment = mysqli_fetch_assoc($query);

if (!$shipment) {

    die("Shipment not found.");
}

/*
|--------------------------------------------------------------------------
| SHIPMENT HISTORY
|--------------------------------------------------------------------------
*/

$historyQuery = mysqli_query($conn,
    "SELECT * FROM shipment_history
     WHERE shipment_id='{$shipment['id']}'
     ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>View Shipment</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</head>

<body class="bg-slate-100">

<!-- SIDEBAR -->
<?php include 'includes/sidebar.php'; ?>

<!-- MAIN -->
<main class="w-full lg:ml-80 min-h-screen p-5 lg:p-10 mt-28 lg:mt-0">

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
                        Live Shipment Monitoring
                    </span>

                </div>

                <h1 class="text-5xl lg:text-6xl font-black leading-tight mt-8">

                    <?= $shipment['tracking_number'] ?>

                </h1>

                <p class="text-slate-300 text-lg leading-relaxed mt-8 max-w-2xl">

                    Shipment management overview, customer delivery
                    activity, shipment timeline, logistics tracking,
                    and operational controls.

                </p>

                <!-- BUTTONS -->
                <div class="flex flex-wrap gap-4 mt-10">

                    <a href="edit-shipment.php?id=<?= $shipment['id'] ?>"
                       class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-4 rounded-2xl font-semibold transition shadow-2xl shadow-blue-500/30">

                        Edit Shipment

                    </a>

                    <a href="add-history.php?shipment_id=<?= $shipment['id'] ?>"
                       class="border border-white/10 bg-white/5 backdrop-blur-xl hover:bg-white/10 px-8 py-4 rounded-2xl font-semibold transition">

                        Add Timeline

                    </a>

                </div>

            </div>

            <!-- STATUS CARD -->
            <div class="bg-white/10 border border-white/10 backdrop-blur-2xl rounded-[2rem] p-8 shadow-2xl">

                <p class="text-slate-300 uppercase tracking-wider text-sm">
                    Shipment Status
                </p>

                <div class="flex items-center gap-4 mt-6">

                    <span class="w-4 h-4 bg-green-400 rounded-full animate-pulse"></span>

                    <h2 class="text-4xl font-black">

                        <?= $shipment['shipment_status'] ?>
<?php

$progress = 25;

if ($shipment['shipment_status'] == 'Processing') {
    $progress = 25;
}
elseif ($shipment['shipment_status'] == 'In Transit') {
    $progress = 60;
}
elseif ($shipment['shipment_status'] == 'Out For Delivery') {
    $progress = 85;
}
elseif ($shipment['shipment_status'] == 'Delivered') {
    $progress = 100;
}

?>

<div class="mt-8">

    <div class="flex justify-between text-sm text-slate-300 mb-3">

        <span>Shipment Progress</span>

        <span><?= $progress ?>%</span>

    </div>

    <div class="w-full h-4 bg-white/10 rounded-full overflow-hidden">

        <div class="bg-gradient-to-r from-blue-400 to-cyan-400 h-full rounded-full"
             style="width: <?= $progress ?>%">

        </div>

    </div>

</div>

<!-- DELIVERY STAGES -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-10">

    <div class="<?= $progress >= 25 ? 'bg-blue-600 text-white' : 'bg-white/10 text-slate-300' ?> rounded-2xl p-3 text-center text-sm font-semibold">

        Processing

    </div>

    <div class="<?= $progress >= 60 ? 'bg-blue-600 text-white' : 'bg-white/10 text-slate-300' ?> rounded-2xl p-3 text-center text-sm font-semibold">

        In Transit

    </div>

    <div class="<?= $progress >= 85 ? 'bg-blue-600 text-white' : 'bg-white/10 text-slate-300' ?> rounded-2xl p-3 text-center text-sm font-semibold">

        Out For Delivery

    </div>

    <div class="<?= $progress >= 100 ? 'bg-green-600 text-white' : 'bg-white/10 text-slate-300' ?> rounded-2xl p-3 text-center text-sm font-semibold">

        Delivered

    </div>

</div>
                    </h2>

                </div>

                <div class="grid grid-cols-2 gap-6 mt-10">

                    <div>

                        <p class="text-slate-400 text-sm">
                            Origin
                        </p>

                        <h3 class="text-xl font-bold mt-2">
                            <?= $shipment['origin'] ?>
                        </h3>

                    </div>

                    <div>

                        <p class="text-slate-400 text-sm">
                            Destination
                        </p>

                        <h3 class="text-xl font-bold mt-2">
                            <?= $shipment['destination'] ?>
                        </h3>

                    </div>

                    <div>

                        <p class="text-slate-400 text-sm">
                            Current Location
                        </p>

                        <h3 class="text-xl font-bold mt-2">
                            <?= $shipment['current_location'] ?>
                        </h3>

                    </div>

                    <div>

                        <p class="text-slate-400 text-sm">
                            Shipping Method
                        </p>

                        <h3 class="text-xl font-bold mt-2">
                            <?= $shipment['shipping_method'] ?>
                        </h3>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- GRID -->
    <section class="grid grid-cols-1 xl:grid-cols-3 gap-8 mt-10">

        <!-- CUSTOMER DETAILS -->
        <div class="bg-white rounded-[2rem] shadow-sm p-8">

            <h2 class="text-3xl font-black text-slate-900 mb-8">
                Customer Details
            </h2>

            <div class="space-y-6">

                <div>

                    <p class="text-slate-400 text-sm">
                        Sender Name
                    </p>

                    <h3 class="text-xl font-bold mt-2">
                        <?= $shipment['sender_name'] ?>
                    </h3>

                </div>

                <div>

                    <p class="text-slate-400 text-sm">
                        Receiver Name
                    </p>

                    <h3 class="text-xl font-bold mt-2">
                        <?= $shipment['receiver_name'] ?>
                    </h3>

                </div>

                <div>

                    <p class="text-slate-400 text-sm">
                        Receiver Email
                    </p>

                    <h3 class="text-lg font-semibold mt-2 break-all">
                        <?= $shipment['receiver_email'] ?>
                    </h3>

                </div>

                <div>

                    <p class="text-slate-400 text-sm">
                        Estimated Delivery
                    </p>

                    <h3 class="text-xl font-bold mt-2">
                        <?= $shipment['estimated_delivery'] ?>
                    </h3>

                </div>

            </div>

        </div>

        <!-- LIVE MAP -->
        <div class="xl:col-span-2 bg-white rounded-[2rem] shadow-sm overflow-hidden">

            <div class="p-8 border-b border-slate-100">

                <h2 class="text-3xl font-black text-slate-900">
                    Live Shipment Map
                </h2>

                <p class="text-slate-500 mt-2">
                    Real-time shipment tracking location.
                </p>

            </div>

            <div id="map" class="w-full h-[500px]"></div>

        </div>

    </section>

    <!-- TIMELINE -->
    <section class="bg-white rounded-[2rem] shadow-sm p-8 lg:p-10 mt-10">

        <h2 class="text-3xl font-black text-slate-900 mb-10">
            Shipment Timeline
        </h2>

        <div class="space-y-6">

            <?php while($history = mysqli_fetch_assoc($historyQuery)): ?>

                <div class="flex gap-5">

                    <!-- ICON -->
                    <div class="w-16 h-16 rounded-3xl bg-blue-900 text-white flex items-center justify-center text-2xl flex-shrink-0">

                        ✓

                    </div>

                    <!-- CONTENT -->
                    <div class="bg-slate-50 rounded-3xl p-6 flex-1">

                        <div class="flex justify-between items-center flex-wrap gap-5">

                            <h3 class="text-2xl font-bold text-slate-900">

                                <?= $history['status_title'] ?>

                            </h3>

                            <span class="text-slate-400 text-sm">

                                <?= date("M d, Y h:i A", strtotime($history['created_at'])) ?>

                            </span>

                        </div>

                        <p class="text-slate-600 leading-relaxed mt-4 text-lg">

                            <?= $history['status_description'] ?>

                        </p>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    </section>

</main>

<script>

const latitude = <?= $shipment['latitude'] ?: 6.5244 ?>;
const longitude = <?= $shipment['longitude'] ?: 3.3792 ?>;

const map = L.map('map').setView([latitude, longitude], 5);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {

    attribution: '&copy; OpenStreetMap contributors'

}).addTo(map);

L.marker([latitude, longitude])
.addTo(map)
.bindPopup(`
    <strong><?= $shipment['tracking_number'] ?></strong><br>
    <?= $shipment['current_location'] ?>
`)
.openPopup();

</script>

</body>
</html>