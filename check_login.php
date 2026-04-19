<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    // Save the page where the user wanted to go
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    $_SESSION['error'] = "Please login to continue!";
    header("Location: login.php");
    exit();
}
?>
