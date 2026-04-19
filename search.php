<?php
include 'db.php';
include 'header.php';

$from = isset($_GET['from']) ? $_GET['from'] : '';
$to   = isset($_GET['to']) ? $_GET['to'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");

?>
<main>
<section class="py-5 mt-5">
  <div class="container">
    <h3 class="mb-4">Available Buses</h3>

    <?php
    if ($from && $to) {
        $sql = "SELECT s.schedule_id, s.departure_time, s.arrival_time, s.fare,
                       b.bus_name, b.bus_type, b.total_seats,
                       r.source_city, r.destination_city
                FROM schedules s
                JOIN buses b ON s.bus_id = b.bus_id
                JOIN routes r ON s.route_id = r.route_id
                WHERE r.source_city LIKE '%$from%' AND r.destination_city LIKE '%$to%'";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="row g-4">';
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="col-md-6">
                  <div class="card shadow border-0 rounded-4 h-100">
                    <div class="card-body">
                      <h5 class="fw-bold">'.$row['bus_name'].' ('.$row['bus_type'].')</h5>
                      <p class="mb-1"><strong>Route:</strong> '.$row['source_city'].' ➝ '.$row['destination_city'].'</p>
                      <p class="mb-1"><strong>Departure:</strong> '.$row['departure_time'].'</p>
                      <p class="mb-1"><strong>Arrival:</strong> '.$row['arrival_time'].'</p>
                      <p class="mb-2"><strong>Fare:</strong> ₹'.$row['fare'].'</p>
                      <a href="book.php?schedule_id='.$row['schedule_id'].'&date='.$date.'" class="btn btn-success w-100">
                        Book Now
                      </a>
                    </div>
                  </div>
                </div>
                ';
            }
            echo '</div>';
        } else {
            echo '<div class="alert alert-warning">No buses found for this route.</div>';
        }
    } else {
        echo '<div class="alert alert-info">Please enter your journey details.</div>';
    }
    ?>
  </div>
</section>
  </main>
<?php include 'footer.php'; ?>
