<?php
session_start();
require_once '../config.php';

// Ensure only logged-in admins can access
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    // File upload handling
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $filename = $_FILES['image']['name'];
        $filetype = $_FILES['image']['type'];
        $filesize = $_FILES['image']['size'];

        // Verify file type
        if (!in_array($filetype, $allowed_types)) {
            $_SESSION['error_message'] = 'Error: Please select a valid image file (JPG, PNG, or GIF).';
            header('Location: add_product.php');
            exit();
        }

        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) {
            $_SESSION['error_message'] = 'Error: File size is larger than the allowed limit (5MB).';
            header('Location: add_product.php');
            exit();
        }

        // Process upload
        $target_dir = "uploads/";
        $target_file = $target_dir . uniqid() . '_' . basename($filename);

        if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // File uploaded successfully, now insert into database
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($conn->connect_error) {
                $_SESSION['error_message'] = "Connection failed: " . $conn->connect_error;
                header('Location: add_product.php');
                exit();
            }

            $stmt = $conn->prepare("INSERT INTO product (name, image, price) VALUES (?, ?, ?)");
            $stmt->bind_param("ssd", $name, $target_file, $price);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Product added successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to add product: " . $conn->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            $_SESSION['error_message'] = 'Error: Failed to upload file.';
        }
    } else {
        $_SESSION['error_message'] = 'Error: Please select an image file.';
    }
    
    header('Location: add_product.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Coffee5 Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px;
            transition: width 0.3s;
        }
        .sidebar:hover {
            width: 300px;
        }
        .sidebar h1 {
            margin-bottom: 30px;
            font-size: 24px;
        }
        .sidebar ul {
            list-style: none;
        }
        .sidebar li {
            margin-bottom: 15px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background: #34495e;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-header {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }
        .form-group input[type="file"] {
            padding: 10px 0;
        }
        .preview-section {
            margin-top: 20px;
            text-align: center;
        }
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            display: none;
            margin: 10px auto;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn-submit {
            background-color: #2ecc71;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
        }
        .btn-submit:hover {
            background-color: #27ae60;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h1>Coffee5 Admin</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="products.php"><i class="fas fa-box"></i> Cart</a></li>
                    <li><a href="bookings.php"><i class="fas fa-calendar"></i> Bookings</a></li>
                    <li><a href="add_product.php"><i class="fas fa-coffee"></i> Product</a></li>
                    <li><a href="login.php?action=logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <div class="container">
                <div class="form-header">
                    <h1><i class="fas fa-coffee"></i> Add New Product</h1>
                    <p>Add a new product to your coffee shop inventory</p>
                </div>

                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-error">
                        <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name"><i class="fas fa-tag"></i> Product Name</label>
                        <input type="text" id="name" name="name" required placeholder="Enter product name">
                    </div>

                    <div class="form-group">
                        <label for="image"><i class="fas fa-image"></i> Product Image</label>
                        <input type="file" id="image" name="image" required accept="image/*" onchange="previewImage(this)">
                    </div>

                    <div class="preview-section">
                        <img id="preview" class="preview-image" src="#" alt="Preview">
                    </div>

                    <div class="form-group">
                        <label for="price"><i class="fas fa-dollar-sign"></i> Product Price</label>
                        <input type="number" step="0.01" id="price" name="price" required placeholder="Enter price">
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-plus-circle"></i> Add Product
                    </button>
                </form>
            </div>
        </main>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>
