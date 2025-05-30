<!--<?php session_start(); ?>-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITECA PROTOTYPE</title>
    <link rel="stylesheet" href="../public/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container">
            <h1>ITECA Platform</h1>
            <nav>
                <a href="/ecommerce-platform/index.php" class="text-white me-3">Home</a>
                <a href="/ecommerce-platform/customer/products.php" class="text-white me-3">Products</a>
                <a href="/ecommerce-platform/customer/cart.php" class="text-white me-3">Cart</a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/ecommerce-platform/customer/orders.php" class="text-white me-3">Orders</a>
                    <a href="/ecommerce-platform/customer/logout.php" class="text-white me-3">Logout</a>
                <?php else: ?>
                    <a href="/ecommerce-platform/customer/login.php" class="text-white me-3">Login</a>
                    <a href="/ecommerce-platform/customer/register.php" class="text-white me-3">Register</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="/ecommerce-platform/admin/dashboard.php" class="text-white me-3">Admin</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container mt-4">
