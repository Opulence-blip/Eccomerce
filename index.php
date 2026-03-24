
<?php
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];

$activeForm = $_SESSION['active_form'] ?? 'login';

unset($_SESSION['login_error'], $_SESSION['register_error'], $_SESSION['active_form']);


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
    <meta name="viewpoort" content="width=device-width, initial-scale=1.0" >
    <title>A Full Simple Eccommrce Website in South Africa</title>
    <link rel="stylesheet" href="style.css">
</head>
    
<body>
    <div class="container">
        <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
           <form action="login_register.php" method="post">
                <h2>Login</h2>
                <?= showError($errors["login"]); ?>
                
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login" >Login</button>
                <p>Don't have an account? 
                    <a href="register.php">Register</a>
                </p>
           </form>     
        </div>
    </div>

</body>
</html>
