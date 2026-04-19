<?php
session_start();
include 'db.php';

// User must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user bookings with payment info
$query = "
  SELECT
    b.booking_id, b.journey_date, b.seat_numbers, b.total_amount, b.booking_status, b.booked_at,
    p.payment_mode, p.payment_status, p.paid_at,
    s.departure_time, s.arrival_time, s.fare,
    r.source_city, r.destination_city,
    bus.bus_name, bus.bus_type
  FROM bookings b
  JOIN schedules s      ON b.schedule_id = s.schedule_id
  JOIN routes r         ON s.route_id    = r.route_id
  JOIN buses  bus       ON s.bus_id      = bus.bus_id
  LEFT JOIN payments p  ON b.booking_id  = p.booking_id
  WHERE b.user_id = ?
  ORDER BY b.booked_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<?php include 'header.php'; ?>

<section class="py-5 mt-5">
  <div class="container">
    <h2 class="mb-4 text-center">🚌 My Bookings</h2>

    <?php if ($result->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered shadow-sm">
          <thead class="table-dark">
            <tr>
              <th>Booking ID</th>
              <th>Bus</th>
              <th>Route</th>
              <th>Journey Date</th>
              <th>Seats</th>
              <th>Total Fare</th>
              <th>Booking Status</th>
              <th>Payment Mode</th>
              <th>Payment Status</th>
              <th>Booked At</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo $row['booking_id']; ?></td>
                <td><?php echo $row['bus_name'] . " (" . $row['bus_type'] . ")"; ?></td>
                <td><?= $row['source_city'] . " → " . $row['destination_city']; ?></td>
                    <small><?php echo $row['departure_time']; ?> - <?php echo $row['arrival_time']; ?></small>
                </td>
                <td><?php echo $row['journey_date']; ?></td>
                <td><?php echo $row['seat_numbers']; ?></td>
                <td>₹<?php echo $row['total_amount']; ?></td>
                <td>
                  <span class="badge bg-<?php echo ($row['booking_status'] == 'CONFIRMED') ? 'success' : 'danger'; ?>">
                    <?php echo $row['booking_status']; ?>
                  </span>
                </td>
                <td><?php echo $row['payment_mode'] ?? "N/A"; ?></td>
                <td>
                  <span class="badge bg-<?php echo ($row['payment_status'] == 'SUCCESS') ? 'success' : (($row['payment_status'] == 'PENDING') ? 'warning' : 'danger'); ?>">
                    <?php echo $row['payment_status'] ?? "N/A"; ?>
                  </span>
                </td>
                <td><?php echo $row['booked_at']; ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center">
        You have no bookings yet. <a href="index.php">Book Now</a>
      </div>
    <?php endif; ?>

  </div>
</section>

<?php include 'footer.php'; ?>
