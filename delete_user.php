<?php
session_start();
include('connect/connection.php'); // Ensure database connection
include('UserController.php'); // Include UserController file

$database = new connection(); // Create a connection instance
$pdo = $database->getConnection(); // Retrieve the PDO connection

$userController = new UserController($pdo);


if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    if ($userController->deleteUser($user_id)) {
        echo "<script>alert('User deleted successfully!'); window.location='manage_users.php';</script>";
    } else {
        echo "<script>alert('Failed to delete user.'); window.location='manage_users.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location='manage_users.php';</script>";
}
?>

