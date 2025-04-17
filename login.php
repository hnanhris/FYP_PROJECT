<?php
include('server/connection.php');
session_start();

if(isset($_SESSION['logged_in'])){
    header('location: account.php');
    exit;
}

if(isset($_POST['login_btn'])){
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if(empty($email) || empty($password)){
        header('location: login.php?error=Please fill in all fields');
        exit;
    }

    $stmt = $conn->prepare("SELECT user_id, username, email, password, role FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);

    if($stmt->execute()){
        $stmt->bind_result($user_id, $username, $user_email, $hashed_password, $role);
        $stmt->store_result();

        if($stmt->num_rows() == 1){
            $stmt->fetch();

            if(password_verify($password, $hashed_password)){
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $user_email;
                $_SESSION['role'] = $role;
                $_SESSION['logged_in'] = true;

                // Redirect based on role
                if($role === 'admin'){
                    header('location: admin/dashboard.php');
                } else {
                    header('location: account.php?login_success=Logged in successfully');
                }
                exit;
            } else {
                header('location: login.php?error=Invalid email or password');
                exit;
            }
        } else {
            header('location: login.php?error=Invalid email or password');
            exit;
        }
    } else {
        header('location: login.php?error=Something went wrong');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Zyza Ismail Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="auth-container">
    <div class="auth-box">
        <div class="nav-tabs">
            <a href="login.php" class="active">Sign In</a>
            <a href="register.php">Create Account</a>
        </div>

        <?php if(isset($_GET['error'])){ ?>
            <div class="alert alert-danger text-center">
                <?php echo $_GET['error']; ?>
            </div>
        <?php } ?>

        <?php if(isset($_GET['message'])){ ?>
            <div class="alert alert-info text-center">
                <?php echo $_GET['message']; ?>
            </div>
        <?php } ?>

        <form id="login-form" method="POST" action="login.php">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login_btn" class="btn-submit">Sign In</button>
        </form>

        <a href="forgot-password.php" class="forgot-link">Forgot Password?</a>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>