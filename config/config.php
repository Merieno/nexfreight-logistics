<?php

// =====================================
// NEXFREIGHT CONFIGURATION
// =====================================

// Start session
session_start();

// Base URL
define('BASE_URL', 'http://localhost/nexfreight/');

// Site Name
define('SITE_NAME', 'NexFreight');

// Timezone
date_default_timezone_set('Africa/Lagos');

// Error Reporting (Development Mode)
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>