<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            text-align: center;
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

        /* Welcome Section */
        .container {
            width: 80%;
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            font-size: 18px;
            color: #555;
        }

        /* Quick Links */
        .quick-links {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
        }

        .quick-links a {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .quick-links a:hover {
            background-color: #45a049;
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
        
    </div>

    <!-- Welcome Section -->
    <div class="container">
        <h1>Welcome to Inventory Management System</h1>
        <p>Manage your inventory with ease using our simple and efficient system.</p>

        <!-- Quick Access Links -->
        <div class="quick-links">
            <a href="index1.php">📦 Login</a>
            <a href="register.php">➕ admin register</a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; <?php echo date("Y"); ?> Inventory System | <a href="index.php">Home</a>
    </footer>

</body>
</html>
