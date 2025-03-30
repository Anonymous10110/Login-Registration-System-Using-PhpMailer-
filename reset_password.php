
<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $reset_code = $_POST['reset_code'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE email = ? AND reset_code = ?");
    $stmt->execute([$email, $reset_code]);
    $reset_request = $stmt->fetch();

    if ($reset_request) {
        $update_stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update_stmt->execute([$new_password, $email]);
        
        $delete_stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
        $delete_stmt->execute([$email]);
        
        echo "Password reset successful. You can now log in.";
        header("Location: index.php?email=$email");
    exit();
    } else {
        echo "Invalid reset code.";
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Rendon T. Torente">
    <meta name="description" content="Secure Login & Registration System Using PHPMailer">
    <meta name="keywords" content="Login, Registration, PHPMailer, Secure Authentication">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Social Media Profile Links -->
    <link rel="me" href="https://github.com/Anonymous10110">
    <link rel="me" href="https://instagram.com/donren17">
</head>
<body class="container mt-5">
    <h2>Reset Password</h2>
    <form action="reset_password.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Reset Code</label>
            <input type="text" class="form-control" name="reset_code" required>
        </div>
        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" class="form-control" name="new_password" required>
        </div>
        <button type="submit" class="btn btn-success">Reset Password</button>
    </form>
</body>
</html>