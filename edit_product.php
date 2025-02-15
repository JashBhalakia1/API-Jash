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

// Get product details if ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $product = $inventoryController->getProductById($product_id);

    if (!$product) {
        die("Product not found.");
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $_POST["item_name"];
    $stock = $_POST["stock"];
    $price = $_POST["price"];

    $updateSuccess = $inventoryController->updateProduct($product_id, $item_name, $stock, $price);

    if ($updateSuccess) {
        echo "<script>alert('Product updated successfully!'); window.location='manage_inventory.php';</script>";
    } else {
        echo "<script>alert('Failed to update product. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f4f4f9;
            text-align: center;
            padding: 30px;
        }

        h2 {
            color: #333;
        }

        form {
            background: white;
            padding: 20px;
            width: 40%;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #0056b3;
        }

        .back-btn {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            padding: 10px;
            color: white;
            background: #6c757d;
            border-radius: 5px;
        }

        .back-btn:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>

    <h2>Edit Product</h2>

    <form method="POST">
        <label>Item Name:</label>
        <input type="text" name="item_name" value="<?= htmlspecialchars($product['item_name']); ?>" required>

        <label>Stock:</label>
        <input type="number" name="stock" value="<?= htmlspecialchars($product['stock']); ?>" required>

        <label>Price:</label>
        <input type="text" name="price" value="<?= htmlspecialchars($product['price']); ?>" required>

        <button type="submit">Update Product</button>
    </form>

    <a href="manage_inventory.php" class="back-btn">⬅ Back to Inventory</a>

</body>
</html>
