document.addEventListener("DOMContentLoaded", function() {
    const registrationForm = document.getElementById("registerForm");
    const fullNameInput = document.getElementById("full_name");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const countryInput = document.getElementById("country");
    const cityInput = document.getElementById("city");
    const contactNumberInput = document.getElementById("contact_number");
    const registerButton = document.getElementById("registerButton");
    const loadingIndicator = document.getElementById("loadingIndicator");

    registrationForm.addEventListener("submit", function(event) {
        event.preventDefault();
        
        // Show loading indicator and disable button
        loadingIndicator.style.display = "block";
        registerButton.disabled = true;

        const fullName = fullNameInput.value.trim();
        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();
        const country = countryInput.value.trim();
        const city = cityInput.value.trim();
        const contactNumber = contactNumberInput.value.trim();

        // Validate inputs
        if (!fullName || !email || !password || !country || !city || !contactNumber) {
            showError("All fields are required.");
            return;
        }

        // Validate full name length
        if (fullName.length > 100) {
            showError("Full name must be less than 100 characters.");
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
        if (password.length < 6) {
            showError("Password must be at least 6 characters long.");
            return;
        }

        // Validate country length
        if (country.length > 30) {
            showError("Country must be less than 30 characters.");
            return;
        }

        // Validate city length
        if (city.length > 30) {
            showError("City must be less than 30 characters.");
            return;
        }

        // Validate contact number format
        const phoneRegex = /^\+?[0-9]{10,15}$/;
        if (!phoneRegex.test(contactNumber)) {
            showError("Please enter a valid contact number (10-15 digits).");
            return;
        }

        // Validate contact number length
        if (contactNumber.length > 15) {
            showError("Contact number must be less than 15 characters.");
            return;
        }

        // Prepare data for submission
        const formData = new FormData();
        formData.append("full_name", fullName);
        formData.append("email", email);
        formData.append("password", password);
        formData.append("country", country);
        formData.append("city", city);
        formData.append("contact_number", contactNumber);

        // Asynchronous request to register_customer_action.php
        fetch("actions/register_customer_action.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.status === 'success') {
                alert("Registration successful! Redirecting to login page...");
                window.location.href = "login.php"; // Redirect to login page
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
        registerButton.disabled = false;
    }
});