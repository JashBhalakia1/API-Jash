<?php
require 'connect/Connection.php';
require 'Saleslogic.php';

$database = new Connection();
$pdo = $database->getConnection();
$sales = new Sales($pdo);
$salesData = $sales->getSales();

// Prepare data for Chart.js ensuring no duplicate labels
$labels = [];
$salesAmounts = [];
$quantities = [];
$uniqueSales = [];

foreach ($salesData as $sale) {
    if (!isset($uniqueSales[$sale['item_name']])) {
        $labels[] = $sale['item_name'];
        $salesAmounts[] = $sale['total_price'];
        $quantities[] = $sale['quantity'];
        $uniqueSales[$sale['item_name']] = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Charts</title>
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
            width: 45%;
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
    <a href="sales.php" class="back-button">Back to Sales</a>
    <script>
        var ctx1 = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Total Sales ($)',
                    data: <?= json_encode($salesAmounts) ?>,
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
                        beginAtZero: true
                    }
                }
            }
        });
        
        var ctx2 = document.getElementById('quantityChart').getContext('2d');
        var quantityChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Quantity Sold',
                    data: <?= json_encode($quantities) ?>,
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
