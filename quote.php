<?php

require_once 'config/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $origin_country = $_POST['origin_country'];
    $destination_country = $_POST['destination_country'];
    $cargo_weight = $_POST['cargo_weight'];
    $shipping_method = $_POST['shipping_method'];
    $additional_info = $_POST['additional_info'];

    $query = "INSERT INTO quotes (
        full_name,
        email,
        origin_country,
        destination_country,
        cargo_weight,
        shipping_method,
        additional_info
    ) VALUES (
        '$full_name',
        '$email',
        '$origin_country',
        '$destination_country',
        '$cargo_weight',
        '$shipping_method',
        '$additional_info'
    )";

    if (mysqli_query($conn, $query)) {
$notifyTitle = "New Quote Request";

$notifyMessage = "{$name} requested a freight quote from {$origin_country} to {$destination_country}.";

mysqli_query($conn,
    "INSERT INTO notifications (
        title,
        message,
        type
    ) VALUES (
        '$notifyTitle',
        '$notifyMessage',
        'quote'
    )");
        $message = "Quote request submitted successfully.";

    } else {

        $message = "Something went wrong.";

    }
}

?>

<?php include 'includes/header.php'; ?>

<!-- HERO -->
<section class="bg-blue-900 text-white py-24">

    <div class="max-w-5xl mx-auto px-6 text-center">

        <span class="uppercase tracking-widest text-blue-200 font-semibold">
            Shipping Quote
        </span>

        <h1 class="text-5xl font-bold mt-6">
            Request A Shipping Quote
        </h1>

        <p class="max-w-3xl mx-auto mt-6 text-blue-100 text-lg leading-relaxed">
            Fill out the form below and our logistics team will contact you with a shipping estimate.
        </p>

    </div>

</section>

<!-- FORM -->
<section class="py-24 bg-slate-100">

    <div class="max-w-4xl mx-auto px-6">

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
                        Full Name
                    </label>

                    <input type="text"
                           name="full_name"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Email Address
                    </label>

                    <input type="email"
                           name="email"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Origin Country
                    </label>

                    <input type="text"
                           name="origin_country"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Destination Country
                    </label>

                    <input type="text"
                           name="destination_country"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Cargo Weight
                    </label>

                    <input type="text"
                           name="cargo_weight"
                           placeholder="e.g 120kg"
                           required
                           class="w-full border border-slate-300 rounded-xl px-5 py-4">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Shipping Method
                    </label>

                    <select name="shipping_method"
                            class="w-full border border-slate-300 rounded-xl px-5 py-4">

                        <option>Air Freight</option>
                        <option>Ocean Freight</option>
                        <option>Road Freight</option>

                    </select>

                </div>

                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Additional Information
                    </label>

                    <textarea rows="5"
                              name="additional_info"
                              class="w-full border border-slate-300 rounded-xl px-5 py-4"></textarea>

                </div>

                <div class="md:col-span-2">

                    <button type="submit"
                            class="bg-blue-900 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-800 transition">

                        Request Quote

                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

<?php include 'includes/footer.php'; ?>