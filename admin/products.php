<?php include("../db.php"); ?>
<?php $activePage = 'products'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Purity Admin - Products</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="admin-body">

<div class="admin-wrapper">

    <?php include("sidebar.php"); ?>

    <main class="admin-main">

        <div class="products-topbar">
            <h1>Product List</h1>
            <a href="add-product.php" class="btn-add"><i class="fa fa-plus"></i> Add Product</a>
        </div>

        <div class="table-card">

            <table class="product-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");

                    if($result && mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo '<tr>';
                            echo '<td>'.$row['id'].'</td>';
                            echo '<td>'.ucfirst($row['category']).'</td>';
                            echo '<td>'.$row['subcategory'].'</td>';
                            echo '<td>'.$row['name'].'</td>';
                            echo '<td>₹'.number_format($row['price'],2).'</td>';
                            echo '<td><img src="../assets/images/'.$row['image'].'" class="table-img"></td>';
                            echo '<td class="action-icons">
                                    <a href="edit-product.php?id='.$row['id'].'"><i class="fa fa-pen edit-icon"></i></a>
                                    <a href="delete-product.php?id='.$row['id'].'" onclick="return confirm(\'Delete this product?\')"><i class="fa fa-trash delete-icon"></i></a>
                                  </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7" style="text-align:center;padding:30px;">No products found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>

        </div>

    </main>

</div>

</body>
</html>