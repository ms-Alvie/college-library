<?php 
session_start();
include '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') 
{
    header("Location: ../auth/login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $book_id = $_POST['book_id'];
    $student_id = $_POST['student_id'];
    $issue_date = date('Y-m-d');
    $return_date = date('Y-m-d', strtotime("+7 days"));

    $conn->query("INSERT INTO `issued_books` 
                  (
                    `user_id`, 
                    `book_id`, 
                    `issue_date`, 
                    `return_date`
                  ) 
                  VALUES 
                  (
                    $student_id, 
                    $book_id, 
                    '$issue_date', 
                    '$return_date'
                  )
    ");

    $conn->query("UPDATE books SET available = 0 WHERE id = $book_id");
    header("Location: dashboard.php");
    exit();
}

// Fetch books and students
$books = $conn->query("SELECT id, title FROM books WHERE available = 1");
$students = $conn->query("SELECT id, username FROM users WHERE role = 'student'");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book</title>
    <style>
        /* General Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: url('../assets/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            min-height: 100vh;
            color: #3e2c23;
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
            background: rgba(255, 248, 238, 0.95);
            backdrop-filter: blur(6px);
            padding: 40px 20px;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            gap: 25px;
            border-right: 2px solid #d4c2b4;
        }

        .sidebar h2 {
            font-size: 26px;
            margin-bottom: 20px;
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
            transition: all 0.3s ease;
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
            padding: 50px 20px;
        }

        .form-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
            max-width: 480px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #5a3e2b;
            font-size: 30px;
            margin-bottom: 30px;
        }

        .issue-form {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .form-group label {
            margin-bottom: 10px;
            font-weight: 500;
            color: #5a3e2b;
            font-size: 16px;
        }

        .form-group select {
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #d4c2b4;
            background-color: #fff8f0;
            font-size: 15px;
        }

        .issue-button {
            background-color: #2563eb;
            color: white;
            padding: 14px;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .issue-button:hover {
            background-color: #1d4ed8;
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

            .sidebar h2 {
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
                padding: 30px 10px;
            }

            .form-wrapper {
                margin-top: 20px;
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
        <h2>Admin Panel</h2>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="books.php">📖 Manage Books</a>
        <a href="../auth/logout.php">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="form-wrapper">
            <h1>Issue Book</h1>
            <form method="POST" class="issue-form">
                <div class="form-group">
                    <label for="student_id">Select Student:</label>
                    <select name="student_id" id="student_id" required>
                        <option value="">-- Choose Student --</option>
                        <?php while ($student = $students->fetch_assoc()): ?>
                            <option value="<?= $student['id'] ?>"><?= htmlspecialchars($student['username']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="book_id">Select Book:</label>
                    <select name="book_id" id="book_id" required>
                        <option value="">-- Choose Book --</option>
                        <?php while ($book = $books->fetch_assoc()): ?>
                            <option value="<?= $book['id'] ?>"><?= htmlspecialchars($book['title']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit" class="issue-button">Issue Book</button>
            </form>
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