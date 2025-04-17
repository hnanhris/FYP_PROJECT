<?php

session_start();

include('server/connection.php');

if(!isset($_SESSION['logged_in'])){
    header('location: login.php');
    exit;
}

// Logout handler
if(isset($_GET['logout'])){
    session_destroy();
    header('location: login.php');
    exit;
}

// Get user details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, phone, address FROM users WHERE user_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $phone, $address);
$stmt->fetch();
$stmt->close();

// Get user orders
$stmt = $conn->prepare("SELECT o.*, COUNT(oi.order_item_id) as total_items 
                       FROM orders o 
                       LEFT JOIN order_items oi ON o.order_id = oi.order_id 
                       WHERE o.user_id = ? 
                       GROUP BY o.order_id 
                       ORDER BY o.created_at DESC");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$orders = $stmt->get_result();

// Handle profile update
if(isset($_POST['update_profile'])){
    $new_username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $new_phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $new_address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);

    $stmt = $conn->prepare("UPDATE users SET username = ?, phone = ?, address = ? WHERE user_id = ?");
    $stmt->bind_param('sssi', $new_username, $new_phone, $new_address, $user_id);

    if($stmt->execute()){
        header('location: account.php?success=Profile updated successfully');
        exit;
    } else {
        header('location: account.php?error=Could not update profile');
        exit;
    }
}

// Handle password change
if(isset($_POST['change_password'])){
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if(strlen($new_password) < 8){
        header('location: account.php?error=Password must be at least 8 characters long');
        exit;
    }

    if($new_password !== $confirm_password){
        header('location: account.php?error=New passwords do not match');
        exit;
    }

    // Verify current password
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if(!password_verify($current_password, $hashed_password)){
        header('location: account.php?error=Current password is incorrect');
        exit;
    }

    // Update password
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $stmt->bind_param('si', $new_hashed_password, $user_id);

    if($stmt->execute()){
        header('location: account.php?success=Password changed successfully');
        exit;
    } else {
        header('location: account.php?error=Could not update password');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Zyza Ismail Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="my-5 py-5">
    <div class="container">
        <div class="row">
            <!-- Profile Section -->
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Profile</h3>
                        
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

                        <form method="POST" action="account.php">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-control" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" rows="3"><?php echo htmlspecialchars($address); ?></textarea>
                            </div>
                            <button type="submit" name="update_profile" class="btn btn-dark w-100">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Change Password</h3>
                        <form method="POST" action="account.php">
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" name="new_password" required minlength="8">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_password" required>
                            </div>
                            <button type="submit" name="change_password" class="btn btn-dark w-100">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Quick Links</h3>
                        <div class="list-group">
                            <a href="orders.php" class="list-group-item list-group-item-action">
                                <i class="bi bi-box-seam"></i> My Orders
                            </a>
                            <a href="wishlist.php" class="list-group-item list-group-item-action">
                                <i class="bi bi-heart"></i> Wishlist
                            </a>
                            <a href="cart.php" class="list-group-item list-group-item-action">
                                <i class="bi bi-cart"></i> Shopping Cart
                            </a>
                            <a href="account.php?logout" class="list-group-item list-group-item-action text-danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Recent Orders</h3>
                        <?php if($orders->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($order = $orders->fetch_assoc()): ?>
                                            <tr>
                                                <td>#<?php echo $order['order_id']; ?></td>
                                                <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                                <td><?php echo $order['total_items']; ?> items</td>
                                                <td>RM <?php echo number_format($order['total_amount'], 2); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php 
                                                        echo match($order['order_status']) {
                                                            'pending' => 'warning',
                                                            'processing' => 'info',
                                                            'shipped' => 'primary',
                                                            'delivered' => 'success',
                                                            'cancelled' => 'danger',
                                                            default => 'secondary'
                                                        };
                                                    ?>">
                                                        <?php echo ucfirst($order['order_status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="order-details.php?id=<?php echo $order['order_id']; ?>" 
                                                       class="btn btn-sm btn-outline-dark">
                                                        View Details
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-center">No orders yet</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
