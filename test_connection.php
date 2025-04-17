<?php
include('server/connection.php');

echo "<h2>Database Connection Test</h2>";

// Test database connection
if ($conn) {
    echo "✅ Database connection successful!<br><br>";

    // Test tables existence
    $tables = ['users', 'categories', 'products', 'orders', 'order_items', 'product_variations', 'newsletter_subscribers'];
    
    echo "<h3>Checking Tables:</h3>";
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows > 0) {
            echo "✅ Table '$table' exists<br>";
            
            // Show count of records
            $count = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc()['count'];
            echo "   - Records: $count<br>";
        } else {
            echo "❌ Table '$table' does not exist<br>";
        }
    }
    
    // Test admin user
    $result = $conn->query("SELECT username, email, role FROM users WHERE role='admin'");
    echo "<br><h3>Admin Users:</h3>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "✅ Found admin user: " . htmlspecialchars($row['username']) . " (" . htmlspecialchars($row['email']) . ")<br>";
        }
    } else {
        echo "❌ No admin users found<br>";
    }
    
    // Test categories
    $result = $conn->query("SELECT name FROM categories");
    echo "<br><h3>Categories:</h3>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "✅ " . htmlspecialchars($row['name']) . "<br>";
        }
    } else {
        echo "❌ No categories found<br>";
    }
    
} else {
    echo "❌ Database connection failed!";
}
?>
