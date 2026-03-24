<?php
session_start();
require_once 'config.php';

if (isset($_POST['add_product'])) {

    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    // Move image to uploads folder
    move_uploaded_file($tmp_name, "uploads/".$image);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO admin (title, price, description, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $price, $description, $image);
    $stmt->execute();

    header("Location: admin_page.php");
    exit();
}
?>