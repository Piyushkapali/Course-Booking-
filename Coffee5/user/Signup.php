<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Coffee Shop</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .signup-container {
            min-height: calc(100vh - 200px);
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('image/coffee-beans.jpg');
            background-size: cover;
            background-position: center;
            padding: 50px 0;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        .signup-form {
            padding: 30px;
        }
        .signup-form h2 {
            color: #4a3500;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .form-control {
            border-radius: 25px;
            padding: 12px 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        .btn-signup {
            background: #4a3500;
            color: white;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-signup:hover {
            background: #6b4e00;
            transform: translateY(-2px);
        }
        .login-link {
            margin-top: 20px;
            text-align: center;
        }
        .login-link a {
            color: #4a3500;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            color: #6b4e00;
        }
        .input-group-text {
            background: transparent;
            border-radius: 25px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <main class="signup-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card">
                        <div class="signup-form">
                            <h2 class="text-center mb-4">Create Account</h2>
                            <form action="signup_process.php" method="post">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" id="signup-name" name="name" placeholder="Full Name" required>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="signup-email" name="email" placeholder="Email Address" required>
                                </div>

                                <div class="input-group mb-4">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="signup-password" name="password" placeholder="Password" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-signup">Create Account</button>
                                </div>

                                <div class="login-link">
                                    <p class="mb-0">Already have an account? <a href="login.php">Login</a></p>
                                </div>
                            </form>
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
    <script src="../script.js"></script>
</body>
</html>