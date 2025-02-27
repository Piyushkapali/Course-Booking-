<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
    $conn = getDbConnection();
    
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $items = array();
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    
    $conn->close();
    echo json_encode($items);
} else {
    echo json_encode(array());
}
?>
