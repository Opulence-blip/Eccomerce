<?php
session_start();
require_once 'config.php';

// Protect page
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Fetch all products from admin table
$productQuery = $conn->query("SELECT * FROM admin ORDER BY created_at DESC");

$products = [];
while ($row = $productQuery->fetch_assoc()) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewpoort" content="width=device-width, initial-scale=1.0" >
    <title>A Full Simple Eccommrce Website in South Africa</title>
    
    <link rel="stylesheet" href="style2.css">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.9.0/fonts/remixicon.css"
    rel="stylesheet"
    />
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
    
    <section class="product-collection">
  
        <div class="product-list">
            <?php foreach($products as $product): ?>
                <div class="product-card">
                    <div class="img-box">
                        <!-- Make image clickable -->
                        <a href="product-detail.php?id=<?= $product['id'] ?>">
                            <img src="uploads/<?= $product['image'] ?>" alt="<?= $product['title'] ?>">
                        </a>
                    </div>
                    <h2 class="title"><?= $product['title'] ?></h2>
                    <span class="price">R<?= $product['price'] ?></span>
                    <!-- Or make the button go to detail page -->
                    
                </div>
            <?php endforeach; ?>
        </div>
     </section>

    <script src="product.js"></script>
    <script src="script.js"></script>
</body>
</html>
