<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    
    if ($quantity < 1) {
        echo json_encode(['success' => false, 'error' => 'Invalid quantity']);
        exit();
    }
    
    $conn = getDbConnection();
    
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("iii", $quantity, $userId, $productId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update quantity']);
    }
    
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
