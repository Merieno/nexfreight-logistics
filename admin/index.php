<?php
require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,
        "SELECT * FROM admins WHERE username='$username'");

    $admin = mysqli_fetch_assoc($query);

    if ($admin && md5($password) === $admin['password']) {

        $_SESSION['admin_id'] = $admin['id'];

        header("Location: dashboard.php");
        exit;

    } else {
        $error = "Invalid login credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Admin Login</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md">

        <h1 class="text-3xl font-bold mb-8 text-center">
            NexFreight Admin
        </h1>

        <?php if($error): ?>

            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                <?= $error ?>
            </div>

        <?php endif; ?>

        <form method="POST" class="space-y-6">

            <div>

                <label class="block mb-2 font-medium">
                    Username
                </label>

                <input type="text"
                       name="username"
                       required
                       class="w-full border border-slate-300 rounded-xl px-5 py-4">

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Password
                </label>

                <input type="password"
                       name="password"
                       required
                       class="w-full border border-slate-300 rounded-xl px-5 py-4">

            </div>

            <button type="submit"
                    class="w-full bg-blue-900 text-white py-4 rounded-xl font-semibold">

                Login

            </button>

        </form>

    </div>

</body>
</html>