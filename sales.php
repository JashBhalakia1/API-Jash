<?php
session_start();
require 'connect/Connection.php';  // Include the Connection class
require 'Saleslogic.php'; // Include Sales class

$database = new Connection(); // Create an instance of the connection class
$pdo = $database->getConnection(); // Retrieve the PDO connection

$sales = new Sales($pdo); // Pass $pdo to Sales class
$inventory = $sales->getInventory(); // Fetch inventory

// Handle Sales Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST["item_id"];
    $quantity = $_POST["quantity"];

    $result = $sales->addSale($item_id, $quantity);
    $message = $result ? "✅ Sale recorded successfully!" : "❌ Error processing sale.";
}

// Fetch Sales Data
$salesData = $sales->getSales();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Management</title>

    <style>
        /* General Styles */
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
            background-color: #28a745;
            transform: scale(1.1);
        }

        /* Container Styling */
        .container {
            width: 90%;
            max-width: 800px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 50px auto;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            color: #555;
        }

        select, input[type="number"], button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            margin-top: 20px;
            background: #28a745;
            color: white;
            border: none;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #218838;
        }

        /* Notification Messages */
        p {
            color: red;
            font-weight: bold;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #28a745;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Mobile Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                text-align: center;
            }
            
            .navbar a {
                padding: 10px;
                display: block;
                margin-bottom: 5px;
            }
            
            .container {
                width: 95%;
            }
            
            table, th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="menu">
            <a href="dashboard.php">🏠 Home</a>
            <a href="manage_inventory.php">📦 Inventory</a>
            <a href="order_reservation.php">🛒 Orders</a>
            <a href="sales.php">💰 Sales</a>
            <a href="report_dashboard.php">📊 Reports</a>
        </div>
    </div>

    <div class="container">
        <h2>Sales Management</h2>

        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>

        <form method="POST">
            <label>Select Item:</label>
            <select name="item_id" required>
                <?php foreach ($inventory as $item): ?>
                    <option value="<?= $item['id']; ?>">
                        <?= $item['item_name']; ?> (Stock: <?= $item['stock']; ?>, Price: <?= $item['price']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Quantity:</label>
            <input type="number" name="quantity" min="1" required>

            <button type="submit">Record Sale</button>
        </form>

        <h2>Recent Sales</h2>
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
    </div>

            </body>
</html>
