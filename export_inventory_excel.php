<?php
require_once 'connect/Connection.php';

// Set headers to force download as an Excel file
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=inventory_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Create a new database connection
$database = new Connection();
$pdo = $database->getConnection();

// Fetch inventory from database
$query = "SELECT item_name, stock, price FROM inventory";
$stmt = $pdo->prepare($query);
$stmt->execute();
$inventoryData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output table format for Excel
echo "<table border='1'>";
echo "<tr>
        <th>Item Name</th>
        <th>Stock</th>
        <th>Price</th>
      </tr>";

foreach ($inventoryData as $item) {
    echo "<tr>
            <td>{$item['item_name']}</td>
            <td>{$item['stock']}</td>
            <td>{$item['price']}</td>
          </tr>";
}
echo "</table>";
?>
