<?php include("header.php"); ?>
<?php include("db.php"); ?>

<?php
if(empty($_SESSION['cart'])){
    header("Location: cart.php");
    exit();
}

if(!isset($_SESSION['user_id'])){
    header("Location: login.php?redirect=checkout");
    exit();
}

// Calculate grand total
$grandTotal = 0;
$cartItems = [];

foreach($_SESSION['cart'] as $id => $qty){
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    $product = mysqli_fetch_assoc($result);
    if($product){
        $subtotal = $product['price'] * $qty;
        $grandTotal += $subtotal;
        $cartItems[] = ['product' => $product, 'qty' => $qty, 'subtotal' => $subtotal];
    }
}
?>
<main>
<section class="checkout-section">

    <h2 class="checkout-heading">Checkout</h2>

    <div class="checkout-layout">

        <!-- LEFT: SHIPPING FORM -->
        <div class="checkout-form-box">

            <h3>Shipping Details</h3>

            <form action="process-order.php" method="POST">

                <label>Full Name</label>
                <input type="text" name="customer_name" placeholder="Enter your name" required>

                <label>Phone Number</label>
                <input type="text" name="phone" placeholder="Enter your phone number" required>

                <label>Delivery Address</label>
                <textarea name="address" rows="4" placeholder="House no, street, city, pincode" required></textarea>

                <label>Payment Method</label>
                <select name="payment_method" required>
                    <option value="COD">Cash on Delivery</option>
                    <option value="UPI">UPI</option>
                    <option value="Card">Credit/Debit Card</option>
                </select>

                <button type="submit" class="btn-submit">Place Order</button>

            </form>

        </div>

        <!-- RIGHT: ORDER SUMMARY -->
        <div class="checkout-summary-box">

            <h3>Order Summary</h3>

            <?php foreach($cartItems as $item): ?>
                <div class="summary-row">
                    <img src="assets/images/<?php echo $item['product']['image']; ?>" alt="">
                    <div class="summary-info">
                        <p class="summary-name"><?php echo $item['product']['name']; ?></p>
                        <p class="summary-qty">Qty: <?php echo $item['qty']; ?></p>
                    </div>
                    <p class="summary-price">₹<?php echo number_format($item['subtotal'],2); ?></p>
                </div>
            <?php endforeach; ?>

            <div class="summary-total">
                <span>Total</span>
                <span>₹<?php echo number_format($grandTotal,2); ?></span>
            </div>

        </div>

    </div>

</section>
</main>

<?php include("footer.php"); ?>