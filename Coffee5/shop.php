<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Coffee Shop</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .shop-container {
            flex: 1;
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('image/coffee-shop-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 50px 0;
        }
        .category-title {
            color: #fff;
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .product-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 30px;
            width: 100%; /* Make the card full width */
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
        }
        .product-image {
            position: relative;
            overflow: hidden;
            height: 500px;
        }
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .product-card:hover .product-image img {
            transform: scale(1.1);
        }
        .product-details {
            padding: 20px;
            text-align: center;
            background: linear-gradient(to bottom, rgba(255,255,255,0.9), rgba(255,255,255,1));
        }
        .product-title {
            color: #4a3500;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 15px;
            text-decoration: none;
        }
        .btn-shop {
            background: #4a3500;
            color: white;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            border: none;
            width: 100%;
        }
        .btn-shop:hover {
            background: #6b4e00;
            transform: translateY(-2px);
            color: white;
        }
        .product-description {
            color: #666;
            margin-bottom: 20px;
        }
        
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <main class="shop-container">
        <div class="container">
            <h1 class="category-title">Our Products</h1>
            <div class="row justify-content-center">
                <!-- Coffee Machines -->
                <div class="col-md-8">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="image/coffes.PNG" height="500" width="1000" alt="Coffee Machines">
                        </div>
                        <div class="product-details">
                            <h3 class="product-title">Coffee Machinery</h3>
                            <p class="product-description">
                                Discover our premium selection of professional coffee machines and equipment.
                                Perfect for both home baristas and commercial establishments.
                            </p>
                            <a href="Machine.php" class="btn btn-shop">
                                <i class="fas fa-shopping-cart me-2"></i>Shop Machines
                            </a>
                        </div>
                    </div>
                </div>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>