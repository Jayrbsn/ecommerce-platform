<?php
include('../includes/admin_check.php');
include('../config/db.php');
include('../includes/header.php');

// Handle delete
if (isset($_GET['delete'])) {
    $product_id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE product_id = $product_id");
    header("Location: manage_products.php");
    exit;
}

// Fetch products
$result = $conn->query("SELECT * FROM products ORDER BY product_id DESC");
?>

<div class="container">
    <h2>Manage Products</h2>

    <h3>Add New Product</h3>
    <form action=" ../actions/save_product.php" method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required><br>
        <label>Description:</label><br>
        <textarea name="description" required></textarea><br>
        <label>Price (R):</label><br>
        <input type="number" name="price" step="0.01" required><br>
        <label>Stock:</label><br>
        <input type="number" name="stock" required><br><br>
        <input type="submit" value="Add Product">
    </form>

    <hr>

    <h3>Existing Products</h3>
    <table class="order-table">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['product_id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>R<?= number_format($row['price'], 2) ?></td>
                <td><?= $row['stock'] ?></td>
                <td>
                    <a href=" ../actions/edit_product.php?id=<?= $row['product_id'] ?>">Edit</a> |
                    <a href="manage_products.php?delete=<?= $row['product_id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>
