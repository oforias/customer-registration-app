<?php
require_once __DIR__ . '/../settings/core.php';
require_once __DIR__ . '/../classes/category_class.php';
require_once __DIR__ . '/../controllers/category_controller.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!isLoggedIn()) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit();
}

// Check if user is admin
if (!isAdmin()) {
    echo json_encode(['status' => 'error', 'message' => 'Access denied. Admin privileges required.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = $_POST['category_id'] ?? 0;
    
    // Create an instance of the category controller
    $categoryController = new CategoryController();

    // Prepare data for deleting category
    $data = [
        'category_id' => $categoryId,
        'user_id' => $_SESSION['customer_id']
    ];

    // Invoke the delete category method
    $result = $categoryController->delete_category_ctr($data);

    // Return the result as JSON
    echo json_encode($result);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
