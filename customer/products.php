<?php
include('../config/db.php');
include('../includes/header.php');

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
                    <p><a href="product_detail.php?id=<?php echo $row['product_id']; ?>">View Details</a></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products available.</p>
        <?php endif; ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
