<?php
// manage_buses.php

include 'db.php';
$bus_type = "";


// Handle Add Bus
if (isset($_POST['add_bus'])) {
    $bus_name = $_POST['bus_name'];
    $bus_type = $_POST['bus_type'];
    $total_seats = $_POST['total_seats'];

    // Insert bus
    $stmt = $conn->prepare("INSERT INTO buses (bus_name, bus_type, total_seats) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $bus_name, $bus_type, $total_seats);
    $stmt->execute();

    // Get inserted bus ID
    $bus_id = $stmt->insert_id;
    $stmt->close();

    // Auto-insert seats
    $insertSeat = $conn->prepare("INSERT INTO seats (bus_id, seat_number) VALUES (?, ?)");

    for ($i = 1; $i <= $total_seats; $i++) {
        $insertSeat->bind_param("ii", $bus_id, $i);
        $insertSeat->execute();
    }
    $insertSeat->close();

    header("Location: manage_buses.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_bus'])) {
    $bus_id = intval($_POST['bus_id']);
    $bus_name = trim($_POST['bus_name']);
    $bus_type = trim($_POST['bus_type']);
    $total_seats = intval($_POST['total_seats']);

    $stmt = $conn->prepare("UPDATE buses SET bus_name=?, bus_type=?, total_seats=? WHERE bus_id=?");
    $stmt->bind_param("ssii", $bus_name, $bus_type, $total_seats, $bus_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Bus updated successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }
    $stmt->close();
    header("Location: manage_buses.php");
    exit();
}



// Handle Delete Bus
if (isset($_GET['delete'])) {
    $bus_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM buses WHERE bus_id = ?");
    $stmt->bind_param("i", $bus_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_buses.php");
    exit();
}

// Fetch all buses
$buses = $conn->query("SELECT * FROM buses ORDER BY bus_id DESC");
?>
<?php include 'admin_header.php'; ?>



 
    <h2 class="mb-4" data-aos="fade-right">🚌 Manage Buses</h2>

    <!-- Add Bus Form -->
    <div class="card shadow-lg border-0 rounded-4 mb-4" data-aos="zoom-in">
      <div class="card-body">
        <h5 class="card-title">Add New Bus</h5>
        <form method="POST">
          <div class="row g-3">
            <div class="col-md-4">
              <input type="text" name="bus_name" class="form-control" placeholder="Bus Name" required>
            </div>
            <div class="col-md-4">
 
 <select name="bus_type" class="form-select fancy-dropdown" required>
    <option value="AC">AC</option>
    <option value="Non-AC">Non-AC</option>
    <option value="Sleeper">Sleeper</option>
    <option value="Semi-Sleeper">Semi-Sleeper</option>
    <option value="Luxury">Luxury</option>
</select>
</div>
            <div class="col-md-4">
              <input type="number" name="total_seats" class="form-control" placeholder="Total Seats" required>
            </div>
          </div>
          <button type="submit" name="add_bus" class="btn btn-success mt-3">Add Bus</button>
        </form>
      </div>
    </div>

    <!-- Bus List -->
    <div class="card shadow-lg border-0 rounded-4" data-aos="fade-up">
      <div class="card-body">
        <h5 class="card-title">Bus List</h5>
        <table class="table table-striped table-hover">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Type</th>
              <th>Total Seats</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($bus = $buses->fetch_assoc()): ?>
              <tr>
                <td><?= $bus['bus_id'] ?></td>
                <td><?= $bus['bus_name'] ?></td>
                <td><?= $bus['bus_type'] ?></td>
                <td><?= $bus['total_seats'] ?></td>
                <td>
  <!-- Edit Button -->
           <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#editBusPanel">
  Edit
</button>
                  <a href="manage_buses.php?delete=<?= $bus['bus_id'] ?>" 
                     class="btn btn-danger btn-sm"
                     onclick="return confirm('Are you sure you want to delete this bus?');">
                    <i class="fas fa-trash"></i> Delete
                  </a>
                </td>
              </tr>
              
          <div class="offcanvas offcanvas-end" tabindex="-1" id="editBusPanel">
  <div class="offcanvas-header">
    <h5>Edit Bus</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <form>
      <input type="text" class="form-control mb-2" placeholder="Bus Name">
      <select class="form-select mb-2">
        <option>AC</option>
        <option>Non-AC</option>
      </select>
      <input type="number" class="form-control mb-2" placeholder="Seats">
      <button class="btn btn-success">Save</button>
    </form>
  </div>
</div>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
 


<?php include 'admin_footer.php'; ?>