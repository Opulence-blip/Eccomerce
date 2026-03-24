<?php
session_start();
require_once 'config.php';

/* ------------------ REGISTER ------------------ */
if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Check if email already exists
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Already registered
        $_SESSION['register_error'] = 'Email is already registered';
        $_SESSION['active_form'] = 'register';
        header("Location: register.php");
        exit();
    }

    // Register new user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    $stmt->execute();

    // Auto-login after registration
        $_SESSION['register_success'] = 'Registration successful! Please log in.';
        header("Location: index.php"); // login page
        exit();

    }

/* ------------------ LOGIN ------------------ */
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['login_error'] = 'Account not found. Please register first.';
        $_SESSION['active_form'] = 'login';
        header("Location: index.php");
        exit();
    }

    $user = $result->fetch_assoc();

    if (!password_verify($password, $user['password'])) {
        $_SESSION['login_error'] = 'Incorrect email or password';
        $_SESSION['active_form'] = 'login';
        header("Location: index.php");
        exit();
    }

    // Login successful
    $_SESSION['name'] = $user['name'];
    $_SESSION['email'] = $user['email'];
    // Login successful
$_SESSION['name'] = $user['name'];
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $user['role']; 

if ($user['role'] === 'admin') {
    header("Location: admin_page.php");
} else {
    header("Location: user_page.php");
}
exit();
    if ($user['role'] === 'admin') {
        header("Location: admin_page.php");
    } else {
        header("Location: user_page.php");
    }
    exit();
}
?>
