<?php include("header.php"); ?>
<?php include("db.php"); ?>

<main>
<section class="cart-section">

    <h2 class="cart-heading">My Cart</h2>

    <?php
    $grandTotal = 0;
    ?>

    <?php if(!empty($_SESSION['cart'])): ?>

        <div class="cart-table">

            <?php
            foreach($_SESSION['cart'] as $id => $qty){
                $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
                $product = mysqli_fetch_assoc($result);

                if($product){
                    $subtotal = $product['price'] * $qty;
                    $grandTotal += $subtotal;
                    ?>
                    <div class="cart-row">

                        <img src="assets/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">

                        <div class="cart-info">
                            <h4><?php echo $product['name']; ?></h4>
                            <p class="cart-price">₹<?php echo number_format($product['price'],2); ?></p>
                        </div>

                        <div class="cart-qty">
                            <button onclick="updateQty(<?php echo $id; ?>, -1)">−</button>
                            <span id="qty-<?php echo $id; ?>"><?php echo $qty; ?></span>
                            <button onclick="updateQty(<?php echo $id; ?>, 1)">+</button>
                        </div>

                        <p class="cart-subtotal" id="subtotal-<?php echo $id; ?>">₹<?php echo number_format($subtotal,2); ?></p>

                        <button class="remove-btn" onclick="removeFromCart(<?php echo $id; ?>)"><i class="fa fa-trash"></i></button>

                    </div>
                    <?php
                }
            }
            ?>

        </div>

        <div class="cart-summary">
            <h3>Total: <span id="grandTotal">₹<?php echo number_format($grandTotal,2); ?></span></h3>
            <?php if(isset($_SESSION['user_id'])): ?>
    <a href="checkout.php" class="checkout-btn" style="text-decoration:none;display:inline-block;">Proceed to Checkout</a>
<?php else: ?>
    <a href="login.php?redirect=checkout" class="checkout-btn" style="text-decoration:none;display:inline-block;">Login to Checkout</a>
<?php endif; ?>
</div>

    <?php else: ?>
        <p class="no-products">Your cart is empty. Start shopping! 🛍️</p>
    <?php endif; ?>

</section>
</main>

<?php include("footer.php"); ?>