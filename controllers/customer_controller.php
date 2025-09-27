<?php
require_once __DIR__ . '/../classes/customer_class.php';

class CustomerController {
    private $customer;

    public function __construct() {
        $this->customer = new Customer();
    }

    public function register_customer_ctr($data) {
        // Validate input data
        $validation = $this->validate_registration_data($data);
        if ($validation['status'] === 'error') {
            return $validation;
        }

        // Call the add method from the customer class
        return $this->customer->add(
            $data['full_name'],
            $data['email'],
            $data['password'],
            $data['country'],
            $data['city'],
            $data['contact_number'],
            $data['user_role'] ?? 2
        );
    }

    private function validate_registration_data($data) {
        // Check required fields
        $requiredFields = ['full_name', 'email', 'password', 'country', 'city', 'contact_number'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return ['status' => 'error', 'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required.'];
            }
        }

        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['status' => 'error', 'message' => 'Invalid email format.'];
        }

        // Validate password length
        if (strlen($data['password']) < 6) {
            return ['status' => 'error', 'message' => 'Password must be at least 6 characters long.'];
        }

        // Validate contact number format
        if (!preg_match('/^\+?[0-9]{10,15}$/', $data['contact_number'])) {
            return ['status' => 'error', 'message' => 'Invalid contact number format.'];
        }

        // Validate field lengths based on database schema
        if (strlen($data['full_name']) > 100) {
            return ['status' => 'error', 'message' => 'Full name must be less than 100 characters.'];
        }
        if (strlen($data['email']) > 50) {
            return ['status' => 'error', 'message' => 'Email must be less than 50 characters.'];
        }
        if (strlen($data['country']) > 30) {
            return ['status' => 'error', 'message' => 'Country must be less than 30 characters.'];
        }
        if (strlen($data['city']) > 30) {
            return ['status' => 'error', 'message' => 'City must be less than 30 characters.'];
        }
        if (strlen($data['contact_number']) > 15) {
            return ['status' => 'error', 'message' => 'Contact number must be less than 15 characters.'];
        }

        return ['status' => 'success'];
    }

    public function login_customer_ctr($data) {
        // Validate input data
        $validation = $this->validate_login_data($data);
        if ($validation['status'] === 'error') {
            return $validation;
        }

        // Call the login method from the customer class
        return $this->customer->login($data['email'], $data['password']);
    }

    private function validate_login_data($data) {
        // Check required fields
        if (empty($data['email']) || empty($data['password'])) {
            return ['status' => 'error', 'message' => 'Email and password are required.'];
        }

        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['status' => 'error', 'message' => 'Invalid email format.'];
        }

        // Validate email length
        if (strlen($data['email']) > 50) {
            return ['status' => 'error', 'message' => 'Email must be less than 50 characters.'];
        }

        return ['status' => 'success'];
    }
}
?>