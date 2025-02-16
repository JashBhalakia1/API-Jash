<?php
include('connect/connection.php');
include('UserController.php');

// Create a connection instance and retrieve the PDO connection
$database = new Connection();
$pdo = $database->getConnection();

// Instantiate the UserController
$userController = new UserController($pdo);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['Role'];  // ✅ Capital "R" matches form
    $status = $_POST['Status'];  // ✅ Capital "S" matches form

    // Update user details
    $userController->updateUser($id, $name, $email, $role, $status);

    // Redirect to the manage users page after updating
    header("Location: manage_users.php");
    exit();
}

// Fetch the user details by ID
$user = $userController->getUserById($_GET['id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Edit User</h2>
    <form method="POST">
        <!-- Hidden field for user ID -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

        <!-- Name Field -->
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required class="form-control">
        </div>

        <!-- Email Field -->
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="form-control">
        </div>

        <!-- Role Dropdown -->
        <div class="form-group">
            <label>Role:</label>
            <select name="Role" class="form-control" required>
                <option value="Admin" <?php echo ($user['Role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="User" <?php echo ($user['Role'] == 'User') ? 'selected' : ''; ?>>User</option>
            </select>
        </div>

        <!-- Status Dropdown -->
        <div class="form-group">
            <label>Status:</label>
            <select name="Status" class="form-control" required>
                <option value="Active" <?php echo ($user['Status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                <option value="Inactive" <?php echo ($user['Status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>
