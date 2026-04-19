<?php
session_start();
include 'db.php';
include 'header.php';

// ✅ Fetch logged-in user's details
$user_name = "";
$user_email = "";
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $user = $conn->query("SELECT full_name, email FROM users WHERE user_id = $uid")->fetch_assoc();
    if ($user) {
        $user_name = $user['full_name'];
        $user_email = $user['email'];
    }
}

// ✅ Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            $_SESSION['success'] = "✅ Your message has been sent successfully!";
        } else {
            $_SESSION['error'] = "❌ Something went wrong. Please try again!";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "⚠ Please fill in all fields.";
    }
}
?>

<div class="container py-5 text-white">
  <h2 class="fw-bold text-center">Contact Us</h2>
  <p class="text-center mb-4">We’d love to hear from you! Send us your queries and feedback.</p>

  <!-- ✅ Show Alerts -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success text-center">
      <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
  <?php endif; ?>
  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger text-center">
      <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>

  <div class="row justify-content-center">
    <div class="col-md-6">
      <form method="POST" action="">
        <div class="mb-3">
          <label class="form-label">Your Name</label>
          <input type="text" name="name" class="form-control"
                 value="<?= htmlspecialchars($user_name) ?>" 
                 <?= $user_name ? "readonly" : "" ?> required>
        </div>
        <div class="mb-3">
          <label class="form-label">Your Email</label>
          <input type="email" name="email" class="form-control"
                 value="<?= htmlspecialchars($user_email) ?>" 
                 <?= $user_email ? "readonly" : "" ?> required>
        </div>
        <div class="mb-3">
          <label class="form-label">Message</label>
          <textarea name="message" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-success w-100">Send Message</button>
      </form>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
