<?php
require_once 'includes/header.php';

// Handle user actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    switch($action) {
        case 'update_status':
            $user_id = $_POST['user_id'];
            $status = $_POST['status'];
            
            $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $user_id);
            
            if ($stmt->execute()) {
                $success_message = "User status updated successfully!";
            } else {
                $error_message = "Error updating user status.";
            }
            break;
            
        case 'reset_password':
            $user_id = $_POST['user_id'];
            $temp_password = bin2hex(random_bytes(8)); // Generate random password
            $hashed_password = password_hash($temp_password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashed_password, $user_id);
            
            if ($stmt->execute()) {
                $success_message = "Password reset successfully! Temporary password: " . $temp_password;
                // In production, you would email this to the user instead of displaying it
            } else {
                $error_message = "Error resetting password.";
            }
            break;
    }
}

// Get filter parameters
$status_filter = $_GET['status'] ?? 'all';
$role_filter = $_GET['role'] ?? 'all';
$search = $_GET['search'] ?? '';

// Build query
$query = "SELECT * FROM users WHERE 1=1";

if ($status_filter != 'all') {
    $query .= " AND status = '$status_filter'";
}

if ($role_filter != 'all') {
    $query .= " AND role = '$role_filter'";
}

if ($search) {
    $query .= " AND (username LIKE '%$search%' OR email LIKE '%$search%')";
}

$query .= " ORDER BY created_at DESC";

$users_result = $conn->query($query);

// Get user statistics
$stats = [
    'total' => $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'],
    'active' => $conn->query("SELECT COUNT(*) as count FROM users WHERE status = 'active'")->fetch_assoc()['count'],
    'inactive' => $conn->query("SELECT COUNT(*) as count FROM users WHERE status = 'inactive'")->fetch_assoc()['count'],
    'new_this_month' => $conn->query("SELECT COUNT(*) as count FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)")->fetch_assoc()['count']
];
?>

<div class="page-header">
    <h2>User Management</h2>
    <div class="actions">
        <button class="btn btn-primary" onclick="exportUsers()">
            <i class="fas fa-download"></i> Export Users
        </button>
    </div>
</div>

<?php if (isset($success_message)): ?>
    <div class="alert alert-success"><?php echo $success_message; ?></div>
<?php endif; ?>

<?php if (isset($error_message)): ?>
    <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Users</h3>
        <p><?php echo number_format($stats['total']); ?></p>
    </div>
    <div class="stat-card">
        <h3>Active Users</h3>
        <p><?php echo number_format($stats['active']); ?></p>
    </div>
    <div class="stat-card">
        <h3>Inactive Users</h3>
        <p><?php echo number_format($stats['inactive']); ?></p>
    </div>
    <div class="stat-card">
        <h3>New This Month</h3>
        <p><?php echo number_format($stats['new_this_month']); ?></p>
    </div>
</div>

<div class="filters">
    <form method="GET" class="filter-form">
        <div class="form-group">
            <label>Status:</label>
            <select name="status" onchange="this.form.submit()">
                <option value="all" <?php echo $status_filter == 'all' ? 'selected' : ''; ?>>All Status</option>
                <option value="active" <?php echo $status_filter == 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?php echo $status_filter == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Role:</label>
            <select name="role" onchange="this.form.submit()">
                <option value="all" <?php echo $role_filter == 'all' ? 'selected' : ''; ?>>All Roles</option>
                <option value="user" <?php echo $role_filter == 'user' ? 'selected' : ''; ?>>User</option>
                <option value="premium" <?php echo $role_filter == 'premium' ? 'selected' : ''; ?>>Premium</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Search:</label>
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Username or Email">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Joined Date</th>
                <th>Last Login</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = $users_result->fetch_assoc()): ?>
            <tr>
                <td>#<?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><span class="role-badge <?php echo $user['role']; ?>"><?php echo ucfirst($user['role']); ?></span></td>
                <td>
                    <form method="POST" class="status-form">
                        <input type="hidden" name="action" value="update_status">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <select name="status" onchange="this.form.submit()" class="status-select <?php echo $user['status']; ?>">
                            <option value="active" <?php echo $user['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $user['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </form>
                </td>
                <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                <td><?php echo $user['last_login'] ? date('M d, Y H:i', strtotime($user['last_login'])) : 'Never'; ?></td>
                <td>
                    <button class="btn btn-sm" onclick="viewUserDetails(<?php echo $user['id']; ?>)">
                        <i class="fas fa-eye"></i>
                    </button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="reset_password">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" class="btn btn-sm" onclick="return confirm('Are you sure you want to reset this user\'s password?')">
                            <i class="fas fa-key"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function viewUserDetails(userId) {
    // Implement modal to show user details
    window.location.href = 'user_details.php?id=' + userId;
}

function exportUsers() {
    window.location.href = 'export_users.php?' + new URLSearchParams(window.location.search);
}
</script>

<?php require_once 'includes/footer.php'; ?>
