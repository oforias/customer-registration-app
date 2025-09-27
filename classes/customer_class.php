<?php
require_once __DIR__ . '/../database/connection.php';

class Customer extends DatabaseConnection {
    public function __construct() {
        $this->conn = $this->getConnection();
    }

    public function add($fullName, $email, $password, $country, $city, $contactNumber, $userRole = 2) {
        try {
            // Check if email already exists
            if ($this->emailExists($email)) {
                return ['status' => 'error', 'message' => 'Email already exists.'];
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("INSERT INTO customer (customer_name, customer_email, customer_pass, customer_country, customer_city, customer_contact, user_role) VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            if ($stmt->execute([$fullName, $email, $hashedPassword, $country, $city, $contactNumber, $userRole])) {
                return ['status' => 'success', 'message' => 'Customer registered successfully.'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to register customer.'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function edit($customerId, $fullName, $email, $country, $city, $contactNumber) {
        try {
            $stmt = $this->conn->prepare("UPDATE customer SET customer_name = ?, customer_email = ?, customer_country = ?, customer_city = ?, customer_contact = ? WHERE customer_id = ?");
            
            if ($stmt->execute([$fullName, $email, $country, $city, $contactNumber, $customerId])) {
                return ['status' => 'success', 'message' => 'Customer updated successfully.'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to update customer.'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function delete($customerId) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM customer WHERE customer_id = ?");
            
            if ($stmt->execute([$customerId])) {
                return ['status' => 'success', 'message' => 'Customer deleted successfully.'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to delete customer.'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function emailExists($email) {
        try {
            $stmt = $this->conn->prepare("SELECT customer_id FROM customer WHERE customer_email = ?");
            $stmt->execute([$email]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getCustomerById($customerId) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM customer WHERE customer_id = ?");
            $stmt->execute([$customerId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getCustomerByEmail($email) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM customer WHERE customer_email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }

    public function login($email, $password) {
        try {
            // Get customer by email
            $customer = $this->getCustomerByEmail($email);
            
            if (!$customer) {
                return ['status' => 'error', 'message' => 'Invalid email or password.'];
            }

            // Verify password
            if (!$this->verifyPassword($password, $customer['customer_pass'])) {
                return ['status' => 'error', 'message' => 'Invalid email or password.'];
            }

            // Return customer data for session
            return [
                'status' => 'success', 
                'message' => 'Login successful.',
                'customer' => [
                    'id' => $customer['customer_id'],
                    'name' => $customer['customer_name'],
                    'email' => $customer['customer_email'],
                    'role' => $customer['user_role'],
                    'country' => $customer['customer_country'],
                    'city' => $customer['customer_city']
                ]
            ];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}
?>