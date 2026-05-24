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
    "SELECT * FROM quotes WHERE id='$id'");

$quote = mysqli_fetch_assoc($query);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $price = $_POST['price'];
    $status = $_POST['status'];
$admin_message = $_POST['admin_message'];
    $update = mysqli_query($conn,
        "UPDATE quotes SET
        price='$price',
status='$status',
admin_message='$admin_message'
        WHERE id='$id'");

    if ($update) {
require_once '../config/mail.php';

$subject = "NexFreight Quote Update";

$emailMessage = "
<h2>NexFreight Quote Response</h2>

<p>Hello {$quote['full_name']},</p>

<p>Your shipping quote has been updated.</p>

<p>
<strong>Status:</strong>
$status
</p>

<p>
<strong>Quoted Price:</strong>
$price
</p>

<p>
<strong>Message From Admin:</strong>
</p>

<p>
$admin_message
</p>

<p>
Thank you for choosing NexFreight.
</p>
";

sendShipmentEmail(
    $quote['email'],
    $subject,
    $emailMessage
);
        $message = "Quote updated successfully.";

        $query = mysqli_query($conn,
            "SELECT * FROM quotes WHERE id='$id'");

        $quote = mysqli_fetch_assoc($query);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manage Quote</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

<?php include 'includes/sidebar.php'; ?>

<main class="w-full lg:ml-72 mt-24 lg:mt-0 p-4 lg:p-10 overflow-x-hidden">

<?php include 'includes/topbar.php'; ?>

<div class="max-w-3xl">

    <div class="mb-8">

        <h1 class="text-4xl font-bold text-slate-800">
            Manage Quote
        </h1>

        <p class="text-slate-500 mt-2">
            Update quote pricing and status.
        </p>

    </div>

    <div class="bg-white rounded-2xl shadow-sm p-10">

        <?php if($message): ?>

            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">

                <?= $message ?>

            </div>

        <?php endif; ?>

        <form method="POST" class="space-y-6">

            <div>

                <label class="block mb-2 font-medium">
                    Customer
                </label>

                <input type="text"
                       value="<?= $quote['full_name'] ?>"
                       disabled
                       class="w-full border border-slate-300 rounded-xl px-5 py-4 bg-slate-100">

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Manual Price
                </label>

                <input type="text"
                       name="price"
                       value="<?= $quote['price'] ?>"
                       placeholder="$2,500"
                       class="w-full border border-slate-300 rounded-xl px-5 py-4">

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Quote Status
                </label>

                <select name="status"
                        class="w-full border border-slate-300 rounded-xl px-5 py-4">

                    <option value="Pending"
                        <?= $quote['status'] == 'Pending' ? 'selected' : '' ?>>

                        Pending

                    </option>

                    <option value="Approved"
                        <?= $quote['status'] == 'Approved' ? 'selected' : '' ?>>

                        Approved

                    </option>

                    <option value="Rejected"
                        <?= $quote['status'] == 'Rejected' ? 'selected' : '' ?>>

                        Rejected

                    </option>

                </select>

            </div>
<div>

    <label class="block mb-2 font-medium">
        Admin Reply Message
    </label>

    <textarea name="admin_message"
              rows="6"
              class="w-full border border-slate-300 rounded-xl px-5 py-4"><?= $quote['admin_message'] ?></textarea>

</div>
            <button type="submit"
                    class="bg-blue-900 text-white px-8 py-4 rounded-xl font-semibold">

                Update Quote

            </button>

        </form>

    </div>

</div>

</main>

</body>
</html>