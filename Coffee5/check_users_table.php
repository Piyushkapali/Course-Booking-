<?php
require_once 'config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if email column exists in users table
$result = $conn->query("SHOW COLUMNS FROM users LIKE 'email'");
if ($result->num_rows == 0) {
    // Add email column if it doesn't exist
    $sql = "ALTER TABLE users ADD COLUMN email VARCHAR(255)";
    if ($conn->query($sql) === TRUE) {
        echo "Email column added to users table<br>";
    } else {
        echo "Error adding email column: " . $conn->error . "<br>";
    }
}

// Show current users
$result = $conn->query("SELECT * FROM users");
echo "<h2>Current Users:</h2>";
echo "<pre>";
while ($row = $result->fetch_assoc()) {
    print_r($row);
}
echo "</pre>";

$conn->close();
?>
