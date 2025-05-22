<?php
// Enable error reporting for debugging purposes (remove later in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session (if not already started)
session_start();

// Redirect to login page
header("Location: /ecommerce-platform/customer/login.php");
exit;
?>
