<?php
// Start the session to manage user sessions
session_start();

// Include the database connection and UserController class
require_once 'connect/Connection.php';  
require 'UserController.php'; 

// Create a new database connection instance
$database = new Connection();
$pdo = $database->getConnection();

// Check if the database connection was successful
if (!$pdo) {
    die("Error: Database connection failed.");
}

// Create a new instance of UserController and fetch all users
$userController = new UserController($pdo);
$users = $userController->getAllUsers();

// Initialize arrays to store counts for roles and statuses
$roleCounts = [];
$statusCounts = [];

// Loop through each user to count roles and statuses
foreach ($users as $user) {
    $role = $user['Role'];
    $status = $user['Status'];

    // Increment count for each role
    $roleCounts[$role] = ($roleCounts[$role] ?? 0) + 1;

    // Increment count for each status
    $statusCounts[$status] = ($statusCounts[$status] ?? 0) + 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Charts</title>

    <!-- Include Chart.js library for rendering charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Page styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f8ff; /* Light blue background */
            text-align: center;
            margin: 0;
            padding: 20px;
        }

        /* Styling for chart containers */
        .chart-container {
            width: 60%;
            max-width: 400px;
            margin: 20px auto;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Adds a soft shadow */
        }

        /* Heading styles */
        h2 {
            color: #333;
        }

        /* Manage Users button styling */
        .manage-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background: #007bff; /* Blue button */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        /* Hover effect for button */
        .manage-btn:hover {
            background: #0056b3;
            transform: scale(1.05); /* Slightly enlarges button */
        }
    </style>
</head>
<body>

    <!-- Chart for User Role Distribution -->
    <h2>User Role Distribution</h2>
    <div class="chart-container">
        <canvas id="roleChart"></canvas>
    </div>

    <!-- Chart for User Status Distribution -->
    <h2>User Status Distribution</h2>
    <div class="chart-container">
        <canvas id="statusChart"></canvas>
    </div>

    <!-- Manage Users Button -->
    <a href="manage_users.php" class="manage-btn">Manage Users</a>

    <script>
        // Role Distribution Chart (Bar Chart)
        var roleCtx = document.getElementById('roleChart').getContext('2d');
        var roleChart = new Chart(roleCtx, {
            type: 'bar', // Bar chart
            data: {
                labels: <?= json_encode(array_keys($roleCounts)); ?>, // Roles as labels
                datasets: [{
                    label: 'Users by Role',
                    data: <?= json_encode(array_values($roleCounts)); ?>, // Role counts
                    backgroundColor: 'rgba(54, 162, 235, 0.7)', // Blue color
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true } // Ensures y-axis starts from zero
                }
            }
        });

        // Status Distribution Chart (Pie Chart)
        var statusCtx = document.getElementById('statusChart').getContext('2d');
        var statusChart = new Chart(statusCtx, {
            type: 'pie', // Pie chart
            data: {
                labels: <?= json_encode(array_keys($statusCounts)); ?>, // Statuses as labels
                datasets: [{
                    data: <?= json_encode(array_values($statusCounts)); ?>, // Status counts
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)', // Red
                        'rgba(54, 162, 235, 0.7)', // Blue
                        'rgba(255, 206, 86, 0.7)'  // Yellow
                    ]
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
