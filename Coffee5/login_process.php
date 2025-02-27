<?php
session_start();

if ($login_success) {
    // Assuming you have the user's ID after successful authentication
    $user_id = $row['id']; // Replace with your actual logic to get the user ID

    // Set session variables for the user
    $_SESSION['user_id'] = $user_id;
    header("Location: dashboard.php"); // Redirect to the dashboard or home page
    exit();
} else {
    // Handle login failure (e.g., show an error message)
    echo "Invalid username or password.";
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            error_log("User logged in: ID = " . $_SESSION['user_id']);
            error_log("User session created: user_id = " . $_SESSION['user_id'] . ", user_name = " . $_SESSION['user_name']);
            header("Location:user/index.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this email.";
    }
}

$conn->close();
?>