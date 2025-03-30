<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $reset_code = rand(100000, 999999);

    $stmt = $pdo->prepare("INSERT INTO password_resets (email, reset_code) VALUES (?, ?) ON DUPLICATE KEY UPDATE reset_code = ?");
    if ($stmt->execute([$email, $reset_code, $reset_code])) {
        $subject = "Password Reset";
        $body = "Your password reset code is: $reset_code";
        sendEmail($email, $subject, $body);
        echo "Check your email for the reset code.";
        header("Location: reset_password.php?email=$email");
        exit();
    } else {
        echo "Error sending reset code.";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Rendon T. Torente">
    <meta name="description" content="Secure Login & Registration System Using PHPMailer">
    <meta name="keywords" content="Login, Registration, PHPMailer, Secure Authentication">
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Social Media Profile Links -->
    <link rel="me" href="https://github.com/Anonymous10110">
    <link rel="me" href="https://instagram.com/donren17">
</head>
<body class="container mt-5">
    <h2>Forgot Password</h2>
    <form action="forgot_password.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <button type="submit" class="btn btn-warning">Send Reset Code</button>
    </form>
</body>
</html>
