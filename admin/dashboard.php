<?php
include('../includes/admin_check.php');
include('../config/db.php');
include('../includes/header.php');

// Get counts
$total_users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$total_products = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];
$total_orders = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];
?>

<div class="container">
    <h2>Admin Dashboard</h2>

    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Total Users</h3>
            <p><?php echo $total_users; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Products</h3>
            <p><?php echo $total_products; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Orders</h3>
            <p><?php echo $total_orders; ?></p>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
