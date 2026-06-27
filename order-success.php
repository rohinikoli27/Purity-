<?php include("header.php"); ?>
<?php include("db.php"); ?>

<?php
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$result = mysqli_query($conn, "SELECT * FROM orders WHERE id=$order_id");
$order = mysqli_fetch_assoc($result);
?>

<main>
<section class="success-section">

    <div class="success-box">
        <i class="fa fa-circle-check success-icon"></i>
        <h2>Order Placed Successfully!</h2>
        <p>Thank you<?php echo $order ? ', ' . htmlspecialchars($order['customer_name']) : ''; ?>! Your order has been received.</p>

        <?php if($order): ?>
            <div class="success-details">
                <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>
                <p><strong>Total Amount:</strong> ₹<?php echo number_format($order['total_amount'],2); ?></p>
                <p><strong>Payment Method:</strong> <?php echo $order['payment_method']; ?></p>
                <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
            </div>
        <?php endif; ?>

        <a href="shop.php" class="btn-submit" style="display:inline-block;width:auto;padding:14px 40px;text-decoration:none;">Continue Shopping</a>
    </div>

</section>
</main>

<?php include("footer.php"); ?>