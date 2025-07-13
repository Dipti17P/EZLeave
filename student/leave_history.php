<?php
include '../common/db.php';
include '../common/auth.php';
include '../common/header.php';
checkRole('student');

$studentId = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM leave_requests WHERE student_id = $studentId ORDER BY created_at DESC");
?>

<!-- 🎨 Custom Styling -->
<style>
  
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

  .card-history {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
  }

  .table th, .table td {
    vertical-align: middle;
  }

  .badge {
    font-size: 0.9rem;
    padding: 6px 12px;
    border-radius: 20px;
  }
</style>

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
      <div class="card-history">
        <h4 class="fw-bold mb-3 text-primary"><i class="bi bi-clock-history me-2"></i>My Leave History</h4>

        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>Type</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Document</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= ucfirst($row['type']) ?></td>
                <td><?= $row['from_date'] ?></td>
                <td><?= $row['to_date'] ?></td>
                <td>
                  <span class="badge bg-<?= 
                    $row['status'] === 'Approved' ? 'success' : 
                    ($row['status'] === 'Rejected' ? 'danger' : 'warning') ?>">
                    <?= $row['status'] ?>
                  </span>
                </td>
                <td><?= $row['remarks'] ?: '—' ?></td>
                <td>
                  <?php if ($row['document']) : ?>
                    <a href="../uploads/<?= $row['document'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                  <?php else: ?>
                    <span class="text-muted">N/A</span>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</div>

<?php include '../common/footer.php'; ?>
