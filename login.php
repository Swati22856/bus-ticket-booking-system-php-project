<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Bus Booking</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

  <style>


/* Bubble container */
.bubbles {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  z-index: 0;
  overflow: hidden;
}

.bubbles span {
  position: absolute;
  bottom: -100px;
  background: rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  animation: rise 15s infinite ease-in;
}

.bubbles span:nth-child(1) { width: 40px; height: 40px; left: 10%; animation-duration: 18s; }
.bubbles span:nth-child(2) { width: 25px; height: 25px; left: 20%; animation-duration: 12s; animation-delay: 2s; }
.bubbles span:nth-child(3) { width: 50px; height: 50px; left: 35%; animation-duration: 20s; animation-delay: 4s; }
.bubbles span:nth-child(4) { width: 20px; height: 20px; left: 50%; animation-duration: 10s; animation-delay: 1s; }
.bubbles span:nth-child(5) { width: 60px; height: 60px; left: 65%; animation-duration: 22s; animation-delay: 3s; }
.bubbles span:nth-child(6) { width: 30px; height: 30px; left: 80%; animation-duration: 14s; animation-delay: 5s; }
.bubbles span:nth-child(7) { width: 15px; height: 15px; left: 90%; animation-duration: 16s; animation-delay: 7s; }

@keyframes rise {
  0% {
    transform: translateY(0) scale(1);
    opacity: 0;
  }
  50% {
    opacity: 0.6;
  }
  100% {
    transform: translateY(-120vh) scale(1.2);
    opacity: 0;
  }
}


    .card {
      animation: bounceIn 1s ease-out;
      position: relative;
        z-index: 1;
        transition: all 0.4s ease;
  border-radius: 1rem;
  overflow: hidden;
    }

.card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.4),
              0 0 40px rgba(142, 197, 252, 0.3),
              0 0 60px rgba(78, 84, 200, 0.4);
}

/* Button glow on hover */
.btn {
  transition: all 0.3s ease-in-out;
}

.btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.6),
              0 0 20px rgba(78, 84, 200, 0.6);
}

    @keyframes bounceIn {
      0% { transform: scale(0.8); opacity: 0; }
      50% { transform: scale(1.05); opacity: 1; }
      70% { transform: scale(0.95); }
      100% { transform: scale(1); }
    }
    h3 {
      animation: fadeInDown 1.2s ease-in-out;
    }
    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-40px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .alert {
  transition: opacity 0.5s ease-out, transform 0.5s ease-out;
}

  </style>
</head>
<body>

<div class="bubbles">
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
</div>


<section class="py-5 mt-3 w-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-body">
<?php
session_start();
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger fade show" id="alertBox">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success fade show" id="alertBox">'.$_SESSION['success'].'</div>';
    unset($_SESSION['success']);
}
?>

            <h3 class="text-center mb-4">Login</h3>
            <form action="login_process.php" method="POST">
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <p class="text-center mt-3">Don’t have an account? <a href="signup.php">Signup</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  // Auto fade out alert after 4 seconds
  setTimeout(() => {
    const alertBox = document.getElementById("alertBox");
    if (alertBox) {
      alertBox.classList.remove("show");
      alertBox.classList.add("fade");
      setTimeout(() => alertBox.remove(), 500); // remove after fade
    }
  }, 4000);
</script>


<script src="css/bootstrap.bundle.min.js"></script>
</body>
</html>
