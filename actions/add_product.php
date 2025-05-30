<?php
require_once '../includes/auth_check.php';
require_once '../config/db.php';

$errors = [];
$name = $description = $price = $stock = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $user_id = $_SESSION['user_id'];

    if (empty($name) || empty($description) || $price <= 0 || $stock < 0) {
        $errors[] = "Please provide valid product details.";
    } else {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdii", $name, $description, $price, $stock, $user_id);

        if ($stmt->execute()) {
            header("Location: ../customer/products.php");
            exit();
        } else {
            $errors[] = "Failed to add product. Please try again.";
        }

        $stmt->close();
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Add New Product</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?php echo htmlspecialchars($err); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="add_product.php" method="POST">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required><?php echo htmlspecialchars($description); ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price (ZAR)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($price); ?>" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock Quantity</label>
            <input type="number" name="stock" class="form-control" value="<?php echo htmlspecialchars($stock); ?>" required min="0">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Add Product</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
