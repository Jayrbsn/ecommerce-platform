<?php
session_start();
include('includes/header.php');
?>

<div class="home-banner">
    <div class="banner-content">
        <h2>Welcome to The ITECA E-Commerce Platform</h2>
        <p>Buy and sell directly with other users. Safe, Easy and Affordable!</p>
        <a href="/ecommerce-platform/customer/products.php" class="btn btn-primary">Browse Products</a>
    </div>
</div>

<div class="container mt-5">
    <div class="row text-center">
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Browse</h5>
                    <p class="card-text">Explore a wide range of products from other users.</p>
                    <a href="/ecommerce-platform/customer/products.php" class="btn btn-outline-primary">View Products</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Cart</h5>
                    <p class="card-text">View and manage items in your shopping cart.</p>
                    <a href="/ecommerce-platform/customer/cart.php" class="btn btn-outline-primary">View Cart</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Orders</h5>
                    <p class="card-text">Track your order history and status.</p>
                    <a href="/ecommerce-platform/customer/orders.php" class="btn btn-outline-primary">My Orders</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Account</h5>
                    <p class="card-text">Login or register to get started.</p>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/ecommerce-platform/customer/logout.php" class="btn btn-outline-danger">Logout</a>
                    <?php else: ?>
                        <a href="/ecommerce-platform/customer/login.php" class="btn btn-outline-success">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
