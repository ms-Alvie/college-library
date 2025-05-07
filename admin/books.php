<?php
session_start();
include '../config/db.php';

// Ensure the user is logged in as an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$books = $conn->query("SELECT * FROM books ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
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
            flex-direction: column; /* Change to column layout */
            justify-content: flex-start; /* Align content to the top */
            align-items: center;
            padding: 40px;
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .wrapper {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            padding: 30px 20px;
            margin: 0 auto; /* Remove top/bottom margins */
            max-width: 1200px;
            width: 100%; /* Ensure full width */
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
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .book-table th,
        .book-table td {
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
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            text-decoration: none;
            margin-right: 8px;
            font-weight: 500;
        }

        .actions a:hover {
            background-color: #1e40af;
        }

        .top-links {
            text-align: center;
            margin-bottom: 30px;
        }

        .top-links a {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            margin: 0 10px;
            font-weight: 600;
            text-decoration: none;
        }

        .top-links a:hover {
            background-color: #1e40af;
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

            .book-table {
                font-size: 14px;
            }

            .book-table th,
            .book-table td {
                padding: 10px;
            }

            .book-table-wrapper {
                overflow-x: auto;
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
        <h1>Admin Panel</h1>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="books.php">📖 Manage Books</a>
        <a href="issue_book.php">📤 Issue Book</a>
        <a href="../auth/logout.php">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Books</h1>

            <div class="top-links">
                <a href="add_book.php">Add New Book</a>
            </div>

            <div class="book-table-wrapper">
                <table class="book-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Available</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($books->num_rows > 0): ?>
                            <?php while ($book = $books->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $book['id'] ?></td>
                                    <td><?= htmlspecialchars($book['title']) ?></td>
                                    <td><?= htmlspecialchars($book['author']) ?></td>
                                    <td><?= htmlspecialchars($book['category']) ?></td>
                                    <td><?= $book['available'] ? 'Yes' : 'No' ?></td>
                                    <td class="actions">
                                        <a href="edit_book.php?id=<?= $book['id'] ?>">Edit</a>
                                        <a href="delete_book.php?id=<?= $book['id'] ?>" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center;">No books found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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