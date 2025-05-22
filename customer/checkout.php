<?php
session_start();
include('../config/db.php');
include('../includes/header.php');
include('../includes/auth_check.php');

$user_id = $_SESSION['user_id'];
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (empty($cart)) {
    echo "<div class='container'><p>Your cart is empty.</p></div>";
    include('../includes/footer.php');
    exit();
}

// 1. Fetch product details for cart items
$total = 0;
$orderItems = [];

$ids = implode(',', array_map('intval', array_keys($cart)));
$sql = "SELECT product_id, price FROM products WHERE product_id IN ($ids)";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productId = $row['product_id'];
        $quantity = $cart[$productId];
        $price = $row['price'];
        $subtotal = $price * $quantity;
        $total += $subtotal;

        $orderItems[] = [
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $price
        ];
    }
} else {
    echo "<div class='container'><p>Unable to fetch product details.</p></div>";
    include('../includes/footer.php');
    exit();
}

// 2. Insert into orders table
$orderSql = "INSERT INTO orders (user_id, total_amount, order_date) VALUES (?, ?, NOW())";
$stmt = $conn->prepare($orderSql);
$stmt->bind_param("id", $user_id, $total);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

// 3. Insert order items
$itemSql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($itemSql);
foreach ($orderItems as $item) {
    $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
    $stmt->execute();
}
$stmt->close();

// 4. Create dummy transaction
$txnSql = "INSERT INTO transactions (order_id, payment_status, transaction_date) VALUES (?, 'Paid', NOW())";
$stmt = $conn->prepare($txnSql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$stmt->close();

// 5. Clear cart
unset($_SESSION['cart']);
?>

<div class="container">
    <h2>Checkout Complete</h2>
    <p>Thank you! Your order (ID: <?php echo $order_id; ?>) has been placed successfully.</p>
    <p><a href="products.php" class="btn">Continue Shopping</a></p>
    <p><a href="orders.php" class="btn">View Order History</a></p>
</div>

<?php include('../includes/footer.php'); ?>
