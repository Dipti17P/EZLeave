<?php
include '../common/db.php';
include '../common/auth.php';
include '../common/header.php';
?>

<style>
  body {
    background: linear-gradient(to right, #f8f9fa, #e3f2fd);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .calendar-container {
    max-width: 1000px;
    margin: 2rem auto;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    padding: 2rem;
  }

  .calendar-container h4 {
    font-weight: 700;
    color: #0d6efd;
    margin-bottom: 1.5rem;
    text-align: center;
  }

  #calendar {
    border-radius: 10px;
    overflow: hidden;
  }
</style>

<div class="calendar-container">
  <h4>📅 Leave Calendar</h4>
  <div id="calendar"></div>
</div>

<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
    initialView: 'dayGridMonth',
    height: 'auto',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,listWeek'
    },
    events: 'calendar_data.php',
    eventDisplay: 'block',
    eventColor: '#0d6efd',
    eventTextColor: '#fff',
    nowIndicator: true,
    dayMaxEventRows: true,
    showNonCurrentDates: false
  });
  calendar.render();
});
</script>

<?php include '../common/footer.php'; ?>
