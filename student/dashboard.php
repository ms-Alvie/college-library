<?php
session_start();
include '../config/db.php';

// Ensure the user is logged in as a student
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | Library</title>
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
            margin: 0;
        }

        /* Hamburger Menu */
        .hamburger-menu button {
            display: none;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1000;
            background: #8b5e3c;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 24px;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: rgba(255, 248, 238, 0.98);
            backdrop-filter: blur(6px);
            padding: 40px 20px;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            gap: 20px;
            border-right: 2px solid #d4c2b4;
        }

        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 30px;
            color: #5a3e2b;
            text-align: center; /* Center-align heading */
        }

        .sidebar a {
            background-color: #8b5e3c;
            color: #fff8f0;
            padding: 12px; /* Consistent padding */
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-align: center; /* Center-align text */
            font-size: 16px; /* Adjust font size for better readability */
        }

        .sidebar a:hover {
            background-color: #70422d;
            transform: translateX(5px);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .welcome-box {
            background: rgba(255, 255, 255, 0.8);
            padding: 60px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .welcome-box h2 {
            font-size: 32px;
            margin: 0;
            color: #5a3e2b;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hamburger-menu button {
                display: block;
            }

            .sidebar {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 248, 238, 0.98);
                z-index: 999;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .sidebar.active {
                display: flex;
            }

            .sidebar h1 {
                display: none; /* Hide heading on small screens */
            }

            .sidebar a {
                flex: 1;
                margin: 0 8px; /* Consistent spacing between links */
                font-size: 14px; /* Reduce font size for smaller screens */
                padding: 10px; /* Slightly reduce padding for compactness */
                text-align: center; /* Center-align text */
            }

            .main-content {
                padding: 20px;
            }

            .welcome-box {
                padding: 40px; /* Reduce padding for smaller screens */
            }
        }
    </style>
</head>
<body>

    <!-- Hamburger Menu -->
    <div class="hamburger-menu">
        <button id="menu-toggle">☰</button>
    </div>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <h1>Student Panel</h1>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="borrowed_books.php">📚 My Borrowed Books</a>
        <a href="../auth/logout.php">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="welcome-box">
            <h2>Welcome, <?= htmlspecialchars($_SESSION['fullName'] ?? 'Student') ?>!</h2>
        </div>
    </div>

    <script>
        // Toggle Sidebar
        document.getElementById('menu-toggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>

</body>
</html>