<?php include("../db.php"); ?>
<?php $activePage = 'dashboard'; ?>


<?php
if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}
?>





<?php
function safeCount($conn, $query, $col = 'count'){
    try {
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row[$col] ?? 0;
    } catch (mysqli_sql_exception $e) {
        return 0;
    }
}

$totalProducts = safeCount($conn, "SELECT COUNT(*) as count FROM products");
$totalCategories = 2;
$totalSubcategories = 14;
$totalOrders = safeCount($conn, "SELECT COUNT(*) as count FROM orders");
$totalRevenue = safeCount($conn, "SELECT SUM(total_amount) as total FROM orders", 'total');
$pending = safeCount($conn, "SELECT COUNT(*) as count FROM orders WHERE status='Pending'");
$delivered = safeCount($conn, "SELECT COUNT(*) as count FROM orders WHERE status='Delivered'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Purity Admin - Dashboard</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
</head>
<body class="admin-body">

<div class="admin-wrapper">

    <?php include("sidebar.php"); ?>

    <!-- MAIN CONTENT -->
    <main class="admin-main">

        <div class="admin-topbar">
            <div>
                <h1>Dashboard</h1>
                <p class="topbar-sub">Here's what's happening with your store today.</p>
            </div>
            <div class="admin-profile">
                <i class="fa fa-circle-user"></i>
                <span>Welcome, Admin</span>
            </div>
        </div>

        <div class="stat-cards">

            <div class="stat-card">
                <div class="stat-icon icon-pink"><i class="fa fa-box"></i></div>
                <div>
                    <p>Total Products</p>
                    <h2><?php echo $totalProducts; ?></h2>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-orange"><i class="fa fa-cart-shopping"></i></div>
                <div>
                    <p>Total Orders</p>
                    <h2><?php echo $totalOrders; ?></h2>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-green"><i class="fa fa-folder"></i></div>
                <div>
                    <p>Total Categories</p>
                    <h2><?php echo $totalCategories; ?></h2>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-blue"><i class="fa fa-layer-group"></i></div>
                <div>
                    <p>Total Subcategories</p>
                    <h2><?php echo $totalSubcategories; ?></h2>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-maroon"><i class="fa fa-indian-rupee-sign"></i></div>
                <div>
                    <p>Total Revenue</p>
                    <h2>₹<?php echo number_format($totalRevenue, 0); ?></h2>
                </div>
            </div>

        </div>

        <div class="chart-card">
            <h3>Order Status</h3>
            <canvas id="orderChart"></canvas>
        </div>

    </main>

</div>

<script>
const ctx = document.getElementById('orderChart').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Pending', 'Delivered'],
        datasets: [{
            label: 'Orders',
            data: [<?php echo $pending; ?>, <?php echo $delivered; ?>],
            backgroundColor: ['#f5a623', '#1a7a1a'],
            borderRadius: 6,
            barThickness: 80
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top', align: 'start' }
        },
        scales: {
            y: { beginAtZero: true, grid: { color: '#eee' } },
            x: { grid: { display: false } }
        }
    }
});
</script>

</body>
</html>