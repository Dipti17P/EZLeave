<?php
include '../common/db.php';
include '../common/auth.php';

$user_id = $_SESSION['user_id'];

$res = $conn->query("SELECT status, COUNT(*) as total FROM leave_requests WHERE student_id = $user_id GROUP BY status");
$data = ['Approved' => 0, 'Rejected' => 0, 'Pending' => 0];

while ($row = $res->fetch_assoc()) {
    $data[$row['status']] = (int)$row['total'];
}

header('Content-Type: application/json');
echo json_encode($data);
?>
