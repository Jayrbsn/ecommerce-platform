<?php
include('../includes/admin_check.php');
include('../config/db.php');

$id = intval($_GET['id']);
$product = $conn->query("SELECT * FROM products WHERE product_id = $id")->fetch_assoc();

if (!$product) {
    die("Product not found.");
}
?>

<?php include('../includes/header.php'); ?>

<div class="container">
    <h2>Edit Product</h2>
    <form action="update_product.php" method="POST">
        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br>
        <label>Description:</label><br>
        <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea><br>
        <label>Price:</label><br>
        <input type="number" name="price" value="<?= $product['price'] ?>" step="0.01" required><br>
        <label>Stock:</label><br>
        <input type="number" name="stock" value="<?= $product['stock'] ?>" required><br><br>
        <input type="submit" value="Update Product">
    </form>
</div>

<?php include('../includes/footer.php'); ?>
