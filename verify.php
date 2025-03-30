<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $verification_code = $_POST['verification_code'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND verification_code = ?");
    $stmt->execute([$email, $verification_code]);
    $user = $stmt->fetch();

    if ($user) {
        $update_stmt = $pdo->prepare("UPDATE users SET is_verified = 1 WHERE email = ?");
        $update_stmt->execute([$email]);
        $_SESSION['success'] = "Email verification successful! You can now log in.";
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid verification code.";
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
    <title>Verify account</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Social Media Profile Links -->
    <link rel="me" href="https://github.com/Anonymous10110">
    <link rel="me" href="https://instagram.com/donren17">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Verify Your Account</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"> <?php echo $error; ?> </div>
        <?php endif; ?>
        <form action="verify.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="verification_code" class="form-label">Verification Code</label>
                <input type="text" class="form-control" id="verification_code" name="verification_code" required>
            </div>
            <button type="submit" class="btn btn-success">Verify</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
