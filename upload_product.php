
<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_POST['upload'])) {

    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Handle file upload
    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $uploadDir = "uploads/";

    // Create folder if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $targetFile = $uploadDir . basename($imageName);

    if (move_uploaded_file($imageTmp, $targetFile)) {
        $stmt = $conn->prepare("INSERT INTO admin (title, price, description, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $price, $description, $imageName);
        $stmt->execute();

        $_SESSION['message'] = "Product uploaded successfully!";
        header("Location: admin_page.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to upload image!";
        header("Location: admin_page.php");
        exit();
    }
}
?>