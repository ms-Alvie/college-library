<?php include '../config/db.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];
    $student_id = $_POST['student_id'];
    $issue_date = date('Y-m-d');
    $return_date = date('Y-m-d', strtotime("+7 days"));

    $conn->query("INSERT INTO issued_books (user_id, book_id, issue_date, return_date) 
                  VALUES ($student_id, $book_id, '$issue_date', '$return_date')");
    $conn->query("UPDATE books SET available = 0 WHERE id = $book_id");
    header("Location: dashboard.php");
}
?>
<!-- Add your form to select student & book -->