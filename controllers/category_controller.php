<?php
require_once __DIR__ . '/../classes/category_class.php';

class CategoryController {
    private $category;

    public function __construct() {
        $this->category = new Category();
    }

    /**
     * Add a new category
     * @param array $data Array containing category data
     * @return array Result array with status and message
     */
    public function add_category_ctr($data) {
        $categoryName = $data['category_name'] ?? '';
        $userId = $data['user_id'] ?? 0;

        // Validate input
        if (empty($categoryName)) {
            return ['status' => 'error', 'message' => 'Category name is required.'];
        }

        if (empty($userId) || $userId <= 0) {
            return ['status' => 'error', 'message' => 'Invalid user ID.'];
        }

        // Sanitize category name
        $categoryName = trim($categoryName);
        if (strlen($categoryName) < 2) {
            return ['status' => 'error', 'message' => 'Category name must be at least 2 characters long.'];
        }

        if (strlen($categoryName) > 100) {
            return ['status' => 'error', 'message' => 'Category name must not exceed 100 characters.'];
        }

        return $this->category->add($categoryName, $userId);
    }

    /**
     * Edit/Update a category
     * @param array $data Array containing category data
     * @return array Result array with status and message
     */
    public function edit_category_ctr($data) {
        $categoryId = $data['category_id'] ?? 0;
        $categoryName = $data['category_name'] ?? '';
        $userId = $data['user_id'] ?? 0;

        // Validate input
        if (empty($categoryId) || $categoryId <= 0) {
            return ['status' => 'error', 'message' => 'Invalid category ID.'];
        }

        if (empty($categoryName)) {
            return ['status' => 'error', 'message' => 'Category name is required.'];
        }

        if (empty($userId) || $userId <= 0) {
            return ['status' => 'error', 'message' => 'Invalid user ID.'];
        }

        // Sanitize category name
        $categoryName = trim($categoryName);
        if (strlen($categoryName) < 2) {
            return ['status' => 'error', 'message' => 'Category name must be at least 2 characters long.'];
        }

        if (strlen($categoryName) > 100) {
            return ['status' => 'error', 'message' => 'Category name must not exceed 100 characters.'];
        }

        return $this->category->edit($categoryId, $categoryName, $userId);
    }

    /**
     * Delete a category
     * @param array $data Array containing category data
     * @return array Result array with status and message
     */
    public function delete_category_ctr($data) {
        $categoryId = $data['category_id'] ?? 0;
        $userId = $data['user_id'] ?? 0;

        // Validate input
        if (empty($categoryId) || $categoryId <= 0) {
            return ['status' => 'error', 'message' => 'Invalid category ID.'];
        }

        if (empty($userId) || $userId <= 0) {
            return ['status' => 'error', 'message' => 'Invalid user ID.'];
        }

        return $this->category->delete($categoryId, $userId);
    }

    /**
     * Get all categories for a user
     * @param array $data Array containing user data
     * @return array Result array with status and categories
     */
    public function get_categories_ctr($data) {
        $userId = $data['user_id'] ?? 0;

        // Validate input
        if (empty($userId) || $userId <= 0) {
            return ['status' => 'error', 'message' => 'Invalid user ID.'];
        }

        $categories = $this->category->getCategoriesByUser($userId);
        
        return [
            'status' => 'success',
            'categories' => $categories,
            'count' => count($categories)
        ];
    }

    /**
     * Get a specific category by ID
     * @param array $data Array containing category and user data
     * @return array Result array with status and category data
     */
    public function get_category_ctr($data) {
        $categoryId = $data['category_id'] ?? 0;
        $userId = $data['user_id'] ?? 0;

        // Validate input
        if (empty($categoryId) || $categoryId <= 0) {
            return ['status' => 'error', 'message' => 'Invalid category ID.'];
        }

        if (empty($userId) || $userId <= 0) {
            return ['status' => 'error', 'message' => 'Invalid user ID.'];
        }

        $category = $this->category->getCategoryById($categoryId, $userId);
        
        if ($category) {
            return [
                'status' => 'success',
                'category' => $category
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Category not found or access denied.'
            ];
        }
    }
}
?>
