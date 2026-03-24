<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" >
<title>Cart - Ecommrce</title>
<link rel="stylesheet" href="style2.css">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.9.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>

<nav>
    <h1>Welcome, <span><?= $_SESSION['name']; ?></span></h1>
    <a href="user_page.php" class="logo">Ecommrce</a>
    <a href="cart.php" class="cart-icon">
        <i class="ri-shopping-bag-line"></i>
        <span class="cart-item-count"></span>
    </a>
</nav>

<div class="cart">
    <div class="cart-header">
        <span>Products</span>
        <span>Price</span>
        <span>Quantity</span>
        <span>Total</span>
        <span>Remove</span>
    </div>

    <div class="cart-items">
        <!-- Items will be dynamically inserted here by script.js -->
    </div>

    <div class="cart-total">
        <h3>Cart Total</h3>
        <p>
            <span>Subtotal</span>
            <span class="subtotal">R0</span>
        </p>
        <p>
            <span>Delivery</span>
            <span>Free</span>
        </p>
        <p>
            <span>Grand Total</span>
            <span class="grand-total">R0</span>
        </p>
        <button class="btn">Proceed to Checkout</button>
    </div>
</div>

<script src="script.js"></script>


</body>
</html>