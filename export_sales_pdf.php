<?php
require_once 'connect/Connection.php';
require_once 'Saleslogic.php';
require_once 'vendor/autoload.php'; // Load TCPDF

use TCPDF;

// Initialize database connection
$database = new Connection();
$pdo = $database->getConnection();

// Fetch sales data
$sales = new Sales($pdo);
$salesData = $sales->getSales();

// Create a new PDF document
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Company');
$pdf->SetTitle('Sales Report');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// PDF Title
$pdf->Cell(0, 10, 'Sales Report', 1, 1, 'C');
$pdf->Ln(5);

// Table Headers
$html = '<table border="1" cellpadding="5">
            <tr>
                <th>Sale ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Date</th>
            </tr>';

// Add sales data to PDF
foreach ($salesData as $sale) {
    $html .= "<tr>
                <td>{$sale['id']}</td>
                <td>{$sale['item_name']}</td>
                <td>{$sale['quantity']}</td>
                <td>\${$sale['total_price']}</td>
                <td>{$sale['sale_date']}</td>
              </tr>";
}

$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$pdf->Output('sales_report.pdf', 'D'); // 'D' forces download

?>
