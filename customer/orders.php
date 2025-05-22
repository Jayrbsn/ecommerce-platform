<?php
include('../includes/auth_check.php');
include('../config/db.php');
include('../includes/header.php');

$user_id = $_SESSION['user_id'];

$sql = "SELECT o.order_id, o.total, o.order_date, t.payment_status
        FROM orders o
        LEFT JOIN transactions t ON o.order_id = t.order_id
        WHERE o.user_id = ?
        ORDER BY o.order_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container">
    <h2>Your Order History</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <div class="order-table-container">
        <table class="order-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['order_id']; ?></td>
                        <td>R<?php echo number_format($row['total'], 2); ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($row['order_date'])); ?></td>
                        <td><?php echo htmlspecialchars($row['payment_status'] ?? 'Pending'); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
                </div>
    <?php else: ?>
        <p>You have no orders yet.</p>
    <?php endif; ?>
</div>

<?php
$stmt->close();
include('../includes/footer.php');
?>
