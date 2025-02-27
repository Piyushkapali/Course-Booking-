<?php
session_start();
require_once '../config.php';

// Ensure admin authentication
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Handle inventory actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    switch($action) {
        case 'add':
            $stmt = $conn->prepare("INSERT INTO inventory (name, category, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssid", $_POST['name'], $_POST['category'], $_POST['quantity'], $_POST['price']);
            $stmt->execute();
            break;

        case 'update':
            $stmt = $conn->prepare("UPDATE inventory SET quantity = ?, price = ? WHERE id = ?");
            $stmt->bind_param("idi", $_POST['quantity'], $_POST['price'], $_POST['id']);
            $stmt->execute();
            break;

        case 'delete':
            $stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
            $stmt->bind_param("i", $_POST['id']);
            $stmt->execute();
            break;
    }
}

// Fetch inventory items
$inventory_result = $conn->query("SELECT * FROM inventory");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inventory Management - Coffee5</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <!-- Same sidebar as dashboard -->
        </aside>
        
        <main class="main-content">
            <h2>Inventory Management</h2>
            
            <div class="inventory-actions">
                <h3>Add New Item</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="text" name="name" placeholder="Item Name" required>
                    <select name="category" required>
                        <option value="coffee_beans">Coffee Beans</option>
                        <option value="machines">Machines</option>
                        <option value="accessories">Accessories</option>
                    </select>
                    <input type="number" name="quantity" placeholder="Quantity" required>
                    <input type="number" step="0.01" name="price" placeholder="Price" required>
                    <button type="submit">Add Item</button>
                </form>
            </div>

            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($item = $inventory_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['category']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <input type="number" name="quantity" placeholder="New Qty">
                                <input type="number" step="0.01" name="price" placeholder="New Price">
                                <button type="submit">Update</button>
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
