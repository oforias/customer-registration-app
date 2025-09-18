<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/register.js" defer></script>
</head>
<body>
    <div class="container">
        <div class="registration-form">
            <h2>Customer Registration</h2>
            <form id="registerForm">
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" required maxlength="100">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required maxlength="50">
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required minlength="6">
                </div>

                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" id="country" name="country" required maxlength="30">
                </div>

                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" required maxlength="30">
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number:</label>
                    <input type="tel" id="contact_number" name="contact_number" required maxlength="15">
                </div>

                <input type="hidden" id="user_role" name="user_role" value="2">

                <div class="form-group">
                    <button type="submit" id="registerButton">Register</button>
                    <div id="loadingIndicator" class="loading-indicator" style="display: none;">
                        <span>Registering...</span>
                    </div>
                </div>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>