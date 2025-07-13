<?php
include '../common/db.php';
include '../common/functions.php';
include '../common/auth.php';
include '../common/header.php';
checkRole('admin');

// Validate and sanitize ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger m-4'>Invalid leave request ID.</div>";
    include '../common/footer.php';
    exit;
}

$id = intval($_GET['id']);
$leave = $conn->query("SELECT l.*, u.username FROM leave_requests l JOIN users u ON u.id = l.student_id WHERE l.id = $id")->fetch_assoc();

if (!$leave) {
    echo "<div class='alert alert-warning m-4'>Leave request not found.</div>";
    include '../common/footer.php';
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    $stmt = $conn->prepare("UPDATE leave_requests SET status = ?, remarks = ? WHERE id = ?");
    $stmt->bind_param("ssi", $status, $remarks, $id);
    $stmt->execute();

    // Notify student
    notifyUser($conn, $leave['student_id'], "Your leave from {$leave['from_date']} to {$leave['to_date']} has been $status.");
    header("Location: leave_requests.php");
    exit;
}
?>

<style>
  body {
    background: #f8f9fc;
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


  .card-leave {
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    padding: 2rem;
    transition: all 0.3s ease;
  }

  .card-leave:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
  }

  .card-leave h5 {
    color: #0d6efd;
    font-weight: 600;
  }

  .form-select,
  .form-control {
    border-radius: 12px;
    padding: 0.75rem 1rem;
  }

  .btn-success {
    border-radius: 12px;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
  }

  label {
    font-weight: 500;
    margin-top: 12px;
  }

  .leave-info p {
    margin-bottom: 10px;
    font-size: 1rem;
    color: #333;
  }

  .badge {
    font-size: 0.95rem;
    padding: 0.4rem 0.7rem;
  }
</style>

<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
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
          <a class="nav-link text-danger" href="../logout.php">🚪 Logout</a>
        </li>
      </ul>
    </nav>

    <!-- Main Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-4">
      <div class="card-leave">
        <h5 class="mb-4">📄 Leave Application Details</h5>

        <div class="leave-info mb-4">
          <p><strong>👤 Student:</strong> <?= htmlspecialchars($leave['username']) ?></p>
          <p><strong>📌 Type:</strong> <?= ucfirst($leave['type']) ?></p>
          <p><strong>📅 From:</strong> <?= date("d M Y", strtotime($leave['from_date'])) ?> <strong>to</strong> <?= date("d M Y", strtotime($leave['to_date'])) ?></p>
          <p><strong>📝 Reason:</strong> <?= nl2br(htmlspecialchars($leave['reason'])) ?></p>
          <p><strong>📌 Status:</strong>
            <span class="badge bg-<?= $leave['status'] === 'Approved' ? 'success' : ($leave['status'] === 'Rejected' ? 'danger' : 'warning') ?>">
              <?= $leave['status'] ?>
            </span>
          </p>
          <?php if ($leave['document']): ?>
            <p><strong>📎 Document:</strong> <a href="../uploads/<?= $leave['document'] ?>" target="_blank">View Attachment</a></p>
          <?php endif; ?>
        </div>

        <form method="POST">
          <label for="status">Update Status:</label>
          <select name="status" id="status" class="form-select" required>
            <option value="Approved" <?= $leave['status'] === 'Approved' ? 'selected' : '' ?>>✅ Approve</option>
            <option value="Rejected" <?= $leave['status'] === 'Rejected' ? 'selected' : '' ?>>❌ Reject</option>
          </select>

          <label for="remarks">Remarks (optional):</label>
          <textarea name="remarks" id="remarks" class="form-control" rows="3"><?= htmlspecialchars($leave['remarks'] ?? '') ?></textarea>

          <button class="btn btn-success mt-3">💾 Update</button>
        </form>
      </div>
    </main>

  </div>
</div>

<?php include '../common/footer.php'; ?>
