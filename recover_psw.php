<?php session_start() ?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <title>Login Form</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">User Password Recover</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

    </div>
</nav>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Password Recover</div>
                    <div class="card-body">
                        <form action="#" method="POST" name="recover_psw">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Recover" name="recover">
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>
</body>
</html>

<?php 
    
 
    require 'connect/connection.php'; // Include PDO connection
    
    
    require_once "Mail/phpmailer/PHPMailerAutoload.php";
    $database = new connection(); // Create a connection instance
    $pdo = $database->getConnection(); // Retrieve the PDO connection

   
    
    if(isset($_POST["recover"])) {
        $email = $_POST["email"];
    
        try {
            // Prepare and execute the query securely
            $stmt = $pdo->prepare("SELECT * FROM login WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Check if email exists
            if (!$fetch) {
                echo "<script>alert('Sorry, no email exists');</script>";
            } elseif ($fetch["status"] == 0) {
                echo "<script>
                        alert('Sorry, your account must be verified first before you can recover your password!');
                        window.location.replace('index.php');
                      </script>";
            } else {
                // Generate a secure token
                $token = bin2hex(random_bytes(50));
    
                // Store token and email in session
                $_SESSION['token'] = $token;
                $_SESSION['email'] = $email;
    
                // Send password reset email
                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 465;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'ssl';
    
                // Replace with environment variables or a config file
                $mail->Username = 'jashbhalakia17@gmail.com';
                $mail->Password = 'zmsilzvamywidztr';
    
                $mail->setFrom('jashbhalakia17@gmail.com', 'Password Reset');
                $mail->addAddress($email);
    
                $mail->isHTML(true);
                $mail->Subject = "Recover your password";
                $mail->Body = "
                    <b>Dear User,</b>
                    <h3>We received a request to reset your password.</h3>
                    <p>Kindly click the below link to reset your password:</p>
                    <a href='http://localhost/Jash-API/reset_psw.php?token=$token'>Reset Password</a>
                    <br><br>
                    <p>With regards,</p>
                    <b>Jash</b>
                ";
    
                if (!$mail->send()) {
                    echo "<script>alert('Invalid Email');</script>";
                } else {
                    echo "<script>window.location.replace('notification.html');</script>";
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    ?>
    