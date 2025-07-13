<?php
include '../common/db.php';
include '../common/auth.php';
include '../common/header.php';
checkRole('admin');
?>

<style>
  body {
    background: #f4f6f9;
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
  .main-content {
    margin-left: 240px;
    padding: 2rem;
  }

  .form-card {
    background: #fff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    transition: transform 0.2s ease;
  }

  .form-card:hover {
    transform: translateY(-4px);
  }

  .btn-primary {
    background-color: #0d6efd;
    border: none;
  }

  .btn-primary:hover {
    background-color: #084298;
  }
</style>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-md-3 col-lg-2 sidebar d-none d-md-block">
      <h5 class="text-primary px-3"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</h5>
      <ul class="nav flex-column mt-4 px-3">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">📊 Dashboard</a>
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
          <a class="nav-link active" href="generate_report.php">📄 Generate Report</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="../logout.php">🚪 Logout</a>
        </li>
      </ul>
    </nav>

    <!-- Main Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
      <h3 class="text-primary mb-4"><i class="bi bi-file-earmark-text me-2"></i> Generate Leave Reports</h3>

      <div class="form-card">
        <form action="report_pdf.php" method="GET" class="row g-4">
          <div class="col-md-4">
            <label for="status" class="form-label">Leave Status</label>
            <select class="form-select" id="status" name="status">
              <option value="all">All</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
              <option value="pending">Pending</option>
            </select>
          </div>

          <div class="col-md-4">
            <label for="month" class="form-label">Month (optional)</label>
            <input type="month" class="form-control" id="month" name="month">
          </div>

          <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-printer me-2"></i> Generate PDF</button>
          </div>
        </form>
      </div>
    </main>
  </div>
</div>

<?php include '../common/footer.php'; ?>
