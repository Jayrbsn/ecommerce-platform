<!-- <?php
require ('../config/db.php');

$users = [
    2 => 'password123',
    3 => 'password123',
    4 => 'adminpass456'
];

foreach ($users as $user_id => $plain_password) {
    $hashed = password_hash($plain_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $stmt->bind_param("si", $hashed, $user_id);
    $stmt->execute();
}

echo "Passwords updated!";
?> -->
