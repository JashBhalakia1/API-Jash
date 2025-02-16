<?php
// Include necessary files for database connection and inventory management
require_once 'connect/Connection.php';  
require_once 'InventoryController.php'; 

// Create a new database connection
$database = new Connection();
$pdo = $database->getConnection();

// Check if the database connection is successful
if (!$pdo) {
    die("Error: Database connection failed.");
}

// Create an instance of InventoryController to fetch inventory data
$inventoryController = new InventoryController($pdo);
$products = $inventoryController->getAllProducts();

// Prepare arrays for chart data
$itemNames = [];
$stocks = [];
$prices = [];

// Loop through products and extract relevant data
foreach ($products as $product) {
    $itemNames[] = $product['item_name'];
    $stocks[] = $product['stock'];
    $prices[] = $product['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory</title>
    <!-- Include Chart.js library for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* General body styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        /* Container styling */
        .container {
            width: 85%; /* Slightly reduced width */
            max-width: 1000px; /* Adjusted max width */
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        /* Heading styling */
        h1 {
            color: #222;
            font-size: 20px;
            margin-bottom: 12px;
            font-weight: bold;
        }
        h2 {
            color: #333;
            font-size: 18px;
            margin-top: 15px;
            font-weight: bold;
        }
        /* Chart canvas styling */
        canvas {
            max-width: 85%; /* Reduced size */
            height: 300px; /* Adjusted height */
            margin: 15px auto;
            display: block;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            background: #f9f9f9;
            padding: 10px;
        }
        /* Back button styling */
        .back-button {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 15px;
            font-size: 14px;
            color: white;
            background: #ff4757;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        .back-button:hover {
            background: #e84118;
        }
    </style>
</head>
<body>
    <div class="container">
       
        <!-- Stock Levels Bar Chart -->
        <h2>Stock Levels</h2>
        <canvas id="stockChart"></canvas>

        <!-- Price Distribution Pie Chart -->
        <h2>Price Distribution</h2>
        <canvas id="priceChart"></canvas>

        <!-- Back button linking to inventory management page -->
        <a href="manage_inventory.php" class="back-button">⬅ Back to Inventory</a>
    </div>

    <script>
        // Generate Stock Levels Bar Chart
        var ctx1 = document.getElementById('stockChart').getContext('2d');
        var stockChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?= json_encode($itemNames); ?>,
                datasets: [{
                    label: 'Stock Levels',
                    data: <?= json_encode($stocks); ?>,
                    //backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    //borderColor: 'rgba(54, 162, 235, 1)',
                    //borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Generate Price Distribution Pie Chart
        var ctx2 = document.getElementById('priceChart').getContext('2d');
        var priceChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: <?= json_encode($itemNames); ?>,
                datasets: [{
                    data: <?= json_encode($prices); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ]
                }]
            }
        });
    </script>
</body>
</html>
