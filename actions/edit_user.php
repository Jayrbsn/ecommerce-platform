<?php
include('../includes/admin_check.php');
include('../config/db.php');
include('../includes/header.php');

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT name, email, role FROM users WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $email, $role);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];
    $new_role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE user_id=?");
    $stmt->bind_param("sssi", $new_name, $new_email, $new_role, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../admin/manage_users.php");
    exit();
}
?>

<div class="container mt-4">
    <h2>Edit User</h2>
    <form method="POST">
        <input class="form-control mb-2" name="name" value="<?= htmlspecialchars($name) ?>" required>
        <input class="form-control mb-2" name="email" type="email" value="<?= htmlspecialchars($email) ?>" required>
        <select class="form-control mb-3" name="role" required>
            <option value="customer" <?= $role == 'customer' ? 'selected' : '' ?>>Customer</option>
            <option value="buyer" <?= $role == 'buyer' ? 'selected' : '' ?>>Buyer</option>
            <option value="seller" <?= $role == 'seller' ? 'selected' : '' ?>>Seller</option>
            <option value="admin" <?= $role == 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
        <button class="btn btn-primary">Update</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
