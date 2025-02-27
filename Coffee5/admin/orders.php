<?php
require_once 'includes/header.php';

// Handle order status updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    
    if ($stmt->execute()) {
        $success_message = "Order #$order_id status updated successfully!";
    } else {
        $error_message = "Error updating order status.";
    }
}

// Get filter parameters
$status_filter = $_GET['status'] ?? 'all';
$date_range = $_GET['date_range'] ?? 'all';
$search = $_GET['search'] ?? '';

// Build query
$query = "SELECT o.*, u.username 
          FROM orders o 
          LEFT JOIN users u ON o.user_id = u.id 
          WHERE 1=1";

if ($status_filter != 'all') {
    $query .= " AND o.status = '$status_filter'";
}

if ($date_range != 'all') {
    switch($date_range) {
        case 'today':
            $query .= " AND DATE(o.order_date) = CURDATE()";
            break;
        case 'week':
            $query .= " AND o.order_date >= DATE_SUB(NOW(), INTERVAL 1 WEEK)";
            break;
        case 'month':
            $query .= " AND o.order_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
            break;
    }
}

if ($search) {
    $query .= " AND (o.id LIKE '%$search%' OR u.username LIKE '%$search%')";
}

$query .= " ORDER BY o.order_date DESC";

$orders_result = $conn->query($query);
?>

<div class="page-header">
    <h2>Order Management</h2>
    <div class="actions">
        <button class="btn btn-primary" onclick="exportOrders()">
            <i class="fas fa-download"></i> Export Orders
        </button>
    </div>
</div>

<?php if (isset($success_message)): ?>
    <div class="alert alert-success"><?php echo $success_message; ?></div>
<?php endif; ?>

<?php if (isset($error_message)): ?>
    <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>

<div class="filters">
    <form method="GET" class="filter-form">
        <div class="form-group">
            <label>Status:</label>
            <select name="status" onchange="this.form.submit()">
                <option value="all" <?php echo $status_filter == 'all' ? 'selected' : ''; ?>>All Status</option>
                <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="processing" <?php echo $status_filter == 'processing' ? 'selected' : ''; ?>>Processing</option>
                <option value="completed" <?php echo $status_filter == 'completed' ? 'selected' : ''; ?>>Completed</option>
                <option value="cancelled" <?php echo $status_filter == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Date Range:</label>
            <select name="date_range" onchange="this.form.submit()">
                <option value="all" <?php echo $date_range == 'all' ? 'selected' : ''; ?>>All Time</option>
                <option value="today" <?php echo $date_range == 'today' ? 'selected' : ''; ?>>Today</option>
                <option value="week" <?php echo $date_range == 'week' ? 'selected' : ''; ?>>This Week</option>
                <option value="month" <?php echo $date_range == 'month' ? 'selected' : ''; ?>>This Month</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Search:</label>
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Order ID or Customer">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($order = $orders_result->fetch_assoc()): ?>
            <tr>
                <td>#<?php echo $order['id']; ?></td>
                <td><?php echo htmlspecialchars($order['username']); ?></td>
                <td>
                    <button class="btn btn-sm" onclick="viewOrderItems(<?php echo $order['id']; ?>)">
                        View Items
                    </button>
                </td>
                <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                <td>
                    <form method="POST" class="status-form">
                        <input type="hidden" name="action" value="update_status">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <select name="status" onchange="this.form.submit()" class="status-select <?php echo $order['status']; ?>">
                            <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                            <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </form>
                </td>
                <td><?php echo date('M d, Y H:i', strtotime($order['order_date'])); ?></td>
                <td>
                    <button class="btn btn-sm" onclick="printOrder(<?php echo $order['id']; ?>)">
                        <i class="fas fa-print"></i>
                    </button>
                    <button class="btn btn-sm" onclick="emailOrder(<?php echo $order['id']; ?>)">
                        <i class="fas fa-envelope"></i>
                    </button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function viewOrderItems(orderId) {
    // Implement modal to show order items
    alert('View items for Order #' + orderId);
}

function printOrder(orderId) {
    window.open('print_order.php?id=' + orderId, '_blank');
}

function emailOrder(orderId) {
    // Implement email functionality
    alert('Email order details for Order #' + orderId);
}

function exportOrders() {
    window.location.href = 'export_orders.php?' + new URLSearchParams(window.location.search);
}
</script>

<?php require_once 'includes/footer.php'; ?>
