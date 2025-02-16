<?php
include('connect/connection.php');
include('UserController.php');

$database = new Connection();
$pdo = $database->pdo; 

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        /* Navigation Bar */
        .navbar {
            background-color: #007bff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .navbar .logo {
            font-size: 20px;
            font-weight: bold;
        }

        .navbar .menu {
            display: flex;
        }

        .navbar .menu a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            transition: 0.3s;
        }

        .navbar .menu a:hover {
            background-color: #0056b3;
            border-radius: 5px;
        }

        .dashboard-container {
            width: 80%;
            margin: auto;
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .dashboard-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
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

        .dashboard-footer {
            margin-top: 20px;
        }

        .dashboard-footer a {
            text-decoration: none;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            transition: 0.3s;
        }

        .dashboard-footer a:hover {
            background-color: #0056b3;
        }
        .export-btn {
    background-color: #28a745;
    margin-left: 10px;
}
.export-btn:hover {
    background-color: #218838;
}

    </style>
</head>
<body>

<!-- ✅ Navigation Bar -->
<div class="navbar">
    <div class="logo">📊 User Report</div>
    <div class="menu">
        <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

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
    <a href="report_dashboard.php">⬅ Back to Reports</a>
    <a href="export_user_report.php" class="export-btn">📄 Export as PDF</a>
    <a href="export_users_excel.php" class="export-btn excel-btn">📊 Export as Excel</a>
</div>

</body>
</html>
