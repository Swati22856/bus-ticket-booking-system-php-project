<?php
include 'db.php';
include 'check_login.php'; // Only logged-in users

// Get schedule & date
$schedule_id = $_GET['schedule_id'] ?? 0;
$date = $_GET['date'] ?? date("Y-m-d");

// Fetch schedule details
$sql = "SELECT s.schedule_id, s.departure_time, s.arrival_time, s.fare,
               b.bus_id, b.bus_name, b.bus_type, b.total_seats,
               r.source_city, r.destination_city
        FROM schedules s
        JOIN buses b ON s.bus_id = b.bus_id
        JOIN routes r ON s.route_id = r.route_id
        WHERE s.schedule_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $schedule_id);
$stmt->execute();
$result = $stmt->get_result();
$schedule = $result->fetch_assoc();

if (!$schedule) {
    die("<div class='alert alert-danger'>Invalid schedule selected.</div>");
}

$bus_id = $schedule['bus_id'];

/*------------------------------
      FETCH SEATS FROM TABLE
------------------------------*/
$seatList = [];
$seatStmt = $conn->prepare("SELECT seat_number FROM seats WHERE bus_id = ? ORDER BY seat_number ASC");
$seatStmt->bind_param("i", $bus_id);
$seatStmt->execute();
$seatRes = $seatStmt->get_result();
while ($row = $seatRes->fetch_assoc()) {
    $seatList[] = intval($row['seat_number']);
}

/*------------------------------
      FETCH BOOKED SEATS
------------------------------*/
$booked_seats = [];
$seatQuery = $conn->prepare("SELECT seat_numbers FROM bookings WHERE schedule_id = ? AND journey_date = ?");
$seatQuery->bind_param("is", $schedule_id, $date);
$seatQuery->execute();
$seatResult = $seatQuery->get_result();

while ($row = $seatResult->fetch_assoc()) {
    $seatNumbers = explode(",", $row['seat_numbers']);
    foreach ($seatNumbers as $sn) {
        $booked_seats[] = intval($sn);
    }
}

include 'header.php';
?>

<section class="py-5 mt-5">
  <div class="container">
    <h3 class="mb-4 text-center">Select Your Seats</h3>

    <div class="card shadow-lg border-0 rounded-4">
      <div class="card-body text-center">
        <h5><?= $schedule['bus_name'] . " (" . $schedule['bus_type'] . ")" ?></h5>
        <p><strong>Route:</strong> <?= $schedule['source_city'] ?> ➝ <?= $schedule['destination_city'] ?></p>
        <p><strong>Date:</strong> <?= $date ?></p>
        <p><strong>Departure:</strong> <?= $schedule['departure_time'] ?> |
           <strong>Arrival:</strong> <?= $schedule['arrival_time'] ?></p>
        <p><strong>Fare per Seat:</strong> ₹<?= $schedule['fare'] ?></p>

        <form action="confirm.php" method="POST">
          <input type="hidden" name="schedule_id" value="<?= $schedule_id ?>">
          <input type="hidden" name="date" value="<?= $date ?>">

<!------------------------------
      BUS LAYOUT SECTION
------------------------------->

<?php
$bus_type = strtolower($schedule['bus_type']);

// Layout selection
if ($bus_type === "volvo" || $bus_type === "ac sleeper") {
    $rows = 10;
    $left = 2;
    $right = 1;
} else {
    $rows = 10;
    $left = 2;
    $right = 2;
}

echo "<div class='bus-layout-container my-4'>";
echo "<div class='bus-layout'>";

$index = 0; // pointer for seatList

for ($r = 1; $r <= $rows; $r++) {
    echo "<div class='bus-row'>";

    // Left seats
    echo "<div class='left-side'>";
    for ($i = 1; $i <= $left; $i++) {
        if (!isset($seatList[$index])) break;

        $num = $seatList[$index];
        $disabled = in_array($num, $booked_seats) ? "disabled booked" : "";

        echo seatButton($num, $disabled);
        $index++;
    }
    echo "</div>";

    echo "<div class='walkway'></div>";

    // Right seats
    echo "<div class='right-side'>";
    for ($i = 1; $i <= $right; $i++) {
        if (!isset($seatList[$index])) break;

        $num = $seatList[$index];
        $disabled = in_array($num, $booked_seats) ? "disabled booked" : "";

        echo seatButton($num, $disabled);
        $index++;
    }
    echo "</div>";

    echo "</div>";
}

echo "</div></div>";

function seatButton($num, $disabled) {
    return "
    <label class='seat-box'>
        <input type='checkbox' name='seats[]' value='$num' hidden ".($disabled ? "disabled" : "").">
        <div class='seat $disabled'>$num</div>
    </label>
    ";
}
?>

          <button type="submit" class="btn btn-primary mt-3">Confirm Booking</button>
        </form>
      </div>
    </div>
  </div>
</section>

<style>
.bus-layout {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.bus-row {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 35px;
}
.left-side, .right-side {
    display: flex;
    gap: 10px;
}
.walkway {
    width: 40px;
}
.seat-box {
    cursor: pointer;
}
.seat {
    width: 45px;
    height: 45px;
    background: #e9ffe9;
    border: 2px solid #28a745;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}
.seat:hover {
    background: #c6f6c6;
}
.booked {
    background: #999 !important;
    border-color: #777 !important;
    color: white;
    pointer-events: none;
}
input[type="checkbox"]:checked + .seat {
    background: #28a745 !important;
    color: white;
    border-color: #1f7f35 !important;
}
</style>

<?php include 'footer.php'; ?>
