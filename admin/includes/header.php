<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>NexFreight Logistics</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>

</head>

<body class="bg-white dark:bg-slate-900 text-slate-800 dark:text-white transition">

<!-- NAVBAR -->
<header class="bg-white dark:bg-slate-800 shadow-sm sticky top-0 z-50 transition">

    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">

        <!-- LOGO -->
        <a href="index.php"
           class="text-3xl font-bold text-blue-900 dark:text-white">

            NexFreight

        </a>

        <!-- NAVIGATION -->
        <nav class="hidden md:flex items-center gap-8">

            <a href="index.php"
               class="font-medium hover:text-blue-700 transition">

                Home

            </a>

            <a href="track.php"
               class="font-medium hover:text-blue-700 transition">

                Track Shipment

            </a>

            <a href="deliveries.php"
               class="font-medium hover:text-blue-700 transition">

                Deliveries

            </a>

            <a href="contact.php"
               class="font-medium hover:text-blue-700 transition">

                Contact

            </a>

        </nav>

        <!-- RIGHT -->
        <div class="flex items-center gap-4">

            <!-- DARK MODE -->
            <button id="themeToggle"
            class="bg-slate-200 dark:bg-slate-700 dark:text-white px-5 py-2 rounded-xl font-semibold transition">

                Dark Mode

            </button>

            <!-- CTA -->
            <a href="track.php"
               class="bg-blue-900 text-white px-5 py-3 rounded-xl font-semibold hover:bg-blue-800 transition">

                Track Now

            </a>

        </div>

    </div>

</header>