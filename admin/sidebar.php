<aside class="admin-sidebar">

    <h2 class="admin-logo">Purity Admin</h2>

    <ul class="admin-nav">
        <li class="<?php echo ($activePage=='dashboard')?'active':''; ?>">
            <a href="dashboard.php"><i class="fa fa-gauge"></i> Dashboard</a>
        </li>
        <li class="<?php echo ($activePage=='products')?'active':''; ?>">
            <a href="products.php"><i class="fa fa-box"></i> Products</a>
        </li>
        <li class="<?php echo ($activePage=='orders')?'active':''; ?>">
            <a href="orders.php"><i class="fa fa-cart-shopping"></i> Orders</a>
        </li>
        <li class="<?php echo ($activePage=='categories')?'active':''; ?>">
            <a href="categories.php"><i class="fa fa-folder"></i> Categories</a>
        </li>
        <li class="<?php echo ($activePage=='users')?'active':''; ?>">
            <a href="users.php"><i class="fa fa-user"></i> Users</a>
        </li>
        
        <li class="<?php echo ($activePage=='messages')?'active':''; ?>">
    <a href="messages.php"><i class="fa fa-envelope"></i> Messages</a>
</li>
        <li><a href="logout.php"><i class="fa fa-right-from-bracket"></i> Logout</a></li>
    </ul>

</aside>