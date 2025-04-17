<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Zyza Ismail Boutique</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/262086238a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Glacial+Indifference:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<?php 
include('server/connection.php');

// Create tables if they don't exist
$create_tables_sql = "
CREATE TABLE IF NOT EXISTS sizes (
    size_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS colors (
    color_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    hex_code VARCHAR(7) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS product_variants (
    variant_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    size_id INT NOT NULL,
    color_id INT NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (size_id) REFERENCES sizes(size_id),
    FOREIGN KEY (color_id) REFERENCES colors(color_id)
);

-- Insert default sizes if not exists
INSERT IGNORE INTO sizes (name) VALUES 
('XS'), ('S'), ('M'), ('L'), ('XL');

-- Insert default colors if not exists
INSERT IGNORE INTO colors (name, hex_code) VALUES 
('Black', '#000000'),
('White', '#FFFFFF'),
('Red', '#FF0000'),
('Blue', '#0000FF'),
('Green', '#008000'),
('Yellow', '#FFFF00'),
('Pink', '#FFC0CB'),
('Purple', '#800080'),
('Brown', '#A52A2A'),
('Gray', '#808080');
";

$conn->multi_query($create_tables_sql);
while ($conn->more_results()) {
    $conn->next_result();
}

// Get all categories
$stmt = $conn->prepare("SELECT * FROM categories ORDER BY name");
if ($stmt) {
    $stmt->execute();
    $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $categories = [];
}

// Get all sizes
$stmt = $conn->prepare("SELECT * FROM sizes ORDER BY name");
if ($stmt) {
    $stmt->execute();
    $sizes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $sizes = [];
}

// Get only colors that are actually used in product variants
$stmt = $conn->prepare("
    SELECT DISTINCT c.* 
    FROM colors c 
    INNER JOIN product_variants pv ON c.color_id = pv.color_id 
    INNER JOIN products p ON pv.product_id = p.product_id 
    WHERE pv.stock > 0 
    ORDER BY c.name
");
if ($stmt) {
    $stmt->execute();
    $colors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $colors = [];
}

// Build query based on filters
$query = "SELECT DISTINCT p.*, c.name as category_name, 
          COALESCE(MIN(pv.stock), 0) as min_stock 
          FROM products p 
          JOIN categories c ON p.category_id = c.category_id
          LEFT JOIN product_variants pv ON p.product_id = pv.product_id
          WHERE 1=1";
$params = [];
$types = "";

// Category filter
if(isset($_GET['category']) && !empty($_GET['category'])) {
    $query .= " AND p.category_id = ?";
    $params[] = $_GET['category'];
    $types .= "i";
}

// Size filter
if(isset($_GET['size']) && !empty($_GET['size'])) {
    $query .= " AND EXISTS (SELECT 1 FROM product_variants pv2 WHERE pv2.product_id = p.product_id AND pv2.size_id = ?)";
    $params[] = $_GET['size'];
    $types .= "i";
}

// Color filter
if(isset($_GET['color']) && !empty($_GET['color'])) {
    $query .= " AND EXISTS (SELECT 1 FROM product_variants pv3 WHERE pv3.product_id = p.product_id AND pv3.color_id = ?)";
    $params[] = $_GET['color'];
    $types .= "i";
}

// Price range filter
if(isset($_GET['min_price']) && isset($_GET['max_price'])) {
    $query .= " AND p.price BETWEEN ? AND ?";
    $params[] = $_GET['min_price'];
    $params[] = $_GET['max_price'];
    $types .= "dd";
}

// Group by to handle the MIN() aggregate
$query .= " GROUP BY p.product_id";

// Sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
switch($sort) {
    case 'price_low':
        $query .= " ORDER BY p.price ASC";
        break;
    case 'price_high':
        $query .= " ORDER BY p.price DESC";
        break;
    case 'popular':
        $query .= " ORDER BY p.views DESC";
        break;
    default: // newest
        $query .= " ORDER BY p.created_at DESC";
}

// Prepare and execute the query
$stmt = $conn->prepare($query);
if($stmt && !empty($params)) {
    $stmt->bind_param($types, ...$params);
}
if($stmt) {
    $stmt->execute();
    $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $products = [];
}

// Get min and max prices for the price slider
$price_query = "SELECT MIN(price) as min_price, MAX(price) as max_price FROM products";
$price_result = $conn->query($price_query);
if($price_result) {
    $price_range = $price_result->fetch_assoc();
    $min_price = floor($price_range['min_price'] ?? 0);
    $max_price = ceil($price_range['max_price'] ?? 1000);
} else {
    $min_price = 0;
    $max_price = 1000;
}

include('header.php');
?>

<div class="container my-5">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Filters</h5>
                    <form id="filterForm" method="GET">
                        <!-- Categories -->
                        <div class="mb-4">
                            <h6>Categories</h6>
                            <div class="list-group">
                                <?php foreach($categories as $category): ?>
                                <label class="list-group-item border-0">
                                    <input type="radio" name="category" value="<?php echo $category['category_id']; ?>"
                                           <?php echo (isset($_GET['category']) && $_GET['category'] == $category['category_id']) ? 'checked' : ''; ?>>
                                    <?php echo $category['name']; ?>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Sizes -->
                        <div class="mb-4">
                            <h6>Sizes</h6>
                            <div class="list-group">
                                <?php foreach($sizes as $size): ?>
                                <label class="list-group-item border-0">
                                    <input type="radio" name="size" value="<?php echo $size['size_id']; ?>"
                                           <?php echo (isset($_GET['size']) && $_GET['size'] == $size['size_id']) ? 'checked' : ''; ?>>
                                    <?php echo $size['name']; ?>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Colors -->
                        <div class="mb-4">
                            <h6>Colors</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach($colors as $color): ?>
                                <label class="color-option" style="background-color: <?php echo $color['hex_code']; ?>"
                                       title="<?php echo $color['name']; ?>">
                                    <input type="radio" name="color" value="<?php echo $color['color_id']; ?>"
                                           <?php echo (isset($_GET['color']) && $_GET['color'] == $color['color_id']) ? 'checked' : ''; ?>>
                                    <span class="color-check"></span>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <h6>Price Range</h6>
                            <div class="range-slider">
                                <input type="range" class="form-range" id="priceRange" 
                                       min="<?php echo $min_price; ?>" 
                                       max="<?php echo $max_price; ?>"
                                       step="1">
                                <div class="range-values">
                                    <span>RM <input type="number" id="minPrice" name="min_price" 
                                                   value="<?php echo isset($_GET['min_price']) ? $_GET['min_price'] : $min_price; ?>"
                                                   min="<?php echo $min_price; ?>" 
                                                   max="<?php echo $max_price; ?>"></span>
                                    <span>to</span>
                                    <span>RM <input type="number" id="maxPrice" name="max_price"
                                                   value="<?php echo isset($_GET['max_price']) ? $_GET['max_price'] : $max_price; ?>"
                                                   min="<?php echo $min_price; ?>" 
                                                   max="<?php echo $max_price; ?>"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Sort By -->
                        <div class="mb-4">
                            <h6>Sort By</h6>
                            <select name="sort" class="form-select">
                                <option value="newest" <?php echo (!isset($_GET['sort']) || $_GET['sort'] == 'newest') ? 'selected' : ''; ?>>Newest First</option>
                                <option value="price_low" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_low') ? 'selected' : ''; ?>>Price: Low to High</option>
                                <option value="price_high" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_high') ? 'selected' : ''; ?>>Price: High to Low</option>
                                <option value="popular" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'popular') ? 'selected' : ''; ?>>Most Popular</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-dark w-100">Apply Filters</button>
                        <a href="shop.php" class="btn btn-outline-dark w-100 mt-2">Clear All</a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach($products as $product): ?>
                <div class="col">
                    <div class="card h-100 product-card">
                        <?php if($product['sale_price']): ?>
                        <div class="sale-badge">
                            <?php 
                            $discount = round((($product['price'] - $product['sale_price']) / $product['price']) * 100);
                            echo "-{$discount}%";
                            ?>
                        </div>
                        <?php endif; ?>
                        
                        <div class="product-image-container">
                            <img src="/<?php echo htmlspecialchars($product['image_url']); ?>" 
                                 class="card-img-top product-image" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                                 onerror="this.src='/assets/placeholder.jpg'">
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text">
                                <?php if($product['sale_price']): ?>
                                <span class="text-decoration-line-through text-muted">RM <?php echo number_format($product['price'], 2); ?></span>
                                <span class="ms-2 text-danger">RM <?php echo number_format($product['sale_price'], 2); ?></span>
                                <?php else: ?>
                                <span>RM <?php echo number_format($product['price'], 2); ?></span>
                                <?php endif; ?>
                            </p>
                            
                            <?php 
                            $stock_status = isset($product['min_stock']) && $product['min_stock'] > 0 ? 'In Stock' : 'Out of Stock';
                            $stock_class = $stock_status === 'In Stock' ? 'text-success' : 'text-danger';
                            ?>
                            <p class="card-text <?php echo $stock_class; ?>"><?php echo $stock_status; ?></p>
                            
                            <?php if($product['min_stock'] > 0): ?>
                            <a href="product.php?id=<?php echo $product['product_id']; ?>" class="btn btn-dark w-100">View Details</a>
                            <?php else: ?>
                            <button class="btn btn-secondary w-100" disabled>Out of Stock</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if(empty($products)): ?>
            <div class="text-center py-5">
                <h3>No products found</h3>
                <p>Try adjusting your filters to find what you're looking for.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.product-card {
    transition: transform 0.2s;
    border: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.product-image-container {
    position: relative;
    padding-top: 100%; /* 1:1 Aspect Ratio */
    overflow: hidden;
    background-color: #f8f8f8;
}

.product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
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
    z-index: 1;
}

.card-title {
    font-size: 1rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.card-text {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

/* Color filter styles */
.color-option {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    position: relative;
    cursor: pointer;
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px #ddd;
}

.color-option input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.color-option input:checked + .color-check::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    text-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
}

/* Price range slider styles */
.range-values {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
}

.range-values input {
    width: 80px;
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when filters change (except price range)
    const form = document.getElementById('filterForm');
    const inputs = form.querySelectorAll('input[type="radio"], select');
    inputs.forEach(input => {
        input.addEventListener('change', () => form.submit());
    });

    // Handle price range
    const priceRange = document.getElementById('priceRange');
    const minPrice = document.getElementById('minPrice');
    const maxPrice = document.getElementById('maxPrice');

    // Update range slider when min/max inputs change
    function updateRangeSlider() {
        const min = parseInt(minPrice.value);
        const max = parseInt(maxPrice.value);
        if (min > max) {
            maxPrice.value = min;
        }
        priceRange.value = (min + max) / 2;
    }

    minPrice.addEventListener('change', updateRangeSlider);
    maxPrice.addEventListener('change', updateRangeSlider);

    // Update min/max inputs when range slider changes
    priceRange.addEventListener('input', function() {
        const value = parseInt(this.value);
        const min = parseInt(this.min);
        const max = parseInt(this.max);
        const range = max - min;
        
        if (value < (min + max) / 2) {
            minPrice.value = value;
        } else {
            maxPrice.value = value;
        }
    });
});
</script>

<?php include('footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
