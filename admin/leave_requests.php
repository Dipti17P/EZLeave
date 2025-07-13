<?php
include '../common/db.php';
include '../common/auth.php';
include '../common/header.php';
checkRole('admin');

$requests = $conn->query("SELECT l.*, u.username FROM leave_requests l JOIN users u ON l.student_id = u.id ORDER BY created_at DESC");
?>

<style>
  body {
    background: #f7faff;
  }

  .page-wrapper {
    display: flex;
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
    flex: 1;
    padding: 2rem 3rem;
  }

  .card-glass {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 6px 24px rgba(0,0,0,0.05);
    transition: 0.3s ease;
  }

  .card-glass:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.08);
  }

  .table thead th {
    position: sticky;
    top: 0;
    background: #f1f3f5;
    z-index: 1;
  }

  .table tbody tr:hover {
    background: #f8f9fa;
  }

  .avatar-circle {
    width: 36px;
    height: 36px;
    background-color: #0d6efd;
    color: #fff;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-right: 8px;
  }
</style>

<div class="page-wrapper">

  <!-- Sidebar -->
<nav class="col-md-3 col-lg-2 sidebar d-none d-md-block">
      <h5 class="text-primary px-3"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</h5>
      <ul class="nav flex-column mt-4 px-3">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">📊 Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="leave_requests.php">📝 Leave Requests</a>
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

  <!-- Main content -->
  <div class="main-content">
    <div class="card-glass">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary">📋 All Leave Applications</h4>
      </div>

      <div class="table-responsive">
        <table class="table align-middle table-bordered">
          <thead class="table-light">
            <tr>
              <th>Student</th>
              <th>Type</th>
              <th>From</th>
              <th>To</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php while ($row = $requests->fetch_assoc()): ?>
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar-circle"><?= strtoupper(substr($row['username'], 0, 1)) ?></div>
                  <?= htmlspecialchars($row['username']) ?>
                </div>
              </td>
              <td><span class="badge bg-info text-dark"><?= ucfirst($row['type']) ?></span></td>
              <td><?= date("d M Y", strtotime($row['from_date'])) ?></td>
              <td><?= date("d M Y", strtotime($row['to_date'])) ?></td>
              <td>
                <span class="badge bg-<?= 
                  $row['status'] === 'Approved' ? 'success' : 
                  ($row['status'] === 'Rejected' ? 'danger' : 'warning') ?>">
                  <?= $row['status'] ?>
                </span>
              </td>
              <td>
                <a href="view_leave.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">👁 View</a>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<?php include '../common/footer.php'; ?>
