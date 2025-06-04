<?php
include('../includes/admin_check.php');
include('../config/db.php');
include('../includes/header.php');
?>

<div class="container mt-4">
    <h2>Admin Reports</h2>

    <h4>Total Users by Role</h4>
    <table class="table table-bordered">
        <thead><tr><th>Role</th><th>Total Users</th></tr></thead>
        <tbody>
        <?php
        $res = $conn->query("SELECT role, COUNT(*) AS total_users FROM users GROUP BY role");
        while ($row = $res->fetch_assoc()):
        ?>
        <tr><td><?= ucfirst($row['role']) ?></td><td><?= $row['total_users'] ?></td></tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <h4>Products Per Seller</h4>
    <table class="table table-bordered">
        <thead><tr><th>Seller</th><th>Product Count</th></tr></thead>
        <tbody>
        <?php
        $res = $conn->query("SELECT u.name, COUNT(p.product_id) AS product_count
                             FROM users u
                             JOIN products p ON u.user_id = p.user_id
                             WHERE u.role = 'seller'
                             GROUP BY u.user_id");
        while ($row = $res->fetch_assoc()):
        ?>
        <tr><td><?= htmlspecialchars($row['name']) ?></td><td><?= $row['product_count'] ?></td></tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <h4>Total Orders</h4>
    <p>
    <?php
    $res = $conn->query("SELECT COUNT(*) AS total_orders FROM orders");
    echo "Total Orders: " . $res->fetch_assoc()['total_orders'];
    ?>
    </p>

    <h4>Total Revenue</h4>
    <p>
    <?php
    $res = $conn->query("SELECT SUM(oi.quantity * oi.price) AS total_revenue FROM order_items oi");
    $revenue = $res->fetch_assoc()['total_revenue'];
    echo "R" . number_format($revenue, 2);
    ?>
    </p>

    <h4>Top-Selling Products</h4>
    <table class="table table-bordered">
        <thead><tr><th>Product Name</th><th>Total Sold</th></tr></thead>
        <tbody>
        <?php
        $res = $conn->query("SELECT p.name, SUM(oi.quantity) AS total_sold
                             FROM order_items oi
                             JOIN products p ON oi.product_id = p.product_id
                             GROUP BY p.product_id
                             ORDER BY total_sold DESC
                             LIMIT 5");
        while ($row = $res->fetch_assoc()):
        ?>
        <tr><td><?= htmlspecialchars($row['name']) ?></td><td><?= $row['total_sold'] ?></td></tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <h4>Orders Per Day (Last 7 Days)</h4>
    <table class="table table-bordered">
        <thead><tr><th>Date</th><th>Order Count</th></tr></thead>
        <tbody>
        <?php
        $res = $conn->query("SELECT DATE(order_date) AS day, COUNT(*) AS order_count
                             FROM orders
                             WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                             GROUP BY day
                             ORDER BY day DESC");
        while ($row = $res->fetch_assoc()):
        ?>
        <tr><td><?= $row['day'] ?></td><td><?= $row['order_count'] ?></td></tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>
