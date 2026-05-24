<?php

// =====================================
// GLOBAL HELPER FUNCTIONS
// =====================================

// Sanitize Input
function clean($data)
{
    return htmlspecialchars(trim($data));
}

// Redirect Function
function redirect($path)
{
    header("Location: " . BASE_URL . $path);
    exit();
}

// Check Admin Login
function isAdminLoggedIn()
{
    return isset($_SESSION['admin_id']);
}

?>