<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = mysqli_connect("localhost", "root", "", "coffee_shop");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $package = $_POST['package'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $preferred_date = $_POST['preferred_date'];
    $preferred_time = $_POST['preferred_time'];
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Insert into database
    $sql = "INSERT INTO course_bookings (package, name, email, phone, preferred_date, preferred_time, message) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssss", $package, $name, $email, $phone, $preferred_date, $preferred_time, $message);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Booking successful! We will contact you soon.";
        } else {
            $_SESSION['error'] = "Error: " . mysqli_error($conn);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
    header("Location:course.php");
    exit();
}
?>
