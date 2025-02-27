<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate passwords match
    if ($new_password !== $confirm_password) {
        $_SESSION['message'] = "Passwords do not match.";
        $_SESSION['message_type'] = "danger";
        header("Location: forgot_password.php");
        exit();
    }
    
    // Check if email exists in database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Hash new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update password in users table
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Password has been successfully reset. Please login with your new password.";
            $_SESSION['message_type'] = "success";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['message'] = "Failed to update password. Please try again.";
            $_SESSION['message_type'] = "danger";
            header("Location: forgot_password.php");
            exit();
        }
    } else {
        // For security, we show a generic message
        $_SESSION['message'] = "If the email exists in our system, the password will be reset.";
        $_SESSION['message_type'] = "info";
        header("Location: forgot_password.php");
        exit();
    }
}
