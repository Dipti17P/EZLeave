<?php
  define('APP_NAME', 'EZLeave');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo APP_NAME; ?></title>

  <!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />

<!-- FullCalendar JS - missing! -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>


  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    .navbar {
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease-in-out;
    }
    .navbar:hover {
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
    }
    .navbar-brand img {
      height: 70px;
      width: auto;
    }
    .nav-link {
      font-weight: 600;
      color: #333 !important;
      padding: 10px 15px;
      border-radius: 6px;
      transition: background 0.3s, color 0.3s;
    }
    .nav-link:hover, .nav-link.active {
      background-color: #f0f4ff;
      color: #0d6efd !important;
    }

    /* Modern Buttons */
    .btn-login, .btn-register {
      padding: 8px 20px;
      border-radius: 25px;
      font-weight: 600;
      border: none;
      transition: all 0.3s ease-in-out;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .btn-login {
      background: linear-gradient(90deg, #0d6efd, #3f8efc);
      color: white;
    }
    .btn-login:hover {
      background: linear-gradient(90deg, #5a32a3, #8a5bd8);
      transform: translateY(-2px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }
    .btn-register {
      background: linear-gradient(90deg, #0d6efd, #3f8efc);
      color: white;
      margin-left: 10px;
    }
    .btn-register:hover {
      background: linear-gradient(90deg, #5a32a3, #8a5bd8);
      transform: translateY(-2px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .dropdown-menu {
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }
    .dropdown-item {
      font-weight: 500;
    }
    .dropdown-item:hover {
      background-color: #f0f4ff;
      color: #0d6efd;
    }
  </style>
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="../index.php">
      <img src="/EZLeave/assets/images/logo.png" alt="EZLeave Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">

        <!-- Auth Buttons -->
        <?php if (!isset($_SESSION['user_id'])): ?>
          <li class="nav-item ms-3">
            <a href="login.php" class="btn btn-login">Login</a>
          </li>
          <li class="nav-item ms-2">
            <a href="register.php" class="btn btn-register">Register</a>
          </li>
        <?php else: ?>
          <!-- Role-based User Dropdown -->
          <li class="nav-item dropdown ms-3">
            <a class="nav-link dropdown-toggle text-primary fw-semibold d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle me-2 fs-5"></i>
              <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-2">
              <?php if ($_SESSION['role'] === 'student'): ?>
                <li><a class="dropdown-item" href="../student/dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Student Dashboard</a></li>
                <li><a class="dropdown-item" href="../student/leave_history.php"><i class="bi bi-clock-history me-2"></i>Leave History</a></li>
              <?php elseif ($_SESSION['role'] === 'admin'): ?>
                <li><a class="dropdown-item" href="../admin/dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</a></li>
              <?php endif; ?>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
          </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
