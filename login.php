<?php
session_start();
$dsn = "mysql:host=localhost;dbname=loginsystem";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// ✅ User Login Function
function loginUser($pdo, $email, $password) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password_hash"])) {
        return $user;
    }
    return false;
}

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!empty($email) && !empty($password)) {
        $user = loginUser($pdo, $email, $password);
        
        if ($user) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"] = $user["role"];

            if ($user["role"] === "admin") {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();
        } else {
            $errorMessage = "Invalid email or password.";
        }
    } else {
        $errorMessage = "Please enter both email and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | User Management</title>
    <style>
        /* General page styling */
        body {
            background: linear-gradient(to right, #4a90e2, #50b5c9);
            font-family: 'Arial', sans-serif;
            color: #fff;
            text-align: center;
        }

        /* Center login box */
        .login-container {
            width: 100%;
            max-width: 400px;
            margin: 80px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            color: #333;
        }

        /* Headings */
        h2 {
            font-weight: bold;
            color: #4a90e2;
        }

        /* Form fields */
        .form-group label {
            font-weight: bold;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            height: 45px;
        }

        /* Submit button */
        .btn-primary {
            background: #4a90e2;
            border: none;
            padding: 12px;
            font-size: 16px;
            color: #fff;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background: #357ABD;
        }

        /* Forgot password */
        .text-center a {
            color: #4a90e2;
            font-weight: bold;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        /* Error message */
        .alert {
            background-color: #ff4d4d;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>User Login</h2>
    
    <?php if (!empty($errorMessage)): ?>
        <div class="alert"><?= $errorMessage; ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required class="form-control" placeholder="Enter your email">
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required class="form-control" placeholder="Enter your password">
        </div>
        <button type="submit" class="btn-primary">Login</button>
    </form>

    <div class="text-center mt-3">
        <a href="forgot_password.php">Forgot Password?</a>
    </div>
</div>

</body>
</html>
