<?php
include('connect/connection.php');

// Create a new database connection
$database = new Connection();
$pdo = $database->getConnection();

$query = "SELECT * FROM inventory";  // Adjust this query based on your database structure
$stmt = $pdo->prepare($query);
$stmt->execute();
$inventoryData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="dashboard-container">
    <div class="dashboard-header">📦 Inventory Report</div>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Stock</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventoryData as $item): ?>
                <tr>
                    <td><?php echo $item['item_name']; ?></td>
                    <td><?php echo $item['stock']; ?></td>
                    <td><?php echo $item['price']; ?></td>
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
