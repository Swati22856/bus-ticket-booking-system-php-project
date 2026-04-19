<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$result = $conn->query("SELECT * FROM buses");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quick View - Buses</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/all.min.css" rel="stylesheet">
  <link href="css/admin.css" rel="stylesheet"> <!-- same stylesheet as manage files -->
</head>
<body>
  <div class="d-flex">
    
    <!-- Sidebar -->
    <div class="sidebar p-3">
      <h3 class="text-white">Admin Panel</h3>
      <ul class="nav flex-column mt-4">
        <li class="nav-item"><a href="admin_dashboard.php" class="nav-link"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="nav-item"><a href="manage_buses.php" class="nav-link"><i class="fas fa-bus"></i> Manage Buses</a></li>
        <li class="nav-item"><a href="manage_routes.php" class="nav-link"><i class="fas fa-route"></i> Manage Routes</a></li>
        <li class="nav-item"><a href="schedules.php" class="nav-link"><i class="fas fa-calendar-alt"></i> Schedules</a></li>
        <li class="nav-item"><a href="users.php" class="nav-link"><i class="fas fa-users"></i> Users</a></li>
        <li class="nav-item"><a href="manage_bookings.php" class="nav-link"><i class="fas fa-ticket-alt"></i> Bookings</a></li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="content flex-grow-1 p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fas fa-bus"></i> Quick View - Buses</h2>
        <a href="admin_dashboard.php" class="btn btn-secondary">⬅ Back</a>
      </div>

      <div class="card shadow-lg p-3">
        <table class="table table-hover table-striped">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Bus Name</th>
              <th>Type</th>
              <th>Total Seats</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($bus = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $bus['bus_id']; ?></td>
                <td><?= $bus['bus_name']; ?></td>
                <td><?= $bus['bus_type']; ?></td>
                <td><?= $bus['total_seats']; ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
