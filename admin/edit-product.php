<?php include("../db.php"); ?>
<?php $activePage = 'products'; ?>

<?php
$id = $_GET['id'];
$message = "";

// Fetch existing product
$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);

if(!$product){
    die("Product not found.");
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    $image_name = $product['image']; // keep old image by default

    if(!empty($_FILES['image']['name'])){
        $image_name = time()."_".basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "../assets/images/" . $image_name);
    }

    $stmt = mysqli_prepare($conn, "UPDATE products SET category=?, subcategory=?, name=?, price=?, image=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssdsi", $category, $subcategory, $name, $price, $image_name, $id);

    if(mysqli_stmt_execute($stmt)){
        header("Location: products.php");
        exit();
    } else {
        $message = "❌ Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Product - Purity Admin</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="admin-body">

<div class="admin-wrapper">

    <?php include("sidebar.php"); ?>

    <main class="admin-main">

        <div class="form-card">

            <h2>Edit Product</h2>

            <?php if($message): ?>
                <p class="form-message"><?php echo $message; ?></p>
            <?php endif; ?>

            <form action="edit-product.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">

                <label>Category</label>
                <select name="category" id="category" onchange="updateSubcategories()" required>
                    <option value="crochet" <?php echo $product['category']=='crochet'?'selected':''; ?>>Crochet</option>
                    <option value="embroidery" <?php echo $product['category']=='embroidery'?'selected':''; ?>>Hand Embroidery</option>
                </select>

                <label>Subcategory</label>
                <select name="subcategory" id="subcategory" required></select>

                <label>Product Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

                <label>Price</label>
                <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>

                <label>Current Image</label>
                <img src="../assets/images/<?php echo $product['image']; ?>" class="current-img">

                <label>Change Image (Optional)</label>
                <input type="file" name="image" accept="image/*">

                <button type="submit" class="btn-submit">Update Product</button>

            </form>

        </div>

    </main>

</div>

<script>
const subcategories = {
    crochet: ["keychains","bags","toys","home-decor","flowers","accessories","clothes","gifts"],
    embroidery: ["hoop","frames","clothing","name","custom","tote"]
};

const labels = {
    keychains:"Keychains", bags:"Bags", toys:"Toys", "home-decor":"Home Decor",
    flowers:"Flowers", accessories:"Accessories", clothes:"Clothes", gifts:"Gifts",
    hoop:"Embroidery Hoop", frames:"Frames Embroidery", clothing:"Clothing Embroidery",
    name:"Name / Initial Embroidery", custom:"Custom Gift", tote:"Embroidery Tote Bags"
};

function updateSubcategories(){
    const category = document.getElementById('category').value;
    const subSelect = document.getElementById('subcategory');
    const currentSub = "<?php echo $product['subcategory']; ?>";

    subSelect.innerHTML = '';

    if(subcategories[category]){
        subcategories[category].forEach(sub => {
            const option = document.createElement('option');
            option.value = sub;
            option.textContent = labels[sub];
            if(sub === currentSub) option.selected = true;
            subSelect.appendChild(option);
        });
    }
}

updateSubcategories(); // run on page load to pre-fill
</script>

</body>
</html>