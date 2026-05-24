<nav class="sticky top-0 z-50 backdrop-blur-xl bg-white/80 border-b border-white/20 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <a href="<?= BASE_URL ?>" class="text-2xl font-bold text-blue-900">
                NexFreight
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">

                <a href="<?= BASE_URL ?>" class="text-slate-700 hover:text-blue-600 font-medium transition duration-300">
                    Home
                </a>

                <a href="<?= BASE_URL ?>about/" class="text-slate-700 hover:text-blue-600 font-medium transition duration-300">
                    About
                </a>

                <a href="<?= BASE_URL ?>services/" class="text-slate-700 hover:text-blue-600 font-medium transition duration-300">
                    Services
                </a>

                <a href="<?= BASE_URL ?>deliveries/" class="text-slate-700 hover:text-blue-600 font-medium transition duration-300">
                    Deliveries
                </a>

                <a href="<?= BASE_URL ?>tracking/" class="text-slate-700 hover:text-blue-600 font-medium transition duration-300">
                    Tracking
                </a>

                <a href="<?= BASE_URL ?>contact/" class="text-slate-700 hover:text-blue-600 font-medium transition duration-300">
                    Contact


<!-- TRACK BUTTON -->
<a href="<?= BASE_URL ?>tracking/"
   class="bg-blue-600 text-white px-5 py-2 rounded-xl hover:bg-blue-500 transition duration-300 shadow-lg shadow-blue-500/30">

    Track Shipment

</a>

            </div>

            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn"
                class="md:hidden text-slate-700 focus:outline-none">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-7 w-7"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>

            </button>

        </div>

    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu"
         class="hidden md:hidden bg-white border-t border-slate-200">

        <div class="px-4 py-4 space-y-4">

            <a href="<?= BASE_URL ?>" class="block text-slate-700">
                Home
            </a>

            <a href="<?= BASE_URL ?>about/" class="block text-slate-700">
                About
            </a>

            <a href="<?= BASE_URL ?>services/" class="block text-slate-700">
                Services
            </a>

            <a href="<?= BASE_URL ?>deliveries/" class="block text-slate-700">
                Deliveries
            </a>

            <a href="<?= BASE_URL ?>tracking/" class="block text-slate-700">
                Tracking
            </a>

            <a href="<?= BASE_URL ?>contact/" class="block text-slate-700">
                Contact
            </a>
</a>

<a href="<?= BASE_URL ?>tracking/"
   class="block bg-blue-900 text-white text-center py-3 rounded-xl">

    Track Shipment

</a>

        </div>

    </div>
</nav>