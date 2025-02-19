<?php
require_once 'connect/Connection.php';  
require_once 'InventoryController.php'; 

// Create a new database connection
$database = new Connection();
$pdo = $database->getConnection();

// Ensure PDO connection is valid
if (!$pdo) {
    die("Error: Database connection failed.");
}

// Create an instance of InventoryController
$inventoryController = new InventoryController($pdo);

// Fetch all inventory products
$products = $inventoryController->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory</title>
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

        /* Header */
        h1 {
            color: #333;
            font-size: 28px;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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

        /* Action Buttons */
        .action-btn {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
            text-decoration: none;
            color: white;
            transition: 0.3s;
        }

        .edit-btn {
            background: #ffc107;
        }

        .edit-btn:hover {
            background: #e0a800;
        }

        .delete-btn {
            background: #dc3545;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        /* Mobile Responsive */
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
           <!-- <a href="order_reservation.php">🛒 Orders</a>-->
            <a href="sales.php">💰 Sales</a>
            <a href="report_dashboard.php">📊 Reports</a>
            <a href="inventory_analytics.php">📊 Analytics</a>
        </div>
        
    </div>

    <div class="container">
        <h1>Inventory Management</h1>

        <!-- Navigation Buttons -->
        <div style="margin-bottom: 20px;">
            <a href="add_product.php" class="action-btn" style="background: #28a745; padding: 10px 15px;">+ Add New Product</a>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Item Name</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['id']); ?></td>
                    <td><?= htmlspecialchars($product['item_name']); ?></td>
                    <td><?= htmlspecialchars($product['stock']); ?></td>
                    <td>$<?= htmlspecialchars($product['price']); ?></td>
                    <td>
                        <a href="edit_product.php?id=<?= $product['id']; ?>" class="action-btn edit-btn">✏ Edit</a>
                        <a href="delete_product.php?id=<?= $product['id']; ?>" class="action-btn delete-btn">🗑 Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</body>
</html>
