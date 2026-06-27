<?php include("header.php"); ?>
<?php include("db.php"); ?>

<?php
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);

if(!$product){
    die("Product not found.");
}
?>

<main>

<div class="breadcrumb">
    <a href="shop.php">Shop</a> /
    <a href="<?php echo $product['category']; ?>-sub.php"><?php echo ucfirst($product['category']); ?></a> /
    <span><?php echo $product['name']; ?></span>
</div>

<section class="product-detail">

    <!-- LEFT: IMAGE GALLERY -->
    <div class="detail-image">
        <div class="main-image">
            <img src="assets/images/<?php echo $product['image']; ?>" id="mainImg" alt="<?php echo $product['name']; ?>">
        </div>
        <div class="thumb-row">
            <img src="assets/images/<?php echo $product['image']; ?>" class="thumb active" onclick="changeImg(this)">
            <img src="assets/images/<?php echo $product['image']; ?>" class="thumb" onclick="changeImg(this)">
            <img src="assets/images/<?php echo $product['image']; ?>" class="thumb" onclick="changeImg(this)">
        </div>
    </div>

    <!-- RIGHT: INFO -->
    <div class="detail-info">

        <span class="detail-badge"><?php echo ucfirst($product['category']); ?></span>

        <h1><?php echo $product['name']; ?></h1>

        <div class="rating-row">
            <span class="rating-badge">4.3 <i class="fa fa-star"></i></span>
            <span class="rating-count">128 Ratings</span>
        </div>

        <div class="price-row">
            <span class="detail-price">₹<?php echo number_format($product['price'],2); ?></span>
            <span class="mrp-price">₹<?php echo number_format($product['price']*1.4,0); ?></span>
            <span class="discount-tag">28% off</span>
        </div>

        <p class="detail-desc">
            <?php echo nl2br(htmlspecialchars($product['description'] ?: 'No description available.')); ?>
        </p>

        <ul class="highlights">
            <li>100% Handmade with premium yarn</li>
            <li>Eco-friendly, reusable packaging</li>
            <li>Each piece is uniquely crafted</li>
        </ul>

        <div class="delivery-box">
            <input type="text" placeholder="Enter pincode" maxlength="6">
            <button>Check</button>
        </div>

        <div class="qty-selector">
            <button onclick="changeQty(-1)">−</button>
            <input type="number" id="qty" value="1" min="1" readonly>
            <button onclick="changeQty(1)">+</button>
        </div>

        <div class="detail-actions">
        <button class="cart-btn" data-id="<?php echo $product['id']; ?>" onclick="addToCart(this)">Add to Cart</button>
            <button class="wish-btn-large"><i class="fa fa-heart"></i></button>
        </div>

        <div class="detail-meta">
            <p><i class="fa fa-truck"></i> Handmade & shipped within 3-5 days</p>
            <p><i class="fa fa-rotate-left"></i> 7 Days Easy Return Policy</p>
            <p><i class="fa fa-shield-halved"></i> Quality Checked Product</p>
        </div>

    </div>

</section>

</main>

<?php include("footer.php"); ?>

<script>
function changeQty(amount){
    const qty = document.getElementById('qty');
    let value = parseInt(qty.value) + amount;
    if(value < 1) value = 1;
    qty.value = value;
}

function changeImg(el){
    document.getElementById('mainImg').src = el.src;
    document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}
</script>