<?php
// Include the database connection file
require_once 'connect/Connection.php';  
// Include the InventoryController to fetch products
require_once 'InventoryController.php'; 

// Create a new database connection instance
$database = new Connection();
$pdo = $database->getConnection();

// Check if the connection is successful
if (!$pdo) {
    die("Error: Database connection failed.");
}

// Create an instance of InventoryController to interact with the database
$inventoryController = new InventoryController($pdo);
// Retrieve all products from the inventory
$products = $inventoryController->getAllProducts();

// Arrays to store product details
$itemNames = [];
$stocks = [];
$prices = [];

// Loop through the products and extract relevant data
foreach ($products as $product) {
    $itemNames[] = $product['item_name']; // Store product names
    $stocks[] = $product['stock'];       // Store stock levels
    $prices[] = $product['price'];       // Store product prices
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Charts</title>
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
    <h2>Stock Levels</h2>
    <div class="chart-container">
        <canvas id="stockChart"></canvas>
    </div>
    <h2>Price Distribution</h2>
    <div class="chart-container">
        <canvas id="priceChart"></canvas>
    </div>
    <br>
    <!-- Button to go back to inventory management page -->
    <a href="manage_inventory.php" class="back-button">Back to Inventory</a>
    <script>
        // Create bar chart for stock levels
        var ctx1 = document.getElementById('stockChart').getContext('2d');
        var stockChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?= json_encode($itemNames); ?>, // Product names as labels
                datasets: [{
                    label: 'Stock Levels',
                    data: <?= json_encode($stocks); ?>, // Stock levels data
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
        
        // Create pie chart for price distribution
        var ctx2 = document.getElementById('priceChart').getContext('2d');
        var priceChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: <?= json_encode($itemNames); ?>, // Product names as labels
                datasets: [{
                    data: <?= json_encode($prices); ?>, // Product prices data
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
