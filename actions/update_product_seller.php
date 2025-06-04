<?php
include('../includes/auth_check.php');
include('../config/db.php');

if ($_SESSION['role'] !== 'seller') {
    header("Location: ../customer/products.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = intval($_POST['product_id']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $user_id = $_SESSION['user_id'];

    $check = $conn->prepare("SELECT product_id FROM products WHERE product_id = ? AND user_id = ?");
    $check->bind_param("ii", $product_id, $user_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ? WHERE product_id = ?");
        $stmt->bind_param("ssdii", $name, $description, $price, $stock, $product_id);
        $stmt->execute();
        $stmt->close();
    }

    $check->close();
}

header("Location: ../customer/products.php");
exit();
