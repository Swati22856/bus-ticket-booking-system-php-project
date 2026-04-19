<?php
include 'db.php';
include 'admin_header.php';

// ✅ Handle Add Schedule
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_schedule'])) {
    $bus_id = intval($_POST['bus_id']);
    $route_id = intval($_POST['route_id']);
    $departure = $_POST['departure_time'];
    $arrival = $_POST['arrival_time'];
    $fare = floatval($_POST['fare']);

    $stmt = $conn->prepare("INSERT INTO schedules (bus_id, route_id, departure_time, arrival_time, fare) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iissd", $bus_id, $route_id, $departure, $arrival, $fare);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Schedule added successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }
    header("Location: manage_schedules.php");
    exit();
}

// ✅ Handle Delete Schedule
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM schedules WHERE schedule_id = $id");
    $_SESSION['success'] = "Schedule deleted successfully!";
    header("Location: manage_schedules.php");
    exit();
}

// ✅ Handle Edit Schedule
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_schedule'])) {
    $id = intval($_POST['schedule_id']);
    $bus_id = intval($_POST['bus_id']);
    $route_id = intval($_POST['route_id']);
    $departure = $_POST['departure_time'];
    $arrival = $_POST['arrival_time'];
    $fare = floatval($_POST['fare']);

    $stmt = $conn->prepare("UPDATE schedules SET bus_id=?, route_id=?, departure_time=?, arrival_time=?, fare=? WHERE schedule_id=?");
    $stmt->bind_param("iissdi", $bus_id, $route_id, $departure, $arrival, $fare, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Schedule updated successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }
    header("Location: manage_schedules.php");
    exit();
}

// ✅ Fetch Data
$schedules = $conn->query("SELECT s.*, b.bus_name, r.source_city, r.destination_city 
                           FROM schedules s
                           JOIN buses b ON s.bus_id=b.bus_id
                           JOIN routes r ON s.route_id=r.route_id
                           ORDER BY s.schedule_id DESC");
$buses = $conn->query("SELECT * FROM buses ORDER BY bus_name");
$routes = $conn->query("SELECT * FROM routes ORDER BY source_city");
?>

<div class="container mt-5">
  <h2 class="mb-4 fw-bold text-white">Manage Schedules</h2>

  <!-- ✅ Alerts -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <!-- ✅ Add Schedule -->
  <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
    <i class="fas fa-plus"></i> Add Schedule
  </button>

  <!-- ✅ Table -->
  <div class="card shadow border-0 rounded-4">
    <div class="card-body">
      <table class="table table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Bus</th>
            <th>Route</th>
            <th>Departure</th>
            <th>Arrival</th>
            <th>Fare</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($s = $schedules->fetch_assoc()): ?>
          <tr>
            <td><?= $s['schedule_id'] ?></td>
            <td><?= $s['bus_name'] ?></td>
            <td><?= $s['source_city'] ?> ➝ <?= $s['destination_city'] ?></td>
            <td><?= $s['departure_time'] ?></td>
            <td><?= $s['arrival_time'] ?></td>
            <td>₹<?= $s['fare'] ?></td>
            <td>
              <!-- ✅ Edit Button -->
              <button class="btn btn-primary btn-sm"
                onclick="openSlideIn(
                  '<?= $s['schedule_id'] ?>',
                  '<?= $s['bus_id'] ?>',
                  '<?= $s['route_id'] ?>',
                  '<?= $s['departure_time'] ?>',
                  '<?= $s['arrival_time'] ?>',
                  '<?= $s['fare'] ?>'
                )">
                <i class="fas fa-edit"></i> Edit
              </button>

              <!-- ✅ Delete -->
              <a href="manage_schedules.php?delete=<?= $s['schedule_id'] ?>"
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('Delete this schedule?');">
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

