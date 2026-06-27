<?php include("header.php"); ?>
<?php include("db.php"); ?>

<main>
<section class="product-view">

    <?php
    // Get selected subcategory from URL, default = all
    $sub = isset($_GET['sub']) ? $_GET['sub'] : 'all';
    ?>

    <div class="filter-row">

        <a href="shop.php" class="back-btn"><i class="fa fa-arrow-left"></i></a>

        <div class="filters">
            <a href="embroidery-sub.php?sub=all" class="filter-btn <?php echo $sub=='all'?'active':''; ?>">All</a>
            <a href="embroidery-sub.php?sub=hoop" class="filter-btn <?php echo $sub=='hoop'?'active':''; ?>">Embroidery Hoop</a>
            <a href="embroidery-sub.php?sub=frames" class="filter-btn <?php echo $sub=='frames'?'active':''; ?>">Frames Embroidery</a>
            <a href="embroidery-sub.php?sub=clothing" class="filter-btn <?php echo $sub=='clothing'?'active':''; ?>">Clothing Embroidery</a>
            <a href="embroidery-sub.php?sub=name" class="filter-btn <?php echo $sub=='name'?'active':''; ?>">Name / Initial Embroidery</a>
            <a href="embroidery-sub.php?sub=custom" class="filter-btn <?php echo $sub=='custom'?'active':''; ?>">Custom Gift</a>
            <a href="embroidery-sub.php?sub=tote" class="filter-btn <?php echo $sub=='tote'?'active':''; ?>">Embroidery Tote Bags</a>
        </div>

    </div>

    <div class="product-grid">

        <?php
        if($sub == 'all'){
            $query = "SELECT * FROM products WHERE category='embroidery'";
        } else {
            $query = "SELECT * FROM products WHERE category='embroidery' AND subcategory='$sub'";
        }

        $result = mysqli_query($conn, $query);

        if($result && mysqli_num_rows($result) > 0){
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
            }
        } else {
            echo '<p class="no-products">No products found in this category yet.</p>';
        }

        mysqli_close($conn);
        ?>

    </div>

</section>
</main>

<?php include("footer.php"); ?>