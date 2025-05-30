<?php
include('../config/db.php');
include('../includes/header.php');
include('../includes/auth_check.php');

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>Browse Products</h2>

    <?php if ($role === 'seller'): ?>
        <a href=" ../actions/add_product.php" class="btn btn-success mb-3">Add New Product</a>
    <?php endif; ?>

    <div class="products-grid">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p>Price: R<?php echo number_format($row['price'], 2); ?></p>

                    <?php if ($role === 'seller' && $row['user_id'] == $user_id): ?>
                        <a href="../actions/edit_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="../actions/delete_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    <?php else: ?>
                        <p><a href="/ecommerce-platform/customer/product_detail.php?id=<?php echo $row['product_id']; ?>">View Details</a></p>
                        <form action="../actions/add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                            <input type="number" name="quantity" value="1" min="1" style="width: 60px;" required>
                            <button type="submit">Add to Cart</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products available.</p>
        <?php endif; ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<script src="../public/js/scripts.js"></script>
