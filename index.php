<<<<<<< HEAD
<?php
if (isset($_SESSION['role'])) {
    header("Location: " . $_SESSION['role'] . "/dashboard.php");
} else {
    header("Location: auth/login.php");
}
exit();
?>
=======
<?php
if (isset($_SESSION['role'])) {
    header("Location: " . $_SESSION['role'] . "/dashboard.php");
} else {
    header("Location: auth/login.php");
}
exit();
?>
>>>>>>> 2646450c5ef3ca0af4dce47960125cb0a7889ac6
