<?php
include '../config/db.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$result = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book List</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #fff;
        }
        h2 {
            text-align: center;
            color: #222;
        }
        nav {
            text-align: center;
            margin-bottom: 20px;
        }
        nav a {
            margin: 0 15px;
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .action-btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
        }
        .edit-btn {
            background-color: #28a745;
        }
        .delete-btn {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <h2>📚 Book List</h2>

    <nav>
        <a href="add_book.php">Add New Book</a> |
        <a href="dashboard.php">Dashboard</a> |
        <a href="../auth/logout.php">Logout</a>
    </nav>

    <table>
        <tr>
            <th>ID</th><th>Title</th><th>Author</th><th>Category</th><th>Available</th><th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td><?= $row['available'] ? 'Yes' : 'No' ?></td>
                <td>
                    <a class="action-btn edit-btn" href="edit_book.php?id=<?= $row['id'] ?>">Edit</a>
                    <a class="action-btn delete-btn" href="delete_book.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
