document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const loginButton = document.getElementById("loginButton");
    const loadingIndicator = document.getElementById("loadingIndicator");

    loginForm.addEventListener("submit", function(event) {
        event.preventDefault();
        
        // Show loading indicator and disable button
        loadingIndicator.style.display = "block";
        loginButton.disabled = true;

        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();

        // Validate inputs
        if (!email || !password) {
            showError("Email and password are required.");
            return;
        }

        // Validate email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showError("Please enter a valid email address.");
            return;
        }

        // Validate email length
        if (email.length > 50) {
            showError("Email must be less than 50 characters.");
            return;
        }

        // Validate password length
        if (password.length < 1) {
            showError("Password is required.");
            return;
        }

        // Prepare data for submission
        const formData = new FormData();
        formData.append("email", email);
        formData.append("password", password);

        // Asynchronous request to login_customer_action.php
        fetch("actions/login_customer_action.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.status === 'success') {
                alert("Login successful! Redirecting to home page...");
                window.location.href = "index.php"; // Redirect to home page
            } else {
                showError(data.message); // Show error message
            }
        })
        .catch(error => {
            hideLoading();
            console.error("Error:", error);
            showError("An error occurred. Please try again.");
        });
    });

    function showError(message) {
        hideLoading();
        alert(message);
    }

    function hideLoading() {
        loadingIndicator.style.display = "none";
        loginButton.disabled = false;
    }
});
