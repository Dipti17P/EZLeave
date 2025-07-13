<?php
include '../common/db.php';
include '../common/auth.php';
include '../common/header.php';
checkRole('admin');

// 1️⃣ Fetch all students' leave requests
$leaveQuery = $conn->query("SELECT leave_requests.*, users.username FROM leave_requests 
JOIN users ON leave_requests.student_id = users.id");

$leaveEvents = [];
while ($row = $leaveQuery->fetch_assoc()) {
    $leaveTypeColors = [
        'sick' => '#0d6efd',
        'casual' => '#ffc107',
        'exam' => '#198754',
        'medical' => '#d63384',
        'vacation' => '#dc3545',
        'default' => '#6c757d'
    ];
    $leaveType = strtolower($row['type']);
    $color = $leaveTypeColors[$leaveType] ?? $leaveTypeColors['default'];

    $leaveEvents[] = [
        'title' => $row['username'] . ' - ' . ucfirst($row['type']),
        'start' => $row['from_date'],
        'end' => date('Y-m-d', strtotime($row['to_date'] . ' +1 day')),
        'color' => $color
    ];
}

// 2️⃣ Fetch academic calendar events
$academicQuery = $conn->query("SELECT * FROM academic_calendar");

$academicEvents = [];
while ($row = $academicQuery->fetch_assoc()) {
    $academicEvents[] = [
        'title' => $row['description'],
        'start' => $row['date'],
        'color' => ($row['event_type'] == 'Holiday') ? '#dc3545' : '#198754' // 🎨
    ];
}


$allEvents = array_merge($leaveEvents, $academicEvents);
?>

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />

<style>
  #calendar {
    background: white;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
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
          <a class="nav-link" href="user.php">👥 Manage Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="calendar.php">📅 Calendar</a>
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
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-4">
      <div class="glass-card">
        <h3 class="text-primary fw-bold mb-3"><i class="bi bi-calendar-week me-2"></i>Academic & Leave Calendar</h3>
        <div id="calendar"></div>

        <div class="mt-4">
          <h6 class="fw-semibold mb-2">Legend:</h6>
          <span class="badge bg-primary me-2">Sick Leave</span>
          <span class="badge bg-success me-2">Exam Leave</span>
          <span class="badge bg-warning text-dark me-2">Casual Leave</span>
          <span class="badge bg-danger me-2">Holiday</span>
          <span class="badge bg-secondary me-2">Other</span>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- FullCalendar Script -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const events = <?= json_encode($allEvents) ?>;

    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      height: 550,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: ''
      },
      events: events
    });

    calendar.render();
  });
</script>

<?php include '../common/footer.php'; ?>
