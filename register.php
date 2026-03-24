
<?php
session_start();

$errors = [
    
    'register' => $_SESSION['register_error'] ?? ''
];

$activeForm = $_SESSION['active_form'] ?? 'register';

unset($_SESSION['register_error'], $_SESSION['active_form']);


function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Full Simple Eccommrce Website in South Africa</title>
    <link rel="stylesheet" href="style.css">
</head>
    
<body>
    <div class="container">
        <div class="form-box <?= isActiveForm('register', $activeForm); ?>" id="register-form">
           <form action="login_register.php" method="post">
                <h2>Register</h2>
                
                <?= showError($errors["register"]); ?>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name='role' required>
                    <option value="">--Select Role--</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>

                <button type="submit" name="register">Register</button>
                <p>Already have an account?
                    <a href="index.php">Login</a>
                </p>
           </form>     
        </div>
    </div>

</body>
</html>
