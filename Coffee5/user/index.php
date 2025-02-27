<?php
session_start();
require_once '../config.php';  // Include database configuration

// Check if there is a user confirmation message to display
if (isset($_SESSION['user_confirmation_message'])) {
    echo "<div class='alert alert-success' style='padding: 15px; border-radius: 5px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin: 20px 0;'>\n        <strong>Success!</strong> " . $_SESSION['user_confirmation_message'] . "\n    </div>";
    unset($_SESSION['user_confirmation_message']); // Clear the message after displaying
}

// Check if there is a booking confirmation message to display
if (isset($_SESSION['booking_message'])) {
    echo '<div class="alert alert-success" style="
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        margin: 20px;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        text-align: center;
        font-size: 16px;
    ">';
    echo '<i class="fas fa-check-circle" style="margin-right: 10px;"></i>';
    echo $_SESSION['booking_message'];
    echo '</div>';
    unset($_SESSION['booking_message']); // Clear the message after displaying
}

// Check if there is a booking confirmation message to display
if (isset($_SESSION['booking_confirmation_message'])) {
    echo "<div class='alert alert-success' style='padding: 15px; border-radius: 5px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin: 20px 0;'>\n        <strong>Booking Confirmed!</strong> " . $_SESSION['booking_confirmation_message'] . "\n    </div>";
    unset($_SESSION['booking_confirmation_message']); // Clear the message after displaying
}

// Display booking confirmation message if it exists for this user
if (isset($_SESSION['email']) && isset($_SESSION['user_messages'][$_SESSION['email']])) {
    echo '<div class="alert alert-success" style="
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        margin: 20px auto;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        text-align: center;
        max-width: 800px;
        font-size: 16px;
    ">';
    echo '<i class="fas fa-check-circle" style="margin-right: 10px;"></i>';
    echo $_SESSION['user_messages'][$_SESSION['email']];
    echo '</div>';
    // Clear the message after displaying
    unset($_SESSION['user_messages'][$_SESSION['email']]);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Coffee Website</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .user-dropdown-btn {
            background: none;
            border: none;
            color: white;
            padding: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .user-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
        }

        .user-dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .user-dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .user-dropdown:hover .user-dropdown-content {
            display: block;
        }

        .user-icon {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }
    </style>
</head>
<body>
    
    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <main>
        <div class="content">
            <section class="slogan">
                <h1 class="stylish-text">Freshly Brewed Coffee <br> Just for You</h1>

                <img src="../image/img3.webp" alt="Coffee Cup" />
                
            </section>

            <div class="cta-section">
                <a href="Aboutus.php" class="explore-button">Explore Our Story</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="social-links">
        <a href="https://www.facebook.com/piyush.kapali.9"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/piyush.kapali"><i class="fab fa-instagram"></i></a>
            <a href="https://www.youtube.com/@piyushkapali3821"><i class="fab fa-youtube"></i></a>
        </div>
        <p>&copy; 2025 Coffee Shop. All rights reserved.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>