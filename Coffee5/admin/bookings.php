<?php
session_start();
require_once '../config.php';

// Handle all booking actions
if (isset($_POST['action']) && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    switch($action) {
        case 'confirm':
            $status = 'confirmed';
            $message = "Booking has been successfully confirmed!";
            
            // Get the user's email to store message
            $stmt = $conn->prepare("SELECT email FROM course_bookings WHERE id = ?");
            $stmt->bind_param("i", $booking_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $booking = $result->fetch_assoc();
            $stmt->close();
            
            if ($booking) {
                // Store message in a session variable
                $_SESSION['user_messages'][$booking['email']] = "Thank you! Your booking has been confirmed.";
            }
            break;
        case 'cancel':
            $status = 'cancelled';
            $message = "Booking has been cancelled.";
            break;
    }

    // Update the booking status
    $stmt = $conn->prepare("UPDATE course_bookings SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $booking_id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['confirmation_message'] = $message;
    $conn->close();
    header("Location: bookings.php");
    exit();
}

// Fetch course booking details with filtering
$time_slot = isset($_GET['time_slot']) ? $_GET['time_slot'] : '';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Build the query based on filters
$query = "SELECT * FROM course_bookings";

if ($time_slot) {
    $query .= " WHERE preferred_time = '" . $conn->real_escape_string($time_slot) . "'";
}

$query .= " ORDER BY booking_date DESC";

$booking_query = $conn->query($query);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings - Coffee5</title>
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
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        .filter-section {
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .filter-buttons {
            display: flex;
            gap: 10px;
            margin: 15px 0;
        }
        .filter-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: #2c3e50;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .filter-button:hover {
            background: #34495e;
        }
        .filter-button.active {
            background: #27ae60;
        }
        .filter-section h3 {
            margin-bottom: 10px;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f0f0f0;
            color: #2c3e50;
            font-weight: 600;
        }
        tr:hover {
            background-color: #f8f9fa;
        }
        .btn-confirm, .btn-cancel {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 5px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-confirm {
            background-color: #27ae60;
        }
        .btn-cancel {
            background-color: #e74c3c;
        }
        .btn-confirm:hover {
            background-color: #219a52;
            transform: translateY(-2px);
        }
        .btn-cancel:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.85em;
        }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .status-pending { background: #fff3cd; color: #856404; }
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
                <h1><i class="fas fa-calendar-alt"></i> Course Bookings</h1>
                
                <div class="filter-section">
                    <h3>Filter by Time Slot</h3>
                    <div class="filter-buttons">
                        <a href="bookings.php" class="filter-button <?php echo !$time_slot ? 'active' : ''; ?>">
                           All Time Slots
                        </a>
                        <a href="bookings.php?time_slot=morning" class="filter-button <?php echo $time_slot === 'morning' ? 'active' : ''; ?>">
                           Morning
                        </a>
                        <a href="bookings.php?time_slot=afternoon" class="filter-button <?php echo $time_slot === 'afternoon' ? 'active' : ''; ?>">
                           Afternoon
                        </a>
                        <a href="bookings.php?time_slot=evening" class="filter-button <?php echo $time_slot === 'evening' ? 'active' : ''; ?>">
                           Evening
                        </a>
                    </div>
                </div>

                <?php if (isset($_SESSION['confirmation_message'])): ?>
                    <p style="color: green;"><?php echo $_SESSION['confirmation_message']; ?></p>
                    <?php unset($_SESSION['confirmation_message']); ?>
                <?php endif; ?>

                <?php if ($booking_query->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Course</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Time Slot</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($booking = $booking_query->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $booking['id']; ?></td>
                            <td><?php echo htmlspecialchars($booking['package']); ?></td>
                            <td><?php echo htmlspecialchars($booking['name']); ?></td>
                            <td><?php echo date('F j, Y', strtotime($booking['booking_date'])); ?></td>
                            <td><?php echo ucfirst($booking['preferred_time']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $booking['status']; ?>">
                                    <?php echo ucfirst($booking['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($booking['status'] !== 'confirmed' && $booking['status'] !== 'cancelled'): ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                        <button type="submit" name="action" value="confirm" class="btn-confirm">
                                            <i class="fas fa-check"></i> Confirm
                                        </button>
                                        <button type="submit" name="action" value="cancel" class="btn-cancel">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p>No bookings found.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
