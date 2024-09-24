<?php
if (!defined('APP_RUNNING')) {
    die('Access denied'); // Stop execution if accessed directly
}

// Your existing code goes here...
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual_Uni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #222; /* Darker background for better contrast */
            color: #fff;
            background-image: linear-gradient(rgb(2, 2, 2) , rgb(185, 178, 178));
            
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 500px;
            padding: 30px;
            background-color: #333;
            border-radius: 10px;
            opacity: 90%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease-in-out;
        }

        .container:hover {
            transform: scale(1.02); /* Slight hover effect to make the form interactive */
        }

        .form-heading {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.75rem;
            font-weight: bold;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            background-color: #444;
            border: none;
            color: #fff;
            padding: 10px;
        }

        .form-control:focus {
            background-color: #555;
            box-shadow: none;
            border-color: #0d6efd;
        }

        .form-switcher {
            text-align: center;
            margin-top: 20px;
            cursor: pointer;
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
            display: block;
        }

        .form-switcher:hover {
            color: #0056b3;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            background-color: #0d6efd;
            border: none;
            font-size: 1rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert {
            display: none;
            margin-top: 20px;
            text-align: center;
        }

        @media (max-width: 600px) {
            .container {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="form-heading">Virtual_Uni</h2>
        <!-- Alerts for feedback messages -->
        <div id="feedback" class="alert" role="alert"></div>

        <!-- Signup Form -->
        <div id="signupForm">
            <form id="signupFormElement" method="post">
                <input type="hidden" name="action" value="signup">
                <div class="mb-3">
                    <label for="username" class="form-label">User Name</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" required>
                </div>
                <div class="mb-3">
                    <label for="emailSignup" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="emailSignup" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="passwordSignup" class="form-label">Password</label>
                    <input type="password" class="form-control" id="passwordSignup" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="roleSignup" class="form-label">Role</label>
                    <select id="roleSignup" name="role" class="form-select" required>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary" onclick="submitForm('signupFormElement')">Sign Up</button>
                <a class="form-switcher" onclick="toggleForm()">Already have an account? Login</a>
            </form>
        </div>

        <!-- Login Form -->
        <div id="loginForm" style="display: none;">
            <form id="loginFormElement" method="post">
                <input type="hidden" name="action" value="login">
                <div class="mb-3">
                    <label for="emailLogin" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="emailLogin" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="passwordLogin" class="form-label">Password</label>
                    <input type="password" class="form-control" id="passwordLogin" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="roleLogin" class="form-label">Role</label>
                    <select id="roleLogin" name="role" class="form-select" required>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary" onclick="submitForm('loginFormElement')">Login</button>
                <a class="form-switcher" onclick="toggleForm()">Don't have an account? Sign Up</a>
            </form>
        </div>
    </div>

    <script>
        function toggleForm() {
            const signupForm = document.getElementById('signupForm');
            const loginForm = document.getElementById('loginForm');
            const feedback = document.getElementById('feedback');

            signupForm.style.display = signupForm.style.display === 'none' ? 'block' : 'none';
            loginForm.style.display = loginForm.style.display === 'none' ? 'block' : 'none';
            feedback.style.display = 'none'; // Hide feedback on form switch
        }

        function submitForm(formId) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);

    // Check if required fields are filled
    const emptyFields = [];
    form.querySelectorAll('input, select').forEach(field => {
        if (field.hasAttribute('required') && !field.value.trim()) {
            emptyFields.push(field);
        }
    });

    // If there are any empty fields, display an error and stop the submission
    if (emptyFields.length > 0) {
        const feedback = document.getElementById('feedback');
        feedback.className = 'alert alert-danger';
        feedback.innerHTML = 'Please fill out all required fields.';
        feedback.style.display = 'block';
        return; // Stop form submission if validation fails
    }

    // Proceed with form submission if validation passes
    fetch('./handlers/login-signup_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const feedback = document.getElementById('feedback');
        if (data.success) {
            feedback.className = 'alert alert-success';
            feedback.innerHTML = data.message;

            // If signup was successful, show success and switch forms
            if (data.action === 'signup') {
                feedback.innerHTML = 'Account created successfully.';
            }

            // If login was successful, display logging in message and delay the reload
            if (data.action === 'login') {
                feedback.innerHTML = 'Logging in...';
                feedback.style.display = 'block';

                // Add a 1-second delay before reloading the page
                setTimeout(() => {
                    window.location.reload();
                }, 1000); // 1000ms = 1 second
            }
        } else {
            feedback.className = 'alert alert-danger';
            feedback.innerHTML = data.message;
        }
        feedback.style.display = 'block';
    })
    .catch(error => {
        const feedback = document.getElementById('feedback');
        feedback.className = 'alert alert-danger';
        feedback.innerHTML = 'An error occurred. Please try again.';
        feedback.style.display = 'block';
    });
}


    </script>
</body>
</html>
