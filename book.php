<?php
include 'db.php';
include 'check_login.php';

if (!isset($_GET['schedule_id']) || !isset($_GET['date'])) {
    $_SESSION['error'] = "Invalid booking request!";
    header("Location: search.php");
    exit();
}

$schedule_id = intval($_GET['schedule_id']);
$date = $_GET['date'];

// ✅ Fetch schedule, bus & route details
$sql = "SELECT s.schedule_id, s.departure_time, s.arrival_time, s.fare,
               b.bus_name, b.bus_type, b.total_seats,
               r.source_city, r.destination_city
        FROM schedules s
        JOIN buses b ON s.bus_id = b.bus_id
        JOIN routes r ON s.route_id = r.route_id
        WHERE s.schedule_id = $schedule_id
        LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    $_SESSION['error'] = "Schedule not found!";
    header("Location: search.php");
    exit();
}

$schedule = $result->fetch_assoc();
?>

<?php include 'header.php'; ?>

<section class="py-5 mt-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-body">
            <h3 class="mb-4 text-center">Confirm Your Booking</h3>

            <div class="mb-3">
              <h5><?= $schedule['source_city']; ?> ➝ <?= $schedule['destination_city']; ?></h5>
              <p>
                <strong>Bus:</strong> <?= $schedule['bus_name']; ?> (<?= $schedule['bus_type']; ?>)<br>
                <strong>Departure:</strong> <?= $schedule['departure_time']; ?><br>
                <strong>Arrival:</strong> <?= $schedule['arrival_time']; ?><br>
                <strong>Date:</strong> <?= $date; ?><br>
                <strong>Fare:</strong> ₹<?= $schedule['fare']; ?>
              </p>
            </div>

            <form action="seats.php" method="GET">
              <input type="hidden" name="schedule_id" value="<?= $schedule['schedule_id']; ?>">
              <input type="hidden" name="date" value="<?= $date; ?>">

              <div class="d-grid">
                <button type="submit" class="btn btn-success btn-lg">
                  Select Seats & Continue
                </button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
