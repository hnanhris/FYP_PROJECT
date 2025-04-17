<?php

session_start();

include('server/connection.php');

//if user has already registered, then take the user to account page
if(isset($_SESSION['logged_in'])){

    header('location: account.php');
    exit;  
}

// Validation
$errors = array();

if(isset($_POST['register_btn'])){
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if(empty($username) || empty($email) || empty($password) || empty($confirm_password)){
        header('location: register.php?error=Please fill in all fields');
        exit;
    }

    if($password !== $confirm_password){
        header('location: register.php?error=Passwords do not match');
        exit;
    }

    // If there are no errors, proceed with registration
    if(empty($errors)){
        // Check if email already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if($count > 0){
            header('location: register.php?error=Email already exists');
            exit;
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $email, $hashed_password);

        if($stmt->execute()){
            header('location: login.php?message=Registration successful! Please login.');
            exit;
        } else {
            header('location: register.php?error=Could not create account');
            exit;
        }
    } else {
        header('location: register.php?error=' . urlencode(implode(", ", $errors)));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Zyza Ismail Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="auth-container">
    <div class="auth-box">
        <div class="nav-tabs">
            <a href="login.php">Sign In</a>
            <a href="register.php" class="active">Create Account</a>
        </div>

        <?php if(isset($_GET['error'])){ ?>
            <div class="alert alert-danger text-center">
                <?php echo $_GET['error']; ?>
            </div>
        <?php } ?>

        <form id="register-form" method="POST" action="register.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="register_btn" class="btn-submit">Create Account</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
