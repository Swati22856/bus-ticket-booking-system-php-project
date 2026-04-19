<?php
session_start();
include 'db.php';

// ✅ Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/all.min.css" rel="stylesheet">
  <script src="js/chart.min.js"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #4a00e0, #8e2de2, #00c6ff);
      background-size: 300% 300%;
      animation: gradientBG 12s ease infinite;
      color: #fff;
      display: flex;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background: rgba(0,0,0,0.85);
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      padding-top: 20px;
    }

    .sidebar h3 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 700;
      color: #f5f5f5;
    }

    .sidebar a {
      display: block;
      color: #ddd;
      padding: 12px 20px;
      text-decoration: none;
      transition: 0.3s;
    }
    .sidebar a:hover {
      background: #4a00e0;
      color: #fff;
      border-radius: 8px;
    }

    /* Content */
    .content {
      margin-left: 250px;
      padding: 20px;
      width: 100%;
    }

    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(0,0,0,0.6);
      padding: 10px 20px;
      border-radius: 12px;
      margin-bottom: 20px;
    }

    .card {
      background: rgba(255,255,255,0.1);
      border: none;
      border-radius: 16px;
      color: #fff;
      transition: transform 0.3s;
      cursor: pointer;
    }
    .card:hover {
      transform: translateY(-5px);
      background: rgba(255,255,255,0.2);
    }

    .card h5 {
      font-weight: 600;
    }

    .quick-actions {
      margin: 25px 0;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h3>Admin Panel</h3>
    <a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="manage_buses.php"><i class="fas fa-bus"></i> Manage Buses</a>
    <a href="manage_routes.php"><i class="fas fa-route"></i> Manage Routes</a>
    <a href="manage_schedules.php"><i class="fas fa-calendar-alt"></i> Schedules</a>
    <a href="manage_users.php"><i class="fas fa-users"></i> Users</a>
    <a href="manage_bookings.php"><i class="fas fa-ticket-alt"></i> Bookings</a>
    <a href="manage_contacts.php" ><i class="fas fa-envelope"></i> Contacts</a>
  </li>

  </div>

  <!-- Content -->
  <div class="content">
    <div class="topbar">
      <h4>Welcome, <?php echo $_SESSION['admin_name']; ?> 👋</h4>
      <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
