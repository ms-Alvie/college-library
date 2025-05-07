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
    min-height: 100vh;
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
    transition: background-color 0.3s ease;
}

.hamburger-menu button:hover {
    background-color: #70422d;
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
    position: sticky;
    height: 100vh;
    top: 0;
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
    font-size: 16px;
}

.sidebar a:hover {
    background-color: #70422d;
    transform: translateX(5px);
}

/* Main Content */
.main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    padding: 20px 40px;
    overflow-y: auto;
}

.wrapper {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(10px);
    padding: 20px 15px;
    max-width: 1200px;
    width: 100%;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

h1 {
    text-align: center;
    color: #5a3e2b;
    margin-bottom: 25px;
    font-size: 28px;
}

.top-links {
    text-align: center;
    margin-bottom: 20px;
}

.top-links a {
    display: inline-block;
    background-color: #2563eb;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    margin: 5px;
    font-weight: 600;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.top-links a:hover {
    background-color: #1e40af;
}

.book-table-wrapper {
    overflow-x: auto;
    width: 100%;
}

.book-table {
    width: 100%;
    border-collapse: collapse;
    background: #fef5e5;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    font-size: 15px;
}

.book-table th,
.book-table td {
    padding: 12px 16px;
    text-align: left;
    color: #3e2c23;
    white-space: normal;
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
    display: inline-block;
    background-color: #2563eb;
    color: white;
    padding: 6px 12px;
    border-radius: 5px;
    margin: 2px 0;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.3s ease;
}

.actions a:hover {
    background-color: #1e40af;
}

/* Responsive Design */
@media (max-width: 992px) {
    .sidebar {
        width: 220px;
        padding: 30px 15px;
    }

    .main-content {
        padding: 20px;
    }

    h1 {
        font-size: 24px;
    }

    .book-table th,
    .book-table td {
        padding: 10px;
        font-size: 14px;
    }
}

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
        gap: 25px;
        animation: fadeIn 0.3s ease-in-out;
    }

    .sidebar.active {
        display: flex;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .sidebar a {
        font-size: 16px;
        padding: 14px 20px;
    }

    .wrapper {
        padding: 15px;
    }

    h1 {
        font-size: 22px;
    }

    .top-links a {
        padding: 8px 16px;
        font-size: 14px;
    }

    .actions a {
        padding: 5px 10px;
        font-size: 13px;
    }

    .book-table th,
    .book-table td {
        padding: 8px;
        font-size: 13px;
    }
}

@media (max-width: 480px) {
    .sidebar a {
        font-size: 14px;
        padding: 12px 16px;
    }

    .book-table th,
    .book-table td {
        font-size: 12px;
        padding: 6px;
    }

    .top-links {
        margin-bottom: 15px;
    }

    .top-links a {
        font-size: 13px;
        padding: 6px 12px;
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