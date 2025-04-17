<?php
session_start();
include('server/connection.php');

if(isset($_SESSION['logged_in'])){
    header('location: account.php');
    exit;
}

if(!isset($_GET['token'])){
    header('location: login.php');
    exit;
}

$token = $_GET['token'];
$current_time = date('Y-m-d H:i:s');

// Verify token and check if it's expired
$stmt = $conn->prepare("SELECT user_id FROM users WHERE reset_token = ? AND reset_expires > ? LIMIT 1");
$stmt->bind_param('ss', $token, $current_time);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows() == 0){
    header('location: forgot-password.php?error=Invalid or expired reset link');
    exit;
}

if(isset($_POST['update_password'])){
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if(strlen($password) < 8){
        header('location: reset-password.php?token=' . $token . '&error=Password must be at least 8 characters long');
        exit;
    }

    if($password !== $confirmPassword){
        header('location: reset-password.php?token=' . $token . '&error=Passwords do not match');
        exit;
    }

    // Update password and clear reset token
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE reset_token = ?");
    $stmt->bind_param('ss', $hashed_password, $token);

    if($stmt->execute()){
        header('location: login.php?success=Password has been reset successfully');
        exit;
    } else {
        header('location: reset-password.php?token=' . $token . '&error=Could not update password');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Zyza Ismail Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="my-5 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h2 class="text-center mb-4">Reset Password</h2>

                <?php if(isset($_GET['error'])){ ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php } ?>

                <form method="POST" action="reset-password.php?token=<?php echo htmlspecialchars($token); ?>">
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               required minlength="8" 
                               title="Must contain at least 8 characters">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                    <button type="submit" name="update_password" class="btn btn-dark w-100">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
