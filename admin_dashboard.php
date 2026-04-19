<?php

include 'db.php';
include 'admin_header.php';

// ✅ Fetch Stats
$totalBuses = $conn->query("SELECT COUNT(*) AS total FROM buses")->fetch_assoc()['total'];
$totalRoutes = $conn->query("SELECT COUNT(*) AS total FROM routes")->fetch_assoc()['total'];
$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$totalBookings = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'];
?>


    <!-- Stats Cards -->
    <div class="row g-4">
      <div class="col-md-3">
        <a href="buses.php" class="text-decoration-none">
          <div class="card p-3 shadow text-center">
            <h5><i class="fas fa-bus"></i> Total Buses</h5>
            <h3><?php echo $totalBuses; ?></h3>
          </div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="manage_routes.php" class="text-decoration-none">
          <div class="card p-3 shadow text-center">
            <h5><i class="fas fa-route"></i> Routes</h5>
            <h3><?php echo $totalRoutes; ?></h3>
          </div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="manage_users.php" class="text-decoration-none">
          <div class="card p-3 shadow text-center">
            <h5><i class="fas fa-users"></i> Users</h5>
            <h3><?php echo $totalUsers; ?></h3>
          </div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="manage_bookings.php" class="text-decoration-none">
          <div class="card p-3 shadow text-center">
            <h5><i class="fas fa-ticket-alt"></i> Bookings</h5>
            <h3><?php echo $totalBookings; ?></h3>
          </div>
        </a>
      </div>
   

    <!-- Quick Actions -->
    <div class="quick-actions">
      <a href="manage_buses.php" class="btn btn-primary btn-sm">+ Add Bus</a>
      <a href="manage_routes.php" class="btn btn-success btn-sm">+ Add Route</a>
      <a href="manage_schedules.php" class="btn btn-warning btn-sm">+ Add Schedule</a>
    </div>

    <!-- Charts -->
    <div class="row mt-4">
      <div class="col-md-6">
        <div class="card p-3">
          
          <h5>📊 Bookings Trend</h5>
          <canvas id="bookingChart"></canvas>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card p-3">
          <h5>👥 User Growth</h5>
          <canvas id="userChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Dummy data for charts (replace with PHP queries if needed)
    const bookingData = [5, 10, 8, 15, 20, 18];
    const userData = [2, 4, 6, 8, 12, 15];

// Bookings Trend Line Chart
new Chart(document.getElementById('bookingChart'), {
  type: 'line',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
    datasets: [{
      label: 'Bookings',
      data: bookingData,
      borderColor: '#00ffea',   // neon cyan for visibility
      backgroundColor: 'rgba(0,255,234,0.2)',
      borderWidth: 3,
      fill: true,
      tension: 0.4,
      pointBackgroundColor: "#fff", // white dots
      pointBorderColor: "#00ffea",  // cyan outline
      pointRadius: 5,
      pointHoverRadius: 7
    }]
  },
  options: {
    plugins: {
      legend: {
        labels: {
          color: "#fff",  // white legend
          font: { size: 14, weight: "bold" }
        }
      }
    },
    scales: {
      x: { ticks: { color: "#fff" }, grid: { color: "rgba(255,255,255,0.2)" } },
      y: { ticks: { color: "#fff" }, grid: { color: "rgba(255,255,255,0.2)" } }
    }
  }
});

// User Growth Bar Chart
new Chart(document.getElementById('userChart'), {
  type: 'bar',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
    datasets: [{
      label: 'Users',
      data: userData,
      backgroundColor: 'rgba(255, 215, 0, 0.8)', // golden bars
      borderColor: '#FFD700', // solid gold outline
      borderWidth: 2
    }]
  },
  options: {
    plugins: {
      legend: {
        labels: {
          color: "#fff",  // white legend
          font: { size: 14, weight: "bold" }
        }
      }
    },
    scales: {
      x: { ticks: { color: "#fff" }, grid: { color: "rgba(255,255,255,0.1)" } },
      y: { ticks: { color: "#fff" }, grid: { color: "rgba(255,255,255,0.1)" } }
    }
  }
});
  </script>


<?php include 'admin_footer.php'; ?>
