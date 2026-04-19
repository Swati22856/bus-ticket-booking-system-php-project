<?php
// admin_login_process.php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check admin credentials from database
    $stmt = $conn->prepare("SELECT admin_id, name, password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($admin_id, $admin_name, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            // ✅ Successful login
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_name'] = $admin_name;

            header("Location: admin_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password!";
            header("Location: admin_login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid email or password!";
        header("Location: admin_login.php");
        exit();
    }
}
?>
