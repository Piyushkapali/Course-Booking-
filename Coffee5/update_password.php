<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $current_time = date('Y-m-d H:i:s');
    
    // Validate passwords match
    if ($new_password !== $confirm_password) {
        $_SESSION['message'] = "Passwords do not match.";
        $_SESSION['message_type'] = "danger";
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }
    
    // Check if token is valid
    $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expiry > ? AND used = 0");
    $stmt->bind_param("ss", $token, $current_time);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
        
        // Hash new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update password in users table
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        
        if ($stmt->execute()) {
            // Mark token as used
            $stmt = $conn->prepare("UPDATE password_resets SET used = 1 WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            
            $_SESSION['message'] = "Password has been successfully reset. Please login with your new password.";
            $_SESSION['message_type'] = "success";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['message'] = "Failed to update password. Please try again.";
            $_SESSION['message_type'] = "danger";
            header("Location: reset_password.php?token=" . urlencode($token));
            exit();
        }
    } else {
        $_SESSION['message'] = "Invalid or expired reset link.";
        $_SESSION['message_type'] = "danger";
        header("Location: login.php");
        exit();
    }
}
