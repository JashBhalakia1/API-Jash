<?php
require_once 'connect/Connection.php';
require_once 'Saleslogic.php';

// Create a new database connection
$database = new Connection();
$pdo = $database->getConnection();

// Ensure PDO connection is valid
if (!$pdo) {
    die("Error: Database connection failed.");
}

// Create an instance of Sales class
$sales = new Sales($pdo);

// Fetch sales data
$salesData = $sales->getSales();

// Handle date filtering
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $salesData = $sales->getSalesByDate($start_date, $end_date);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <style>
        /* General Page Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        /* Navigation Bar */
        .navbar {
            background-color: #343a40;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            margin: 0 5px;
            border-radius: 5px;
            transition: background 0.3s, transform 0.2s;
        }

        .navbar a:hover {
            background-color: #007bff;
            transform: scale(1.1);
        }

        /* Container */
        .container {
            width: 90%;
            max-width: 900px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 50px auto;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        /* Form Styling */
        form {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        input[type="date"], button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #218838;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background: #007bff;
            color: white;
            font-size: 16px;
        }

        td {
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            color: #333;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background: #f1f1f1;
        }

        /* Export Buttons */
        .export-btns {
            margin-top: 20px;
        }

        .export-btn {
            padding: 10px 15px;
            margin: 5px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 16px;
            transition: 0.3s;
        }

        .pdf-btn {
            background: #dc3545;
        }

        .pdf-btn:hover {
            background: #c82333;
        }

        .excel-btn {
            background: #28a745;
        }

        .excel-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="menu">
            <a href="index.php">🏠 Home</a>
            <a href="inventory.php">📦 Inventory</a>
            <a href="order_reservation.php">🛒 Orders</a>
            <a href="sales.php">💰 Sales</a>
            <a href="sales_report.php">📊 Sales Report</a>
        </div>
    </div>

    <div class="container">
        <h2>Sales Report</h2>

        <!-- Date Filter Form -->
        <form method="POST">
            <input type="date" name="start_date" required>
            <input type="date" name="end_date" required>
            <button type="submit">Filter</button>
        </form>

        <table>
            <tr>
                <th>Sale ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Date</th>
            </tr>
            <?php foreach ($salesData as $sale): ?>
                <tr>
                    <td><?= $sale['id']; ?></td>
                    <td><?= $sale['item_name']; ?></td>
                    <td><?= $sale['quantity']; ?></td>
                    <td>$<?= number_format($sale['total_price'], 2); ?></td>
                    <td><?= $sale['sale_date']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Export Buttons -->
        <div class="export-btns">
            <a href="export_sales_pdf.php" class="export-btn pdf-btn">📄 Export as PDF</a>
            <a href="export_sales_excel.php" class="export-btn excel-btn">📊 Export as Excel</a>
        </div>
    </div>

</body>
</html>
