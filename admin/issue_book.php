<?php 
include '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];
    $student_id = $_POST['student_id'];
    $issue_date = date('Y-m-d');
    $return_date = date('Y-m-d', strtotime("+7 days"));

    $conn->query("INSERT INTO issued_books (user_id, book_id, issue_date, return_date) 
                  VALUES ($student_id, $book_id, '$issue_date', '$return_date')");
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
    <title>Issued Books</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Crimson Text', serif;
            background: url('../assets/library-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #3e2c23;
            display: flex;
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

        .wrapper {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            padding: 30px 20px;
            margin: 50px auto;
            max-width: 1200px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #5a3e2b;
            margin-bottom: 30px;
            font-size: 32px;
        }

        .book-table {
            width: 100%;
            border-collapse: collapse;
            background: #fef5e5;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .book-table th, .book-table td {
            padding: 16px;
            text-align: left;
            font-size: 15px;
            color: #3e2c23;
        }

        .book-table thead {
            background-color: #8b5e3c;
            color: white;
        }

        .book-table tbody tr:nth-child(even) {
            background-color: #f3f4f6;
        }

        .book-table tbody tr:hover {
            background-color: #e0e7ff;
        }

        .actions a {
            color: #2563eb;
            text-decoration: none;
            margin-right: 8px;
            font-weight: 500;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .top-links {
            text-align: center;
            margin-bottom: 30px;
        }

        .top-links a {
            margin: 0 10px;
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        .top-links a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
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

            .form-wrapper {
    background: rgba(255, 255, 255, 0.9);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    max-width: 500px;
    width: 100%;
    text-align: center;
}

.issue-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.form-group label {
    margin-bottom: 8px;
    font-weight: bold;
    color: #5a3e2b;
    font-size: 16px;
}

.form-group select {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #d4c2b4;
    background-color: #fff8f0;
    font-size: 15px;
}

.issue-button {
    background-color: #2563eb;
    color: white;
    padding: 12px;
    font-size: 16px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.issue-button:hover {
    background-color: #1d4ed8;
}

        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="books.php">📖 Manage Books</a>
        <a href="../auth/logout.php">🚪 Logout</a>
    </div>

    <div class="main-content">
        <div class="form-wrapper">
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
</body>

</html>