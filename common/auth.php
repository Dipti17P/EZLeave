<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Optional Role Check Example:
function checkRole($expectedRole) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $expectedRole) {
        header("Location: ../login.php");
        exit();
    }
}
?>
