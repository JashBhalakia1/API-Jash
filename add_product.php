<?php
require_once 'connect/Connection.php';
require_once 'InventoryController.php';

// Create a new database connection
$database = new Connection();
$pdo = $database->getConnection();

// Create an instance of InventoryController
$inventoryController = new InventoryController($pdo);

// Check if the form is submitted
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $_POST['item_name'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];

    // Add product to the inventory
    if ($inventoryController->addProduct($item_name, $stock, $price)) {
        $message = "<p class='success'>Product added successfully!</p>";
    } else {
        $message = "<p class='error'>Error adding product.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        /* Navigation Bar */
        .navbar {
            background-color: #333;
            overflow: hidden;
            display: flex;
            justify-content: center;
            padding: 15px 0;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            font-size: 16px;
            transition: 0.3s;
        }

        .navbar a:hover {
            background-color: #575757;
            border-radius: 5px;
        }

        /* Page Container */
        .container {
            width: 100%;
            max-width: 500px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        label {
            margin-bottom: 8px;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        select,
        input[type="number"] {
            padding: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Messages */
        .success {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #888;
            background-color: #222;
            position: fixed;
            bottom: 0;
            width: 100%;
            color: white;
        }

        footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="index.php">🏠 Home</a>
        <a href="manage_inventory.php">📦 Manage Inventory</a>
        <a href="add_product.php">➕ Add Product</a>
        <a href="edit_product.php">✏ Edit Product</a>
        <a href="delete_product.php">🗑 Delete Product</a>
    </div>

    <!-- Page Content -->
    <div class="container">
        <h1>Add New Product</h1>
        <p>Fill in the form below to add a new product to your inventory.</p>

        <!-- Display success/error message -->
        <?php echo $message; ?>

        <!-- Add Product Form -->
        <form action="add_product.php" method="POST">
            <label for="item_name">Product Name</label>
            <select id="item_name" name="item_name" required>
                <option value="" disabled selected>Select a product</option>
                <option value="iPhone 10">iPhone 10</option>
                <option value="Redmi 5">Redmi 5</option>
                <option value="Oppo 7">Oppo 7</option>
                <option value="Vivo 7">Vivo 7</option>
                <option value="Samsung S24">Samsung S24</option>
            </select>
            
            <label for="stock">Stock Quantity</label>
            <input type="number" id="stock" name="stock" placeholder="Enter product stock" required>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" placeholder="Enter product price" required step="0.01">

            <input type="submit" value="Add Product">
        </form>
    </div>

    <!-- Footer -->
    <footer>
        &copy; <?php echo date("Y"); ?> Inventory System | <a href="index.php">Home</a>
    </footer>

</body>
</html>
