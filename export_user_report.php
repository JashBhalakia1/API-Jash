<?php
require_once 'connect/connection.php';
require_once __DIR__ . '/vendor/autoload.php'; // Load TCPDF

// Initialize database connection
$database = new Connection();
$pdo = $database->pdo;

// Fetch users with role and status
$query = "SELECT id, name, email, role, status FROM users";
$stmt = $pdo->prepare($query);
$stmt->execute();
$userData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Clean output buffer before sending PDF
ob_start();

// Create a new PDF document
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Company');
$pdf->SetTitle('User Report');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// PDF Title
$pdf->Cell(0, 10, 'User Report', 1, 1, 'C');
$pdf->Ln(5);

// Table Headers
$html = '<table border="1" cellpadding="5">
            <tr>
                <th><b>User ID</b></th>
                <th><b>Name</b></th>
                <th><b>Email</b></th>
                <th><b>Role</b></th>
                <th><b>Status</b></th>
            </tr>';

// Add user data to PDF
foreach ($userData as $user) {
    $html .= "<tr>
                <td>{$user['id']}</td>
                <td>{$user['name']}</td>
                <td>{$user['email']}</td>
                <td>{$user['role']}</td>
                <td>{$user['status']}</td>
              </tr>";
}

$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');

// Clear output buffer and output PDF
ob_end_clean();
$pdf->Output('user_report.pdf', 'D'); // 'D' forces download
?>
