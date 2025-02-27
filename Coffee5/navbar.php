<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

// Initialize cart count
$cart_count = 0;
if (isset($_SESSION['email'])) {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM cart WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $cart_count = $result->fetch_assoc()['count'];
    $conn->close();
}
?>
<nav class="navbar">
    <div class="logo">
        <img src="image/log.png" alt="Coffee Shop Logo" style="height: 60px; margin-left: 20px;">
    </div>
    <ul class="nav-list">
        <li><a href="index.php" class="nav-link">Home</a></li>
        <li><a href="Aboutus.php" class="nav-link">About Us</a></li>
        <li><a href="course.php" class="nav-link">Course</a></li>
        <li><a href="shop.php" class="nav-link">Shop</a></li>
        <li><a href="contact.php" class="nav-link">Contact</a></li>
        <?php if (isset($_SESSION['email'])): ?>
            <li>
                <a href="cart.php" class="nav-link">
                    Cart
                    <?php if ($cart_count > 0): ?>
                        <span class="cart-badge"><?php echo $cart_count; ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li><a href="logout.php" class="nav-link">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php" class="nav-link">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
<style>
    .navbar {
        background-color: #333;
        overflow: hidden;
        padding: 30px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo img {
        height: 60px;
        margin-left: 20px;
    }

    .nav-list {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
    }

    .nav-link {
        color: white;
        text-decoration: none;
        padding: 14px 16px;
        font-size: 17px;
        transition: color 0.3s;
    }

    .nav-link:hover {
        color: #ffd700;
    }

    .cart-badge {
        background-color: #ffd700;
        color: #333;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
        position: relative;
        top: -10px;
        margin-left: 2px;
    }
</style>
