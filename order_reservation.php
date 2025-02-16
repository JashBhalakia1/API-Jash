<?php
session_start();
require 'Connection.php';  
require 'Order.php'; 

$database = new Connection();
$pdo = $database->getConnection();

$order = new Order($pdo);
$inventory = $order->getInventory();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Reservation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css"> <!-- ✅ External CSS -->
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
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        /* Dropdown Styling */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #343a40;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 10px 15px;
            display: block;
            transition: 0.3s;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Container */
        .container {
            width: 90%;
            max-width: 600px;
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
            background: #007bff;
            color: white;
            border: none;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #0056b3;
        }

        /* Message Styling */
        p {
            color: red;
            font-weight: bold;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                width: 95%;
            }
        }
    </style>
</head>
<body>

<!-- ✅ Navigation Bar -->
<div class="navbar">
    <div class="menu">
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="manage_inventory.php">📦 Inventory</a>
        <a href="order_reservation.php">🛒 Orders</a>
        <a href="sales.php">💰 Sales</a>
        <a href="report_dashboard.php">📊 Reports</a>
        
        <div class="dropdown">
            <a href="#">⚙️ Settings ▾</a>
            <div class="dropdown-content">
                <a href="manage_users.php">👤 Users</a>
                <a href="logout.php">🚪 Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Page Content -->
<div class="container">
    <h2 class="text-primary">Order Reservation</h2>

    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>

    <form method="POST">
        <label>Select Item:</label>
        <select name="item_id" required>
            <?php foreach ($inventory as $item): ?>
                <option value="<?= $item['id']; ?>">
                    <?= htmlspecialchars($item['item_name']); ?> (Stock: <?= htmlspecialchars($item['stock']); ?>, Price: <?= htmlspecialchars($item['price']); ?>)
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
