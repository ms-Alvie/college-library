<?php
include '../config/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to get the user
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the password using password_verify
        if (password_verify($password, $user['password'])) {
            // Password is correct
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../" . $user['role'] . "/dashboard.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="container mt-5">
    <h2>Login</h2>
    <form method="post">
        <div class="form-group">
            <label>Username</label><input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label><input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Login</button>
    </form>
</body>
</html>