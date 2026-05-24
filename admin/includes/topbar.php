

<?php
$notificationQuery = mysqli_query($conn,
    "SELECT * FROM notifications
     ORDER BY id DESC
     LIMIT 5");
$unreadNotifications = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM notifications
     WHERE is_read=0")
);
?>
<div class="hidden lg:flex items-center justify-between mb-10">
    <!-- LEFT -->
    <div>
        <h2 class="text-4xl font-black text-slate-900">
            NexFreight Admin
        </h2>
        <p class="text-slate-500 mt-2 text-lg">
            Premium Logistics Management System
        </p>
    </div>
    <!-- RIGHT -->
    <div class="flex items-center gap-5">
        <!-- DARK MODE -->
        <button id="themeToggle"
                class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-2xl hover:scale-105 transition">
            🌙
        </button>
        <!-- NOTIFICATIONS -->
        <div class="relative">
            <button id="notificationBtn"
                    class="relative w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-2xl hover:scale-105 transition">
                🔔
                <?php if($unreadNotifications > 0): ?>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-7 h-7 rounded-full flex items-center justify-center">
                        <?= $unreadNotifications ?>
                    </span>
                <?php endif; ?>
            </button>
            <!-- DROPDOWN -->
            <div id="notificationDropdown"
                 class="hidden absolute right-0 mt-4 w-[420px] bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-50">
                <!-- HEADER -->
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900">
                            Notifications
                        </h3>
                        <p class="text-slate-500 text-sm mt-1">
                            Recent platform activity
                        </p>
                    </div>
                    <a href="notifications.php"
                       class="text-blue-700 font-semibold text-sm">
                        View All
                    </a>
                </div>
                <!-- LIST -->
                <div class="max-h-[500px] overflow-y-auto">
                    <?php while($notify = mysqli_fetch_assoc($notificationQuery)): ?>
                        <div class="p-6 border-b border-slate-100 hover:bg-slate-50 transition">
                            <div class="flex gap-4">
                                <!-- ICON -->
                                <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl flex-shrink-0">
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
                                    <div class="flex justify-between items-start gap-4">
                                        <h4 class="font-bold text-slate-900">
                                            <?= $notify['title'] ?>
                                        </h4>
                                        <?php if(!$notify['is_read']): ?>
                                            <span class="w-3 h-3 bg-blue-600 rounded-full mt-2 animate-pulse"></span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed mt-2">
                                        <?= $notify['message'] ?>
                                    </p>
                                    <p class="text-xs text-slate-400 mt-3">
                                        <?= date("M d, Y h:i A", strtotime($notify['created_at'])) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        <!-- ADMIN CARD -->
        <div class="bg-white rounded-2xl shadow-sm px-6 py-4 flex items-center gap-5">
            <div class="text-right">
                <p class="font-bold text-slate-900">
                    Administrator
                </p>
                <p class="text-slate-500 text-sm mt-1">
                    <?= date('M d, Y') ?>
                </p>
            </div>
            <!-- AVATAR -->
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-400 text-white flex items-center justify-center font-black text-xl shadow-lg shadow-blue-500/20">
                A
            </div>
        </div>
    </div>
</div>
<script>
/*
|--------------------------------------------------------------------------
| DARK MODE
|--------------------------------------------------------------------------
*/
if(localStorage.theme === 'dark') {
    document.documentElement.classList.add('dark');
}
document.getElementById('themeToggle')
.addEventListener('click', () => {
    document.documentElement.classList.toggle('dark');
    if(document.documentElement.classList.contains('dark')) {
        localStorage.theme = 'dark';
    } else {
        localStorage.theme = 'light';
    }
});
/*
|--------------------------------------------------------------------------
| NOTIFICATION DROPDOWN
|--------------------------------------------------------------------------
*/
const notificationBtn = document.getElementById('notificationBtn');
const notificationDropdown = document.getElementById('notificationDropdown');
notificationBtn.addEventListener('click', () => {
    notificationDropdown.classList.toggle('hidden');
});
document.addEventListener('click', function(e) {
    if(!notificationBtn.contains(e.target) &&
       !notificationDropdown.contains(e.target)) {
        notificationDropdown.classList.add('hidden');
    }
});
</script>