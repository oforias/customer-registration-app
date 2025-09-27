<?php
require_once __DIR__ . '/settings/core.php';
require_once __DIR__ . '/classes/customer_class.php';

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

// Get all users
$customer = new Customer();
$users = [];

try {
    $stmt = $customer->conn->prepare("SELECT customer_id, customer_name, customer_email, customer_country, customer_city, user_role, customer_contact FROM customer ORDER BY customer_id");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Error fetching users: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>👥 User Management</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="admin.php">Admin Panel</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
        <div class="admin-container">
            <div class="page-header">
                <h2>Customer Management</h2>
                <p>Manage all registered customers and their roles</p>
            </div>

            <?php if (isset($error_message)): ?>
                <div class="error-message">
                    <p><?php echo htmlspecialchars($error_message); ?></p>
                </div>
            <?php endif; ?>

            <div class="users-table-container">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Contact</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['customer_id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['customer_name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['customer_email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['customer_city'] . ', ' . $user['customer_country']); ?></td>
                                    <td><?php echo htmlspecialchars($user['customer_contact']); ?></td>
                                    <td>
                                        <span class="role-badge <?php echo $user['user_role'] == 1 ? 'admin' : 'customer'; ?>">
                                            <?php echo $user['user_role'] == 1 ? 'Administrator' : 'Customer'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="edit-user.php?id=<?php echo $user['customer_id']; ?>" class="btn btn-small">Edit</a>
                                            <?php if ($user['customer_id'] != $_SESSION['customer_id']): ?>
                                                <a href="delete-user.php?id=<?php echo $user['customer_id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                            <?php else: ?>
                                                <span class="current-user">Current User</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="no-data">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="admin-stats">
                <h3>User Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h4>Total Users</h4>
                        <p class="stat-number"><?php echo count($users); ?></p>
                    </div>
                    <div class="stat-card">
                        <h4>Administrators</h4>
                        <p class="stat-number"><?php echo count(array_filter($users, function($user) { return $user['user_role'] == 1; })); ?></p>
                    </div>
                    <div class="stat-card">
                        <h4>Regular Customers</h4>
                        <p class="stat-number"><?php echo count(array_filter($users, function($user) { return $user['user_role'] == 2; })); ?></p>
                    </div>
                </div>
            </div>

            <div class="admin-actions">
                <a href="admin.php" class="btn">Back to Admin Panel</a>
                <a href="add-user.php" class="btn">Add New User</a>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Customer Registration App - Admin Panel</p>
    </footer>
</body>
</html>
