<?php
if (isset($_SESSION['role'])) {
    header("Location: " . $_SESSION['role'] . "/dashboard.php");
} else {
    header("Location: auth/login.php");
}
exit();
?>