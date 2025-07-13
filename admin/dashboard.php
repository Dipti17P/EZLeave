<?php
include '../common/db.php';
include '../common/auth.php';
include '../common/header.php';
checkRole('admin');

$total = $conn->query("SELECT COUNT(*) as total FROM leave_requests")->fetch_assoc()['total'];
$byType = $conn->query("SELECT type, COUNT(*) as count FROM leave_requests GROUP BY type");
$byDept = $conn->query("SELECT dept, COUNT(*) as count FROM users u JOIN leave_requests l ON u.id = l.student_id GROUP BY dept");
?>

<!-- 🌟 Admin Dashboard Style -->
<style>
  body {
    background: linear-gradient(to right, #f8f9fa, #e3f2fd);
  }

  .sidebar {
    height: 100vh;
    position: sticky;
    top: 0;
    background-color: #fff;
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

  .chart-card {
    background: #fff;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: 0.3s ease;
  }

  .chart-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
  }
</style>

<!-- 🧭 Sidebar -->
<div class="container-fluid">
  <div class="row">
    <nav class="col-md-3 col-lg-2 sidebar d-none d-md-block">
      <h5 class="text-primary px-3"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</h5>
      <ul class="nav flex-column mt-4 px-3">
        <li class="nav-item">
          <a class="nav-link active" href="dashboard.php">📊 Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="leave_requests.php">📝 Leave Requests</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="user.php">👥 Manage Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="calendar.php">📅 Calendar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="generate_report.php">📄 Generate Report</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="../logout.php">🚪 Logout</a>
        </li>
      </ul>
    </nav>

    <!-- 📊 Main Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-4">
      <h2 class="mb-2 fw-bold">👋 Welcome, Admin!</h2>
      <p class="text-muted">Here’s an overview of leave applications</p>

      <div class="row g-4 mt-2">
        <div class="col-md-4">
          <div class="card bg-primary-subtle text-primary text-center p-4 shadow-sm">
            <div class="card-body">
              <h5>Total Requests</h5>
              <h3><?= $total ?></h3>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-4 mt-2">
        <div class="col-md-6">
          <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="fw-bold">📈 Leave Types</h6>
              <i class="bi bi-pie-chart-fill text-primary fs-4"></i>
            </div>
            <canvas id="leaveTypeChart" height="250"></canvas>
          </div>
        </div>
        <div class="col-md-6">
          <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="fw-bold">🏫 Requests by Department</h6>
              <i class="bi bi-bar-chart-fill text-success fs-4"></i>
            </div>
            <canvas id="deptChart" height="250"></canvas>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- 📊 Charts Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const typeChart = document.getElementById('leaveTypeChart');
const deptChart = document.getElementById('deptChart');

new Chart(typeChart, {
  type: 'doughnut',
  data: {
    labels: [<?php mysqli_data_seek($byType, 0); while($row = $byType->fetch_assoc()) echo "'{$row['type']}',"; ?>],
    datasets: [{
      data: [<?php mysqli_data_seek($byType, 0); while($row = $byType->fetch_assoc()) echo "{$row['count']},"; ?>],
      backgroundColor: ['#0d6efd', '#198754', '#dc3545', '#ffc107', '#6c757d']
    }]
  },
  options: {
    plugins: { legend: { position: 'bottom' } }
  }
});

new Chart(deptChart, {
  type: 'bar',
  data: {
    labels: [<?php while($row = $byDept->fetch_assoc()) echo "'{$row['dept']}',"; ?>],
    datasets: [{
      label: 'Applications',
      data: [<?php mysqli_data_seek($byDept, 0); while($row = $byDept->fetch_assoc()) echo "{$row['count']},"; ?>],
      backgroundColor: '#6610f2',
      borderRadius: 8
    }]
  },
  options: {
    scales: {
      y: { beginAtZero: true }
    },
    plugins: {
      legend: { display: false }
    }
  }
});
</script>

<?php include '../common/footer.php'; ?>
