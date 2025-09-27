-- Update categories table to include user_id column
-- This script adds the user_id column to track which user created each category

-- Add user_id column to categories table
ALTER TABLE `categories` ADD COLUMN `user_id` int(11) NOT NULL AFTER `cat_name`;

-- Add foreign key constraint to link categories to users
ALTER TABLE `categories` ADD CONSTRAINT `fk_categories_user` FOREIGN KEY (`user_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Add index for better performance
ALTER TABLE `categories` ADD INDEX `idx_user_id` (`user_id`);

-- Add unique constraint to ensure category names are unique per user
ALTER TABLE `categories` ADD UNIQUE KEY `unique_category_per_user` (`cat_name`, `user_id`);
