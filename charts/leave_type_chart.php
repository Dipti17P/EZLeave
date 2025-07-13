<?php
include '../common/db.php';

$data = [];

$res = $conn->query("SELECT type, COUNT(*) as total FROM leave_requests GROUP BY type ORDER BY total DESC");

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $data[] = [
            'label' => ucfirst($row['type']),
            'value' => (int)$row['total']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($data);
?>
