<?php  

include '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$books = $conn->query("SELECT * FROM books ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Books</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;700&display=swap');

        body {
            margin: 0;
            padding: 0;
            
            font-family: 'Crimson Text', serif;
            background: url('../assets/bg.jpg') no-repeat center center fixed;
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
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            color:rgb(255, 255, 255);
            text-decoration: none;
            margin-right: 8px;
            font-weight: 500;
        }

        .actions a:hover {
            background-color: #1e40af;
            text-decoration: none;
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
            color:rgb(255, 255, 255);
            font-weight: 600;
            text-decoration: none;
        }

        .top-links a:hover {
            background-color: #1e40af;
            text-decoration: none;
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
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
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
                <a href="add_book.php"> Add New Book</a> | 
            </div>

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
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
