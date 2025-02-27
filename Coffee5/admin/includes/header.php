<?php
session_start();
require_once '../config.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

// Get admin info
$admin_username = $_SESSION['admin_username'];
$admin_role = $_SESSION['admin_role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee5 Admin Panel</title>
    <link rel="stylesheet" href="../../css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h1>Coffee5 Admin</h1>
            <nav>
                <ul>
                    <li><a href="../admin/products.php"><i class="fas fa-box"></i> Product Management</a></li>
                    <li><a href="../admin/bookings.php"><i class="fas fa-calendar-alt"></i> Booking Management</a></li>
                    <li><a href="../admin/users.php"><i class="fas fa-users"></i> User Management</a></li>
                    <li><a href="../login.php?action=logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <div class="top-bar">
                <div class="admin-info">
                    <i class="fas fa-user"></i>
                    <span><?php echo htmlspecialchars($admin_username); ?></span>
                    <span class="role-badge"><?php echo htmlspecialchars($admin_role); ?></span>
                </div>
            </div>
            <div class="top-bar">
                <div class="admin-info">
                    <i class="fas fa-user"></i>
                    <span><?php echo htmlspecialchars($admin_username); ?></span>
                    <span class="role-badge"><?php echo htmlspecialchars($admin_role); ?></span>
                </div>
            </div>
