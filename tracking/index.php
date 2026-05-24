<?php

require_once '../config/db.php';

include '../includes/header.php';

$shipment = null;

if (isset($_GET['tracking'])) {

    $tracking = $_GET['tracking'];

    $query = mysqli_query($conn,
        "SELECT * FROM shipments
         WHERE tracking_number='$tracking'");

    $shipment = mysqli_fetch_assoc($query);
    $history = [];

if ($shipment) {

    $historyQuery = mysqli_query($conn,
        "SELECT * FROM shipment_history
         WHERE shipment_id='{$shipment['id']}'
         ORDER BY created_at DESC");

    while($row = mysqli_fetch_assoc($historyQuery)) {
        $history[] = $row;
    }
}
}

?>

<!-- PREMIUM HERO -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-white">

    <!-- GLOW -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-blue-600/20 blur-3xl rounded-full"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-500/20 blur-3xl rounded-full"></div>

    <div class="relative max-w-7xl mx-auto px-6 py-28 text-center">

        <!-- BADGE -->
        <div class="inline-flex items-center gap-3 bg-white/10 border border-white/10 backdrop-blur-xl px-5 py-3 rounded-full">

            <span class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></span>

            <span class="text-sm tracking-wide text-blue-100">
                Real-Time Shipment Tracking
            </span>

        </div>

        <!-- TITLE -->
        <h1 class="text-5xl md:text-7xl font-black leading-tight mt-8">

            Track Shipments
            <span class="text-blue-400">
                Anywhere
            </span>
            In The World

        </h1>

        <!-- DESCRIPTION -->
        <p class="max-w-3xl mx-auto mt-8 text-xl text-slate-300 leading-relaxed">

            Monitor cargo movement in real-time with NexFreight’s
            intelligent shipment tracking infrastructure.

        </p>

    </div>

</section>

<!-- TRACKING -->
<section class="py-24 bg-slate-50">

    <div class="max-w-5xl mx-auto px-6">

        <!-- FORM -->
        <div class="bg-white/80 backdrop-blur-xl border border-white rounded-[2rem] shadow-xl p-10">

            <form method="GET" class="flex flex-col md:flex-row gap-4">

                <input type="text"
                       name="tracking"
                       placeholder="Enter Tracking Number"
                       required
                       class="flex-1 border border-slate-200 bg-white rounded-2xl px-6 py-5 text-lg focus:outline-none focus:ring-4 focus:ring-blue-100">

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white px-10 py-5 rounded-2xl font-semibold transition duration-300 shadow-xl shadow-blue-500/30">

                    Track Shipment

                </button>

            </form>

        </div>

        <?php if(isset($_GET['tracking'])): ?>

            <?php if($shipment): ?>

                <!-- RESULT -->
                <div class="bg-white/80 backdrop-blur-xl border border-white rounded-[2rem] shadow-2xl p-10 mt-14">

                    <div class="flex items-center justify-between flex-wrap gap-4">

                        <div>

                            <span class="text-slate-500 uppercase text-sm">
                                Tracking Number
                            </span>

                            <h2 class="text-3xl font-bold mt-2">
                                <?= $shipment['tracking_number'] ?>
                            </h2>

                        </div>

                        <?php

$status = $shipment['shipment_status'];

$progress = 25;

if ($status == 'Processing') {
    $progress = 25;
}
elseif ($status == 'In Transit') {
    $progress = 60;
}
elseif ($status == 'Out For Delivery') {
    $progress = 85;
}
elseif ($status == 'Delivered') {
    $progress = 100;
}

?>

<div class="text-right">

    <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-5 py-3 rounded-full font-semibold text-sm">

    <span class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></span>

    <?= $status ?>

</span>

    <div class="w-64 bg-slate-200 rounded-full h-4 mt-4">

        <div class="bg-blue-900 h-4 rounded-full"
             style="width: <?= $progress ?>%">

        </div>

    </div>

    <p class="text-sm text-slate-500 mt-2">
        Shipment Progress: <?= $progress ?>%
    </p>

</div>

                    </div>

                    <!-- DETAILS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>

                            <h3 class="text-2xl font-bold mb-6">
                                Shipment Details
                            </h3>

                            <div class="space-y-4 text-slate-600">

                                <p>
                                    <strong>Sender:</strong>
                                    <?= $shipment['sender_name'] ?>
                                </p>

                                <p>
                                    <strong>Receiver:</strong>
                                    <?= $shipment['receiver_name'] ?>
                                </p>

                                <p>
                                    <strong>Origin:</strong>
                                    <?= $shipment['origin'] ?>
                                </p>

                                <p>
                                    <strong>Destination:</strong>
                                    <?= $shipment['destination'] ?>
                                </p>

                                <p>
                                    <strong>Shipping Method:</strong>
                                    <?= $shipment['shipping_method'] ?>
                                </p>

                            </div>

                        </div>

                        <div>

                            <h3 class="text-2xl font-bold mb-6">
                                Delivery Information
                            </h3>
<!-- DELIVERY STAGES -->
<div class="space-y-4 mb-8">

    <div class="flex items-center gap-4">

        <div class="<?= $progress >= 25 ? 'bg-blue-900 text-white' : 'bg-slate-300' ?> w-10 h-10 rounded-full flex items-center justify-center font-bold">
            ✓
        </div>

        <span class="font-medium">
            Shipment Processing
        </span>

    </div>

    <div class="flex items-center gap-4">

        <div class="<?= $progress >= 60 ? 'bg-blue-900 text-white' : 'bg-slate-300' ?> w-10 h-10 rounded-full flex items-center justify-center font-bold">
            ✓
        </div>

        <span class="font-medium">
            In Transit
        </span>

    </div>

    <div class="flex items-center gap-4">

        <div class="<?= $progress >= 85 ? 'bg-blue-900 text-white' : 'bg-slate-300' ?> w-10 h-10 rounded-full flex items-center justify-center font-bold">
            ✓
        </div>

        <span class="font-medium">
            Out For Delivery
        </span>

    </div>

    <div class="flex items-center gap-4">

        <div class="<?= $progress >= 100 ? 'bg-blue-900 text-white' : 'bg-slate-300' ?> w-10 h-10 rounded-full flex items-center justify-center font-bold">
            ✓
        </div>

        <span class="font-medium">
            Delivered
        </span>

    </div>

</div>
                            <div class="space-y-4 text-slate-600">

                                <p>
                                    <strong>Current Location:</strong>
                                    <?= $shipment['current_location'] ?>
                                </p>

                                <p>
                                    <strong>Shipment Date:</strong>
                                    <?= $shipment['shipment_date'] ?>
                                </p>

                                <p>
                                    <strong>Estimated Delivery:</strong>
                                    <?= $shipment['estimated_delivery'] ?>
                                </p>

                                <p>
                                    <strong>Status:</strong>
                                    <?= $shipment['shipment_status'] ?>
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            <?php else: ?>

                <!-- NOT FOUND -->
                <div class="bg-red-100 text-red-700 rounded-2xl p-6 mt-10">

                    Tracking number not found.

                </div>

            <?php endif; ?>

        <?php endif; ?>

    </div>
<?php if($shipment): ?>
<?php if($shipment): ?>

<!-- LIVE MAP -->
<section class="py-16 bg-slate-50">

    <div class="max-w-5xl mx-auto px-6">

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

            <div class="p-8 border-b">

                <h3 class="text-3xl font-bold">
                    Live Shipment Location
                </h3>

                <p class="text-slate-500 mt-2">
                    Current shipment tracking location
                </p>

            </div>

            <div id="map" class="w-full h-[500px]"></div>

        </div>

    </div>

</section>

<!-- LEAFLET -->
<link rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

    
    const latitude = <?= $shipment['latitude'] ?: 6.5244 ?>;
const longitude = <?= $shipment['longitude'] ?: 3.3792 ?>;

const originLat = <?= $shipment['origin_lat'] ?: 6.5244 ?>;
const originLng = <?= $shipment['origin_lng'] ?: 3.3792 ?>;

const destinationLat = <?= $shipment['destination_lat'] ?: 51.5072 ?>;
const destinationLng = <?= $shipment['destination_lng'] ?: -0.1276 ?>;

const map = L.map('map').setView([latitude, longitude], 4);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {

    attribution: '&copy; OpenStreetMap contributors'

}).addTo(map);

/*
|--------------------------------------------------------------------------
| Shipment Marker
|--------------------------------------------------------------------------
*/

const shipmentMarker = L.marker([latitude, longitude]).addTo(map);

shipmentMarker.bindPopup(`
    <strong>NexFreight Shipment</strong><br>
    Current Location:<br>
    <?= $shipment['current_location'] ?>
`).openPopup();

/*
|--------------------------------------------------------------------------
| Origin Marker
|--------------------------------------------------------------------------
*/

const originMarker = L.marker([originLat, originLng]).addTo(map);

originMarker.bindPopup(`
    <strong>Origin</strong><br>
    <?= $shipment['origin'] ?>
`);

/*
|--------------------------------------------------------------------------
| Destination Marker
|--------------------------------------------------------------------------
*/

const destinationMarker = L.marker([destinationLat, destinationLng]).addTo(map);

destinationMarker.bindPopup(`
    <strong>Destination</strong><br>
    <?= $shipment['destination'] ?>
`);

/*
|--------------------------------------------------------------------------
| Route Line
|--------------------------------------------------------------------------
*/

const route = L.polyline([
    [originLat, originLng],
    [latitude, longitude],
    [destinationLat, destinationLng]
], {
    color: '#1e3a8a',
    weight: 5,
    opacity: 0.8
}).addTo(map);

map.fitBounds(route.getBounds());

</script>

<?php endif; ?>
<!-- TIMELINE -->
<section class="pb-24 bg-slate-50">

    <div class="max-w-5xl mx-auto px-6">

        <div class="bg-white/80 backdrop-blur-xl border border-white rounded-[2rem] shadow-2xl p-10">

            <h3 class="text-3xl font-bold mb-10">
                Shipment Timeline
            </h3>

            <div class="space-y-8">

                <?php foreach($history as $item): ?>

                    <div class="flex flex-col md:flex-row gap-5">

                        <!-- ICON -->
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-800 text-white flex items-center justify-center flex-shrink-0 font-bold shadow-lg shadow-blue-500/30">

                            ✓

                        </div>

                        <!-- CONTENT -->
                        <div class="bg-slate-50 border border-slate-100 rounded-3xl p-5 md:p-6 w-full hover:shadow-lg transition duration-300 break-words">

                            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">

                                <h4 class="text-xl font-bold">
                                    <?= $item['status_title'] ?>
                                </h4>

                                <span class="text-slate-600 mt-4 leading-relaxed text-lg">
                                    <?= date("M d, Y h:i A", strtotime($item['created_at'])) ?>
                                </span>

                            </div>

                            <p class="text-slate-600 mt-4 leading-relaxed text-lg">
                                <?= $item['status_description'] ?>
                            </p>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    </div>

</section>

<?php endif; ?>

<?php include '../includes/footer.php'; ?>