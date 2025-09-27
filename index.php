<?php
require_once __DIR__ . '/settings/core.php';
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
            <?php if (isLoggedIn()): ?>
                <li><a href="logout.php">Logout</a></li>
                <?php if (isAdmin()): ?>
                    <li><a href="admin/category.php">Category</a></li>
                    <li><a href="admin.php">Admin Panel</a></li>
                <?php endif; ?>
                <li><span>Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>!</span></li>
            <?php else: ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <main>
        <?php if (isLoggedIn()): ?>
            <div class="welcome-message">
                <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>!</h2>
                <p>You are successfully logged in.</p>
                <div class="user-info">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['customer_email']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($_SESSION['customer_city']); ?>, <?php echo htmlspecialchars($_SESSION['customer_country']); ?></p>
                    <p><strong>Role:</strong> <?php echo isAdmin() ? 'Administrator' : 'Customer'; ?></p>
                    <?php if (isAdmin()): ?>
                        <p class="admin-badge">🔑 Admin Access Granted</p>
                    <?php endif; ?>
                </div>
                <div class="quick-actions">
                    <a href="dashboard.php" class="btn">Go to Dashboard</a>
                    <?php if (isAdmin()): ?>
                        <a href="admin.php" class="btn admin-btn">Admin Panel</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="welcome-guest">
                <h2>Welcome to Customer Registration App</h2>
                <p>Please choose an option above to get started.</p>
                <div class="guest-actions">
                    <a href="register.php" class="btn">Create Account</a>
                    <a href="login.php" class="btn">Login</a>
                </div>
            </div>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Customer Registration App</p>
    </footer>
</body>
</html>