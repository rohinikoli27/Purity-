<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Purity Handmade Store</title>

<link rel="stylesheet" href="assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<header>

<a href="index.php" class="logo">
    <img src="assets/images/logo.png">
    <h2>PURITY</h2>
</a>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="shop.php">Shop</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="wishlist.php"><i class="fa fa-heart"></i></a></li>
        <li><a href="cart.php" class="cart-icon"><i class="fa fa-cart-shopping"></i><span class="cart-count"><?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?></span></a></li>
        <li><a href="login.php">Login</a></li>
    </ul>
</nav>
</header>