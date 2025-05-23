<?php
include('../includes/auth_check.php');
include('../config/db.php');
include('../includes/header.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Invalid product.</p>";
    include('../includes/footer.php');
    exit();
}

$product_id = $_GET['id'];
$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    echo "<p>Product not found.</p>";
    include('../includes/footer.php');
    exit();
}
?>

<div class="container">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
    <div class="product-detail">
        <p><strong>Price:</strong> R<?php echo number_format($product['price'], 2); ?></p>
        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        
        <form action="../transactions/add_to_cart.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" value="1" min="1" required>
            <button type="submit" class="btn btn-primary mt-2">Add to Cart</button>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
