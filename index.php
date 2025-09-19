<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration App</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Welcome to the Customer Registration App</h1>
    </header>
    <nav>
        <ul>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                <li><a href="logout.php">Logout</a></li>
                <li><span>Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>!</span></li>
            <?php else: ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <main>
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            <div class="welcome-message">
                <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>!</h2>
                <p>You are successfully logged in.</p>
                <div class="user-info">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['customer_email']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($_SESSION['customer_city']); ?>, <?php echo htmlspecialchars($_SESSION['customer_country']); ?></p>
                    <p><strong>Role:</strong> <?php echo $_SESSION['user_role'] == 1 ? 'Administrator' : 'Customer'; ?></p>
                </div>
            </div>
        <?php else: ?>
            <p>Please choose an option above to get started.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Customer Registration App</p>
    </footer>
</body>
</html>