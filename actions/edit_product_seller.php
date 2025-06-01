<?php
include('../includes/auth_check.php');
include('../config/db.php');

// Check if the user is a seller
if ($_SESSION['role'] !== 'seller') {
    header("Location: ../customer/products.php");
    exit();
}

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Fetch product and ensure it belongs to the logged-in seller
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found or you do not have permission to edit it.");
}
?>

<?php include('../includes/header.php'); ?>

<div class="container">
    <h2>Edit Product</h2>
    <form action="../actions/update_product_seller.php" method="POST">
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
