<?php

include 'db.php';
include 'admin_header.php';

// ✅ Handle Delete Booking
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM bookings WHERE booking_id=$id");
    $_SESSION['success'] = "Booking deleted successfully!";
    header("Location: manage_bookings.php");
    exit();
}

// ✅ Handle Status Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $id = intval($_POST['booking_id']);
    $status = $_POST['booking_status'];

    $stmt = $conn->prepare("UPDATE bookings SET booking_status=? WHERE booking_id=?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Booking status updated!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }
    header("Location: manage_bookings.php");
    exit();
}

// ✅ Fetch All Bookings with Join
$sql = "SELECT b.*, u.full_name, u.email,
               s.departure_time, s.arrival_time, s.fare,
               r.source_city, r.destination_city,
               bus.bus_name
        FROM bookings b
        JOIN users u ON b.user_id = u.user_id
        JOIN schedules s ON b.schedule_id = s.schedule_id
        JOIN buses bus ON s.bus_id = bus.bus_id
        JOIN routes r ON s.route_id = r.route_id
        ORDER BY b.booking_id DESC";

$bookings = $conn->query($sql);
?>

<div class="container mt-5">
  <h2 class="mb-4 fw-bold text-white">Manage Bookings</h2>

  <!-- ✅ Alerts -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <!-- ✅ Table -->
  <div class="card shadow border-0 rounded-4">
    <div class="card-body table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-dark text-center">
          <tr>
            <th>ID</th>
            <th>User</th>
            <th>Email</th>
            <th>Bus</th>
            <th>Route</th>
            <th>Journey Date</th>
            <th>Departure</th>
            <th>Arrival</th>
            <th>Seats</th>
            <th>Total</th>
            <th>Status</th>
            <th>Booked At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php while ($b = $bookings->fetch_assoc()): ?>
          <tr>
            <td><?= $b['booking_id'] ?></td>
            <td><?= $b['full_name'] ?></td>
            <td><?= $b['email'] ?></td>
            <td><?= $b['bus_name'] ?></td>
            <td><?= $b['source_city'] ?> ➝ <?= $b['destination_city'] ?></td>
            <td><?= $b['journey_date'] ?></td>
            <td><?= $b['departure_time'] ?></td>
            <td><?= $b['arrival_time'] ?></td>
            <td><?= $b['seat_numbers'] ?></td>
            <td>₹<?= number_format($b['total_amount'], 2) ?></td>
            <td>
              <span class="badge <?= $b['booking_status']=='confirmed'?'bg-success':'bg-danger' ?>">
                <?= ucfirst($b['booking_status']) ?>
              </span>
            </td>
            <td><?= $b['booked_at'] ?></td>
            <td>
           
              <!-- Delete -->
              <a href="manage_bookings.php?delete=<?= $b['booking_id'] ?>"
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('Delete this booking?');">
                <i class="fas fa-trash"></i> Delete
              </a>
            </td>
          </tr>

         
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'admin_footer.php'; ?>
