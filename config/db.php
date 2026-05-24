<?php

// =====================================
// DATABASE CONNECTION
// =====================================

require_once 'config.php';

$host = "localhost";
$dbname = "nexfreight";
$username = "root";
$password = "";

// Create Connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check Connection
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>