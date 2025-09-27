<?php
require_once __DIR__ . '/settings/core.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Check if user is admin
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
    <title>Test Categories - Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>🧪 Test Category Management</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="admin/category.php">Category Management</a></li>
            <li><a href="admin.php">Admin Panel</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
        <div class="admin-container">
            <div class="page-header">
                <h2>Category Management Test</h2>
                <p>This page demonstrates the category management functionality</p>
            </div>

            <div class="admin-card">
                <h3>📋 Implementation Summary</h3>
                <div class="implementation-details">
                    <h4>✅ Completed Features:</h4>
                    <ul>
                        <li><strong>Category Class:</strong> Full CRUD operations with user isolation</li>
                        <li><strong>Category Controller:</strong> Input validation and business logic</li>
                        <li><strong>Action Scripts:</strong> All four required action scripts implemented</li>
                        <li><strong>Admin Interface:</strong> Complete category management page</li>
                        <li><strong>JavaScript:</strong> Client-side validation and AJAX functionality</li>
                        <li><strong>Database:</strong> Updated categories table with user_id column</li>
                        <li><strong>Security:</strong> Admin-only access with proper authentication</li>
                    </ul>

                    <h4>🔧 Technical Features:</h4>
                    <ul>
                        <li><strong>User Isolation:</strong> Each user can only see/manage their own categories</li>
                        <li><strong>Unique Names:</strong> Category names must be unique per user</li>
                        <li><strong>Input Validation:</strong> Both client-side and server-side validation</li>
                        <li><strong>Error Handling:</strong> Comprehensive error messages and user feedback</li>
                        <li><strong>Responsive Design:</strong> Mobile-friendly interface</li>
                        <li><strong>Modal Dialogs:</strong> Edit and delete confirmation modals</li>
                    </ul>

                    <h4>📁 File Structure:</h4>
                    <div class="file-structure">
                        <pre><code>classes/
├── category_class.php          # Category model with CRUD methods

controllers/
├── category_controller.php     # Category controller with validation

actions/
├── fetch_category_action.php   # GET categories for user
├── add_category_action.php     # POST new category
├── update_category_action.php  # POST update category
└── delete_category_action.php  # POST delete category

admin/
├── category.php               # Category management interface

js/
├── category.js               # Client-side validation & AJAX

database/
├── update_categories_table.sql # Database schema update</code></pre>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <h3>🚀 How to Use</h3>
                <ol>
                    <li><strong>Access:</strong> Only administrators can access category management</li>
                    <li><strong>Create:</strong> Use the "Add New Category" form to create categories</li>
                    <li><strong>View:</strong> All your categories are displayed in the table below</li>
                    <li><strong>Edit:</strong> Click "Edit" to modify category names</li>
                    <li><strong>Delete:</strong> Click "Delete" to remove categories (with confirmation)</li>
                </ol>
            </div>

            <div class="admin-card">
                <h3>🔒 Security Features</h3>
                <ul>
                    <li><strong>Authentication:</strong> Must be logged in to access</li>
                    <li><strong>Authorization:</strong> Admin privileges required</li>
                    <li><strong>User Isolation:</strong> Users can only manage their own categories</li>
                    <li><strong>Input Sanitization:</strong> All inputs are validated and sanitized</li>
                    <li><strong>SQL Injection Protection:</strong> Prepared statements used throughout</li>
                    <li><strong>XSS Protection:</strong> HTML escaping in JavaScript output</li>
                </ul>
            </div>

            <div class="admin-actions">
                <a href="admin/category.php" class="btn admin-btn">Go to Category Management</a>
                <a href="admin.php" class="btn">Back to Admin Panel</a>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Customer Registration App - Category Management Test</p>
    </footer>
</body>
</html>
