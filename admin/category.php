<?php
require_once __DIR__ . '/../settings/core.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

// Check if user is admin
if (!isAdmin()) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/category.js" defer></script>
</head>
<body>
    <header>
        <h1>📁 Category Management</h1>
    </header>
    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../dashboard.php">Dashboard</a></li>
            <li><a href="../admin.php">Admin Panel</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
        <div class="admin-container">
            <div class="page-header">
                <h2>Manage Categories</h2>
                <p>Create, edit, and delete categories for your e-commerce platform</p>
            </div>

            <!-- Add Category Form -->
            <div class="admin-card">
                <h3>➕ Add New Category</h3>
                <form id="addCategoryForm">
                    <div class="form-group">
                        <label for="categoryName">Category Name:</label>
                        <input type="text" id="categoryName" name="category_name" required maxlength="100" placeholder="Enter category name">
                        <div id="categoryNameError" class="error"></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="addCategoryBtn">Add Category</button>
                        <div id="addLoadingIndicator" class="loading-indicator" style="display: none;">
                            <span>Adding category...</span>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Categories List -->
            <div class="admin-card">
                <h3>📋 Your Categories</h3>
                <div id="categoriesContainer">
                    <div id="loadingMessage" class="loading-indicator">
                        <span>Loading categories...</span>
                    </div>
                </div>
            </div>

            <!-- Edit Category Modal -->
            <div id="editModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>✏️ Edit Category</h3>
                        <span class="close" onclick="closeEditModal()">&times;</span>
                    </div>
                    <form id="editCategoryForm">
                        <input type="hidden" id="editCategoryId" name="category_id">
                        <div class="form-group">
                            <label for="editCategoryName">Category Name:</label>
                            <input type="text" id="editCategoryName" name="category_name" required maxlength="100">
                            <div id="editCategoryNameError" class="error"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="editCategoryBtn">Update Category</button>
                            <div id="editLoadingIndicator" class="loading-indicator" style="display: none;">
                                <span>Updating category...</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div id="deleteModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>🗑️ Delete Category</h3>
                        <span class="close" onclick="closeDeleteModal()">&times;</span>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this category?</p>
                        <p><strong>Category:</strong> <span id="deleteCategoryName"></span></p>
                        <p class="warning-text">This action cannot be undone!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Category</button>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            <div id="messageContainer" style="display: none;">
                <div id="messageContent" class="message"></div>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Customer Registration App - Category Management</p>
    </footer>
</body>
</html>
