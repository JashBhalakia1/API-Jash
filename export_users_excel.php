<?php
require_once 'connect/Connection.php';

// Set headers to force download as an Excel file
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=users_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Create a new database connection
$database = new Connection();
$pdo = $database->getConnection();

// Fetch users from database
$query = "SELECT id, name, email, role, status FROM users";
$stmt = $pdo->prepare($query);
$stmt->execute();
$usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output table format for Excel
echo "<table border='1'>";
echo "<tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Status</th>
      </tr>";

foreach ($usersData as $user) {
    echo "<tr>
            <td>{$user['id']}</td>
            <td>{$user['name']}</td>
            <td>{$user['email']}</td>
            <td>{$user['role']}</td>
            <td>{$user['status']}</td>
          </tr>";
}
echo "</table>";
?>
