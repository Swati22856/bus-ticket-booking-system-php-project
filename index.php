<?php include 'db.php'; 
include 'header.php';?>

<!-- 🎨 Hero Section -->
<section class="hero d-flex align-items-center text-center text-white">
  <div class="container" data-aos="fade-up">
    <h1 class="fw-bold display-4 mb-3">Book Your Bus Ticket Easily</h1>
    <p class="lead mb-4">Fast, Secure & Comfortable Travel – Anytime, Anywhere 🚍</p>
    
    <!-- 🔎 Search Box -->
    <div class="search-box p-4 rounded-4 shadow-lg bg-white text-dark">
      <form action="search.php" method="GET" class="row g-3 align-items-center">
        <div class="col-md-4">
          <label class="form-label">From</label>
          <input type="text" name="from" class="form-control" placeholder="Enter source city" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">To</label>
          <input type="text" name="to" class="form-control" placeholder="Enter destination city" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Travel Date</label>
          <input type="date" name="date" class="form-control" required>
        </div>
        <div class="col-md-1 d-grid">
          <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-search"></i></button>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- 🌟 Features Section -->
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="mb-5 fw-bold text-dark">Why Choose ComfiGo?</h2>
    <div class="row g-4">
      <div class="col-md-4" data-aos="zoom-in">
        <div class="p-4 border rounded-4 shadow-sm h-100 bg-white">
          <i class="fas fa-bus fa-3x text-primary mb-3"></i>
          <h5 class="fw-bold text-dark">Luxury Buses</h5>
          <p class="text-secondary">Travel with comfort in our clean, modern buses.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
        <div class="p-4 border rounded-4 shadow-sm h-100 bg-white">
          <i class="fas fa-wallet fa-3x text-success mb-3"></i>
          <h5 class="fw-bold text-dark">Affordable Prices</h5>
          <p class="text-secondary">Best fares with no hidden charges.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="400">
        <div class="p-4 border rounded-4 shadow-sm h-100 bg-white">
          <i class="fas fa-lock fa-3x text-danger mb-3"></i>
          <h5 class="fw-bold text-dark">Secure Payments</h5>
          <p class="text-secondary">100% secure payment system with instant confirmation.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 🚍 Popular Routes Section -->
<section class="py-5">
  <div class="container text-center text-white">
    <h2 class="mb-5 fw-bold">Popular Routes</h2>
    <div class="row g-4">
      <div class="col-md-3" data-aos="fade-up">
        <div class="p-4 rounded-4 shadow-lg bg-dark h-100">
          <h5 class="fw-bold">Rajkot → Ahemdabad</h5>
          <p>Starting from <span class="fw-bold text-success">₹600</span></p>
          <a href="search.php?from=Rajkot&to=Ahemdabad&date=<?php echo date('Y-m-d'); ?>" class="btn btn-outline-light btn-sm">Book Now</a>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="150">
        <div class="p-4 rounded-4 shadow-lg bg-dark h-100">
          <h5 class="fw-bold">Ahemdabad → Rajkot</h5>
          <p>Starting from <span class="fw-bold text-success">₹600</span></p>
          <a href="search.php?from=Ahemdabad&to=Rajkot&date=<?php echo date('Y-m-d'); ?>" class="btn btn-outline-light btn-sm">Book Now</a>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
        <div class="p-4 rounded-4 shadow-lg bg-dark h-100">
          <h5 class="fw-bold">Rajkot → Gandhinagar</h5>
          <p>Starting from <span class="fw-bold text-success">₹800</span></p>
          <a href="search.php?from=Rajkot&to=Gandhinagar&date=<?php echo date('Y-m-d'); ?>" class="btn btn-outline-light btn-sm">Book Now</a>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="450">
        <div class="p-4 rounded-4 shadow-lg bg-dark h-100">
          <h5 class="fw-bold">Rajkot → Mumbai</h5>
          <p>Starting from <span class="fw-bold text-success">₹900</span></p>
          <a href="search.php?from=Rajkot&to=Mumbai&date=<?php echo date('Y-m-d'); ?>" class="btn btn-outline-light btn-sm">Book Now</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 📞 Footer -->
<footer class="text-center text-white py-4">
  <div class="container">
    <p>&copy; <?php echo date("Y"); ?> ComfiGo. All Rights Reserved.</p>
    <p><i class="fas fa-envelope"></i> support@comfigo.com | <i class="fas fa-phone"></i> +91 9876543210</p>
  </div>
</footer>

<!-- JS Files -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/aos.js"></script>
<script>
  AOS.init();
</script>
</body>
</html>
