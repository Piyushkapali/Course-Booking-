<?php
require_once 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Coffee Shop</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }
        .forgot-password-container {
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
        .form-container {
            padding: 30px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <main class="forgot-password-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card">
                        <div class="form-container">
                            <h2 class="text-center mb-4">Reset Password</h2>
                            <?php
                            if (isset($_SESSION['message'])) {
                                echo '<div class="alert alert-' . $_SESSION['message_type'] . '">';
                                echo htmlspecialchars($_SESSION['message']);
                                echo '</div>';
                                unset($_SESSION['message']);
                                unset($_SESSION['message_type']);
                            }
                            ?>
                            <form action="reset_password_process.php" method="post">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" name="new_password" placeholder="New Password" required minlength="8">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm New Password" required minlength="8">
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Reset Password</button>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="login.php">Back to Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="footer">
        <p>&copy; 2025 Coffee Shop. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
