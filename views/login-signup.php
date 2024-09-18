<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual_Uni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #333;
            color: #fff;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
            background-color: #444;
            padding: 20px;
            border-radius: 8px;
        }
        .form-heading {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-switcher {
            cursor: pointer;
            color: #0d6efd;
            text-decoration: underline;
        }
        .alert {
            display: none;
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
                <p class="form-switcher" onclick="toggleForm()">Already have an account? Login</p>
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
                <p class="form-switcher" onclick="toggleForm()">Don't have an account? Sign Up</p>
            </form>
        </div>
    </div>

    <script>
        function toggleForm() {
            const signupForm = document.getElementById('signupForm');
            const loginForm = document.getElementById('loginForm');
            const feedback = document.getElementById('feedback');

            if (signupForm.style.display === 'none') {
                signupForm.style.display = 'block';
                loginForm.style.display = 'none';
            } else {
                signupForm.style.display = 'none';
                loginForm.style.display = 'block';
            }
            
            feedback.style.display = 'none'; // Hide feedback on form switch
        }

        function submitForm(formId) {
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
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
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
