<?php
require_once __DIR__ . '/settings/core.php';

// Example 1: Redirect if not logged in
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Example 2: Check for admin privileges
$isAdmin = isAdmin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example Protected Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Example Protected Page</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <?php if ($isAdmin): ?>
                <li><a href="admin.php">Admin Panel</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
        <div class="container">
            <div class="welcome-message">
                <h2>This is a Protected Page</h2>
                <p>This page demonstrates how to use the session management functions.</p>
                
                <div class="user-info">
                    <h3>Session Information:</h3>
                    <p><strong>User ID:</strong> <?php echo htmlspecialchars($_SESSION['customer_id']); ?></p>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['customer_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['customer_email']); ?></p>
                    <p><strong>Is Logged In:</strong> <?php echo isLoggedIn() ? 'Yes' : 'No'; ?></p>
                    <p><strong>Is Admin:</strong> <?php echo isAdmin() ? 'Yes' : 'No'; ?></p>
                    <p><strong>User Role:</strong> <?php echo $_SESSION['user_role'] == 1 ? 'Administrator' : 'Customer'; ?></p>
                </div>

                <?php if ($isAdmin): ?>
                    <div class="admin-section">
                        <h3>🔑 Admin-Only Content</h3>
                        <p>This content is only visible to administrators!</p>
                        <div class="admin-actions">
                            <a href="admin.php" class="btn admin-btn">Go to Admin Panel</a>
                            <a href="manage-users.php" class="btn admin-btn">Manage Users</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="regular-user-section">
                        <h3>👤 Regular User Content</h3>
                        <p>This content is visible to all authenticated users.</p>
                    </div>
                <?php endif; ?>

                <div class="code-examples">
                    <h3>How to Use Session Functions:</h3>
                    <div class="code-block">
                        <h4>1. Check if user is logged in:</h4>
                        <pre><code>&lt;?php
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}
?&gt;</code></pre>

                        <h4>2. Check if user is admin:</h4>
                        <pre><code>&lt;?php
if (isAdmin()) {
    // Show admin content
    echo "&lt;div class='admin-panel'&gt;Admin Panel&lt;/div&gt;";
}
?&gt;</code></pre>

                        <h4>3. Conditional content based on role:</h4>
                        <pre><code>&lt;?php if (isAdmin()): ?&gt;
    &lt;a href="admin.php"&gt;Admin Panel&lt;/a&gt;
&lt;?php endif; ?&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Customer Registration App</p>
    </footer>
</body>
</html>
