<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Coffee Shop</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .navbar {
            background-color: #333;
            overflow: hidden;
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
    </style>
</head>
<body>

    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <main>
        <section class="about-us">
            <h1>About Us</h1>
            <div class="video-container">
                <video controls autoplay muted loop>
                    <source src="../image/cofffee.mp4"  type="video/mp4">
                </video>
                <div class="about-info">
                    <h3>Our Story</h3>
                    <p>Welcome to Coffee Shop, where our passion for coffee meets our commitment to quality. Established in 2020, we have been serving the finest coffee to our community. Our journey began with a simple idea: to create a place where coffee lovers can come together and enjoy the perfect cup of coffee.</p>
                    <h3>Our Team</h3>
                    <p>Our team of skilled baristas and coffee enthusiasts are dedicated to providing you with an exceptional coffee experience. From selecting the best beans to mastering the art of brewing, we take pride in every step of the process.</p>
                    <h3>Our Mission</h3>
                    <p>Our mission is to bring people together through the love of coffee. We believe that coffee is more than just a beverage; it's a way to connect, relax, and enjoy the moment. Join us on our journey and discover the true essence of coffee.</p>
                </div>
            </div>
        </section>
    </main>
    
    <footer class="footer">
        <div class="social-links">
        <a href="https://www.facebook.com/piyush.kapali.9"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/piyush.kapali"><i class="fab fa-instagram"></i></a>
            <a href="https://www.youtube.com/@piyushkapali3821"><i class="fab fa-youtube"></i></a>
        </div>
        <p>&copy; 2025 Coffee Shop. All rights reserved.</p>
    </footer>

    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../script.js"></script>
</body>
</html>