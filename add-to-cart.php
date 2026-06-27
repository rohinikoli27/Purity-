<?php include("db.php"); ?>
<?php
header('Content-Type: application/json');

$id = $_POST['id'];

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}

$totalItems = array_sum($_SESSION['cart']);

echo json_encode([
    'status' => 'added',
    'count' => $totalItems
]);
?>