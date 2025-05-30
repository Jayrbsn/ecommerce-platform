<?php
require_once '../includes/admin_check.php';
require_once '../config/db.php';
require_once '../includes/header.php';

$sql = "SELECT o.order_id, u.name AS customer_name, o.total_amount, o.order_date, t.payment_status
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        LEFT JOIN transactions t ON o.order_id = t.order_id
        ORDER BY o.order_date DESC";

$result = $conn->query($sql);
?>

<div class="container">
    <h2>Manage Orders</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total (R)</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['order_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo number_format($row['total_amount'], 2); ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($row['order_date'])); ?></td>
                        <td><?php echo htmlspecialchars($row['payment_status'] ?? 'Pending'); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No orders found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>
