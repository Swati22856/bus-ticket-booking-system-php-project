<?php
// admin_login.php
session_start();
include 'db.php';

// If admin already logged in, redirect to dashboard
if (isset($_SESSION['admin_id'])) {
  header("Location: admin_dashboard.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login - ComfiGo</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/aos.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(120deg, #4a00e0, #8e2de2, #00c6ff);
      background-size: 300% 300%;
      animation: gradientBG 12s ease infinite;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
    }
    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .card {
      border-radius: 20px;
      box-shadow: 0px 8px 25px rgba(0,0,0,0.3);
      overflow: hidden;
      animation: fadeInUp 1s ease;
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .btn-custom {
      background: #ff9800;
      border: none;
      transition: transform 0.3s ease, background 0.3s;
    }
    .btn-custom:hover {
      background: #e68900;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card p-4 text-dark">
          <h3 class="text-center mb-4 fw-bold">🔑 Admin Login</h3>
          <form action="admin_login_process.php" method="POST">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Login</button>
          </form>
          <p class="text-center text-muted mt-3 mb-0" style="font-size: 14px;">
            © <?php echo date("Y"); ?> ComfiGo Admin Panel
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>
</html>
