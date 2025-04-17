<?php
include('server/connection.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: shop.php');
    exit();
}

$product_id = $_GET['id'];

// Get product details with category
$stmt = $conn->prepare("
    SELECT p.*, c.name as category_name 
    FROM products p 
    JOIN categories c ON p.category_id = c.category_id 
    WHERE p.product_id = ?
");

$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    header('Location: shop.php');
    exit();
}

// Get available sizes for this product
$stmt = $conn->prepare("
    SELECT DISTINCT s.* 
    FROM sizes s 
    INNER JOIN product_variants pv ON s.size_id = pv.size_id 
    WHERE pv.product_id = ? AND pv.stock > 0 
    ORDER BY s.name
");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$sizes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get available colors for this product
$stmt = $conn->prepare("
    SELECT DISTINCT c.* 
    FROM colors c 
    INNER JOIN product_variants pv ON c.color_id = pv.color_id 
    WHERE pv.product_id = ? AND pv.stock > 0 
    ORDER BY c.name
");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$colors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

include('header.php');
?>

<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['name']); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 mb-4">
            <div class="product-image-container">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                <?php if ($product['sale_price'] > 0): ?>
                    <span class="sale-badge">Sale!</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="mb-3"><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="text-muted mb-3">Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
            
            <div class="mb-3">
                <?php if ($product['sale_price'] > 0): ?>
                    <span class="text-decoration-line-through text-muted me-2">RM<?php echo number_format($product['price'], 2); ?></span>
                    <span class="fs-4 text-danger">RM<?php echo number_format($product['sale_price'], 2); ?></span>
                <?php else: ?>
                    <span class="fs-4">RM<?php echo number_format($product['price'], 2); ?></span>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>

            <form id="addToCartForm" action="cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($product['image']); ?>">
                <input type="hidden" name="product_price" value="<?php echo $product['sale_price'] > 0 ? $product['sale_price'] : $product['price']; ?>">
                <input type="hidden" name="add_to_cart" value="1">
                
                <!-- Size Selection -->
                <?php if (!empty($sizes)): ?>
                <div class="mb-3">
                    <label class="form-label">Size</label>
                    <div class="btn-group" role="group">
                        <?php foreach($sizes as $size): ?>
                            <input type="radio" class="btn-check" name="size" id="size<?php echo $size['size_id']; ?>" value="<?php echo $size['size_id']; ?>" required>
                            <label class="btn btn-outline-dark" for="size<?php echo $size['size_id']; ?>"><?php echo htmlspecialchars($size['name']); ?></label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Color Selection -->
                <?php if (!empty($colors)): ?>
                <div class="mb-3">
                    <label class="form-label">Color</label>
                    <div class="d-flex gap-2">
                        <?php foreach($colors as $color): ?>
                            <label class="color-option">
                                <input type="radio" name="color" value="<?php echo $color['color_id']; ?>" required>
                                <span class="color-check" style="background-color: <?php echo htmlspecialchars($color['hex_code']); ?>"></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Quantity -->
                <div class="mb-4">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control" name="quantity" value="1" min="1" style="width: 100px;">
                </div>

                <button type="submit" class="btn btn-dark btn-lg">Add to Cart</button>
            </form>
        </div>
    </div>
</div>

<style>
.product-image-container {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.product-image {
    width: 100%;
    height: auto;
    display: block;
}

.sale-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #dc3545;
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.9rem;
}

.color-option {
    width: 30px;
    height: 30px;
    position: relative;
    cursor: pointer;
}

.color-option input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.color-check {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px #ddd;
    transition: transform 0.2s;
}

.color-option input:checked + .color-check {
    transform: scale(1.1);
    box-shadow: 0 0 0 2px #000;
}

.btn-check:checked + .btn-outline-dark {
    background-color: #212529;
    color: #fff;
}

.breadcrumb a {
    color: #666;
    text-decoration: none;
}

.breadcrumb a:hover {
    color: #000;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('addToCartForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Check if size and color are selected (if they exist)
        const sizeInputs = form.querySelectorAll('input[name="size"]');
        const colorInputs = form.querySelectorAll('input[name="color"]');
        
        if (sizeInputs.length > 0) {
            const sizeSelected = Array.from(sizeInputs).some(input => input.checked);
            if (!sizeSelected) {
                alert('Please select a size');
                return;
            }
        }
        
        if (colorInputs.length > 0) {
            const colorSelected = Array.from(colorInputs).some(input => input.checked);
            if (!colorSelected) {
                alert('Please select a color');
                return;
            }
        }
        
        // If all validations pass, submit the form
        form.submit();
    });
});
</script>

<?php include('footer.php'); ?>
