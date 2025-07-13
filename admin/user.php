<?php
include '../common/db.php';
include '../common/auth.php';
include '../common/header.php';
checkRole('admin');

// Add new user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $dept = $_POST['dept'] ?? null;

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, dept) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $password, $role, $dept);
    $stmt->execute();

    // Refresh to avoid resubmission
    header("Location: user.php");
    exit;
}

// Fetch all users
$users = $conn->query("SELECT * FROM users");
?>

<style>
  .card-users {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    padding: 2rem;
    transition: 0.3s ease;
  }

  .card-users h4 {
    color: #0d6efd;
    font-weight: 600;
    margin-bottom: 1.5rem;
  }

  .form-control, .form-select {
    border-radius: 10px;
  }

  .btn-success {
    border-radius: 10px;
    padding: 0.5rem 1.5rem;
  }

  .table thead th {
    background: #f1f3f5;
    position: sticky;
    top: 0;
    z-index: 1;
  }

  .table tbody tr:hover {
    background: #f8f9fa;
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
          <a class="nav-link active" href="user.php">👥 Manage Users</a>
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

    <!-- Main Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-4">
      <div class="card-users">
        <h4>👥 Manage Users</h4>

        <form method="POST" class="row g-3 mb-4">
          <div class="col-md-3">
            <input type="text" name="username" class="form-control" placeholder="Name" required>
          </div>
          <div class="col-md-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="col-md-2">
            <select name="role" class="form-select" required>
              <option value="student">Student</option>
              <option value="admin">LG / CC</option>
            </select>
          </div>
          <div class="col-md-2">
            <input type="text" name="dept" class="form-control" placeholder="Department">
          </div>
          <div class="col-md-2">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>
          <div class="col-md-12">
            <button class="btn btn-primary">➕ Add User</button>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>👤 Name</th>
                <th>📧 Email</th>
                <th>🎓 Role</th>
                <th>🏢 Department</th>
              </tr>
            </thead>
            <tbody>
              <?php while($user = $users->fetch_assoc()): ?>
              <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                  <span class="badge bg-<?= 
                    $user['role'] === 'admin' ? 'primary' : 
                    ($user['role'] === 'faculty' ? 'info text-dark' : 'secondary') ?>">
                    <?= ucfirst($user['role']) ?>
                  </span>
                </td>
                <td><?= htmlspecialchars($user['dept']) ?></td>
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
