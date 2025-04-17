<?php
$conn = mysqli_connect('localhost', 'root', '');

if ($conn) {
    echo "Connected to MySQL server successfully!<br><br>";
    
    // Check if database exists
    $result = mysqli_query($conn, "SHOW DATABASES LIKE 'zyza_ismail'");
    if (mysqli_num_rows($result) > 0) {
        echo "✅ Database 'zyza_ismail' exists<br>";
        
        // Select the database
        mysqli_select_db($conn, 'zyza_ismail');
        
        // Check tables
        $result = mysqli_query($conn, "SHOW TABLES");
        echo "<br>Tables in database:<br>";
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_row($result)) {
                echo "- " . $row[0] . "<br>";
            }
        } else {
            echo "❌ No tables found in database<br>";
        }
    } else {
        echo "❌ Database 'zyza_ismail' does not exist<br>";
    }
} else {
    echo "Failed to connect to MySQL server";
}
?>
