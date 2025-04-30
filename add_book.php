<?php include '../config/db.php'; ?>
<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $category = $conn->real_escape_string($_POST['category']);

    $conn->query("INSERT INTO books (title, author, category, available) VALUES ('$title', '$author', '$category', 1)");
    header("Location: books.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Book</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>Add Book</h2>
    <form method="POST">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Author:</label><br>
        <input type="text" name="author" required><br><br>

        <label>Category:</label><br>
        <input type="text" name="category" required><br><br>

        <button type="submit">Add Book</button>
    </form>
    <br>
    <a href="books.php">Back to Book List</a>
</body>
</html>