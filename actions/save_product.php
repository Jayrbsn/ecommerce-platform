<?php
include('../includes/admin_check.php');
include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $user_id = $_SESSION['user_id']; 

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdii", $name, $description, $price, $stock, $user_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../admin/manage_products.php");
exit;
