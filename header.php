<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ComfiGo - Bus Ticket Booking</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link href="css/all.min.css" rel="stylesheet">

  <!-- AOS Animation CSS -->
  <link rel="stylesheet" href="css/aos.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* Sticky header effect */
    #mainHeader {
      transition: top 0.3s ease-in-out;
    }
  </style>
</head>
<body>
  
<header id="mainHeader" class="shadow bg-light fixed-top">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php">ComfiGO</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>
           <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
         
  <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
    <!-- Show these if user is logged in -->
    <li class="nav-item"><a class="nav-link" href="my_bookings.php">My Bookings</a></li>
    <li class="nav-item"><a class="btn btn-danger btn-sm ms-2" href="logout.php">Logout</a></li>
  <?php else: ?>
    <!-- Show these if user is NOT logged in -->
    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
    <li class="nav-item"><a class="nav-link" href="signup.php">Signup</a></li>
  <?php endif; ?>
        
         
        </ul>
      </div>
    </div>
  </nav>
</header>

<script>
let lastScrollTop = 0;
const header = document.getElementById("mainHeader");

window.addEventListener("scroll", function() {
  let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

  if (scrollTop > lastScrollTop) {
    // scrolling down → hide header
    header.style.top = "-80px"; 
  } else {
    // scrolling up → show header
    header.style.top = "0";
  }

  lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; 
});
</script>