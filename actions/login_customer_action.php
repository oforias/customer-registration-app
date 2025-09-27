<?php
require_once __DIR__ . '/../settings/core.php';
require_once '../classes/customer_class.php';
require_once '../controllers/customer_controller.php';

// Set content type to JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Create an instance of the customer controller
    $customerController = new CustomerController();

    // Prepare data for login
    $loginData = [
        'email' => $email,
        'password' => $password
    ];

    // Invoke the login method
    $result = $customerController->login_customer_ctr($loginData);

    // If login successful, set session variables
    if ($result['status'] === 'success') {
        $_SESSION['customer_id'] = $result['customer']['id'];
        $_SESSION['customer_name'] = $result['customer']['name'];
        $_SESSION['customer_email'] = $result['customer']['email'];
        $_SESSION['user_role'] = $result['customer']['role'];
        $_SESSION['customer_country'] = $result['customer']['country'];
        $_SESSION['customer_city'] = $result['customer']['city'];
        $_SESSION['logged_in'] = true;
        
        // Add login timestamp
        $_SESSION['login_time'] = time();
    }

    // Return the result as JSON
    echo json_encode($result);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
