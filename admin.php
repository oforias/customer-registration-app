<?php
require_once __DIR__ . '/settings/core.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Redirect if not admin
if (!isAdmin()) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Customer Registration App</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>🔑 Admin Panel</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h2>Welcome, Administrator <?php echo htmlspecialchars($_SESSION['customer_name']); ?>!</h2>
                <p>You have full administrative privileges to manage the system.</p>
            </div>

            <div class="admin-grid">
                <div class="admin-card">
                    <h3>👥 User Management</h3>
                    <p>Manage customer accounts, roles, and permissions</p>
                    <div class="admin-actions">
                        <a href="manage-users.php" class="btn">View All Users</a>
                        <a href="add-user.php" class="btn">Add New User</a>
                        <a href="user-roles.php" class="btn">Manage Roles</a>
                    </div>
                </div>

                <div class="admin-card">
                    <h3>📊 System Reports</h3>
                    <p>View system analytics and user statistics</p>
                    <div class="admin-actions">
                        <a href="reports.php" class="btn">View Reports</a>
                        <a href="user-stats.php" class="btn">User Statistics</a>
                        <a href="activity-logs.php" class="btn">Activity Logs</a>
                    </div>
                </div>

                <div class="admin-card">
                    <h3>⚙️ System Settings</h3>
                    <p>Configure application settings and preferences</p>
                    <div class="admin-actions">
                        <a href="system-settings.php" class="btn">System Config</a>
                        <a href="security-settings.php" class="btn">Security Settings</a>
                        <a href="backup.php" class="btn">Backup & Restore</a>
                    </div>
                </div>

                <div class="admin-card">
                    <h3>🔒 Security Management</h3>
                    <p>Monitor security and manage access controls</p>
                    <div class="admin-actions">
                        <a href="security-audit.php" class="btn">Security Audit</a>
                        <a href="session-management.php" class="btn">Session Management</a>
                        <a href="access-logs.php" class="btn">Access Logs</a>
                    </div>
                </div>
            </div>

            <div class="admin-info">
                <h3>Current Session Information</h3>
                <div class="session-details">
                    <p><strong>Admin User:</strong> <?php echo htmlspecialchars($_SESSION['customer_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['customer_email']); ?></p>
                    <p><strong>Role Level:</strong> Administrator (Level 1)</p>
                    <p><strong>Login Time:</strong> <?php echo isset($_SESSION['login_time']) ? date('Y-m-d H:i:s', $_SESSION['login_time']) : 'Unknown'; ?></p>
                    <p><strong>Session ID:</strong> <?php echo session_id(); ?></p>
                </div>
            </div>

            <div class="admin-warning">
                <h4>⚠️ Administrative Notice</h4>
                <p>You are currently logged in with administrative privileges. Please use these tools responsibly and ensure you log out when finished.</p>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Customer Registration App - Admin Panel</p>
    </footer>
</body>
</html>
