<?php
require_once 'connect/Connection.php';
require_once 'Saleslogic.php';

// Set headers for Excel file download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=sales_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Create a new database connection
$database = new Connection();
$pdo = $database->getConnection();

// Ensure PDO connection is valid
if (!$pdo) {
    die("Error: Database connection failed.");
}

// Create an instance of Sales class
$sales = new Sales($pdo);

// Fetch sales data (check if filtering is applied)
$salesData = $sales->getSales();
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $salesData = $sales->getSalesByDate($start_date, $end_date);
}

// Output data in table format for Excel
echo "<table border='1'>";
echo "<tr>
        <th>Sale ID</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Date</th>
      </tr>";

foreach ($salesData as $sale) {
    echo "<tr>
            <td>{$sale['id']}</td>
            <td>{$sale['item_name']}</td>
            <td>{$sale['quantity']}</td>
            <td>{$sale['total_price']}</td>
            <td>{$sale['sale_date']}</td>
          </tr>";
}

echo "</table>";
?>
