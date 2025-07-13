<?php
include '../common/db.php';
include '../common/auth.php';
include '../common/header.php';
checkRole('student');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $from = $_POST['from_date'];
    $to = $_POST['to_date'];
    $reason = $_POST['reason'];

    $docName = '';
    if ($_FILES['document']['name']) {
        $docName = uniqid() . "_" . basename($_FILES['document']['name']);
        move_uploaded_file($_FILES['document']['tmp_name'], "../uploads/" . $docName);
    }

    $stmt = $conn->prepare("INSERT INTO leave_requests (student_id, type, from_date, to_date, reason, document) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $_SESSION['user_id'], $type, $from, $to, $reason, $docName);
    $stmt->execute();
    $msg = "🎉 Leave Applied Successfully!";
}
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

  .card-leave-form {
    background: #ffffff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
  }

  .card-leave-form h2 {
    font-weight: bold;
    color: #0d6efd;
    margin-bottom: 20px;
  }

  label {
    font-weight: 500;
    margin-bottom: 5px;
  }

  .form-control, select, textarea {
    border-radius: 8px;
    box-shadow: none !important;
  }

  .btn-primary {
    border-radius: 20px;
    padding: 10px 30px;
    font-weight: 600;
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
      <div class="card-leave-form">
        <h2>📝 Apply for Leave</h2>

        <?php if (isset($msg)): ?>
          <div class="alert alert-success"><?= $msg ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label>Leave Type</label>
            <select name="type" class="form-control" required>
              <option value="">Select</option>
              <option value="sick">Sick Leave</option>
              <option value="casual">Casual Leave</option>
              <option value="exam">Exam Leave</option>
            </select>
          </div>

          <div class="mb-3">
            <label>From Date</label>
            <input type="date" name="from_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>To Date</label>
            <input type="date" name="to_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Reason</label>
            <textarea name="reason" class="form-control" rows="3" placeholder="Mention a valid reason..." required></textarea>
          </div>

          <div class="mb-3">
            <label>Upload Medical/Proof Document (optional)</label>
            <input type="file" name="document" class="form-control">
          </div>

          <button class="btn btn-primary mt-2"><i class="bi bi-send me-1"></i>Submit</button>
        </form>
      </div>
    </main>
  </div>
</div>

<?php include '../common/footer.php'; ?>
