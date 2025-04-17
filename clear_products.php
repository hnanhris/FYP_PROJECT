<?php
include('server/connection.php');

try {
    // Start transaction
    $conn->begin_transaction();

    // Disable foreign key checks
    $conn->query('SET FOREIGN_KEY_CHECKS=0');

    // Clear all product-related tables
    $tables = ['product_variants', 'product_images', 'products'];
    
    foreach($tables as $table) {
        $conn->query("TRUNCATE TABLE $table");
    }

    // Re-enable foreign key checks
    $conn->query('SET FOREIGN_KEY_CHECKS=1');

    // Commit transaction
    $conn->commit();

    echo "Successfully cleared all product data.";

} catch(Exception $e) {
    // Rollback on error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
} finally {
    // Always re-enable foreign key checks
    $conn->query('SET FOREIGN_KEY_CHECKS=1');
}
