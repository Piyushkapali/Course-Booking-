<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'coffee_shop');

// Security Configuration
define('SESSION_TIMEOUT', 3600); // 1 hour
define('HASH_ALGO', 'PASSWORD_BCRYPT');
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 900); // 15 minutes

// Application Configuration
define('ITEMS_PER_PAGE', 10);
define('DATE_FORMAT', 'Y-m-d H:i:s');
define('CURRENCY', 'USD');
define('TIMEZONE', 'Asia/Kathmandu');

// Email Configuration
define('SMTP_FROM', 'noreply@coffeeshop.com');
define('SHOP_NAME', 'Coffee Shop');

// Set timezone
date_default_timezone_set(TIMEZONE);

// Error reporting in development
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}
?>
