<?php
include('../includes/admin_check.php');
include('../config/db.php');
include('../includes/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    $stmt->execute();
    $stmt->close();

    header("Location: ../admin/manage_users.php");
    exit();
}
?>

<div class="container mt-4">
    <h2>Add User</h2>
    <form method="POST">
        <input class="form-control mb-2" name="name" placeholder="Name" required>
        <input class="form-control mb-2" name="email" type="email" placeholder="Email" required>
        <input class="form-control mb-2" name="password" type="password" placeholder="Password" required>
        <select class="form-control mb-3" name="role" required>
            <option value="customer">Customer</option>
            <option value="buyer">Buyer</option>
            <option value="seller">Seller</option>
            <option value="admin">Admin</option>
        </select>
        <button class="btn btn-success">Add User</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
