<?php
include('../config/db.php');
include('../includes/header.php');
include('../includes/auth_check.php');

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>Browse Products</h2>
    <div class="products-grid">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
    <div class="product-card">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p>Price: R<?php echo number_format($row['price'], 2); ?></p>
        <p><a href="/ecommerce-platform/customer/product_detail.php?id=<?php echo $row['product_id']; ?>">View Details</a></p>
        
        <form action="../actions/add_to_cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
            <input type="number" name="quantity" value="1" min="1" style="width: 60px;" required>
            <button type="submit">Add to Cart</button>
        </form>
    </div>
<?php endwhile; ?>

        <?php else: ?>
            <p>No products available.</p>
        <?php endif; ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
