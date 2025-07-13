<?php
require('../libs/fpdf.php');
include '../common/db.php';
include '../common/auth.php';
checkRole('student');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Leave History Report', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);

$studentId = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM leave_requests WHERE student_id = $studentId");

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(50, 10, ucfirst($row['type']), 1);
    $pdf->Cell(40, 10, $row['from_date'], 1);
    $pdf->Cell(40, 10, $row['to_date'], 1);
    $pdf->Cell(60, 10, $row['status'], 1);
    $pdf->Ln();
}

$pdf->Output();
?>
