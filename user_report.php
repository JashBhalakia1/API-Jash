<?php
include('connect/connection.php');
 include('UserController.php');

$database = new Connection();
$pdo = $database->pdo; // Use PDO instead of mysqli

$query = "SELECT * FROM users";  // Adjust this query based on your database structure
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
</head>
<body>

<div class="dashboard-container">
    <div class="dashboard-header">👤 User Report</div>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userData as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    
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