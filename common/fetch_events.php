<?php
include 'db.php';

$result = $conn->query("SELECT lr.from_date, lr.to_date, lr.type, u.username 
                        FROM leave_requests lr 
                        JOIN users u ON lr.student_id = u.id 
                        WHERE lr.status = 'Approved'");

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['username'] . ' - ' . $row['type'],
        'start' => $row['from_date'],
        'end'   => date('Y-m-d', strtotime($row['to_date'] . ' +1 day'))
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
?>
