<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    // Database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    switch ($action) {
        case 'add':
            if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
                $product_id = $_POST['product_id'];
                $quantity = (int)$_POST['quantity'];
                
                // Fetch product details
                $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND stock >= ?");
                $stmt->bind_param("ii", $product_id, $quantity);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $product = $result->fetch_assoc();
                    
                    // Initialize cart if it doesn't exist
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }
                    
                    // Add or update cart item
                    if (isset($_SESSION['cart'][$product_id])) {
                        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                    } else {
                        $_SESSION['cart'][$product_id] = [
                            'name' => $product['name'],
                            'price' => $product['price'],
                            'quantity' => $quantity,
                            'image_path' => $product['image_path']
                        ];
                    }
                    
                    $_SESSION['message'] = "Product added to cart successfully!";
                } else {
                    $_SESSION['error'] = "Product not available in the requested quantity!";
                }
            }
            break;
            
        case 'update':
            if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
                $product_id = $_POST['product_id'];
                $quantity = (int)$_POST['quantity'];
                
                if ($quantity > 0) {
                    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
                    $_SESSION['message'] = "Cart updated successfully!";
                } else {
                    unset($_SESSION['cart'][$product_id]);
                    $_SESSION['message'] = "Product removed from cart!";
                }
            }
            break;
            
        case 'remove':
            if (isset($_POST['product_id'])) {
                $product_id = $_POST['product_id'];
                unset($_SESSION['cart'][$product_id]);
                $_SESSION['message'] = "Product removed from cart!";
            }
            break;
            
        case 'clear':
            unset($_SESSION['cart']);
            $_SESSION['message'] = "Cart cleared successfully!";
            break;
    }
    
    $conn->close();
}

// Redirect back to the previous page
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
