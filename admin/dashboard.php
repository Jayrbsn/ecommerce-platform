<?php
include('../includes/admin_check.php');
include('../includes/header.php');
?>

<div class="container">
    <h2>Admin Dashboard</h2>

    <div class="admin-cards">
        <div class="admin-card">
            <h3>Manage Users</h3>
            <p>View, add, or remove user accounts.</p>
            <a href="manage_users.php" class="btn btn-primary">Go to Users</a>
        </div>

        <div class="admin-card">
            <h3>Manage Products</h3>
            <p>Add, edit, or delete product listings.</p>
            <a href="manage_products.php" class="btn btn-primary">Go to Products</a>
        </div>

        <div class="admin-card">
            <h3>View Orders</h3>
            <p>See all customer orders.</p>
            <a href="manage_orders.php" class="btn btn-primary">Go to Orders</a>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
