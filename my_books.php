<?php include '../config/db.php'; ?>
<?php if ($_SESSION['role'] !== 'student') die("Access Denied"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>My Books</title>
</head>
<body>
    <h2>My Borrowed Books</h2>
    <table border="1">
        <tr><th>Title</th><th>Author</th><th>Due Date</th><th>Status</th><th>Fine</th></tr>
        <?php
        $user_id = $_SESSION['user_id'];
        $res = $conn->query("SELECT b.title, b.author, i.due_date, i.return_date, i.fine
                             FROM issued_books i
                             JOIN books b ON i.book_id = b.id
                             WHERE i.user_id = $user_id");
        while ($row = $res->fetch_assoc()) {
            $status = $row['return_date'] ? "Returned" : "Pending";
            echo "<tr>
                <td>{$row['title']}</td>
                <td>{$row['author']}</td>
                <td>{$row['due_date']}</td>
                <td>{$status}</td>
                <td>{$row['fine']}</td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>