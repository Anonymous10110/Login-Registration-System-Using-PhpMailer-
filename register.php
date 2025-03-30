<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $verification_code = rand(100000, 999999);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, verification_code) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $email, $password, $verification_code])) {
        $subject = "Email Verification";
        $body = "Your verification code is: $verification_code";
        sendEmail($email, $subject, $body);
        header("Location: verify.php?email=$email");
        exit();
    } else {
        $error = "Error registering user.";
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
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Social Media Profile Links -->
    <link rel="me" href="https://github.com/Anonymous10110">
    <link rel="me" href="https://instagram.com/donren17">
</head>
<body class="container mt-5">
    <h2>Register</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"> <?php echo $error; ?> </div>
    <?php endif; ?>
    <form action="register.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</body>
</html>
