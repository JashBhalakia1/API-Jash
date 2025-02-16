<?php
include('connect/connection.php');
include('UserController.php');

$database = new Connection();
$pdo = $database->pdo; // Ensure $pdo is correctly initialized

// Fetch users with role and status
$query = "SELECT id, name, email, role, status FROM users";  
$stmt = $pdo->prepare($query);
$stmt->execute();
$userData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Report</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .dashboard-container {
            width: 80%;
            margin: auto;
            text-align: center;
        }
        .dashboard-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .dashboard-footer {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="dashboard-header">👤 User Report</div>

    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userData as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo htmlspecialchars($user['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="dashboard-footer">
        <a href="report_dashboard.php">Back to Dashboard</a>
    </div>
</div>

</body>
</html>
