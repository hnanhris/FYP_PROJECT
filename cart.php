<?php
session_start();
include('server/connection.php');

// Add to cart functionality
if(isset($_POST['add_to_cart'])){
    $product_id = $_POST['product_id'];
    
    // If cart is empty, create first product
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
    
    // Check if product exists in cart
    if(isset($_SESSION['cart'][$product_id])){
        $_SESSION['cart'][$product_id]['product_quantity'] += $_POST['product_quantity'];
    } else {
        // Add new product to cart
        $_SESSION['cart'][$product_id] = array(
            'product_id' => $product_id,
            'product_name' => $_POST['product_name'],
            'product_price' => $_POST['product_price'],
            'product_image' => $_POST['product_image'],
            'product_quantity' => $_POST['product_quantity']
        );
    }
}

// Remove from cart
if(isset($_POST['remove_product'])){
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
}

// Update quantity
if(isset($_POST['update_quantity'])){
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    
    if($quantity > 0){
        $_SESSION['cart'][$product_id]['product_quantity'] = $quantity;
    }
}

// Calculate total
$total = 0;
if(isset($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $item){
        $total += $item['product_price'] * $item['product_quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Zyza Ismail Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="cart-section">
    <h1 class="section-title">Shopping Cart</h1>
    
    <div class="container">
        <?php if(empty($_SESSION['cart'])): ?>
            <div class="empty-cart">
                <p>Your cart is empty</p>
                <a href="shop.php" class="btn-shop">Continue Shopping</a>
            </div>
        <?php else: ?>
            <div class="cart-container">
                <div class="cart-items">
                    <?php foreach($_SESSION['cart'] as $item): ?>
                        <div class="cart-item">
                            <div class="item-image">
                                <img src="assets/<?php echo $item['product_image']; ?>" alt="<?php echo $item['product_name']; ?>">
                            </div>
                            <div class="item-details">
                                <h3><?php echo $item['product_name']; ?></h3>
                                <p class="price">RM <?php echo number_format($item['product_price'], 2); ?></p>
                                
                                <form class="quantity-form" method="POST" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                    <div class="quantity-controls">
                                        <button type="button" class="quantity-btn minus">-</button>
                                        <input type="number" name="quantity" value="<?php echo $item['product_quantity']; ?>" min="1" class="quantity-input">
                                        <button type="button" class="quantity-btn plus">+</button>
                                    </div>
                                    <button type="submit" name="update_quantity" class="btn-update">Update</button>
                                </form>
                                
                                <form method="POST" action="cart.php" class="remove-form">
                                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                    <button type="submit" name="remove_product" class="btn-remove">Remove</button>
                                </form>
                            </div>
                            <div class="item-subtotal">
                                <p>Subtotal:</p>
                                <p class="price">RM <?php echo number_format($item['product_price'] * $item['product_quantity'], 2); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="cart-summary">
                    <h3>Order Summary</h3>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>RM <?php echo number_format($total, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>RM <?php echo number_format($total, 2); ?></span>
                    </div>
                    <a href="checkout.php" class="btn-checkout">Proceed to Checkout</a>
                    <a href="shop.php" class="btn-continue">Continue Shopping</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>

<style>
.cart-section {
    padding: 80px 0;
    min-height: 60vh;
    font-family: 'Glacial Indifference', sans-serif;
}

.section-title {
    text-align: center;
    font-size: 24px;
    letter-spacing: 1px;
    margin: 40px 0;
    font-family: 'Glacial Indifference', sans-serif;
    font-weight: bold;
}

.empty-cart {
    text-align: center;
    padding: 40px;
}

.empty-cart p {
    font-size: 16px;
    color: #666;
    margin-bottom: 20px;
}

.cart-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
}

.cart-items {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.cart-item {
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 20px;
    padding: 20px;
    border-bottom: 1px solid #eee;
}

.cart-item:last-child {
    border-bottom: none;
}

.item-image {
    width: 100px;
    height: 100px;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
}

.item-details h3 {
    font-size: 16px;
    margin-bottom: 5px;
}

.price {
    font-size: 14px;
    color: #666;
    margin-bottom: 10px;
}

.quantity-form {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.quantity-controls {
    display: flex;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.quantity-btn {
    border: none;
    background: none;
    padding: 5px 10px;
    cursor: pointer;
    color: #666;
}

.quantity-input {
    width: 50px;
    border: none;
    text-align: center;
    font-size: 14px;
}

.btn-update, .btn-remove {
    border: none;
    background: none;
    color: #666;
    font-size: 13px;
    cursor: pointer;
    padding: 5px 10px;
}

.btn-update:hover, .btn-remove:hover {
    color: #000;
}

.item-subtotal {
    text-align: right;
}

.cart-summary {
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    align-self: start;
}

.cart-summary h3 {
    font-size: 18px;
    margin-bottom: 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    font-size: 14px;
    color: #666;
}

.summary-row.total {
    font-size: 16px;
    font-weight: bold;
    color: #000;
    border-top: 1px solid #eee;
    padding-top: 15px;
    margin-top: 15px;
}

.btn-checkout, .btn-continue {
    display: block;
    width: 100%;
    padding: 12px;
    text-align: center;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
    margin-top: 15px;
}

.btn-checkout {
    background: #000;
    color: white;
}

.btn-continue {
    background: #f7f7f7;
    color: #333;
}

.btn-shop {
    display: inline-block;
    background: #000;
    color: white;
    padding: 10px 25px;
    border-radius: 25px;
    text-decoration: none;
    font-size: 14px;
    transition: background 0.3s ease;
}

.btn-shop:hover {
    background: #333;
    color: white;
}

@media (max-width: 768px) {
    .cart-container {
        grid-template-columns: 1fr;
    }
    
    .cart-item {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .item-image {
        margin: 0 auto;
    }
    
    .item-subtotal {
        text-align: center;
    }
    
    .quantity-form {
        justify-content: center;
    }
}
</style>

<script>
document.querySelectorAll('.quantity-btn').forEach(button => {
    button.addEventListener('click', function() {
        const input = this.parentElement.querySelector('.quantity-input');
        const currentValue = parseInt(input.value);
        
        if(this.classList.contains('minus') && currentValue > 1) {
            input.value = currentValue - 1;
        } else if(this.classList.contains('plus')) {
            input.value = currentValue + 1;
        }
    });
});
</script>

</body>
</html>