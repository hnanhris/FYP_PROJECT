<?php
session_start();
include('server/connection.php');

// Get category if specified
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 12;
$offset = ($page - 1) * $per_page;

// Build query based on filters
$where_clauses = ['p.status = "active"'];
$params = [];
$param_types = '';

if($category_id) {
    $where_clauses[] = 'p.category_id = ?';
    $params[] = $category_id;
    $param_types .= 'i';
}

if($search) {
    $where_clauses[] = '(p.name LIKE ? OR p.description LIKE ?)';
    $params[] = "%$search%";
    $params[] = "%$search%";
    $param_types .= 'ss';
}

$where_sql = implode(' AND ', $where_clauses);

// Sort options
$sort_sql = match($sort) {
    'price_low' => 'p.price ASC',
    'price_high' => 'p.price DESC',
    'name_asc' => 'p.name ASC',
    'name_desc' => 'p.name DESC',
    default => 'p.created_at DESC'
};

// Get total products for pagination
$count_sql = "SELECT COUNT(*) FROM products p WHERE $where_sql";
$stmt = $conn->prepare($count_sql);
if(!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}
$stmt->execute();
$total_products = $stmt->get_result()->fetch_row()[0];
$total_pages = ceil($total_products / $per_page);

// Get products
$sql = "SELECT p.*, c.name as category_name, 
        (SELECT GROUP_CONCAT(DISTINCT size) FROM product_variations WHERE product_id = p.product_id) as sizes
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.category_id 
        WHERE $where_sql 
        ORDER BY $sort_sql 
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$params[] = $per_page;
$params[] = $offset;
$param_types .= 'ii';
$stmt->bind_param($param_types, ...$params);
$stmt->execute();
$products = $stmt->get_result();

// Get all categories for filter
$categories = $conn->query("SELECT * FROM categories ORDER BY name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Zyza Ismail Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="my-5" style="margin-top: 100px;">
    <div class="container">
        <!-- Filters and Search -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <div class="list-group mt-2">
                            <a href="products.php" class="list-group-item list-group-item-action <?php echo !$category_id ? 'active' : ''; ?>">
                                All Categories
                            </a>
                            <?php while($category = $categories->fetch_assoc()): ?>
                                <a href="products.php?category=<?php echo $category['category_id']; ?>" 
                                   class="list-group-item list-group-item-action <?php echo $category_id == $category['category_id'] ? 'active' : ''; ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </a>
                            <?php endwhile; ?>
                        </div>

                        <h5 class="card-title mt-4">Sort By</h5>
                        <select class="form-select mt-2" onchange="window.location.href=this.value">
                            <option value="products.php?<?php echo http_build_query(array_merge($_GET, ['sort' => 'newest'])); ?>" 
                                    <?php echo $sort == 'newest' ? 'selected' : ''; ?>>
                                Newest First
                            </option>
                            <option value="products.php?<?php echo http_build_query(array_merge($_GET, ['sort' => 'price_low'])); ?>"
                                    <?php echo $sort == 'price_low' ? 'selected' : ''; ?>>
                                Price: Low to High
                            </option>
                            <option value="products.php?<?php echo http_build_query(array_merge($_GET, ['sort' => 'price_high'])); ?>"
                                    <?php echo $sort == 'price_high' ? 'selected' : ''; ?>>
                                Price: High to Low
                            </option>
                            <option value="products.php?<?php echo http_build_query(array_merge($_GET, ['sort' => 'name_asc'])); ?>"
                                    <?php echo $sort == 'name_asc' ? 'selected' : ''; ?>>
                                Name: A to Z
                            </option>
                            <option value="products.php?<?php echo http_build_query(array_merge($_GET, ['sort' => 'name_desc'])); ?>"
                                    <?php echo $sort == 'name_desc' ? 'selected' : ''; ?>>
                                Name: Z to A
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <!-- Search Bar -->
                <form action="products.php" method="GET" class="mb-4">
                    <?php if($category_id): ?>
                        <input type="hidden" name="category" value="<?php echo $category_id; ?>">
                    <?php endif; ?>
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Search products..." 
                               value="<?php echo htmlspecialchars($search); ?>">
                        <button class="btn btn-dark" type="submit">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </form>

                <!-- Products Grid -->
                <?php if($products->num_rows > 0): ?>
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php while($product = $products->fetch_assoc()): ?>
                            <div class="col">
                                <div class="card h-100">
                                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                                         class="card-img-top" 
                                         alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                        <p class="card-text text-muted">
                                            <?php echo htmlspecialchars($product['category_name']); ?>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <?php if($product['sale_price']): ?>
                                                    <span class="text-decoration-line-through text-muted">
                                                        RM <?php echo number_format($product['price'], 2); ?>
                                                    </span>
                                                    <span class="ms-2 text-danger fw-bold">
                                                        RM <?php echo number_format($product['sale_price'], 2); ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="fw-bold">
                                                        RM <?php echo number_format($product['price'], 2); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <?php if($product['stock'] > 0): ?>
                                                    <a href="product-details.php?id=<?php echo $product['product_id']; ?>" 
                                                       class="btn btn-sm btn-dark">
                                                        View Details
                                                    </a>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-secondary" disabled>
                                                        Out of Stock
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if($total_pages > 1): ?>
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <?php if($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="products.php?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">
                                            Previous
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                        <a class="page-link" href="products.php?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <?php if($page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="products.php?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">
                                            Next
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-search display-1"></i>
                        <h3 class="mt-3">No Products Found</h3>
                        <p class="text-muted">Try adjusting your search or filter to find what you're looking for.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
