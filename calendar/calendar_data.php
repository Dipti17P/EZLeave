<?php
include '../common/db.php';

// Approved leave events
$leave_result = $conn->query("SELECT lr.from_date, lr.to_date, lr.type, u.username 
                              FROM leave_requests lr 
                              JOIN users u ON lr.student_id = u.id 
                              WHERE lr.status = 'Approved'");

$events = [];

while ($row = $leave_result->fetch_assoc()) {
    $events[] = [
        'title' => $row['username'] . ' - ' . $row['type'],
        'start' => $row['from_date'],
        'end' => date('Y-m-d', strtotime($row['to_date'] . ' +1 day')),
        'color' => '#0d6efd'
    ];
}

// Exam days from academic_calendar
$exam_result = $conn->query("SELECT date, event_type FROM academic_calendar WHERE event_type = 'Exam'");

while ($row = $exam_result->fetch_assoc()) {
    $events[] = [
        'title' => '📘 Exam',
        'start' => $row['date'],
        'color' => '#dc3545'
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
?>
