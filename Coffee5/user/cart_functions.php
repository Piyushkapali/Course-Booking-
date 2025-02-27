<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        
        $conn = getDbConnection();
        
        // Check if product already exists in cart
        $stmt = $conn->prepare("SELECT quantity FROM cart WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $productId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Update quantity
            $row = $result->fetch_assoc();
            $newQuantity = $row['quantity'] + 1;
            
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE product_id = ? AND user_id = ?");
            $stmt->bind_param("iii", $newQuantity, $productId, $userId);
            $stmt->execute();
        } else {
            // Insert new item
            $quantity = 1; // Define quantity first
            $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iissd", $userId, $productId, $productName, $productPrice, $quantity);
            $stmt->execute();
        }
        
        $conn->close();
        header("Location: Machine.php");
        exit();
    } else {
        header("Location: login.php");
        exit();
    }
}
?>
