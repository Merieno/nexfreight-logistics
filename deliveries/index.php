<?php
require_once '../config/db.php';

$result = mysqli_query($conn,
"SELECT * FROM shipments ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Deliveries - NexFreight</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

<!-- Navbar -->
<header class="bg-white shadow">

<div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">

<h1 class="text-3xl font-bold text-blue-900">
NexFreight
</h1>

<nav class="hidden md:flex gap-8 text-gray-700 font-medium">

<a href="../" class="hover:text-blue-900">Home</a>
<a href="../about/" class="hover:text-blue-900">About</a>
<a href="../services/" class="hover:text-blue-900">Services</a>
<a href="index.php" class="text-blue-900 font-bold">Deliveries</a>
<a href="../tracking/" class="hover:text-blue-900">Tracking</a>
<a href="../contact/" class="hover:text-blue-900">Contact</a>

</nav>

<a href="../tracking/"
class="bg-blue-900 text-white px-6 py-3 rounded-xl font-semibold">
Track Shipment
</a>

</div>

</header>

<!-- Hero -->
<section class="bg-blue-950 text-white py-20">

<div class="max-w-7xl mx-auto px-6 text-center">

<h2 class="text-5xl font-bold mb-6">
Global Deliveries
</h2>

<p class="text-xl text-gray-300 max-w-3xl mx-auto">
Track and monitor active deliveries across the world with speed,
security, and reliability.
</p>

</div>

</section>

<!-- Deliveries -->
<section class="py-20">

<div class="max-w-7xl mx-auto px-6">

<div class="bg-white rounded-2xl shadow overflow-x-auto">

<table class="w-full">

<thead class="bg-blue-950 text-white">

<tr>
<th class="p-5 text-left">Tracking</th>
<th class="p-5 text-left">Receiver</th>
<th class="p-5 text-left">Destination</th>
<th class="p-5 text-left">Status</th>
<th class="p-5 text-left">Estimated Delivery</th>
</tr>

</thead>

<tbody>

<?php while($shipment = mysqli_fetch_assoc($result)): ?>

<tr class="border-b hover:bg-gray-50">

<td class="p-5 font-semibold">
<?php echo $shipment['tracking_number']; ?>
</td>

<td class="p-5">
<?php echo $shipment['receiver_name']; ?>
</td>

<td class="p-5">
<?php echo $shipment['destination']; ?>
</td>

<td class="p-5">

<?php
$status = $shipment['shipment_status'];

if ($status == 'Delivered') {
echo "<span class='bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm'>Delivered</span>";
}
elseif ($status == 'In Transit') {
echo "<span class='bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm'>In Transit</span>";
}
else {
echo "<span class='bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm'>$status</span>";
}
?>

</td>

<td class="p-5">
<?php echo $shipment['estimated_delivery']; ?>
</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</section>

<!-- Footer -->
<footer class="bg-blue-950 text-white py-20">

<div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-10">

<div>
<h3 class="text-4xl font-bold mb-6">NexFreight</h3>

<p class="text-gray-400 leading-9">
Modern logistics and freight solutions built for speed,
reliability, and global delivery management.
</p>
</div>

<div>
<h4 class="font-bold text-2xl mb-6">Quick Links</h4>

<ul class="space-y-4 text-gray-400">
<li><a href="../">Home</a></li>
<li><a href="../about/">About</a></li>
<li><a href="../services/">Services</a></li>
<li><a href="../tracking/">Tracking</a></li>
</ul>
</div>

<div>
<h4 class="font-bold text-2xl mb-6">Services</h4>

<ul class="space-y-4 text-gray-400">
<li>Air Freight</li>
<li>Ocean Freight</li>
<li>Warehousing</li>
<li>Cargo Tracking</li>
</ul>
</div>

<div>
<h4 class="font-bold text-2xl mb-6">Contact</h4>

<ul class="space-y-4 text-gray-400">
<li>Lagos, Nigeria</li>
<li>support@nexfreight.com</li>
<li>+234 000 000 0000</li>
</ul>
</div>

</div>

<div class="border-t border-gray-700 mt-16 pt-10 text-center text-gray-500">
© 2026 NexFreight. All rights reserved.
</div>

</footer>

</body>
</html>