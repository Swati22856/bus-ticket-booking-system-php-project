<?php
include 'db.php';
include 'check_login.php';

$totalFare = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id     = $_SESSION['user_id'];
    $schedule_id = $_POST['schedule_id'];
    $date        = $_POST['date'];
    $seats       = $_POST['seats'] ?? [];
   


    if (empty($seats)) {
        $_SESSION['error'] = "Please select at least one seat.";
        header("Location: seats.php?schedule_id=$schedule_id&date=$date");
        exit();
    }

    // Fetch schedule details
    $sql = "SELECT s.schedule_id, s.departure_time, s.arrival_time, s.fare,
                   b.bus_name, b.bus_type,
                   r.source_city, r.destination_city
            FROM schedules s
            JOIN buses b ON s.bus_id = b.bus_id
            JOIN routes r ON s.route_id = r.route_id
            WHERE s.schedule_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $schedule_id);
    $stmt->execute();
    $schedule = $stmt->get_result()->fetch_assoc();

    if (!$schedule) {
        die("<div class='alert alert-danger'>Invalid schedule.</div>");
    }

    // Insert bookings for each seat
 
     $totalFare = $schedule['fare'] * count($seats);

}
?>
<?php include 'header.php'; ?>

<section class="py-5 mt-5">
  <div class="container">
    <div class="card shadow-lg border-0 rounded-4">
      <div class="card-body text-center">
        <h3 class="text-success">Booking Confirmed 🎉</h3>
        <p class="mt-3">Thank you, <strong><?php echo $_SESSION['name']; ?></strong>. Your booking has been successfully completed.</p>

        <h5 class="mt-4">Booking Details</h5>
       <ul class="list-group list-group-flush text-start">
          <li class="list-group-item"><strong>Bus:</strong> <?php echo $schedule['bus_name']." (".$schedule['bus_type'].")"; ?></li>
          <li class="list-group-item"><strong>Route:</strong> <?php echo $schedule['source_city']." ➝ ".$schedule['destination_city']; ?></li>
          <li class="list-group-item"><strong>Date:</strong> <?php echo $date; ?></li>
          <li class="list-group-item"><strong>Departure:</strong> <?php echo $schedule['departure_time']; ?></li>
          <li class="list-group-item"><strong>Arrival:</strong> <?php echo $schedule['arrival_time']; ?></li>
          <li class="list-group-item"><strong>Seats:</strong> <?php echo implode(", ", $seats); ?></li>
          <li class="list-group-item"><strong>Total Fare:</strong> ₹<?php echo $totalFare; ?></li>
        </ul> 

        <form action="payment.php" method="POST">
  <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">
  <input type="hidden" name="date" value="<?php echo $date; ?>">
  <?php foreach ($seats as $seat): ?>
    <input type="hidden" name="seats[]" value="<?php echo $seat; ?>">
  <?php endforeach; ?>
  <input type="hidden" name="totalFare" value="<?php echo $totalFare; ?>">
  <button type="submit" class="btn btn-success mt-4">Proceed to Payment</button>
  <a href="index.php" class="btn btn-outline-secondary mt-4">Back to Home</a>
</form>


        
        
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
