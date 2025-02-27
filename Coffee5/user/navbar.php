<nav class="navbar">
    <div class="logo">
        <img src="../image/log.png" alt="Coffee Shop Logo">
    </div>
    <ul class="nav-list">
        <li><a href="index.php" class="nav-link">Home</a></li>
        <li><a href="Aboutus.php" class="nav-link">About Us</a></li>
        <li><a href="course.php" class="nav-link">Course</a></li>
        <li><a href="shop.php" class="nav-link">Shop</a></li>
        <li><a href="contact.php" class="nav-link">Contact</a></li>
        <?php if (basename($_SERVER['PHP_SELF']) == 'shop.php') { ?>
        <li><a href="login.php" class="nav-link">Login</a></li>
        <?php } ?>
        <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') { ?>
        <li class="user-dropdown">
            <button class="user-dropdown-btn" style="background-color: #4CAF50; color: white; border: none; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 5px;">
                User
            </button>
            
            <div class="user-dropdown-content">
                <a href="../logout.php">Logout</a>
            </div>
        </li>
        <?php } ?>
    </ul>
</nav>
<style>
    .navbar {
        background-color: #333;
        overflow: hidden;
        padding: 30px 0;
    }
    .nav-list {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }
    .nav-list li {
        float: left;
    }
    .nav-link {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }
    .nav-link:hover {
        background-color: #ddd;
        color: black;
    }
    .user-dropdown {
        position: relative;
        display: inline-block;
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
    .user-dropdown:hover .user-dropdown-content {
        display: block;
    }
    .notification-item {
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }
    .notification-item:last-child {
        border-bottom: none;
    }
</style>
