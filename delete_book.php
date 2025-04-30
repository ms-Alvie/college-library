<?php
include '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete the book
    $conn->query("DELETE FROM books WHERE id = $id");

    // Redirect back to the book list
    header("Location: books.php");
    exit();
} else {
    echo "Book ID not provided.";
}
?>