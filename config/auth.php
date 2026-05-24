<?php

require_once 'config.php';
require_once 'db.php';
require_once '../includes/functions.php';

// Check if admin is logged in
if (!isAdminLoggedIn()) {
    header("Location: " . BASE_URL . "admin/login.php");
    exit();
}

?>