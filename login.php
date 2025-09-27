<?php
require_once __DIR__ . '/settings/core.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Customer Registration App</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/login.js" defer></script>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2>Login</h2>
            <form id="loginForm">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required maxlength="50">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit" id="loginButton">Login</button>
                    <div id="loadingIndicator" class="loading-indicator" style="display: none;">
                        <span>Logging in...</span>
                    </div>
                </div>
            </form>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>