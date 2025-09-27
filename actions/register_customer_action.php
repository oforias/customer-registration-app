<?php
require_once '../classes/customer_class.php';
require_once '../controllers/customer_controller.php';

// Set content type to JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $country = $_POST['country'] ?? '';
    $city = $_POST['city'] ?? '';
    $contactNumber = $_POST['contact_number'] ?? '';
    
    // Create an instance of the customer controller
    $customerController = new CustomerController();

    // Prepare data for registration
    $customerData = [
        'full_name' => $fullName,
        'email' => $email,
        'password' => $password, // Don't hash here, let the controller handle it
        'country' => $country,
        'city' => $city,
        'contact_number' => $contactNumber,
        'user_role' => 2 // Default user role for customers
    ];

    // Invoke the registration method
    $result = $customerController->register_customer_ctr($customerData);

    // Return the result as JSON
    echo json_encode($result);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>