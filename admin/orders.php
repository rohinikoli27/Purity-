<?php include("../db.php"); ?>

<?php
if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}
?>

<?php $activePage = 'orders'; ?>

<?php
// Handle status update
if(isset($_POST['update_status'])){
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    $stmt = mysqli_prepare($conn, "UPDATE orders SET status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "si", $new_status, $order_id);
    mysqli_stmt_execute($stmt);

    header("Location: orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Purity Admin - Orders</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="admin-body">

<div class="admin-wrapper">

    <?php include("sidebar.php"); ?>

    <main class="admin-main">

        <div class="products-topbar">
            <h1>Orders</h1>
        </div>

        <div class="table-card">

            <table class="product-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");

                    if($result && mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo '<tr>';
                            echo '<td>#'.$row['id'].'</td>';
                            echo '<td>'.htmlspecialchars($row['customer_name']).'</td>';
                            echo '<td>'.htmlspecialchars($row['phone']).'</td>';
                            echo '<td>'.htmlspecialchars($row['address']).'</td>';
                            echo '<td>₹'.number_format($row['total_amount'],2).'</td>';
                            echo '<td>'.$row['payment_method'].'</td>';
                            echo '<td>
                                    <form method="POST" action="orders.php" style="display:flex;gap:8px;align-items:center;">
                                        <input type="hidden" name="order_id" value="'.$row['id'].'">
                                        <select name="status" class="status-select" onchange="this.form.submit()">
                                            <option value="Pending" '.($row['status']=='Pending'?'selected':'').'>Pending</option>
                                            <option value="Delivered" '.($row['status']=='Delivered'?'selected':'').'>Delivered</option>
                                            <option value="Cancelled" '.($row['status']=='Cancelled'?'selected':'').'>Cancelled</option>
                                        </select>
                                        <input type="hidden" name="update_status" value="1">
                                    </form>
                                  </td>';
                            echo '<td>'.date('d M Y', strtotime($row['created_at'])).'</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8" style="text-align:center;padding:30px;">No orders yet.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>

        </div>

    </main>

</div>

</body>
</html>