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

// Check if the product ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // Confirm before deletion
    echo "<script>
            var confirmDelete = confirm('Are you sure you want to delete this product?');
            if (confirmDelete) {
                window.location.href='delete_product_action.php?id=$product_id';
            } else {
                window.location.href='manage_inventory.php';
            }
          </script>";
} else {
    echo "<script>alert('Invalid request.'); window.location.href='manage_inventory.php';</script>";
}
?>
