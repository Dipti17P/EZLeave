<?php
include '../common/db.php';

$res = $conn->query("SELECT u.dept, COUNT(*) as total 
                     FROM leave_requests lr 
                     JOIN users u ON lr.student_id = u.id 
                     GROUP BY u.dept");

$data = [];

while ($row = $res->fetch_assoc()) {
    $data[] = [
        'label' => $row['dept'],
        'value' => (int)$row['total']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>
