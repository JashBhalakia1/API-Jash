<?php
include('connect/connection.php');
include('UserController.php');


$database = new connection(); // Create a connection instance
$pdo = $database->getConnection(); // Retrieve the PDO connection


$userController = new UserController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userController->updateUser($_POST['id'], $_POST['name'], $_POST['email'], $_POST['role']);
    header("Location: manage_users.php");
    exit();
}

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
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>
