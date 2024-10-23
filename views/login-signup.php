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
                    <select id="roleSignup" name="role" class="form-select" required onchange="toggleAccessKeyField()">
                        <option value="university">University</option>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                       
                    </select>
                </div>
                              <!-- Access Key Field (Hidden by Default) -->
                <div class="mb-3" id="accessKeyField" style="display: none;">
                    <label for="accessKey" class="form-label">Access Key</label>
                    <input type="text" class="form-control" id="accessKey" name="access_key">
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
                        <option value="university">University</option>
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

    function toggleAccessKeyField() {
        const role = document.getElementById('roleSignup').value;
        const accessKeyField = document.getElementById('accessKeyField');

        if (role === 'university') {
            accessKeyField.style.display = 'none'; // Hide Access Key for 'university'
        } else {
            accessKeyField.style.display = 'block'; // Show Access Key for 'student' or 'teacher'
        }
    }

    function validateForm(formId) {
        const form = document.getElementById(formId);
        const inputs = form.querySelectorAll('input[required], select[required]');
        let isValid = true;
        let emptyFields = [];

        inputs.forEach(input => {
            if (!input.value) {
                isValid = false;
                emptyFields.push(input.previousElementSibling.innerText); // Get the label text for feedback
            }
        });

        if (!isValid) {
            const feedback = document.getElementById('feedback');
            feedback.className = 'alert alert-danger';
            feedback.innerHTML = 'Please fill in the following fields: ' + emptyFields.join(', ');
            feedback.style.display = 'block';
        }

        return isValid; // Return validation result
    }

    function submitForm(formId) {
        if (!validateForm(formId)) return; // Validate before submission

        const form = document.getElementById(formId);
        const formData = new FormData(form);

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

                if (data.action === 'signup') {
                    feedback.innerHTML = 'Account created successfully.';
                }

                if (data.action === 'login') {
                    feedback.innerHTML = 'Logging in...';
                    feedback.style.display = 'block';

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000); // 1 second delay
                }
            } else {
                feedback.className = 'alert alert-danger';
                feedback.innerHTML = data.message;
            }
            feedback.style.display = 'block';
        })
        
    }
</script>

</body>
</html>