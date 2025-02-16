<?php
require_once 'connect/Connection.php';  // Ensure this file exists
require_once 'InventoryController.php'; // Ensure this file exists

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Create a new database connection
    $database = new Connection();
    $pdo = $database->getConnection();

    // Ensure PDO connection is valid
    if (!$pdo) {
        die("Error: Database connection failed.");
    }

    // Create an instance of InventoryController
    $inventoryController = new InventoryController($pdo);

    // Delete product
    if ($inventoryController->deleteProduct($id)) {
        header("Location: manage_inventory.php?message=Product Deleted Successfully");
        exit();
    } else {
        echo "Error deleting product.";
    }
} else {
    echo "Invalid product ID.";
}
?>
