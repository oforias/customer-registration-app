# Customer Registration App

## Overview
The Customer Registration App is a web application that allows users to register and manage customer accounts. It includes functionalities for user registration, form validation, and a simple login interface.

## 🚀 **Recent Changes & Improvements**

### **Major Refactoring & Bug Fixes:**
- **Fixed Database Connection**: Updated from MySQLi to PDO for better security and modern PHP practices
- **Corrected Database Schema**: Aligned all code with the actual `shoppn` database structure
- **Fixed Field Name Mismatches**: Updated form fields to match database column names exactly
- **Enhanced Error Handling**: Implemented comprehensive client-side and server-side validation
- **Improved Security**: Added proper password hashing and SQL injection prevention
- **Modernized UI**: Added responsive design, loading indicators, and better user experience

### **Technical Improvements:**
- **MVC Architecture**: Proper separation of concerns with Models, Views, and Controllers
- **AJAX Implementation**: Asynchronous form submission without page reloads
- **Input Validation**: Regex patterns for email, phone numbers, and field length validation
- **Error Response System**: Structured JSON responses for better error handling
- **Loading States**: Visual feedback during form processing
- **Responsive Design**: Mobile-friendly interface with modern CSS

## Features

- **Customer Registration Form**: Fully validated registration form with client-side and server-side validation
- **Database Integration**: Uses PDO for secure database operations
- **Email Uniqueness Check**: Prevents duplicate email registrations
- **Password Encryption**: Passwords are securely hashed using PHP's password_hash()
- **Responsive Design**: Modern, mobile-friendly interface
- **Loading Indicators**: Visual feedback during form submission
- **Form Validation**: Comprehensive validation using regex patterns and length checks

## Database Schema

The application uses the `shoppn` database with the following customer table structure:

