<?php
include '../common/db.php';
include '../common/auth.php';
include '../common/header.php';
checkRole('student');

$studentId = $_SESSION['user_id'];

$sql = "SELECT 
    COUNT(*) as total,
    SUM(status = 'Approved') as approved,
    SUM(status = 'Rejected') as rejected 
    FROM leave_requests WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentId);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();
?>

<!-- 🌟 Custom Dashboard Style -->
<style>
  body {
    background: linear-gradient(to right, #e3f2fd, #f8f9fa);
  }

  .sidebar {
    height: 100vh;
    position: sticky;
    top: 0;
    background-color: #ffffff;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
    padding-top: 2rem;
  }

  .sidebar .nav-link {
    font-weight: 500;
    padding: 12px 20px;
    color: #333;
    border-radius: 8px;
    transition: background 0.3s ease;
  }

  .sidebar .nav-link:hover, .sidebar .nav-link.active {
    background-color: #0d6efd;
    color: #fff !important;
  }

  .card {
    border: none;
    border-radius: 12px;
    transition: transform 0.2s ease;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  }

  iframe {
    border: none;
    width: 100%;
    height: 400px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    background: white;
  }
</style>

<!-- 📊 Dashboard Layout -->
<div class="container-fluid">
  <div class="row">
    
    <!-- Sidebar -->
<nav class="col-md-3 col-lg-2 sidebar d-none d-md-block">
  <h5 class="text-primary px-3"><i class="bi bi-speedometer2 me-2"></i>Student Panel</h5>
  <ul class="nav flex-column mt-4 px-3">
    <li class="nav-item">
      <a class="nav-link active" href="dashboard.php">📊 Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="apply_leave.php">📝 Apply Leave</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="leave_history.php">📝 Leave History</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="calendar.php">📅 Calendar</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-danger" href="../logout.php">🚪 Logout</a>
    </li>
  </ul>
</nav>


    <!-- Main Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-4">
      <h2 class="mb-2 fw-bold">👋 Hello, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
      <p class="text-muted">Here’s a summary of your leave applications</p>

      <div class="row g-4 mt-4">
        <div class="col-md-4">
          <div class="card bg-primary-subtle text-primary text-center p-4 shadow-sm">
            <div class="card-body">
              <h5>Total Applications</h5>
              <h3><?= $stats['total'] ?? 0 ?></h3>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card bg-success-subtle text-success text-center p-4 shadow-sm">
            <div class="card-body">
              <h5>Approved</h5>
              <h3><?= $stats['approved'] ?? 0 ?></h3>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card bg-danger-subtle text-danger text-center p-4 shadow-sm">
            <div class="card-body">
              <h5>Rejected</h5>
              <h3><?= $stats['rejected'] ?? 0 ?></h3>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</div>

<?php include '../common/footer.php'; ?>
