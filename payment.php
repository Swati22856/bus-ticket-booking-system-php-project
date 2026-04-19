<?php include 'header.php'; ?>

<section class="py-5 mt-5">
  <div class="container">
    <div class="card shadow-lg border-0 rounded-4">
      <div class="card-body">
        <h3 class="text-center">Choose Payment Method</h3>
        <form action="payment_success.php" method="POST" id="paymentForm">
          <!-- Hidden booking data -->
          <input type="hidden" name="schedule_id" value="<?php echo $_POST['schedule_id']; ?>">
          <input type="hidden" name="date" value="<?php echo $_POST['date']; ?>">
          <?php foreach ($_POST['seats'] as $seat): ?>
            <input type="hidden" name="seats[]" value="<?php echo $seat; ?>">
          <?php endforeach; ?>
          <input type="hidden" name="totalFare" value="<?php echo $_POST['totalFare']; ?>">

          <!-- Payment Methods -->
          <div class="mt-3">
            <label><input type="radio" name="payment_method" value="UPI" required> UPI</label><br>
            <label><input type="radio" name="payment_method" value="Cash" required> Cash on Arrival</label>
          </div>

          <!-- Dynamic Payment Details -->
          <div id="paymentDetails" class="mt-4"></div>

          <button type="submit" class="btn btn-primary mt-4">Pay Now</button>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
const detailsDiv = document.getElementById("paymentDetails");
document.querySelectorAll("input[name='payment_method']").forEach(radio => {
  radio.addEventListener("change", function() {
    let method = this.value;
    let html = "";

    if (method === "UPI") {
      html = `<label>Enter UPI ID</label>
              <input type="text" name="upi_id" class="form-control" required>`;
    } else if (method === "Card") {
      html = `<label>Card Number</label>
              <input type="text" name="card_number" class="form-control mb-2" required>
              <label>Expiry</label>
              <input type="text" name="expiry" class="form-control mb-2" placeholder="MM/YY" required>
              <label>CVV</label>
              <input type="password" name="cvv" class="form-control" required>`;
    } else if (method === "NetBanking") {
      html = `<label>Select Bank</label>
              <select name="bank" class="form-control" required>
                <option>SBI</option>
                <option>HDFC</option>
                <option>ICICI</option>
                <option>Axis</option>
              </select>`;
    } else if (method === "Wallet") {
      html = `<label>Wallet ID</label>
              <input type="text" name="wallet_id" class="form-control" required>`;
    } else if (method === "Cash") {
      html = `<p class="text-success">You chose Cash on Arrival. Pay at the bus counter.</p>`;
    }

    detailsDiv.innerHTML = html;
  });
});
</script>

<?php include 'footer.php'; ?>
