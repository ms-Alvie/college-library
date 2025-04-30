<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../" . $user['role'] . "/dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Invalid username.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../assets/style.css">
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
        <h2>Login</h2>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
    </form>
</body>
</html>
