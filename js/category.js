// Category Management JavaScript

// Global variables
let categories = [];
let currentEditId = null;
let currentDeleteId = null;

// DOM Content Loaded Event
document.addEventListener('DOMContentLoaded', function() {
    loadCategories();
    setupEventListeners();
});

// Setup event listeners
function setupEventListeners() {
    // Add category form
    document.getElementById('addCategoryForm').addEventListener('submit', handleAddCategory);
    
    // Edit category form
    document.getElementById('editCategoryForm').addEventListener('submit', handleEditCategory);
    
    // Delete confirmation button
    document.getElementById('confirmDeleteBtn').addEventListener('click', handleDeleteCategory);
    
    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        const editModal = document.getElementById('editModal');
        const deleteModal = document.getElementById('deleteModal');
        
        if (event.target === editModal) {
            closeEditModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    });
}

// Load categories from server
async function loadCategories() {
    try {
        showLoading(true);
        const response = await fetch('../actions/fetch_category_action.php');
        const result = await response.json();
        
        if (result.status === 'success') {
            categories = result.categories || [];
            displayCategories();
        } else {
            showMessage('Error loading categories: ' + result.message, 'error');
        }
    } catch (error) {
        showMessage('Network error: ' + error.message, 'error');
    } finally {
        showLoading(false);
    }
}

// Display categories in the UI
function displayCategories() {
    const container = document.getElementById('categoriesContainer');
    
    if (categories.length === 0) {
        container.innerHTML = '<div class="no-data">No categories found. Create your first category above!</div>';
        return;
    }
    
    let html = '<div class="categories-table-container"><table class="categories-table"><thead><tr><th>ID</th><th>Category Name</th><th>Actions</th></tr></thead><tbody>';
    
    categories.forEach(category => {
        html += `
            <tr>
                <td>${category.cat_id}</td>
                <td>${escapeHtml(category.cat_name)}</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-small" onclick="openEditModal(${category.cat_id}, '${escapeHtml(category.cat_name)}')">Edit</button>
                        <button class="btn btn-small btn-danger" onclick="openDeleteModal(${category.cat_id}, '${escapeHtml(category.cat_name)}')">Delete</button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    html += '</tbody></table></div>';
    container.innerHTML = html;
}

// Handle add category form submission
async function handleAddCategory(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const categoryName = formData.get('category_name').trim();
    
    // Validate input
    if (!validateCategoryName(categoryName, 'categoryNameError')) {
        return;
    }
    
    try {
        showLoading(true, 'addLoadingIndicator');
        disableButton('addCategoryBtn', true);
        
        const response = await fetch('../actions/add_category_action.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.status === 'success') {
            showMessage(result.message, 'success');
            event.target.reset();
            loadCategories(); // Reload categories
        } else {
            showMessage(result.message, 'error');
        }
    } catch (error) {
        showMessage('Network error: ' + error.message, 'error');
    } finally {
        showLoading(false, 'addLoadingIndicator');
        disableButton('addCategoryBtn', false);
    }
}

// Handle edit category form submission
async function handleEditCategory(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const categoryName = formData.get('category_name').trim();
    
    // Validate input
    if (!validateCategoryName(categoryName, 'editCategoryNameError')) {
        return;
    }
    
    try {
        showLoading(true, 'editLoadingIndicator');
        disableButton('editCategoryBtn', true);
        
        const response = await fetch('../actions/update_category_action.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.status === 'success') {
            showMessage(result.message, 'success');
            closeEditModal();
            loadCategories(); // Reload categories
        } else {
            showMessage(result.message, 'error');
        }
    } catch (error) {
        showMessage('Network error: ' + error.message, 'error');
    } finally {
        showLoading(false, 'editLoadingIndicator');
        disableButton('editCategoryBtn', false);
    }
}

// Handle delete category
async function handleDeleteCategory() {
    if (!currentDeleteId) return;
    
    const formData = new FormData();
    formData.append('category_id', currentDeleteId);
    
    try {
        showLoading(true);
        
        const response = await fetch('../actions/delete_category_action.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.status === 'success') {
            showMessage(result.message, 'success');
            closeDeleteModal();
            loadCategories(); // Reload categories
        } else {
            showMessage(result.message, 'error');
        }
    } catch (error) {
        showMessage('Network error: ' + error.message, 'error');
    } finally {
        showLoading(false);
    }
}

// Open edit modal
function openEditModal(categoryId, categoryName) {
    currentEditId = categoryId;
    document.getElementById('editCategoryId').value = categoryId;
    document.getElementById('editCategoryName').value = categoryName;
    document.getElementById('editModal').style.display = 'block';
    clearError('editCategoryNameError');
}

// Close edit modal
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    currentEditId = null;
    document.getElementById('editCategoryForm').reset();
    clearError('editCategoryNameError');
}

// Open delete modal
function openDeleteModal(categoryId, categoryName) {
    currentDeleteId = categoryId;
    document.getElementById('deleteCategoryName').textContent = categoryName;
    document.getElementById('deleteModal').style.display = 'block';
}

// Close delete modal
function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    currentDeleteId = null;
}

// Validate category name
function validateCategoryName(name, errorElementId) {
    const errorElement = document.getElementById(errorElementId);
    
    if (!name) {
        showError(errorElement, 'Category name is required.');
        return false;
    }
    
    if (name.length < 2) {
        showError(errorElement, 'Category name must be at least 2 characters long.');
        return false;
    }
    
    if (name.length > 100) {
        showError(errorElement, 'Category name must not exceed 100 characters.');
        return false;
    }
    
    // Check for duplicate names (excluding current category if editing)
    const isDuplicate = categories.some(cat => {
        if (currentEditId && cat.cat_id == currentEditId) {
            return false; // Skip current category when editing
        }
        return cat.cat_name.toLowerCase() === name.toLowerCase();
    });
    
    if (isDuplicate) {
        showError(errorElement, 'Category name already exists.');
        return false;
    }
    
    clearError(errorElement);
    return true;
}

// Show error message
function showError(element, message) {
    element.textContent = message;
    element.style.display = 'block';
}

// Clear error message
function clearError(elementId) {
    const element = document.getElementById(elementId);
    element.textContent = '';
    element.style.display = 'none';
}

// Show loading indicator
function showLoading(show, indicatorId = 'loadingMessage') {
    const indicator = document.getElementById(indicatorId);
    if (indicator) {
        indicator.style.display = show ? 'block' : 'none';
    }
}

// Disable/enable button
function disableButton(buttonId, disable) {
    const button = document.getElementById(buttonId);
    if (button) {
        button.disabled = disable;
    }
}

// Show message to user
function showMessage(message, type) {
    const container = document.getElementById('messageContainer');
    const content = document.getElementById('messageContent');
    
    content.textContent = message;
    content.className = `message ${type}`;
    container.style.display = 'block';
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        container.style.display = 'none';
    }, 5000);
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
