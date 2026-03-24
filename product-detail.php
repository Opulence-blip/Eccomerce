<?php
session_start();
require_once 'config.php';

// Protect page
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Check product ID
if (!isset($_GET['id'])) {
    header("Location: user_page.php");
    exit();
}

$productId = (int)$_GET['id'];

// Fetch product from admin table
$stmt = $conn->prepare("SELECT * FROM admin WHERE id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "Product not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($product['title']); ?> - Ecommrce</title>
<link rel="stylesheet" href="style2.css">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.9.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>

<nav>
    <h1>Welcome, <span><?= htmlspecialchars($_SESSION['name']); ?></span></h1>
    <a href="user_page.php" class="logo">Ecommrce</a>
    <a href="cart.php" class="cart-icon">
        <i class="ri-shopping-bag-line"></i>
        <span class="cart-item-count"></span>
    </a>
</nav>

<div class="product-detail">
    <div class="product-img">
        <div class="thumbnail-list"></div>
        <div class="main-img">
            <img src="uploads/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['title']); ?>">
        </div>
    </div>

    <div class="product-info">
        <h2 class="title"><?= htmlspecialchars($product['title']); ?></h2>
        <span class="price">R<?= htmlspecialchars($product['price']); ?></span>
        <p class="description"><?= htmlspecialchars($product['description']); ?></p>

        <div class="size-selection">
            <p>Select Size</p>
            <div class="size-options"></div>
        </div>
        <div class="color-selection">
            <p>Select Color</p>
            <div class="color-options"></div>
        </div>

        <button class="btn" id="add-cart-btn">Add To Cart</button>

        <div class="product-policy">
            <p>100% Original Product</p>
            <p>Easy return within 14 days</p>
        </div>
    </div>
</div>

<script>
    const productFromPHP = <?= json_encode($product); ?>;
    sessionStorage.setItem("selectedProduct", JSON.stringify(productFromPHP));
</script>

<script src="script.js"></script>

</body>
</html>