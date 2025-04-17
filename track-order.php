<?php 
session_start();
include('server/connection.php');
include 'header.php'; 
?>

<!-- Main Content -->
<div class="container" style="margin-top: 100px; min-height: 70vh;">
    <div class="row justify-content-center py-5">
        <div class="col-lg-8">
            <h1 class="text-center mb-5">Track Your Order</h1>

            <!-- Track Order Form -->
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body p-5">
                    <form action="" method="POST">
                        <div class="mb-4">
                            <label for="order_id" class="form-label">Order Number</label>
                            <input type="text" class="form-control" id="order_id" name="order_id" required 
                                   placeholder="Enter your order number">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                   placeholder="Enter the email used for order">
                        </div>
                        <div class="text-center">
                            <button type="submit" name="track_order" class="btn btn-primary px-5">Track Order</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            if(isset($_POST['track_order'])) {
                $order_id = $_POST['order_id'];
                $email = $_POST['email'];

                $stmt = $conn->prepare("SELECT o.*, u.email 
                                      FROM orders o 
                                      JOIN users u ON o.user_id = u.user_id 
                                      WHERE o.order_id = ? AND u.email = ?");
                $stmt->bind_param('is', $order_id, $email);
                $stmt->execute();
                $order = $stmt->get_result()->fetch_assoc();

                if($order) {
                    ?>
                    <!-- Order Status -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <h3 class="card-title text-center mb-4">Order #<?php echo $order_id; ?></h3>
                            
                            <!-- Status Timeline -->
                            <div class="position-relative mb-5">
                                <div class="progress" style="height: 3px;">
                                    <div class="progress-bar" role="progressbar" style="width: 
                                        <?php
                                        switch($order['status']) {
                                            case 'pending': echo "25%"; break;
                                            case 'processing': echo "50%"; break;
                                            case 'shipped': echo "75%"; break;
                                            case 'delivered': echo "100%"; break;
                                            default: echo "0%";
                                        }
                                        ?>;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="position-absolute w-100" style="top: -10px;">
                                    <div class="row text-center">
                                        <div class="col">
                                            <div class="rounded-circle bg-<?php echo $order['status'] == 'pending' ? 'primary' : ($order['status'] == 'cancelled' ? 'danger' : 'success'); ?> d-inline-block" style="width: 20px; height: 20px;"></div>
                                            <div class="mt-2"><small>Order Placed</small></div>
                                        </div>
                                        <div class="col">
                                            <div class="rounded-circle bg-<?php echo $order['status'] == 'processing' || $order['status'] == 'shipped' || $order['status'] == 'delivered' ? 'success' : 'light'; ?> border d-inline-block" style="width: 20px; height: 20px;"></div>
                                            <div class="mt-2"><small>Processing</small></div>
                                        </div>
                                        <div class="col">
                                            <div class="rounded-circle bg-<?php echo $order['status'] == 'shipped' || $order['status'] == 'delivered' ? 'success' : 'light'; ?> border d-inline-block" style="width: 20px; height: 20px;"></div>
                                            <div class="mt-2"><small>Shipped</small></div>
                                        </div>
                                        <div class="col">
                                            <div class="rounded-circle bg-<?php echo $order['status'] == 'delivered' ? 'success' : 'light'; ?> border d-inline-block" style="width: 20px; height: 20px;"></div>
                                            <div class="mt-2"><small>Delivered</small></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Details -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h5>Order Details</h5>
                                    <p>Order Date: <?php echo date('F j, Y', strtotime($order['created_at'])); ?><br>
                                    Status: <span class="badge bg-<?php echo $order['status'] == 'delivered' ? 'success' : 'primary'; ?>"><?php echo ucfirst($order['status']); ?></span><br>
                                    Total: RM <?php echo number_format($order['total_amount'], 2); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h5>Shipping Address</h5>
                                    <p><?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    echo '<div class="alert alert-danger">No order found with the provided details.</div>';
                }
            }
            ?>

            <!-- Help Section -->
            <div class="text-center mt-5">
                <p>Need help tracking your order?</p>
                <a href="contact.php" class="btn btn-outline-primary">Contact Support</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
