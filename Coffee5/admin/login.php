<?php
session_start();
require_once '../config.php';

// Handle logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Check if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // Get user data
    $stmt = $conn->prepare("SELECT id, username, password, role FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        
        // Check plain text password
        if ($password === $admin['password']) {
            // Set session variables
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_role'] = $admin['role'];
            
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
    
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Coffee5</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #565452;
            background-image: url(../image/img2.webp);
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(10px);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header h2 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }
        .login-header p {
            color: #666;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-group input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        .error {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            text-align: center;
            border: 1px solid rgba(231, 76, 60, 0.2);
        }
        button {
            width: 100%;
            padding: 1rem;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #2980b9;
        }
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo img {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="../image/log.png" alt="Coffee5 Logo">
        </div>
        <div class="login-header">
            <h2>Admin Panel</h2>
            <p>Please login to continue</p>
        </div>
        
        <?php if ($error): ?>
            <div class="error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
    </div>
</body>
</html>
