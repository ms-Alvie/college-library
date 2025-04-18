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
</head>
<body>
    <h2>Edit Book</h2>
    <form method="post">
        <label>Title:</label>
        <input type="text" name="title" value="<?= $book['title'] ?>"><br>
        <label>Author:</label>
        <input type="text" name="author" value="<?= $book['author'] ?>"><br>
        <label>Category:</label>
        <input type="text" name="category" value="<?= $book['category'] ?>"><br>
        <button type="submit">Update Book</button>
    </form>
</body>
</html>