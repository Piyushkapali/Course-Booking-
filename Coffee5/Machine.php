<?php
session_start();
require_once 'config.php';

// Create database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all products
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);

// Fetch products from the database
$product_query = $conn->query("SELECT * FROM products");
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Machines - Coffee Shop</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .product-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* 4 items in a row */
        gap: 15px; /* Space between items */
        max-width: 400px; /* Adjusted max-width to make it smaller */
        margin: 0 auto; /* Center the container */
}

.product-item {
    border: 1px solid #ccc; /* Optional: Add border to items */
    padding: 5px; /* Reduced padding */
    text-align: center; /* Center the text */
    max-width: 150px; /* Adjusted max-width to make it thinner */
}


        .product-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .product-image img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .product-title {
            font-size: 1.5rem;
            margin: 1rem 0;
            color: #333;
        }

        .product-description {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .product-price {
            font-size: 1.25rem;
            color: #2c3e50;
            font-weight: bold;
            margin: 0.5rem 0;
        }

        .stock-info {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .quantity-selector {
            margin: 1rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .quantity-input {
            width: 60px;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }

        .add-to-cart-btn {
            background: #2c3e50;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
        }

        .add-to-cart-btn:hover {
            background: #34495e;
        }

        .no-products {
            grid-column: 1 / -1;
            text-align: center;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <header>
    <?php include 'navbar.php'; ?>
    </header>

    <main>
    <main>
        <div class="product-container">
            <div class="product-card">
                <img src="image/distr.jpg" height="300" width="300" alt="Brazil Coffee">
                <h3>Distributer</h3>
                <p class="price">Rs402.33 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="1">
                    <input type="hidden" name="product_name" value="Distributer">
                    <input type="hidden" name="product_price" value="402.33">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>

            <div class="product-card">
                <img src="image/scale.jpg" height="300" width="300" alt="Brazil Coffee">
                <h3>Scale</h3>
                <p class="price">Rs400.33 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="2">
                    <input type="hidden" name="product_name" value="Scale">
                    <input type="hidden" name="product_price" value="400.33">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>

            <div class="product-card">
                <img src="image/paper.jpg" height="300" width="300" alt="Brazil Coffee">
                <h3>V60 paper</h3>
                <p class="price">Rs350 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="3">
                    <input type="hidden" name="product_name" value="V60 paper">
                    <input type="hidden" name="product_price" value="350">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>

            <div class="product-card">
                <img src="image/pitch.jpg" height="300" width="300" alt="Brazil Coffee">
                <h3>Pitcher</h3>
                <p class="price">Rs402.33 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="4">
                    <input type="hidden" name="product_name" value="Pitcher">
                    <input type="hidden" name="product_price" value="402.33">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>
        </div>
    </main>

    <main>
        <div class="product-container">
            <div class="product-card">
                <img src="image/store.avif" height="300" width="300" alt="Brazil Coffee">
                <h3>Storage</h3>
                <p class="price">Rs402.33 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="5">
                    <input type="hidden" name="product_name" value="Storage">
                    <input type="hidden" name="product_price" value="402.33">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>

            <div class="product-card">
                <img src="image/mach.avif" height="300" width="300" alt="Brazil Coffee">
                <h3>Machine</h3>
                <p class="price">Rs400.33 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="6">
                    <input type="hidden" name="product_name" value="Machine">
                    <input type="hidden" name="product_price" value="400.33">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>

            <div class="product-card">
                <img src="image/exnedle.jpg" height="300" width="300" alt="Brazil Coffee">
                <h3>Express Needle</h3>
                <p class="price">Rs350 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="7">
                    <input type="hidden" name="product_name" value="Express Needle">
                    <input type="hidden" name="product_price" value="350">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>

            <div class="product-card">
                <img src="image/filt.avif" height="300" width="300" alt="Brazil Coffee">
                <h3>Filter</h3>
                <p class="price">Rs402.33 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="8">
                    <input type="hidden" name="product_name" value="Filter">
                    <input type="hidden" name="product_price" value="402.33">
                    <button class="add-to-cart">Add to cart</button>
                </form>
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
</body>
</html>