```sql
CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(50) NOT NULL UNIQUE,
  `customer_pass` varchar(150) NOT NULL,
  `customer_country` varchar(30) NOT NULL,
  `customer_city` varchar(30) NOT NULL,
  `customer_contact` varchar(15) NOT NULL,
  `customer_image` varchar(100) DEFAULT NULL,
  `user_role` int(11) NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customer_email` (`customer_email`)
);
```

## Project Structure
```
customer-registration-app
├── actions/
│   └── register_customer_action.php    # Handles form submission
├── classes/
│   └── customer_class.php              # Customer model with CRUD operations
├── controllers/
│   └── customer_controller.php         # Business logic controller
├── css/
│   └── style.css                       # Styling and responsive design
├── database/
│   ├── connection.php                  # Database connection class
│   └── dbforlab.sql                    # Database schema
├── js/
│   └── register.js                     # Client-side validation and AJAX
├── index.php                           # Home page with navigation
├── login.php                           # Login form (UI only)
└── register.php                        # Registration form
```

## Setup Instructions

1. **Database Setup**:
   - Import the database schema from `database/dbforlab.sql` into your MySQL/MariaDB database
   - Ensure the database name is `shoppn`

2. **Configuration**:
   - Update database credentials in `database/connection.php` if needed:
     ```php
     private $host = 'localhost';
     private $db_name = 'shoppn';
     private $username = 'root';
     private $password = '';
     ```

3. **Web Server**:
   - Place all files in your web server directory (e.g., `htdocs`, `www`, etc.)
   - Ensure PHP 7.4+ is installed with PDO MySQL extension

4. **Access**:
   - Navigate to `index.php` in your web browser
   - Click "Register" to access the registration form

## Usage

1. **Registration Process**:
   - Fill out all required fields (Full Name, Email, Password, Country, City, Contact Number)
   - Email must be unique and valid format
   - Password must be at least 6 characters
   - Contact number must be 10-15 digits
   - All fields have length validation based on database schema

2. **Validation**:
   - Client-side validation provides immediate feedback
   - Server-side validation ensures data integrity
   - Email uniqueness is checked before registration

3. **Success**:
   - Upon successful registration, user is redirected to login page
   - Loading indicator shows during form submission

## 📝 **Detailed Changes Made**

### **Database Layer (`database/connection.php`)**
- **Changed**: Class name from `Database` to `DatabaseConnection`
- **Updated**: Database name from `customer_registration` to `shoppn`
- **Maintained**: PDO connection with proper error handling

### **Model Layer (`classes/customer_class.php`)**
- **Fixed**: Constructor to properly initialize database connection
- **Updated**: All SQL queries to match `shoppn` database schema
- **Changed**: Table name from `customers` to `customer`
- **Updated**: Column names to match database:
  - `full_name` → `customer_name`
  - `email` → `customer_email`
  - `password` → `customer_pass`
  - `country` → `customer_country`
  - `city` → `customer_city`
  - `contact_number` → `customer_contact`
- **Added**: Proper error handling with try-catch blocks
- **Implemented**: Email uniqueness checking before registration
- **Enhanced**: Return structured JSON responses for better error handling

### **Controller Layer (`controllers/customer_controller.php`)**
- **Fixed**: Class instantiation from `CustomerClass` to `Customer`
- **Added**: Comprehensive input validation with field length checks
- **Implemented**: Email format validation using `filter_var()`
- **Added**: Password strength validation (minimum 6 characters)
- **Enhanced**: Contact number validation with regex pattern
- **Added**: Database schema compliance validation

### **Action Script (`actions/register_customer_action.php`)**
- **Simplified**: Removed redundant validation (handled by controller)
- **Added**: Proper JSON content-type header
- **Fixed**: Field name mapping to match form inputs
- **Enhanced**: Error response structure

### **Frontend (`register.php`)**
- **Updated**: Form field names to match database schema
- **Added**: HTML5 validation attributes (maxlength, minlength)
- **Enhanced**: Form structure with proper semantic HTML
- **Added**: Loading indicator element
- **Improved**: Accessibility with proper labels and form groups

### **JavaScript (`js/register.js`)**
- **Fixed**: Form element ID references to match updated HTML
- **Enhanced**: Client-side validation with comprehensive checks
- **Added**: Field length validation based on database schema
- **Improved**: Error handling with proper user feedback
- **Added**: Loading state management (show/hide indicators)
- **Enhanced**: Form submission with proper data mapping

### **Styling (`css/style.css`)**
- **Completely Redesigned**: Modern, responsive layout
- **Added**: Loading indicator animations with CSS keyframes
- **Enhanced**: Form styling with better spacing and typography
- **Added**: Hover effects and focus states
- **Implemented**: Mobile-responsive design
- **Added**: Button disabled states for better UX

### **Login Page (`login.php`)**
- **Updated**: Styling to match registration page
- **Enhanced**: Container structure for consistency
- **Added**: Proper semantic HTML structure

## Technical Details

- **Backend**: PHP 7.4+ with PDO for database operations
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Database**: MySQL/MariaDB
- **Security**: Password hashing, SQL injection prevention, input validation
- **Architecture**: MVC pattern with separation of concerns

## User Roles

- **Role 1**: Administrator
- **Role 2**: Customer (default for new registrations)

## 🧪 **Testing & Validation**

### **Error Handling Tests Performed:**
-  **Empty Field Validation**: All required fields properly validated
-  **Email Format Validation**: Invalid email formats rejected
-  **Password Length Validation**: Minimum 6 characters enforced
-  **Contact Number Validation**: Proper phone number format required
-  **Field Length Limits**: Database schema limits enforced
-  **Duplicate Email Detection**: Prevents duplicate registrations
-  **Special Character Handling**: Proper input sanitization
-  **Loading States**: Visual feedback during form submission
-  **Error Messages**: Clear, user-friendly error feedback

### **Security Features Tested:**
-  **Password Hashing**: Secure password storage using `password_hash()`
-  **SQL Injection Prevention**: PDO prepared statements implemented
-  **Input Sanitization**: Proper data cleaning and validation
-  **XSS Prevention**: Proper output escaping

### **User Experience Features:**
-  **Responsive Design**: Mobile and desktop compatibility
-  **Loading Indicators**: Smooth user feedback
-  **Form Validation**: Real-time client-side validation
-  **Error Recovery**: Clear error messages and form state management

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Contributing
Feel free to fork the repository and submit pull requests for any improvements or bug fixes. 

## License
This project is licensed under the MIT License.