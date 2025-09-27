<?php
require_once __DIR__ . '/settings/core.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Customer Registration App</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>User Dashboard</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
            <?php if (isAdmin()): ?>
                <li><a href="admin.php">Admin Panel</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <main>
        <div class="dashboard-container">
            <div class="user-profile">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>!</h2>
                <div class="profile-info">
                    <div class="info-card">
                        <h3>Personal Information</h3>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['customer_email']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($_SESSION['customer_city']); ?>, <?php echo htmlspecialchars($_SESSION['customer_country']); ?></p>
                        <p><strong>Account Type:</strong> <?php echo isAdmin() ? 'Administrator' : 'Customer'; ?></p>
                        <p><strong>Login Time:</strong> <?php echo isset($_SESSION['login_time']) ? date('Y-m-d H:i:s', $_SESSION['login_time']) : 'Unknown'; ?></p>
                    </div>
                </div>
            </div>

            <div class="dashboard-actions">
                <h3>Quick Actions</h3>
                <div class="action-buttons">
                    <a href="profile.php" class="btn">View Profile</a>
                    <a href="settings.php" class="btn">Account Settings</a>
                    <?php if (isAdmin()): ?>
                        <a href="admin.php" class="btn admin-btn">Admin Panel</a>
                        <a href="manage-users.php" class="btn admin-btn">Manage Users</a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (isAdmin()): ?>
                <div class="admin-section">
                    <h3>🔑 Administrator Tools</h3>
                    <div class="admin-actions">
                        <div class="admin-card">
                            <h4>User Management</h4>
                            <p>Manage customer accounts and permissions</p>
                            <a href="manage-users.php" class="btn">Manage Users</a>
                        </div>
                        <div class="admin-card">
                            <h4>System Settings</h4>
                            <p>Configure application settings</p>
                            <a href="system-settings.php" class="btn">System Settings</a>
                        </div>
                        <div class="admin-card">
                            <h4>Reports</h4>
                            <p>View system reports and analytics</p>
                            <a href="reports.php" class="btn">View Reports</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Customer Registration App</p>
    </footer>
</body>
</html>
