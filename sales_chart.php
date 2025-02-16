<?php
// Include the database connection file
require 'connect/Connection.php';
// Include the Sales logic file to fetch sales data
require 'Saleslogic.php';

// Create a new database connection instance
$database = new Connection();
$pdo = $database->getConnection();

// Create an instance of Sales class to interact with the database
$sales = new Sales($pdo);
// Retrieve sales data from the database
$salesData = $sales->getSales();

// Prepare data for Chart.js ensuring no duplicate labels
$labels = [];
$salesAmounts = [];
$quantities = [];
$uniqueSales = [];

// Loop through sales data to extract unique product names and corresponding sales details
foreach ($salesData as $sale) {
    if (!isset($uniqueSales[$sale['item_name']])) {
        $labels[] = $sale['item_name']; // Store product names as labels
        $salesAmounts[] = $sale['total_price']; // Store total sales amounts
        $quantities[] = $sale['quantity']; // Store quantity sold
        $uniqueSales[$sale['item_name']] = true; // Mark product as processed
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Charts</title>
    <!-- Include Chart.js for generating charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f8ff;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        .chart-container {
            width: 45%; /* Set chart container width */
            display: inline-block;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            vertical-align: top;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }
        .back-button:hover {
            background: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <h2>Sales Graph</h2>
    <div class="chart-container">
        <canvas id="salesChart"></canvas>
    </div>
    <h2>Sales Chart</h2>
    <div class="chart-container">
        <canvas id="quantityChart"></canvas>
    </div>
    <br>
    <!-- Button to navigate back to the sales page -->
    <a href="sales.php" class="back-button">Back to Sales</a>
    <script>
        // Create bar chart for total sales amount
        var ctx1 = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>, // Product names as labels
                datasets: [{
                    label: 'Total Sales ($)',
                    data: <?= json_encode($salesAmounts) ?>, // Sales amounts data
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true // Ensure Y-axis starts from zero
                    }
                }
            }
        });
        
        // Create pie chart for quantity of products sold
        var ctx2 = document.getElementById('quantityChart').getContext('2d');
        var quantityChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: <?= json_encode($labels) ?>, // Product names as labels
                datasets: [{
                    label: 'Quantity Sold',
                    data: <?= json_encode($quantities) ?>, // Quantity data
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>
