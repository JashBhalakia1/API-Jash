


<?php
session_start();
include('connect/connection.php'); // Ensure this returns $pdo
include('UserController.php'); 

$database = new Connection();
$pdo = $database->getConnection();

//  Pass $pdo to UserController
$userController = new UserController($pdo);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $role = trim($_POST["role"]);
    $status = trim($_POST["status"]);
    $password = trim($_POST["password"]);
   

    if (!empty($name) && !empty($email) && !empty($password) && !empty($role)) {
        if ($userController->createUser($name, $email, $role, $status, $password)) {
            $message = "<div class='alert alert-success'>User added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error adding user!</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Please fill in all fields!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Navigation Bar */
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
            font-weight: bold;
        }
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        /* Page Container */
        .container {
            margin-top: 50px;
            max-width: 600px;
        }

        /* Card Style */
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Button Styling */
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<!-- ✅ Navigation Bar -->
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="manage_users.php">Manage Users</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="card p-4">
        <h2 class="text-center text-primary">Add User</h2>

        <!-- Display Messages -->
        <?= $message; ?>

        <form method="POST">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" required class="form-control" placeholder="Enter full name">
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required class="form-control" placeholder="Enter email address">
            </div>
            <div class="form-group">
                <label>Role:</label>
                <select name="role" class="form-control">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label>status:</label>
                <select name="status" class="form-control">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required class="form-control" placeholder="Enter password">
            </div>
            
            <button type="submit" class="btn btn-primary">Create User</button>
        </form>
    </div>
</div>

</body>
</html>
