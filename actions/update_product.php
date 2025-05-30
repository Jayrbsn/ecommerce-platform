<?php
include('../includes/admin_check.php');
include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = intval($_POST['product_id']);
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ? WHERE product_id = ?");
    $stmt->bind_param("ssdii", $name, $description, $price, $stock, $product_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../admin/manage_products.php");
exit;
