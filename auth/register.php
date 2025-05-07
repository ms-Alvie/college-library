<?php
session_start();
include '../config/db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if the username or email already exists
    $check_query = $conn->query("SELECT * FROM users WHERE username='$username' OR email='$email'");
    if ($check_query->num_rows > 0) {
        echo "<script>alert('Username or email already exists.');</script>";
    } else {
        // Insert new user into the database
        $conn->query("INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'student')");
        header("Location: ../auth/login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Crimson Text', serif;
            background: url('../assets/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #3e2c23;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .form-container h2 {
            font-size: 32px;
            margin-bottom: 30px;
            color: #5a3e2b;
        }

        .form-container label {
            font-size: 16px;
            font-weight: 500;
            color: #5a3e2b;
            margin-bottom: 8px;
            display: block;
            text-align: left;
        }

        .form-container input {
            width: 100%;
            padding: 12px;
            margin-bottom: 16px;
            border: 2px solid #d4c2b4;
            border-radius: 8px;
            font-size: 16px;
            color: #5a3e2b;
        }

        .form-container button {
            padding: 12px 24px;
            background-color: #8b5e3c;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        .form-container button:hover {
            background-color: #70422d;
        }

        .login-link {
            display: block;
            margin-top: 20px;
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            text-align: center;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .form-container h2 {
                font-size: 28px;
            }

            .form-container input {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- Main Content -->
    <div class="form-container">
        <h2>Create Account</h2>

        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Register</button>
        </form>

        <!-- Already Have an Account Link -->
        <a href="../auth/login.php" class="login-link">Already have an account? Login here</a>
    </div>

</body>
</html>