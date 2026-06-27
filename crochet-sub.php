<?php include("header.php"); ?>
<?php include("db.php"); // your database connection file ?>

<main>
<section class="product-view">

    <?php
    // Get selected subcategory from URL, default = all
    $sub = isset($_GET['sub']) ? $_GET['sub'] : 'all';
    ?>

    <div class="filter-row">

        <a href="shop.php" class="back-btn"><i class="fa fa-arrow-left"></i></a>

        <div class="filters">
            <a href="crochet-sub.php?sub=all" class="filter-btn <?php echo $sub=='all'?'active':''; ?>">All</a>
            <a href="crochet-sub.php?sub=keychains" class="filter-btn <?php echo $sub=='keychains'?'active':''; ?>">Keychains</a>
            <a href="crochet-sub.php?sub=bags" class="filter-btn <?php echo $sub=='bags'?'active':''; ?>">Bags</a>
            <a href="crochet-sub.php?sub=toys" class="filter-btn <?php echo $sub=='toys'?'active':''; ?>">Toys</a>
            <a href="crochet-sub.php?sub=home-decor" class="filter-btn <?php echo $sub=='home-decor'?'active':''; ?>">Home Decor</a>
            <a href="crochet-sub.php?sub=flowers" class="filter-btn <?php echo $sub=='flowers'?'active':''; ?>">Flowers</a>
            <a href="crochet-sub.php?sub=accessories" class="filter-btn <?php echo $sub=='accessories'?'active':''; ?>">Accessories</a>
            <a href="crochet-sub.php?sub=clothes" class="filter-btn <?php echo $sub=='clothes'?'active':''; ?>">Clothes</a>
            <a href="crochet-sub.php?sub=gifts" class="filter-btn <?php echo $sub=='gifts'?'active':''; ?>">Gifts</a>
        </div>

    </div>

    <div class="product-grid">

        <?php
        if($sub == 'all'){
            $query = "SELECT * FROM products WHERE category='crochet'";
        } else {
            $query = "SELECT * FROM products WHERE category='crochet' AND subcategory='$sub'";
        }

        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo '<div class="product-card">';
                $isWished = isset($_SESSION['wishlist']) && in_array($row['id'], $_SESSION['wishlist']);
echo '<button class="wish-btn '.($isWished?'active':'').'" data-id="'.$row['id'].'" onclick="toggleWishlist(this)"><i class="fa fa-heart"></i></button>';
                echo '<a href="product.php?id='.$row['id'].'" class="product-link">';
                echo '<img src="assets/images/'.$row['image'].'" alt="'.$row['name'].'">';
                echo '<h4>'.$row['name'].'</h4>';
                echo '</a>';
                echo '<p class="price">₹'.number_format($row['price'],2).'</p>';
                echo '<button class="cart-btn" data-id="'.$row['id'].'" onclick="addToCart(this)">Add to Cart</button>';
                echo '</div>';
            }
        } else {
            echo '<p class="no-products">No products found in this category yet.</p>';
        }
        ?>

    </div>

</section>
</main>

<?php include("footer.php"); ?>