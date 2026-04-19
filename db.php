<?php
// Database configuration
$host = "localhost";     // Change if using remote server
$user = "root";          // Your MySQL username
$pass = "";              // Your MySQL password (default empty for XAMPP)
$dbname = "comfigo_bus"; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set UTF-8 encoding (important for special characters)
$conn->set_charset("utf8");

?>
