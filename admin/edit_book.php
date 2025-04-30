<?php include '../config/db.php'; ?> 
<?php if ($_SESSION['role'] !== 'admin') die("Access Denied"); ?>

<?php
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM books WHERE id=$id");
$book = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];

    $conn->query("UPDATE books SET title='$title', author='$author', category='$category' WHERE id=$id");
    header("Location: books.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Crimson Text', serif;
            background: url('../assets/library-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #3e2c23;
            display: flex;
            height: 100vh;
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

        .form-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .form-container h2 {
            font-size: 32px;
            margin-bottom: 30px;
            color: #5a3e2b;
        }

        .form-container input {
            width: 100%;
            padding: 12px;
            margin-bottom: 16px;
            border: 2px solid #d4c2b4;
            border-radius: 8px;
            font-size: 16px;
            color: #5a3e2b;
        }

        .form-container button {
            padding: 12px 24px;
            background-color: #8b5e3c;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #70422d;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
        }

        .back-link:hover {
            text-decoration: underline;
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
        <h1>Admin</h1>
        <a href="books.php">📚 Manage Books</a>
        <a href="issue_book.php">📤 Issue Book</a>
        <a href="../auth/logout.php">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="form-container">
            <h2>Edit Book</h2>

            <form method="POST">
                <label>Title:</label><br>
                <input type="text" name="title" value="<?= $book['title'] ?>" required><br><br>

                <label>Author:</label><br>
                <input type="text" name="author" value="<?= $book['author'] ?>" required><br><br>

                <label>Category:</label><br>
                <input type="text" name="category" value="<?= $book['category'] ?>" required><br><br>

                <button type="submit">Update Book</button>
            </form>

            <a href="books.php" class="back-link">Back to Book List</a>
        </div>
    </div>

</body>
</html>
