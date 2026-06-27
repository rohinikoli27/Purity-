<?php include("db.php"); ?>
<?php
header('Content-Type: application/json');

$id = $_POST['id'];
$action = $_POST['action']; // 'increase' or 'decrease'

if(isset($_SESSION['cart'][$id])){
    if($action == 'increase'){
        $_SESSION['cart'][$id]++;
    } elseif($action == 'decrease'){
        $_SESSION['cart'][$id]--;
        if($_SESSION['cart'][$id] <= 0){
            unset($_SESSION['cart'][$id]);
        }
    }
}

// Recalculate this product's subtotal and grand total
$result = mysqli_query($conn, "SELECT price FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);
$price = $product ? $product['price'] : 0;

$qty = isset($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id] : 0;
$subtotal = $price * $qty;

$grandTotal = 0;
foreach($_SESSION['cart'] as $pid => $pqty){
    $r = mysqli_query($conn, "SELECT price FROM products WHERE id=$pid");
    $p = mysqli_fetch_assoc($r);
    if($p) $grandTotal += $p['price'] * $pqty;
}

echo json_encode([
    'qty' => $qty,
    'subtotal' => number_format($subtotal,2),
    'grandTotal' => number_format($grandTotal,2),
    'cartCount' => array_sum($_SESSION['cart'])
]);
?>