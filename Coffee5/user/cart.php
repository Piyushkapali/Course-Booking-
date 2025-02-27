<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$conn = getDbConnection();

$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = array();
$total = 0;

while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
    $total += $row['price'] * $row['quantity'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Coffee Shop</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .cart-page {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .cart-items {
            margin-bottom: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            background: #4a3500;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        .cart-total {
            text-align: right;
            font-size: 1.2em;
            margin-top: 20px;
        }

        .checkout-btn {
            background: #4a3500;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            float: right;
            margin-top: 10px;
        }

        .checkout-btn:hover {
            background: #2d1810;
        }
    </style>
</head>
<body>
    <header>
        <?php include '../navbar.php'; ?>
    </header>

    <main class="cart-page">
        <h1>Shopping Cart</h1>
        
        <div class="cart-items">
            <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <div class="cart-item-details">
                        <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                        <p>Price: Rs <?php echo number_format($item['price'], 2); ?> NPR</p>
                    </div>
                    <div class="quantity-controls">
                        <button class="quantity-btn" onclick="updateQuantity(<?php echo $item['product_id']; ?>, <?php echo $item['quantity']; ?> - 1)">-</button>
                        <span><?php echo $item['quantity']; ?></span>
                        <button class="quantity-btn" onclick="updateQuantity(<?php echo $item['product_id']; ?>, <?php echo $item['quantity']; ?> + 1)">+</button>
                        <button class="quantity-btn" onclick="removeItem(<?php echo $item['product_id']; ?>)">Remove</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-total">
            <h2>Total: Rs <?php echo number_format($total, 2); ?> NPR</h2>
            <button class="checkout-btn" onclick="location.href='checkout.php'">Proceed to Checkout</button>
        </div>
    </main>

    <footer class="footer">
        <div class="social-links">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
        <p>&copy; 2024 Coffee Shop. All rights reserved.</p>
    </footer>

    <script>
    function updateQuantity(productId, newQuantity) {
        if (newQuantity < 1) {
            removeItem(productId);
            return;
        }

        fetch('update_cart_quantity.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&quantity=${newQuantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function removeItem(productId) {
        fetch('remove_cart_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
    </script>
</body>
</html>
