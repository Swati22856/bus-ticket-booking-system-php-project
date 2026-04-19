<?php
include 'db.php';  // adjust path if needed
include 'admin_header.php';

if (!isset($_GET['bus_id'])) {
    header("Location: manage_buses.php");
    exit();
}

$bus_id = intval($_GET['bus_id']);

// Fetch current bus details
$stmt = $conn->prepare("SELECT bus_name, bus_type, total_seats FROM buses WHERE bus_id = ?");
$stmt->bind_param("i", $bus_id);
$stmt->execute();
$stmt->bind_result($bus_name, $bus_type, $total_seats);
$stmt->fetch();
$stmt->close();

// Update bus if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = $_POST['bus_name'];
    $new_type = $_POST['bus_type'];
    $new_seats = $_POST['total_seats'];

    $update = $conn->prepare("UPDATE buses SET bus_name=?, bus_type=?, total_seats=? WHERE bus_id=?");
    $update->bind_param("ssii", $new_name, $new_type, $new_seats, $bus_id);
    $update->execute();
    $update->close();

    header("Location: manage_buses.php");
    exit();
}
?>

<div class="container mt-5">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-body">
      <h3 class="mb-4">Edit Bus</h3>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Bus Name</label>
          <input type="text" name="bus_name" class="form-control" value="<?= $bus_name ?>" required>
        </div>

  <div class="mb-3">
  <label class="form-label fw-bold text-white">Bus Type</label>
  <select name="bus_type" class="form-select fancy-dropdown" required>
    <option value="AC" <?= ($bus_type == 'AC') ? 'selected' : '' ?>>AC</option>
    <option value="Non-AC" <?= ($bus_type == 'Non-AC') ? 'selected' : '' ?>>Non-AC</option>
    <option value="Sleeper" <?= ($bus_type == 'Sleeper') ? 'selected' : '' ?>>Sleeper</option>
    <option value="Semi-Sleeper" <?= ($bus_type == 'Semi-Sleeper') ? 'selected' : '' ?>>Semi-Sleeper</option>
    <option value="Luxury" <?= ($bus_type == 'Luxury') ? 'selected' : '' ?>>Luxury</option>
  </select>
</div>



        <div class="mb-3">
          <label class="form-label">Total Seats</label>
          <input type="number" name="total_seats" class="form-control" value="<?= $total_seats ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Update Bus</button>
        <a href="manage_buses.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>

<?php include 'admin_footer.php'; ?>
