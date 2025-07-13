<?php
// Format date from DB to readable
function formatDate($date) {
    return date("d M Y", strtotime($date));
}

// Leave type to readable label
function leaveTypeLabel($type) {
    $types = [
        'sick' => 'Sick Leave',
        'casual' => 'Casual Leave',
        'exam' => 'Exam Leave',
    ];
    return $types[$type] ?? $type;
}

// Send system notification (insert into notifications table)
function notifyUser($conn, $userId, $msg) {
    $stmt = $conn->prepare("INSERT INTO notifications (user_id, message, is_read, created_at) VALUES (?, ?, 0, NOW())");
    $stmt->bind_param("is", $userId, $msg);
    $stmt->execute();
}
?>
