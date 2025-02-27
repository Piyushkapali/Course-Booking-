<?php
require_once 'includes/header.php';

// Get date range parameters
$start_date = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
$end_date = $_GET['end_date'] ?? date('Y-m-d');

// Sales Overview
$sales_query = "SELECT 
    COUNT(*) as total_orders,
    SUM(total_price) as total_revenue,
    AVG(total_price) as avg_order_value,
    COUNT(DISTINCT user_id) as unique_customers
FROM orders 
WHERE order_date BETWEEN ? AND ?";

$stmt = $conn->prepare($sales_query);
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$sales_overview = $stmt->get_result()->fetch_assoc();

// Top Products
$top_products_query = "SELECT 
    p.name,
    COUNT(*) as order_count,
    SUM(oi.quantity) as total_quantity,
    SUM(oi.quantity * oi.price) as total_revenue
FROM order_items oi
JOIN products p ON oi.product_id = p.id
JOIN orders o ON oi.order_id = o.id
WHERE o.order_date BETWEEN ? AND ?
GROUP BY p.id
ORDER BY total_revenue DESC
LIMIT 5";

$stmt = $conn->prepare($top_products_query);
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$top_products = $stmt->get_result();

// Daily Sales Trend
$daily_sales_query = "SELECT 
    DATE(order_date) as date,
    COUNT(*) as order_count,
    SUM(total_price) as revenue
FROM orders
WHERE order_date BETWEEN ? AND ?
GROUP BY DATE(order_date)
ORDER BY date";

$stmt = $conn->prepare($daily_sales_query);
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$daily_sales = $stmt->get_result();

$trend_data = [
    'labels' => [],
    'orders' => [],
    'revenue' => []
];

while ($row = $daily_sales->fetch_assoc()) {
    $trend_data['labels'][] = date('M d', strtotime($row['date']));
    $trend_data['orders'][] = $row['order_count'];
    $trend_data['revenue'][] = $row['revenue'];
}
?>

<div class="page-header">
    <h2>Sales Reports & Analytics</h2>
    <div class="date-range-picker">
        <form method="GET" class="filter-form">
            <div class="form-group">
                <label>From:</label>
                <input type="date" name="start_date" value="<?php echo $start_date; ?>">
            </div>
            <div class="form-group">
                <label>To:</label>
                <input type="date" name="end_date" value="<?php echo $end_date; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Report</button>
        </form>
    </div>
</div>

<div class="metrics-grid">
    <div class="metric-card">
        <i class="fas fa-shopping-cart"></i>
        <h3>Total Orders</h3>
        <p><?php echo number_format($sales_overview['total_orders']); ?></p>
    </div>
    <div class="metric-card">
        <i class="fas fa-dollar-sign"></i>
        <h3>Total Revenue</h3>
        <p>$<?php echo number_format($sales_overview['total_revenue'], 2); ?></p>
    </div>
    <div class="metric-card">
        <i class="fas fa-receipt"></i>
        <h3>Average Order Value</h3>
        <p>$<?php echo number_format($sales_overview['avg_order_value'], 2); ?></p>
    </div>
    <div class="metric-card">
        <i class="fas fa-users"></i>
        <h3>Unique Customers</h3>
        <p><?php echo number_format($sales_overview['unique_customers']); ?></p>
    </div>
</div>

<div class="report-grid">
    <div class="report-card">
        <h3>Sales Trend</h3>
        <canvas id="salesTrendChart"></canvas>
    </div>
    
    <div class="report-card">
        <h3>Top Selling Products</h3>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Orders</th>
                        <th>Quantity</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($product = $top_products->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo number_format($product['order_count']); ?></td>
                        <td><?php echo number_format($product['total_quantity']); ?></td>
                        <td>$<?php echo number_format($product['total_revenue'], 2); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="report-actions">
    <button class="btn btn-primary" onclick="exportReport('pdf')">
        <i class="fas fa-file-pdf"></i> Export PDF
    </button>
    <button class="btn btn-primary" onclick="exportReport('excel')">
        <i class="fas fa-file-excel"></i> Export Excel
    </button>
    <button class="btn btn-primary" onclick="emailReport()">
        <i class="fas fa-envelope"></i> Email Report
    </button>
</div>

<script>
// Sales Trend Chart
const ctx = document.getElementById('salesTrendChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($trend_data['labels']); ?>,
        datasets: [{
            label: 'Revenue ($)',
            data: <?php echo json_encode($trend_data['revenue']); ?>,
            borderColor: '#3498db',
            backgroundColor: 'rgba(52, 152, 219, 0.1)',
            yAxisID: 'y',
            fill: true
        }, {
            label: 'Orders',
            data: <?php echo json_encode($trend_data['orders']); ?>,
            borderColor: '#2ecc71',
            backgroundColor: 'rgba(46, 204, 113, 0.1)',
            yAxisID: 'y1',
            fill: true
        }]
    },
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Revenue ($)'
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Number of Orders'
                },
                grid: {
                    drawOnChartArea: false
                }
            }
        }
    }
});

function exportReport(format) {
    const params = new URLSearchParams(window.location.search);
    params.append('format', format);
    window.location.href = 'export_report.php?' + params.toString();
}

function emailReport() {
    // Implement email functionality
    alert('Report will be emailed to the configured address.');
}
</script>

<?php require_once 'includes/footer.php'; ?>
