<?php
session_start();
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $id_number = trim($_POST['id_number']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = "student";

    // Validate
    if (empty($fullname) || empty($id_number) || empty($username) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Check if username or id_number exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR id_number = ?");
        $stmt->bind_param("ss", $username, $id_number);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username or ID number already exists.";
        } else {
            // Hash password
            $hashedPassword = md5($password); 

            // Insert user
            $stmt = $conn->prepare("INSERT INTO users (username, password, role, fullname, id_number) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $hashedPassword, $role, $fullname, $id_number);

            if ($stmt->execute()) {
                $success = "Student registered successfully. You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Register</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('../assets/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 24px;
            font-size: 24px;
            color: #1e3a8a;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #374151;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        button {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #1e40af;
        }

        .error-message {
            color: red;
            margin-top: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <form method="post" class="login-box">
        <h2>Student Registration</h2>
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="fullname" required>
        </div>
        <div class="form-group">
            <label>ID Number</label>
            <input type="text" name="id_number" required>
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Register</button>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="success-message"><?= $success ?></div>
        <?php endif; ?>
    </form>
</body>
</html>
