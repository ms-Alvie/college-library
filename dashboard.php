<?php
include '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>

    <nav>
        <a href="my_books.php">My Borrowed Books</a> |
        <a href="../auth/logout.php">Logout</a>
    </nav>

    <p style="margin-top: 20px;">Use the navigation above to view your borrowed books or log out.</p>
</body>
</html>