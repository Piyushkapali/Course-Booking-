<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'coffee_shop');

// Email Configuration
define('SMTP_FROM', 'noreply@coffeeshop.com');
define('SHOP_NAME', 'Coffee Shop');

// Database Connection Function
function getDbConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}
?>
