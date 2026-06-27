<?php include("../db.php"); ?>

<?php
$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT image FROM products WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if($row){
    $imagePath = "../assets/images/" . $row['image'];
    if(file_exists($imagePath)){
        unlink($imagePath); // delete image file too
    }
}

mysqli_query($conn, "DELETE FROM products WHERE id=$id");

header("Location: products.php");
exit();
?>