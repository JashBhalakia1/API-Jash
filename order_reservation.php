<?php
session_start();
require 'Connection.php';  // Include the Connection class
require 'Order.php'; // Include Order class

$database = new Connection(); // Create an instance of the connection class
$pdo = $database->getConnection(); // Retrieve the PDO connection

$order = new Order($pdo); // Pass $pdo to Order class
$inventory = $order->getInventory(); // Fetch inventory
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Reservation</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        /* Navigation Bar */
        .navbar {
            background-color: #333;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: inline-block;
            transition: 0.3s;
        }

        .navbar a:hover {
            background-color: #28a745;
        }

        .navbar .menu {
            display: flex;
        }

        .navbar .menu a {
            margin-right: 10px;
        }

        /* Dropdown Styling */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 10px 15px;
            display: block;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .container {
            width: 100%;
            max-width: 500px;
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

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            color: #555;
            text-align: left;
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

        p {
            color: red;
            font-weight: bold;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="menu">
            <a href="index.php">🏠 Home</a>
            <a href="manage_inventory.php">📦 Inventory</a>
            <a href="order_reservation.php">🛒 Order Reservation</a>
            <a href="report_dashboard.php">📊 Reports</a>
            <a href="sales.php">💰 Sales</a>
            
            <div class="dropdown">
                <a href="#">⚙️ Settings ▾</a>
                <div class="dropdown-content">
                    <a href="profile.php">👤 Profile</a>
                    <a href="logout.php">🚪 Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h2>Order Reservation</h2>

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

            <button type="submit">Reserve Order</button>
        </form>
    </div>

</body>
</html>
