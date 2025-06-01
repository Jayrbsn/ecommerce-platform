<?php
include('../includes/auth_check.php');
include('../config/db.php');

// Only allow sellers
if ($_SESSION['role'] !== 'seller') {
    header("Location: ../customer/products.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Check ownership
    $check = $conn->prepare("SELECT product_id FROM products WHERE product_id = ? AND user_id = ?");
    $check->bind_param("ii", $product_id, $user_id);
    $check->execute();
    $result = $check->get_result();

    if ($result && $result->num_rows > 0) {
        // Safe to delete
        $delete = $conn->prepare("DELETE FROM products WHERE product_id = ?");
        $delete->bind_param("i", $product_id);
        $delete->execute();
        $delete->close();
    }

    $check->close();
}

header("Location: ../customer/products.php");
exit();
