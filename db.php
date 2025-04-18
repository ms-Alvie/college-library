<?php
$conn = new mysqli("localhost", "root", "", "book_storage");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
?>