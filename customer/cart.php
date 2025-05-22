<?php
session_start();
include('../config/db.php');
include('../includes/header.php');
include('../includes/auth_check.php');

// Initialize cart
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$products = [];

$total = 0;

if (!empty($cart)) {
    $ids = implode(',', array_keys($cart));
    $sql = "SELECT * FROM products WHERE product_id IN ($ids)";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['quantity'] = $cart[$row['product_id']];
            $row['subtotal'] = $row['price'] * $row['quantity'];
            $total += $row['subtotal'];
            $products[] = $row;
        }
    }
}
?>

<div class="container">
    <h2>Your Cart</h2>

    <?php if (!empty($products)): ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td>R<?php echo number_format($product['price'], 2); ?></td>
                        <td>R<?php echo number_format($product['subtotal'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>R<?php echo number_format($total, 2); ?></strong></td>
                </tr>
            </tbody>
        </table>
        <p><a href="/ecommerce-platform/customer/checkout.php" class="btn">Proceed to Checkout</a></p>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
    
</div> 

<?php include('../includes/footer.php'); ?>
