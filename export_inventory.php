<?php
require_once 'connect/connection.php';
require_once __DIR__ . '/vendor/autoload.php'; // Load TCPDF

// Initialize database connection
$database = new Connection();
$pdo = $database->getConnection();

// Fetch inventory data
$query = "SELECT item_name, stock, price FROM inventory";
$stmt = $pdo->prepare($query);
$stmt->execute();
$inventoryData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Clean output buffer before sending PDF
ob_start();

// Create a new PDF document
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Company');
$pdf->SetTitle('Inventory Report');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// PDF Title
$pdf->Cell(0, 10, 'Inventory Report', 1, 1, 'C');
$pdf->Ln(5);

// Table Headers
$html = '<table border="1" cellpadding="5">
            <tr>
                <th><b>Item Name</b></th>
                <th><b>Stock</b></th>
                <th><b>Price</b></th>
            </tr>';

// Add inventory data to PDF
foreach ($inventoryData as $item) {
    $html .= "<tr>
                <td>{$item['item_name']}</td>
                <td>{$item['stock']}</td>
                <td>\${$item['price']}</td>
              </tr>";
}

$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');

// Clear output buffer and output PDF
ob_end_clean();
$pdf->Output('inventory_report.pdf', 'D'); // 'D' forces download
?>
