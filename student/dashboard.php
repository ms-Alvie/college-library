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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;700&display=swap');

        body {
            margin: 0;
            font-family: 'Crimson Text', serif;
            background: url('../assets/library-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            color: #3e2c23;
        }

        .sidebar {
            width: 250px;
            background: rgba(255, 248, 238, 0.98);
            backdrop-filter: blur(6px);
            padding: 40px 20px;
            box-shadow: 2px 0 15px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: column;
            gap: 20px;
            border-right: 2px solid #d4c2b4;
        }

        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 30px;
            color: #5a3e2b;
            text-align: center;
        }

        .sidebar a {
            background-color: #8b5e3c;
            color: #fff8f0;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-align: center;
        }

        .sidebar a:hover {
            background-color: #70422d;
            transform: translateX(5px);
        }

        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .welcome-box {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            padding: 50px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .welcome-box h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #5a3e2b;
        }

        .welcome-box nav {
            background: none;
            padding: 0;
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .welcome-box nav a {
            background-color: #8b5e3c;
            color: #fff8f0;
            padding: 10px 20px;
            display: inline-block;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
        }

        .welcome-box nav a:hover {
            background-color: #70422d;
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                flex-direction: row;
                overflow-x: auto;
                justify-content: center;
                border-right: none;
                border-bottom: 2px solid #d4c2b4;
            }

            .sidebar h1 {
                display: none;
            }

            .sidebar a {
                flex: 1;
                margin: 0 8px;
            }

            .main-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h1>Student</h1>
        <a href="my_books.php">📚 My Books</a>
        <a href="../auth/logout.php">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="welcome-box">
            <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>
            <nav>
                <a href="my_books.php">📘 My Borrowed Books</a>
                <a href="../auth/logout.php">🚪 Logout</a>
            </nav>
        </div>
    </div>

</body>
</html>
