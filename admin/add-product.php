<?php include("../db.php"); ?>
<?php $activePage = 'products'; ?>

<?php
$message = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $image_name = time()."_".basename($_FILES["image"]["name"]);
    $target_file = "../assets/images/" . $image_name;

    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){

        $stmt = mysqli_prepare($conn, "INSERT INTO products (category, subcategory, name, description, price, image) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssds", $category, $subcategory, $name, $description, $price, $image_name);

        if(mysqli_stmt_execute($stmt)){
            header("Location: products.php");
            exit();
        } else {
            $message = "❌ Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);

    } else {
        $message = "❌ Image upload failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Product - Purity Admin</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="admin-body">

<div class="admin-wrapper">

    <?php include("sidebar.php"); ?>

    <main class="admin-main">

        <div class="form-card">

            <h2>Add Product</h2>

            <?php if($message): ?>
                <p class="form-message"><?php echo $message; ?></p>
            <?php endif; ?>

            <form action="add-product.php" method="POST" enctype="multipart/form-data">

                <select name="category" id="category" onchange="updateSubcategories()" required>
                    <option value="">Select Category</option>
                    <option value="crochet">Crochet</option>
                    <option value="embroidery">Hand Embroidery</option>
                </select>

                <select name="subcategory" id="subcategory" required>
                    <option value="">Select Subcategory</option>
                </select>

                <input type="text" name="name" placeholder="Product Name" required>

                <textarea name="description" placeholder="Product Description" rows="4"></textarea>

                <input type="number" name="price" step="0.01" placeholder="Price" required>

                <input type="file" name="image" accept="image/*" required>

                <button type="submit" class="btn-submit">Add Product</button>

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
    subSelect.innerHTML = '<option value="">Select Subcategory</option>';

    if(subcategories[category]){
        subcategories[category].forEach(sub => {
            const option = document.createElement('option');
            option.value = sub;
            option.textContent = labels[sub];
            subSelect.appendChild(option);
        });
    }
}
</script>

</body>
</html>