<?php
require_once '../includes/admin_check.php';
require_once '../config/db.php';
require_once '../includes/header.php';

if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);

    $checkProducts = $conn->prepare("SELECT COUNT(*) FROM products WHERE user_id = ?");
    $checkProducts->bind_param("i", $delete_id);
    $checkProducts->execute();
    $checkProducts->bind_result($productCount);
    $checkProducts->fetch();
    $checkProducts->close();

    $checkOrders = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ?");
    $checkOrders->bind_param("i", $delete_id);
    $checkOrders->execute();
    $checkOrders->bind_result($orderCount);
    $checkOrders->fetch();
    $checkOrders->close();

    if ($productCount > 0 || $orderCount > 0) {
        echo "<script>alert('Cannot delete user with existing products or orders.'); window.location.href='manage_users.php';</script>";
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_users.php");
    exit();
}

$sql = "SELECT user_id, name, email, role FROM users ORDER BY role";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>Manage Users</h2>
    <a href="../actions/add_user.php" class="btn btn-primary mb-3">Add New User</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo ucfirst($row['role']); ?></td>
                        <td>
                            <a href="../actions/edit_user.php?id=<?= $row['user_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="manage_users.php?delete=<?= $row['user_id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No users found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>
