<?php
require_once __DIR__ . '/../database/connection.php';

class Category extends DatabaseConnection {
    public function __construct() {
        $this->conn = $this->getConnection();
    }

    /**
     * Add a new category
     * @param string $categoryName The name of the category
     * @param int $userId The ID of the user creating the category
     * @return array Result array with status and message
     */
    public function add($categoryName, $userId) {
        try {
            // Check if category name already exists for this user
            if ($this->categoryNameExists($categoryName, $userId)) {
                return ['status' => 'error', 'message' => 'Category name already exists.'];
            }

            $stmt = $this->conn->prepare("INSERT INTO categories (cat_name, user_id) VALUES (?, ?)");
            
            if ($stmt->execute([$categoryName, $userId])) {
                return ['status' => 'success', 'message' => 'Category added successfully.'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to add category.'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Edit/Update a category
     * @param int $categoryId The ID of the category to update
     * @param string $categoryName The new name for the category
     * @param int $userId The ID of the user (for security check)
     * @return array Result array with status and message
     */
    public function edit($categoryId, $categoryName, $userId) {
        try {
            // Check if category exists and belongs to user
            if (!$this->categoryBelongsToUser($categoryId, $userId)) {
                return ['status' => 'error', 'message' => 'Category not found or access denied.'];
            }

            // Check if new category name already exists for this user
            if ($this->categoryNameExists($categoryName, $userId, $categoryId)) {
                return ['status' => 'error', 'message' => 'Category name already exists.'];
            }

            $stmt = $this->conn->prepare("UPDATE categories SET cat_name = ? WHERE cat_id = ? AND user_id = ?");
            
            if ($stmt->execute([$categoryName, $categoryId, $userId])) {
                return ['status' => 'success', 'message' => 'Category updated successfully.'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to update category.'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Delete a category
     * @param int $categoryId The ID of the category to delete
     * @param int $userId The ID of the user (for security check)
     * @return array Result array with status and message
     */
    public function delete($categoryId, $userId) {
        try {
            // Check if category exists and belongs to user
            if (!$this->categoryBelongsToUser($categoryId, $userId)) {
                return ['status' => 'error', 'message' => 'Category not found or access denied.'];
            }

            $stmt = $this->conn->prepare("DELETE FROM categories WHERE cat_id = ? AND user_id = ?");
            
            if ($stmt->execute([$categoryId, $userId])) {
                return ['status' => 'success', 'message' => 'Category deleted successfully.'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to delete category.'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Get all categories for a specific user
     * @param int $userId The ID of the user
     * @return array Array of categories
     */
    public function getCategoriesByUser($userId) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM categories WHERE user_id = ? ORDER BY cat_name ASC");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Get a specific category by ID
     * @param int $categoryId The ID of the category
     * @param int $userId The ID of the user (for security check)
     * @return array|false Category data or false if not found
     */
    public function getCategoryById($categoryId, $userId) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM categories WHERE cat_id = ? AND user_id = ?");
            $stmt->execute([$categoryId, $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Check if category name already exists for a user
     * @param string $categoryName The category name to check
     * @param int $userId The user ID
     * @param int $excludeId Optional category ID to exclude from check (for updates)
     * @return bool True if name exists, false otherwise
     */
    private function categoryNameExists($categoryName, $userId, $excludeId = null) {
        try {
            if ($excludeId) {
                $stmt = $this->conn->prepare("SELECT cat_id FROM categories WHERE cat_name = ? AND user_id = ? AND cat_id != ?");
                $stmt->execute([$categoryName, $userId, $excludeId]);
            } else {
                $stmt = $this->conn->prepare("SELECT cat_id FROM categories WHERE cat_name = ? AND user_id = ?");
                $stmt->execute([$categoryName, $userId]);
            }
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Check if category belongs to user
     * @param int $categoryId The category ID
     * @param int $userId The user ID
     * @return bool True if category belongs to user, false otherwise
     */
    private function categoryBelongsToUser($categoryId, $userId) {
        try {
            $stmt = $this->conn->prepare("SELECT cat_id FROM categories WHERE cat_id = ? AND user_id = ?");
            $stmt->execute([$categoryId, $userId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
