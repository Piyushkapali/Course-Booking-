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

// Fetch cart details with product information
$cart_query = "SELECT c.*, DATE_FORMAT(c.created_at, '%Y-%m-%d %h:%i %p') as formatted_date 
               FROM cart c 
               ORDER BY c.created_at DESC";
$cart_result = $conn->query($cart_query);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Coffee5</title>
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
        .cart-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .cart-table th, .cart-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .cart-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }
        .cart-summary {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px dashed #ddd;
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
            <div class="cart-section">
                <h2><i class="fas fa-shopping-cart"></i> Recent Cart Activities</h2>
                
                <?php if ($cart_result && $cart_result->num_rows > 0): ?>
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Date Added</th>
                                <th>User ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total_revenue = 0;
                            $total_items = 0;
                            while ($row = $cart_result->fetch_assoc()): 
                                $item_total = $row['price'] * $row['quantity'];
                                $total_revenue += $item_total;
                                $total_items += $row['quantity'];
                            ?>
                                <tr>
                                    <td>#<?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                    <td>Rs <?php echo number_format($row['price'], 2); ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td>Rs <?php echo number_format($item_total, 2); ?></td>
                                    <td><?php echo $row['formatted_date']; ?></td>
                                    <td><?php echo $row['user_id']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <div class="cart-summary">
                        <h3>Summary</h3>
                        <div class="summary-item">
                            <span>Total Items:</span>
                            <strong><?php echo $total_items; ?></strong>
                        </div>
                        <div class="summary-item">
                            <span>Total Revenue:</span>
                            <strong>Rs <?php echo number_format($total_revenue, 2); ?></strong>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No cart items found.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
