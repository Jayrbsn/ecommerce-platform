<?php
include('../includes/auth_check.php');
include('../config/db.php');
include('../includes/header.php');

$user_id = $_SESSION['user_id'];

$sql = "SELECT o.order_id, o.total_amount, o.order_date, t.payment_status
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
                        <td>R<?php echo number_format($row['total_amount'], 2); ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($row['order_date'])); ?></td>
                        <td><?php echo htmlspecialchars($row['payment_status'] ?? 'Pending'); ?></td>
                    </tr>

                    <!-- Show order items below this row -->
                    <tr>
                        <td colspan="4">
                            <strong>Items:</strong>
                            <ul>
                                <?php
                                $items_sql = "SELECT p.name, oi.quantity, oi.price
                                              FROM order_items oi
                                              JOIN products p ON oi.product_id = p.product_id
                                              WHERE oi.order_id = ?";
                                $items_stmt = $conn->prepare($items_sql);
                                $items_stmt->bind_param("i", $row['order_id']);
                                $items_stmt->execute();
                                $items_result = $items_stmt->get_result();
                                
                                while ($item = $items_result->fetch_assoc()):
                                ?>
                                    <li>
                                        <?php echo htmlspecialchars($item['name']); ?> - 
                                        Quantity: <?php echo $item['quantity']; ?> - 
                                        Price: R<?php echo number_format($item['price'], 2); ?>
                                    </li>
                                <?php endwhile; ?>
                                <?php $items_stmt->close(); ?>
                            </ul>
                        </td>
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
