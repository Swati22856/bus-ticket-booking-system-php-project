<?php include 'header.php'; ?>

<style>
/* Background */
.about-hero {
  background: linear-gradient(135deg, #4a00e066, #8e2de266), 
              url('images/bus-bg.jpg') center/cover no-repeat;
  color: white;
  padding: 120px 0;
  text-align: center;
  animation: fadeIn 1.5s ease-in-out;
  border-bottom-left-radius: 80px;
  border-bottom-right-radius: 80px;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-40px); }
  to { opacity: 1; transform: translateY(0); }
}

.section-title {
  font-size: 38px;
  font-weight: 700;
  color: #4a00e0;
}

.feature-card {
  background: white;
  border-radius: 18px;
  padding: 25px;
  box-shadow: 0px 10px 25px rgba(0,0,0,0.1);
  transition: 0.4s;
  text-align: center;
}

.feature-card:hover {
  transform: translateY(-10px);
  box-shadow: 0px 20px 40px rgba(0,0,0,0.2);
}

.feature-card i {
  font-size: 45px;
  background: linear-gradient(135deg, #4a00e0, #8e2de2);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 10px;
}

.feature-card h5 ,
.feature-card p{
  color: #8e2de2;
}

.about-section {
  padding: 60px 0;
}

.timeline {
  position: relative;
  padding-left: 40px;
}

.timeline::before {
  content: "";
  width: 4px;
  background: #8e2de2;
  height: 100%;
  position: absolute;
  left: 15px;
  top: 0;
  border-radius: 6px;
}

.timeline-item {
  margin-bottom: 40px;
  position: relative;
    padding-left: 40px; 
}

.timeline-item::before {
  content: "";
  width: 18px;
  height: 18px;
  background: #4a00e0;
  position: absolute;
  left: -3px;
  top: 5px;
  border-radius: 50%;
  border: 3px solid white;
}

.team-card {
  background: white;
  border-radius: 18px;
  padding: 20px;
  text-align: center;
  transition: 0.4s;
  box-shadow: 0px 10px 25px rgba(0,0,0,0.1);
}

.team-card h5{
  color: #000;
}
.about-section h2{
  color:#fff;
} 

.team-card img {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  margin-bottom: 10px;
  border: 3px solid #8e2de2;
}

.team-card:hover {
  transform: translateY(-8px);
}
</style>


<!-- HERO SECTION -->
<section class="about-hero">
  <h1 class="fw-bold display-4">About ComfiGo</h1>
  <p class="lead mt-3">Your trusted partner for comfortable, reliable and easy bus travel.</p>
</section>


<!-- OUR MISSION -->
<section class="about-section container">
  <div class="text-center mb-5">
    <h2 class="section-title">Our Mission</h2>
    <p class="text-muted mt-2">Making travel simple, fast, and comfortable for everyone.</p>
  </div>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="feature-card">
        <i class="fas fa-bus"></i>
        <h5>Comfortable Travel</h5>
        <p>We ensure every ride is smooth, secure and comfortable with top-class bus services.</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="feature-card">
        <i class="fas fa-bolt"></i>
        <h5>Faster Bookings</h5>
        <p>ComfiGo makes booking faster with seamless one-click seat selection and confirmation.</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="feature-card">
        <i class="fas fa-shield-alt"></i>
        <h5>Safe & Secure</h5>
        <p>Your data and journey are protected with advanced security and verified buses.</p>
      </div>
    </div>
  </div>
</section>


<!-- TIMELINE SECTION -->
<section class="about-section bg-light">
  <div class="container">
    <h2 class="section-title text-center mb-5">Our Journey</h2>
    <div class="timeline">

      <div class="timeline-item">
        <h5 class="fw-bold"> 2023 – Idea</h5>
        <p class="text-muted">ComfiGo was born with the goal of simplifying bus travel experience.</p>
      </div>

      <div class="timeline-item">
        <h5 class="fw-bold"> 2024 – Development</h5>
        <p class="text-muted">We built a modern, user-friendly and secure booking platform.</p>
      </div>

      <div class="timeline-item">
        <h5 class="fw-bold"> 2025 – Launch</h5>
        <p class="text-muted">ComfiGo officially launched, offering seamless bus bookings across multiple cities.</p>
      </div>

    </div>
  </div>
</section>


<!-- TEAM SECTION -->
<section class="about-section container">
  <h2 class="section-title text-center mb-5">Meet Our Team</h2>

  <div class="row g-4 justify-content-center">

    <div class="col-md-4 col-lg-3">
      <div class="team-card">
        <img src="images/profile1.jpg" alt="">
        <h5 class="fw-bold">John Doe</h5>
        <p class="text-muted small">Founder & Developer</p>
      </div>
    </div>

    <div class="col-md-4 col-lg-3">
      <div class="team-card">
        <img src="images/profile2.jpg" alt="">
        <h5 class="fw-bold">Alice Roy</h5>
        <p class="text-muted small">Backend Engineer</p>
      </div>
    </div>

    <div class="col-md-4 col-lg-3">
      <div class="team-card">
        <img src="images/profile3.jpg" alt="">
        <h5 class="fw-bold">Charlie </h5>
        <p class="text-muted small">UI/UX Designer</p>
      </div>
    </div>

  </div>
</section>


<?php include 'footer.php'; ?>
