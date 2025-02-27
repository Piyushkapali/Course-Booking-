<?php
session_start();
require_once '../config.php';

// Ensure only logged-in admins can access
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Coffee5</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px;
            transition: width 0.3s;
        }
        .sidebar:hover {
            width: 300px;
        }
        .sidebar h1 {
            margin-bottom: 30px;
            font-size: 24px;
        }
        .sidebar ul {
            list-style: none;
        }
        .sidebar li {
            margin-bottom: 15px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background: #34495e;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .container {
            margin-bottom: 30px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }
        .box {
            flex: 1;
            max-width: 400px;
            min-width: 300px;
            border: 1px solid #ccc;
            padding: 30px;
            border-radius: 12px;
            cursor: pointer;
            background-color: #ffffff;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin: 15px;
        }
        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .box img, .box picture img {
            width: 250px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h1>Coffee5 Admin</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="products.php"><i class="fas fa-box"></i> Cart</a></li>
                    <li><a href="bookings.php"><i class="fas fa-calendar"></i> Bookings</a></li>
                    <li><a href="add_product.php"><i class="fas fa-coffee"></i>Product</a></li>
                    
                    <li><a href="login.php?action=logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <div class="container">
                <h2>Dashboard</h2>
            </div>
            <div class="container">
                <div class="box" onclick="window.location.href='bookings.php';">
                    <picture>
                        <source srcset="./images/img1.webp" type="image/webp">
                        <img src="images/img1.jpg" alt="Bookings" onerror="this.src='./images/img1.webp'">
                    </picture>
                    <h3>View Bookings</h3>
                    <p>Click here to view all booking details.</p>
                </div>
                <div class="box" onclick="window.location.href='products.php';">
                    <picture>
                        <source srcset="./images/img2.webp" type="image/webp">
                        <img src="images/img2.jpg" alt="Products" onerror="this.src='./images/img2.webp'">
                    </picture>
                    <h3>Manage Products</h3>
                    <p>Click here to manage product details.</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
