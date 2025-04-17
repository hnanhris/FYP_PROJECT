<?php
session_start();
include('server/connection.php');

if(isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // Get product details
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    
    // Get related products
    $category_id = $product['category_id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ? AND product_id != ? LIMIT 4");
    $stmt->bind_param('ii', $category_id, $product_id);
    $stmt->execute();
    $related_products = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['product_name']; ?> - Zyza Ismail Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="product-details">
    <div class="container">
        <div class="product-container">
            <div class="product-images">
                <div class="main-image">
                    <img src="assets/<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>">
                </div>
                <div class="image-thumbnails">
                    <img src="assets/<?php echo $product['product_image']; ?>" alt="Thumbnail 1" class="active">
                    <img src="assets/<?php echo $product['product_image2']; ?>" alt="Thumbnail 2">
                    <img src="assets/<?php echo $product['product_image3']; ?>" alt="Thumbnail 3">
                </div>
            </div>
            
            <div class="product-info">
                <h1><?php echo $product['product_name']; ?></h1>
                <p class="price">RM <?php echo number_format($product['product_price'], 2); ?></p>
                
                <div class="description">
                    <?php echo $product['product_description']; ?>
                </div>
                
                <form method="POST" action="cart.php" class="add-to-cart-form">
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $product['product_price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $product['product_image']; ?>">
                    
                    <div class="quantity-selector">
                        <label>Quantity:</label>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn minus">-</button>
                            <input type="number" name="product_quantity" value="1" min="1" class="quantity-input">
                            <button type="button" class="quantity-btn plus">+</button>
                        </div>
                    </div>
                    
                    <button type="submit" name="add_to_cart" class="btn-add-to-cart">Add to Cart</button>
                </form>
                
                <div class="product-meta">
                    <p><strong>Category:</strong> <?php echo $product['category_name']; ?></p>
                    <p><strong>SKU:</strong> <?php echo $product['product_code']; ?></p>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        <div class="related-products">
            <h2>Related Products</h2>
            <div class="product-grid">
                <?php while($related = $related_products->fetch_assoc()): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="assets/<?php echo $related['product_image']; ?>" alt="<?php echo $related['product_name']; ?>">
                        <a href="product-details.php?id=<?php echo $related['product_id']; ?>" class="btn-shop">Shop now</a>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name"><?php echo $related['product_name']; ?></h3>
                        <p class="product-price">RM <?php echo number_format($related['product_price'], 2); ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<style>
.product-details {
    padding: 80px 0;
    margin-top: 70px;
    font-family: 'Glacial Indifference', sans-serif;
}

.product-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 60px;
}

/* Product Images */
.product-images {
    position: sticky;
    top: 100px;
}

.main-image {
    margin-bottom: 20px;
    border-radius: 8px;
    overflow: hidden;
}

.main-image img {
    width: 100%;
    height: auto;
    display: block;
}

.image-thumbnails {
    display: flex;
    gap: 10px;
}

.image-thumbnails img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.3s ease;
}

.image-thumbnails img:hover,
.image-thumbnails img.active {
    opacity: 1;
}

/* Product Info */
.product-info h1 {
    font-size: 24px;
    margin-bottom: 10px;
}

.price {
    font-size: 20px;
    color: #333;
    margin-bottom: 20px;
}

.description {
    color: #666;
    line-height: 1.6;
    margin-bottom: 30px;
}

/* Add to Cart Form */
.quantity-selector {
    margin-bottom: 20px;
}

.quantity-selector label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
}

.quantity-controls {
    display: inline-flex;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.quantity-btn {
    border: none;
    background: none;
    padding: 8px 12px;
    cursor: pointer;
    color: #666;
}

.quantity-input {
    width: 60px;
    border: none;
    text-align: center;
    font-size: 14px;
}

.btn-add-to-cart {
    display: block;
    width: 100%;
    padding: 15px;
    background: #000;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn-add-to-cart:hover {
    background: #333;
}

.product-meta {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.product-meta p {
    font-size: 14px;
    color: #666;
    margin-bottom: 5px;
}

/* Related Products */
.related-products {
    margin-top: 60px;
    padding-top: 40px;
    border-top: 1px solid #eee;
}

.related-products h2 {
    font-size: 20px;
    margin-bottom: 30px;
    text-align: center;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

@media (max-width: 1024px) {
    .product-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .product-container {
        grid-template-columns: 1fr;
    }
    
    .product-images {
        position: static;
    }
    
    .product-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .product-grid {
        grid-template-columns: 1fr;
    }
    
    .image-thumbnails img {
        width: 60px;
        height: 60px;
    }
}
</style>

<script>
// Quantity controls
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

// Image thumbnails
document.querySelectorAll('.image-thumbnails img').forEach(thumb => {
    thumb.addEventListener('click', function() {
        // Update main image
        const mainImage = document.querySelector('.main-image img');
        mainImage.src = this.src;
        
        // Update active state
        document.querySelectorAll('.image-thumbnails img').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>

</body>
</html>
