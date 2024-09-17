<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual_Uni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
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
    </style>
</head>
<body>
    <div class="container">
        <h2 class="form-heading">Virtual_Uni</h2>
        <!-- Signup Form -->
        <div id="signupForm">
            <form action="handler.php" method="post">
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
                <button type="submit" class="btn btn-primary">Sign Up</button>
                <p class="form-switcher" onclick="toggleForm()">Already have an account? Login</p>
            </form>
        </div>

        <!-- Login Form -->
        <div id="loginForm" style="display: none;">
            <form action="handler.php" method="post">
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
                <button type="submit" class="btn btn-primary">Login</button>
                <p class="form-switcher" onclick="toggleForm()">Don't have an account? Sign Up</p>
            </form>
        </div>
    </div>

    <script>
        function toggleForm() {
            const signupForm = document.getElementById('signupForm');
            const loginForm = document.getElementById('loginForm');

            if (signupForm.style.display === 'none') {
                signupForm.style.display = 'block';
                loginForm.style.display = 'none';
            } else {
                signupForm.style.display = 'none';
                loginForm.style.display = 'block';
            }
        }
    </script>
</body>
</html>
