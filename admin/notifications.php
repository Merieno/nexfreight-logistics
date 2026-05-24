<?php

require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {

    header("Location: index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| MARK ALL AS READ
|--------------------------------------------------------------------------
*/

mysqli_query($conn,
    "UPDATE notifications
     SET is_read=1");

/*
|--------------------------------------------------------------------------
| GET NOTIFICATIONS
|--------------------------------------------------------------------------
*/

$notifications = mysqli_query($conn,
    "SELECT * FROM notifications
     ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Notifications</title>

<script src="https://cdn.tailwindcss.com"></script>

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

        <div class="relative z-10">

            <div class="inline-flex items-center gap-3 bg-white/10 border border-white/10 px-5 py-3 rounded-full backdrop-blur-xl">

                <span class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></span>

                <span class="text-sm text-blue-100">
                    Live Admin Activity
                </span>

            </div>

            <h1 class="text-5xl lg:text-6xl font-black mt-8">

                Notifications
                <span class="text-blue-400">
                    Center
                </span>

            </h1>

            <p class="text-slate-300 text-lg leading-relaxed mt-8 max-w-3xl">

                Monitor shipment activities, customer quote requests,
                logistics updates, and platform operations in real time.

            </p>

        </div>

    </section>

    <!-- NOTIFICATIONS -->
    <section class="bg-white rounded-[2rem] shadow-sm p-6 lg:p-10 mt-10">

        <div class="flex justify-between items-center flex-wrap gap-5 mb-10">

            <div>

                <h2 class="text-3xl font-black text-slate-900">
                    All Notifications
                </h2>

                <p class="text-slate-500 mt-2">
                    Latest platform activity logs.
                </p>

            </div>

        </div>

        <div class="space-y-5">

            <?php while($notify = mysqli_fetch_assoc($notifications)): ?>

                <div class="border border-slate-100 rounded-3xl p-6 hover:shadow-xl transition duration-300">

                    <div class="flex gap-5">

                        <!-- ICON -->
                        <div class="w-16 h-16 rounded-3xl flex items-center justify-center text-3xl flex-shrink-0

                        <?=
                            $notify['type'] == 'shipment'
                            ? 'bg-blue-100 text-blue-700'
                            : (
                                $notify['type'] == 'quote'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-slate-100 text-slate-700'
                            )
                        ?>">

                            <?=
                                $notify['type'] == 'shipment'
                                ? '🚚'
                                : (
                                    $notify['type'] == 'quote'
                                    ? '💰'
                                    : '🔔'
                                )
                            ?>

                        </div>

                        <!-- CONTENT -->
                        <div class="flex-1">

                            <div class="flex justify-between items-start flex-wrap gap-5">

                                <div>

                                    <h3 class="text-2xl font-bold text-slate-900">

                                        <?= $notify['title'] ?>

                                    </h3>

                                    <p class="text-slate-600 leading-relaxed mt-3 text-lg">

                                        <?= $notify['message'] ?>

                                    </p>

                                </div>

                                <div class="text-right">

                                    <span class="inline-flex items-center gap-2 bg-slate-100 px-4 py-2 rounded-full text-sm font-semibold text-slate-700">

                                        <?= ucfirst($notify['type']) ?>

                                    </span>

                                    <p class="text-slate-400 text-sm mt-4">

                                        <?= date("M d, Y h:i A", strtotime($notify['created_at'])) ?>

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    </section>

</main>

</body>
</html>