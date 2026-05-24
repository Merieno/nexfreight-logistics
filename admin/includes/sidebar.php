<?php

$currentPage = basename($_SERVER['PHP_SELF']);

?>

<!-- MOBILE TOPBAR -->
<div class="lg:hidden fixed top-0 left-0 right-0 z-50 backdrop-blur-2xl bg-slate-950/90 border-b border-white/10 px-6 py-5 flex justify-between items-center">

    <div class="flex items-center gap-3">

        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-lg shadow-blue-500/30">

            🚚

        </div>

        <div>

            <h1 class="text-xl font-black text-white">
                NexFreight
            </h1>

            <p class="text-xs text-slate-400">
                Admin Panel
            </p>

        </div>

    </div>

    <button id="menuBtn"
            class="w-12 h-12 rounded-2xl bg-white/10 border border-white/10 text-white text-2xl flex items-center justify-center">

        ☰

    </button>

</div>

<!-- SIDEBAR -->
<aside id="sidebar"
       class="fixed top-0 left-0 z-50 w-80 min-h-screen overflow-y-auto
              bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900
              text-white border-r border-white/10 shadow-2xl
              transform -translate-x-full lg:translate-x-0
              transition-all duration-300 ease-in-out">

    <!-- GLOW -->
    <div class="absolute top-0 right-0 w-72 h-72 bg-blue-500/20 blur-3xl rounded-full"></div>

    <!-- CONTENT -->
    <div class="relative z-10 p-8">

        <!-- CLOSE BUTTON -->
        <div class="flex justify-end lg:hidden mb-6">

            <button id="closeSidebar"
                    class="w-12 h-12 rounded-2xl bg-white/10 border border-white/10 text-2xl flex items-center justify-center">

                ×

            </button>

        </div>

        <!-- LOGO -->
        <div class="mb-12 mt-10 lg:mt-0">

            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-3xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-2xl shadow-xl shadow-blue-500/30">

                    🚚

                </div>

                <div>

                    <h1 class="text-3xl font-black tracking-tight">
                        NexFreight
                    </h1>

                    <p class="text-blue-200 text-sm mt-1">
                        Logistics Admin System
                    </p>

                </div>

            </div>

        </div>

        <!-- NAVIGATION -->
        <nav class="space-y-3">

            <!-- DASHBOARD -->
            <a href="../admin/dashboard.php"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300
               <?= $currentPage == 'dashboard.php'
                    ? 'bg-gradient-to-r from-blue-600 to-cyan-500 shadow-xl shadow-blue-500/20'
                    : 'hover:bg-white/10 border border-transparent hover:border-white/10'
               ?>">

                <span class="text-2xl">📊</span>

                <div>
                    <h3 class="font-semibold">
                        Dashboard
                    </h3>

                    <p class="text-xs text-slate-300">
                        Analytics & overview
                    </p>
                </div>

            </a>

            <!-- CREATE SHIPMENT -->
            <a href="../admin/create-shipment.php"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300
               <?= $currentPage == 'create-shipment.php'
                    ? 'bg-gradient-to-r from-blue-600 to-cyan-500 shadow-xl shadow-blue-500/20'
                    : 'hover:bg-white/10 border border-transparent hover:border-white/10'
               ?>">

                <span class="text-2xl">➕</span>

                <div>
                    <h3 class="font-semibold">
                        Create Shipment
                    </h3>

                    <p class="text-xs text-slate-300">
                        Add new cargo delivery
                    </p>
                </div>

            </a>

            <!-- SHIPMENTS -->
            <a href="../admin/shipments.php"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300
               <?= ($currentPage == 'shipments.php' || $currentPage == 'edit-shipment.php' || $currentPage == 'add-history.php')
                    ? 'bg-gradient-to-r from-blue-600 to-cyan-500 shadow-xl shadow-blue-500/20'
                    : 'hover:bg-white/10 border border-transparent hover:border-white/10'
               ?>">

                <span class="text-2xl">📦</span>

                <div>
                    <h3 class="font-semibold">
                        Manage Shipments
                    </h3>

                    <p class="text-xs text-slate-300">
                        Edit shipment activity
                    </p>
                </div>

            </a>

            <!-- QUOTES -->
            <a href="../admin/quotes.php"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300
               <?= $currentPage == 'quotes.php'
                    ? 'bg-gradient-to-r from-blue-600 to-cyan-500 shadow-xl shadow-blue-500/20'
                    : 'hover:bg-white/10 border border-transparent hover:border-white/10'
               ?>">

                <span class="text-2xl">💰</span>

                <div>
                    <h3 class="font-semibold">
                        Quote Requests
                    </h3>

                    <p class="text-xs text-slate-300">
                        Manage customer pricing
                    </p>
                </div>

            </a>

            <!-- TRACKING -->
            <a href="../tracking/"
               target="_blank"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300 hover:bg-white/10 border border-transparent hover:border-white/10">

                <span class="text-2xl">🌍</span>

                <div>
                    <h3 class="font-semibold">
                        Tracking Portal
                    </h3>

                    <p class="text-xs text-slate-300">
                        Open customer tracking
                    </p>
                </div>

            </a>

        </nav>

        <!-- BOTTOM -->
        <div class="mt-16">

            <a href="../admin/logout.php"
               class="flex items-center justify-center gap-3 bg-red-600 hover:bg-red-700 transition-all duration-300 px-6 py-4 rounded-2xl font-semibold shadow-xl shadow-red-500/20">

                <span>🚪</span>

                Logout

            </a>

        </div>

    </div>

</aside>

<!-- OVERLAY -->
<div id="overlay"
     class="fixed inset-0 bg-black/70 backdrop-blur-sm z-40 hidden lg:hidden"></div>

<script>

const menuBtn = document.getElementById('menuBtn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const closeSidebar = document.getElementById('closeSidebar');

function openSidebar() {

    sidebar.classList.remove('-translate-x-full');
    overlay.classList.remove('hidden');

}

function closeMenu() {

    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');

}

menuBtn.addEventListener('click', openSidebar);

closeSidebar.addEventListener('click', closeMenu);

overlay.addEventListener('click', closeMenu);

</script>