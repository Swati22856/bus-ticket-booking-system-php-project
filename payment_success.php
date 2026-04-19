<?php
session_start();
include 'db.php';

// User must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Collect booking data
$schedule_id   = $_POST['schedule_id'];
$date          = $_POST['date'];
$seats         = $_POST['seats'];
$totalFare     = $_POST['totalFare'];
$paymentMethod = $_POST['payment_method'];

// Prepare seat numbers as comma-separated string
$seatNumbers = implode(",", $seats);

// Insert booking first
$stmt = $conn->prepare("INSERT INTO bookings (user_id, schedule_id, journey_date, seat_numbers, total_amount, booking_status, booked_at) VALUES (?, ?, ?, ?, ?, 'CONFIRMED', NOW())");
$stmt->bind_param("iissi", $user_id, $schedule_id, $date, $seatNumbers, $totalFare);
$stmt->execute();
$booking_id = $stmt->insert_id; // get the newly created booking id
$stmt->close();

// Insert payment details
$paymentStatus = ($paymentMethod == "Cash") ? "PENDING" : "SUCCESS";
$stmt2 = $conn->prepare("INSERT INTO payments (booking_id, amount, payment_mode, payment_status, paid_at) VALUES (?, ?, ?, ?, NOW())");
$stmt2->bind_param("idss", $booking_id, $totalFare, $paymentMethod, $paymentStatus);
$stmt2->execute();
$stmt2->close();

?>
<?php include 'header.php'; ?>

<section class="py-5 mt-5">
  <div class="container text-center">
    <div class="card shadow-lg border-0 rounded-4 p-5">
      <h2 class="text-success mb-3">🎉 Booking Confirmed!</h2>
      <p class="lead">Thank you, <strong><?php echo $_SESSION['name']; ?></strong>. Your tickets are booked.</p>

      <div class="mt-4 text-start">
        <p><strong>Journey Date:</strong> <?php echo $date; ?></p>
        <p><strong>Seats:</strong> <?php echo $seatNumbers; ?></p>
        <p><strong>Total Fare:</strong> ₹<?php echo $totalFare; ?></p>
        <p><strong>Payment Method:</strong> <?php echo $paymentMethod; ?></p>
        <p><strong>Payment Status:</strong> <?php echo $paymentStatus; ?></p>
      </div>

      <a href="my_bookings.php" class="btn btn-primary mt-4">View My Bookings</a>
      <a href="index.php" class="btn btn-outline-secondary mt-4">Back to Home</a>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
