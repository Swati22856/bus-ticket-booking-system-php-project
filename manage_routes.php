<?php
include 'db.php';
include 'admin_header.php';

// ✅ Handle Add Route
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_route'])) {
    $source = trim($_POST['source_city']);
    $destination = trim($_POST['destination_city']);
    $stmt = $conn->prepare("INSERT INTO routes (source_city, destination_city) VALUES (?, ?)");
    $stmt->bind_param("ss", $source, $destination);
    $stmt->execute();
    $stmt->close();
    $_SESSION['success'] = "Route added successfully!";
    header("Location: manage_routes.php");
    exit();
}

// ✅ Handle Edit Route
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_route'])) {
    $route_id = intval($_POST['route_id']);
    $source = trim($_POST['source_city']);
    $destination = trim($_POST['destination_city']);
    $stmt = $conn->prepare("UPDATE routes SET source_city=?, destination_city=? WHERE route_id=?");
    $stmt->bind_param("ssi", $source, $destination, $route_id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['success'] = "Route updated successfully!";
    header("Location: manage_routes.php");
    exit();
}

// ✅ Handle Delete
if (isset($_GET['delete'])) {
    $route_id = intval($_GET['delete']);
    $conn->query("DELETE FROM routes WHERE route_id = $route_id");
    $_SESSION['success'] = "Route deleted successfully!";
    header("Location: manage_routes.php");
    exit();
}

// ✅ Fetch Routes
$result = $conn->query("SELECT * FROM routes ORDER BY route_id DESC");
?>

<div class="container mt-5">
  <h2 class="mb-4 fw-bold text-white">Manage Routes</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <button class="btn btn-success mb-3" data-bs-toggle="collapse" data-bs-target="#addRouteForm">
    <i class="fas fa-plus"></i> Add New Route
  </button>

  <!-- Add Route Form -->
  <div class="collapse" id="addRouteForm">
    <div class="card p-3 mb-4 shadow-lg border-0 rounded-4">
      <form method="POST">
        <div class="row">
          <div class="col-md-5">
            <input type="text" name="source_city" class="form-control" placeholder="Source City" required>
          </div>
          <div class="col-md-5">
            <input type="text" name="destination_city" class="form-control" placeholder="Destination City" required>
          </div>
          <div class="col-md-2">
            <button type="submit" name="add_route" class="btn btn-success w-100">Add</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Table -->
  <div class="card shadow border-0 rounded-4">
    <div class="card-body">
      <table class="table table-hover align-middle text-white">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($route = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $route['route_id'] ?></td>
            <td><?= $route['source_city'] ?></td>
            <td><?= $route['destination_city'] ?></td>
            <td>
              <button class="btn btn-primary btn-sm" 
                      onclick="openSlideIn(<?= $route['route_id'] ?>, '<?= htmlspecialchars($route['source_city']) ?>', '<?= htmlspecialchars($route['destination_city']) ?>')">
                <i class="fas fa-edit"></i> Edit
              </button>
              <a href="manage_routes.php?delete=<?= $route['route_id'] ?>" 
                 class="btn btn-danger btn-sm" 
                 onclick="return confirm('Are you sure you want to delete this route?');">
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
<!-- ✅ Slide-In Edit Panel -->
<div id="editPanel">
  <div class="panel-header">
    <h4>Edit Route</h4>
    <button type="button" class="close-btn" onclick="closeSlideIn()">&times;</button>
  </div>
  <div class="panel-content">
    <form method="POST">
      <input type="hidden" id="route_id" name="route_id">
      <div class="mb-3">
        <label class="form-label">Source City</label>
        <input type="text" id="source_city" name="source_city" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Destination City</label>
        <input type="text" id="destination_city" name="destination_city" class="form-control" required>
      </div>
      <div class="d-flex justify-content-between mt-4">
        <button type="submit" name="edit_route" class="btn btn-primary px-4">Save Changes</button>
        <button type="button" class="btn btn-secondary px-4" onclick="closeSlideIn()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<style>
  /* 🔹 Slide-In Panel Styling */
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

  #editPanel.active {
    right: 0;
  }

  #editPanel .panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid rgba(255,255,255,0.3);
    padding-bottom: 10px;
  }

  #editPanel .panel-header h4 {
    margin: 0;
    font-weight: 700;
    color: #fff;
  }

  #editPanel .close-btn {
    background: none;
    border: none;
    color: #fff;
    font-size: 28px;
    line-height: 1;
    cursor: pointer;
    transition: transform 0.2s;
  }

  #editPanel .close-btn:hover {
    transform: scale(1.2);
    color: #ff6666;
  }

  #editPanel .panel-content {
    margin-top: 25px;
  }

  #editPanel .form-control {
    border-radius: 10px;
    border: none;
    padding: 10px;
  }

  #editPanel .btn {
    border-radius: 10px;
  }
</style>

<script>
function openSlideIn(id, source, dest) {
  document.getElementById("route_id").value = id;
  document.getElementById("source_city").value = source;
  document.getElementById("destination_city").value = dest;
  document.getElementById("editPanel").classList.add("active");
}

function closeSlideIn() {
  document.getElementById("editPanel").classList.remove("active");
}
</script>

<?php include 'admin_footer.php'; ?>
