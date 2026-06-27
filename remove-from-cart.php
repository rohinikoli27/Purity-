<?php include("db.php"); ?>
<?php
header('Content-Type: application/json');

$id = $_POST['id'];

if(isset($_SESSION['cart'][$id])){
    unset($_SESSION['cart'][$id]);
}

echo json_encode([
    'count' => isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0
]);
?>