<!-- ✅ Add Schedule Modal -->
<div class="modal fade" id="addScheduleModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Add Schedule</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label>Bus</label>
            <select name="bus_id" class="form-control" required>
              <?php
              $buses->data_seek(0);
              while ($b = $buses->fetch_assoc()):
              ?>
                <option value="<?= $b['bus_id'] ?>"><?= $b['bus_name'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="mb-3">
            <label>Route</label>
            <select name="route_id" class="form-control" required>
              <?php
              $routes->data_seek(0);
              while ($r = $routes->fetch_assoc()):
              ?>
                <option value="<?= $r['route_id'] ?>"><?= $r['source_city'] ?> ➝ <?= $r['destination_city'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="mb-3">
            <label>Departure Time</label>
            <input type="time" name="departure_time" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Arrival Time</label>
            <input type="time" name="arrival_time" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Fare</label>
            <input type="number" step="0.01" name="fare" class="form-control" required>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" name="add_schedule" class="btn btn-success">Add</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ✅ Slide-In Edit Panel -->
<div id="editPanel">
  <div class="panel-header">
    <h4>Edit Schedule</h4>
    <button type="button" class="close-btn" onclick="closeSlideIn()">&times;</button>
  </div>
  <div class="panel-content">
    <form method="POST">
      <input type="hidden" id="schedule_id" name="schedule_id">

      <div class="mb-3">
        <label class="form-label">Bus</label>
        <select id="bus_id" name="bus_id" class="form-control" required>
          <?php
          $buses->data_seek(0);
          while ($b = $buses->fetch_assoc()):
          ?>
            <option value="<?= $b['bus_id'] ?>"><?= $b['bus_name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Route</label>
        <select id="route_id" name="route_id" class="form-control" required>
          <?php
          $routes->data_seek(0);
          while ($r = $routes->fetch_assoc()):
          ?>
            <option value="<?= $r['route_id'] ?>"><?= $r['source_city'] ?> ➝ <?= $r['destination_city'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Departure Time</label>
        <input type="time" id="departure_time" name="departure_time" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Arrival Time</label>
        <input type="time" id="arrival_time" name="arrival_time" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Fare (₹)</label>
        <input type="number" step="0.01" id="fare" name="fare" class="form-control" required>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button type="submit" name="edit_schedule" class="btn btn-primary px-4">Save Changes</button>
        <button type="button" class="btn btn-secondary px-4" onclick="closeSlideIn()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<style>
#editPanel {
  position: fixed;
  top: 0;
  right: -420px;
  width: 400px;
  height: 100vh;
  background: linear-gradient(135deg, #4a00e0, #8e2de2);
  color: #fff;
  box-shadow: -3px 0 15px rgba(0,0,0,0.3);
  transition: right 0.4s ease;
  z-index: 1055;
  padding: 20px;
  border-top-left-radius: 16px;
  border-bottom-left-radius: 16px;
}
#editPanel.active { right: 0; }

.panel-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 2px solid rgba(255,255,255,0.3);
  padding-bottom: 10px;
}
.panel-header h4 { margin: 0; font-weight: 700; color: #fff; }

.close-btn {
  background: none;
  border: none;
  color: #fff;
  font-size: 28px;
  line-height: 1;
  cursor: pointer;
  transition: transform 0.2s;
}
.close-btn:hover { transform: scale(1.2); color: #ff6666; }

.panel-content { margin-top: 25px; }
.form-control { border-radius: 10px; border: none; padding: 10px; }
.btn { border-radius: 10px; }
</style>

<script>
function openSlideIn(schedule_id, bus_id, route_id, departure, arrival, fare) {
  document.getElementById("schedule_id").value = schedule_id;
  document.getElementById("bus_id").value = bus_id;
  document.getElementById("route_id").value = route_id;
  document.getElementById("departure_time").value = departure;
  document.getElementById("arrival_time").value = arrival;
  document.getElementById("fare").value = fare;
  document.getElementById("editPanel").classList.add("active");
}
function closeSlideIn() {
  document.getElementById("editPanel").classList.remove("active");
}
</script>

<?php include 'admin_footer.php'; ?>
