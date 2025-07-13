<?php
session_start();
//include 'config/constants.php';
include 'common/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo APP_NAME ?> – Student Leave Management System</title>

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #e0f7fa, #ffffff);
      color: #333;
    }

    /* .hero {
      background: linear-gradient(120deg, #0d6efd, #6610f2);
      color: white;
      padding: 100px 20px;
      text-align: center;
    } */

    .hero {
      background: url('assets/images/bg.jpg') center center/cover no-repeat;
      color: white;
      padding: 120px 20px;
      text-align: center;
    }

    .hero h1 {
      font-size: 3.5rem;
      font-weight: bold;
      animation: fadeInDown 1s ease;
    }

    .hero p {
      font-size: 1.3rem;
      margin-top: 10px;
      animation: fadeInUp 1s ease;
    }

    .hero .btn {
      margin-top: 30px;
      padding: 12px 30px;
      font-size: 1.1rem;
      animation: zoomIn 1s ease;
    }

    .features i {
      font-size: 2.5rem;
      color: #0d6efd;
      margin-bottom: 10px;
    }

    .features h5 {
      font-weight: bold;
    }

    footer {
      background: #0d6efd;
      color: white;
      text-align: center;
      padding: 15px 0;
      margin-top: 60px;
    }

footer ul li a {
  transition: all 0.3s ease;
  display: inline-block; 
}

footer ul li a:hover {
  color: #0d6efd;
  text-decoration: underline;
  transform: scale(1.1);
}



.col-md-4.mb-4 p {
  transition: color 0.3s ease, transform 0.3s ease;
  cursor: pointer;
}

.col-md-4.mb-4 p:hover {
  color: #0d6efd;
  transform: translateX(5px);
}


.col-md-4.mb-4 a i {
  transition: color 0.3s ease, transform 0.3s ease;
  font-size: 1.2rem;
}

.col-md-4.mb-4 a:hover i {
  color: #0d6efd;
  transform: scale(1.2);
}


    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes zoomIn {
      from { opacity: 0; transform: scale(0.8); }
      to   { opacity: 1; transform: scale(1); }
    }
  </style>
</head>

<body>

<!-- HERO -->
<section class="hero py-5" style=" min-height: 100vh;">
  <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center text-center text-white">
      <div class="col-md-8">
        <h1 class="display-4 fw-bold">EZLeave</h1>
        <p class="lead mt-3">Smart leave management system for students & staff</p>
        <a href="login.php" class="btn btn-light text-primary mt-4 px-4 py-2">Login Now</a>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="container py-5 features">
  <div class="text-center mb-5">
    <h2 class="fw-bold">Why <?php echo APP_NAME; ?>?</h2>
    <p class="text-muted">Your one-stop solution for leave tracking, reporting, and approval</p>
  </div>
  <div class="row text-center">
    <div class="col-md-4 mb-4">
      <i class="bi bi-shield-lock"></i>
      <h5>Secure Access</h5>
      <p>Role-based logins ensure access control for students, faculty, and admins.</p>
    </div>
    <div class="col-md-4 mb-4">
      <i class="bi bi-journal-check"></i>
      <h5>Easy Leave Application</h5>
      <p>Apply for leaves online, upload documents, and track approvals instantly.</p>
    </div>
    <div class="col-md-4 mb-4">
      <i class="bi bi-bar-chart-line-fill"></i>
      <h5>Insights & Reports</h5>
      <p>Dashboards with pie/bar charts and calendar for better visibility & planning.</p>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="text-center py-5 bg-light">
  <h3 class="fw-bold mb-3">Ready to simplify student leave management?</h3>
  <a href="register.php" class="btn btn-primary btn-lg">Get Started</a>
</section>

<!-- FOOTER -->
<footer class="text-white pt-5 pb-3" style="background-color:rgba(0, 0, 0, 0.73);">
  <div class="container">
    <div class="row text-center text-md-start">
      <!-- About -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold"><?php echo APP_NAME; ?></h5>
        <p><?php echo APP_NAME; ?> is a student leave management system that simplifies applying, tracking, and approving leaves. Built with care, crafted for convenience.</p>
      </div>

      <!-- Quick Links -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="index.php" class="text-white text-decoration-none">🏠 Home</a></li>
          <li><a href="login.php" class="text-white text-decoration-none">🔐 Login</a></li>
          <li><a href="register.php" class="text-white text-decoration-none">📝 Register</a></li>
          <li><a href="calendar/calendar.php" class="text-white text-decoration-none">📅 Calendar</a></li>
          <li><a href="charts/leave_type_chart.php" class="text-white text-decoration-none">📊 Charts</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Contact Us</h5>
        <p><i class="bi bi-envelope-fill me-2"></i>EZleave@support.com</p>
        <p><i class="bi bi-telephone-fill me-2"></i> +91 12345 67890</p>
        <p><i class="bi bi-geo-alt-fill me-2"></i>SVKM's Institute of Technology, Dhule, Maharashtra</p>
        <div>
          <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
          <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-white"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div>

    <hr class="bg-white" />
    <div class="text-center">
      <p class="mb-0">&copy; <?php echo date("Y"); ?> <strong><?php echo APP_NAME; ?></strong> | Designed & Developed by Dipti | Pooja | Manasi💙</p>
    </div>
  </div>
</footer>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
