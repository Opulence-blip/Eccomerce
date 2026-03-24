<?php
session_start();
require_once 'config.php';

// Protect admin page
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle messages
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Upload Products</title>
<link rel="stylesheet" href="style2.css">
</head>
<body>


<h2>Upload New Product</h2>

<?php if ($message): ?>
<p style="color:green;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form action="upload_product.php" method="post" enctype="multipart/form-data">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Price:</label><br>
    <input type="text" name="price" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="4" required></textarea><br><br>

    <label>Image:</label><br>
    <input type="file" name="image" accept="image/*" required><br><br>

    <button type="submit" name="upload">Upload Product</button>
</form>

<h2>Existing Products</h2>
<div class="product-list">
<?php
$result = $conn->query("SELECT * FROM admin ORDER BY created_at DESC");
while($row = $result->fetch_assoc()):
?>
<div class="product-card">
    <img src="uploads/<?= $row['image'] ?>" width="150">
    <h3><?= $row['title'] ?></h3>
    <p>R<?= $row['price'] ?></p>
    <p><?= $row['description'] ?></p>
</div>
<?php endwhile; ?>
</div>

</body>
</html>