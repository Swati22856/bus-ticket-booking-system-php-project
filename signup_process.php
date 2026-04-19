<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name       = mysqli_real_escape_string($conn, $_POST['name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $gender     = mysqli_real_escape_string($conn, $_POST['gender']);
    $password   = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // ✅ Check if user already exists (by email or phone)
    $checkUser = $conn->query("SELECT * FROM users WHERE email='$email' OR phone='$phone'");
    if ($checkUser->num_rows > 0) {
        $_SESSION['error'] = "Email or Phone already registered!";
        header("Location: signup.php");
        exit();
    }

    // ✅ Insert new user
    $sql = "INSERT INTO users (full_name, email, phone, birth_dt, gender, password) 
            VALUES ('$name', '$email', '$phone', '$birth_date', '$gender', '$password')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Signup successful! Please login.";
        header("Location: login.php");
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
        header("Location: signup.php");
    }
}
?>
