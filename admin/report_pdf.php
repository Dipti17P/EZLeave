<?php
require('../assets/libs/fpdf.php');
include '../common/db.php';
include '../common/auth.php';
checkRole('admin');

$status = $_GET['status'] ?? 'all';
$month  = $_GET['month'] ?? '';

$where = "1=1";

if ($status != 'all') {
    $where .= " AND l.status = '" . $conn->real_escape_string($status) . "'";
}

if (!empty($month)) {
    $where .= " AND DATE_FORMAT(l.from_date, '%Y-%m') = '" . $conn->real_escape_string($month) . "'";
}

$result = $conn->query("
    SELECT l.*, u.username 
    FROM leave_requests l 
    JOIN users u ON u.id = l.student_id
    WHERE $where
    ORDER BY l.from_date DESC
");

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Leave Report', 1, 1, 'C');

// Header
$pdf->SetFont('Arial', 'B', 10);
$headers = ['Username' => 30, 'Type' => 20, 'From' => 30, 'To' => 30, 'Status' => 25, 'Reason' => 55];

foreach ($headers as $header => $width) {
    $pdf->Cell($width, 10, $header, 1, 0, 'C');
}
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);

// Function to calculate the number of lines a string will take
function getNumLines($pdf, $text, $width) {
    return $pdf->GetStringWidth($text) > $width ? ceil($pdf->GetStringWidth($text) / $width * 0.7) : 1;
}

while ($row = $result->fetch_assoc()) {
    $username = $row['username'];
    $type = $row['type'];
    $from = $row['from_date'];
    $to = $row['to_date'];
    $status = ucfirst($row['status']);
    $reason = $row['reason'];

    // Set widths for each column
    $w_username = 30;
    $w_type     = 20;
    $w_from     = 30;
    $w_to       = 30;
    $w_status   = 25;
    $w_reason   = 55;

    // Line height for MultiCell
    $lineHeight = 5;

    // Calculate height needed for Reason
    $reason_lines = $pdf->GetStringWidth($reason) / ($w_reason - 2);
    $numLines = max(1, ceil($reason_lines));
    $rowHeight = $numLines * $lineHeight;

    // Save current position
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // Draw normal cells with manually adjusted height
    $pdf->MultiCell($w_username, $rowHeight, $username, 1, 'C');
    $pdf->SetXY($x + $w_username, $y);

    $pdf->MultiCell($w_type, $rowHeight, $type, 1, 'C');
    $pdf->SetXY($x + $w_username + $w_type, $y);

    $pdf->MultiCell($w_from, $rowHeight, $from, 1, 'C');
    $pdf->SetXY($x + $w_username + $w_type + $w_from, $y);

    $pdf->MultiCell($w_to, $rowHeight, $to, 1, 'C');
    $pdf->SetXY($x + $w_username + $w_type + $w_from + $w_to, $y);

    $pdf->MultiCell($w_status, $rowHeight, $status, 1, 'C');
    $pdf->SetXY($x + $w_username + $w_type + $w_from + $w_to + $w_status, $y);

    // Reason cell with actual wrapping
    $pdf->MultiCell($w_reason, $lineHeight, $reason, 1, 'L');

    // Move cursor to start of next row
    $pdf->SetY($y + $rowHeight);
}

$pdf->Output();
?>
