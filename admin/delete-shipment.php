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

mysqli_query($conn,
    "DELETE FROM shipments WHERE id='$id'");

header("Location: shipments.php");
exit;