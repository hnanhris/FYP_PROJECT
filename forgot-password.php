<?php
session_start();
include('server/connection.php');

if(isset($_SESSION['logged_in'])){
    header('location: account.php');
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if(isset($_POST['reset_password'])){
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if(empty($email)){
        header('location: forgot-password.php?error=Please enter your email');
        exit;
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows() == 1){
        // Generate reset token
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Store token in database
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->bind_param('sss', $token, $expires, $email);
        $stmt->execute();

        // Send reset email
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Update with your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com'; // Update with your email
            $mail->Password = 'your-app-password'; // Update with your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('your-email@gmail.com', 'Zyza Ismail Boutique');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "
                <h2>Password Reset Request</h2>
                <p>Click the link below to reset your password. This link will expire in 1 hour.</p>
                <p><a href='http://localhost/ZYZA/reset-password.php?token={$token}'>Reset Password</a></p>
                <p>If you didn't request this, please ignore this email.</p>
            ";

            $mail->send();
            header('location: forgot-password.php?success=Reset link has been sent to your email');
            exit;
        } catch (Exception $e) {
            header('location: forgot-password.php?error=Could not send reset email. Please try again later.');
            exit;
        }
    } else {
        header('location: forgot-password.php?error=No account found with that email');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Zyza Ismail Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="my-5 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h2 class="text-center mb-4">Forgot Password</h2>

                <?php if(isset($_GET['error'])){ ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php } ?>

                <?php if(isset($_GET['success'])){ ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo htmlspecialchars($_GET['success']); ?>
                    </div>
                <?php } ?>

                <form method="POST" action="forgot-password.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="form-text">We'll send you a link to reset your password.</div>
                    </div>
                    <button type="submit" name="reset_password" class="btn btn-dark w-100">Reset Password</button>
                    <p class="text-center mt-3">
                        Remember your password? <a href="login.php">Login here</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
