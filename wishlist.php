<?php include("header.php"); ?>
<?php include("db.php"); ?>

<main>
<section class="wishlist-section">

    <h2 class="wishlist-heading">My Wishlist</h2>

    <div class="product-grid">

        <?php
        if(!empty($_SESSION['wishlist'])){

            $ids = implode(',', array_map('intval', $_SESSION['wishlist']));
            $query = "SELECT * FROM products WHERE id IN ($ids)";
            $result = mysqli_query($conn, $query);

            if($result && mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo '<div class="product-card">';
                    echo '<button class="wish-btn active" data-id="'.$row['id'].'" onclick="toggleWishlist(this)"><i class="fa fa-heart"></i></button>';
                    echo '<a href="product.php?id='.$row['id'].'" class="product-link">';
                    echo '<img src="assets/images/'.$row['image'].'" alt="'.$row['name'].'">';
                    echo '<h4>'.$row['name'].'</h4>';
                    echo '</a>';
                    echo '<p class="price">₹'.number_format($row['price'],2).'</p>';
                    echo '<button class="cart-btn">Add to Cart</button>';
                    echo '</div>';
                }
            }

        } else {
            echo '<p class="no-products">Your wishlist is empty. Start adding products you love! 💕</p>';
        }
        ?>

    </div>

</section>
</main>

<?php include("footer.php"); ?>