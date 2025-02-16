<?php
session_start();
require_once 'connect/Connection.php';  
require 'UserController.php'; 

$database = new Connection();
$pdo = $database->getConnection();

if (!$pdo) {
    die("Error: Database connection failed.");
}

$userController = new UserController($pdo);
$users = $userController->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css"> <!-- ✅ External CSS -->
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

        /* Page Container */
        .container {
            width: 90%;
            max-width: 1000px;
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

        /* Buttons */
        .btn {
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            transition: 0.3s;
        }

        .btn-primary {
            background: #007bff;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #fff;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
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
        <a href="report_dashboard.php">📊 Report</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
</div>

<!-- ✅ Page Content -->
<div class="container">
    <h2 class="text-primary">Manage Users</h2>
    <a href="add_user.php" class="btn btn-primary mb-3">➕ Add User</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>  
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['Role']) ?></td> 
                    <td><?= htmlspecialchars($user['Status']) ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">✏ Edit</a>
                        <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">🗑 Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
