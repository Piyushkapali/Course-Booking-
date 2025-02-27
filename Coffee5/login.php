<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Coffee Shop</title>
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
            margin: 0;
        }
        .login-container {
            flex: 1;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('image/coffee-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 50px 0;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        .login-form {
            padding: 30px;
        }
        .login-form h2 {
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
        .btn-login {
            background: #4a3500;
            color: white;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: #6b4e00;
            transform: translateY(-2px);
        }
        .signup-link {
            margin-top: 20px;
            text-align: center;
        }
        .signup-link a {
            color: #4a3500;
            text-decoration: none;
            font-weight: 600;
        }
        .signup-link a:hover {
            color: #6b4e00;
        }
        .input-group-text {
            background: transparent;
            border-radius: 25px;
            border: 1px solid #ddd;
        }
        .footer {
            background-color: #4a3500;
            color: white;
            text-align: center;
            padding: 20px 0;
            width: 100%;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <main class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card">
                        <div class="login-form">
                            <h2 class="text-center mb-4">Welcome Back!</h2>
                            <form action="login_process.php" method="post">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="login-email" name="email" placeholder="Email Address" required>
                                </div>

                                <div class="input-group mb-4">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-login">Login</button>
                                </div>

                                <div class="signup-link">
                                    <p class="mb-0">Don't have an account? <a href="Signup.php">Sign Up</a></p>
                                    <p class="mb-0">Forgot Password? <a href="forgot_password.php">Forgot Password?</a></p>
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
</body>
</html>