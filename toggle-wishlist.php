<?php include("db.php"); ?>
<?php
header('Content-Type: application/json');

$id = $_POST['id'];

if(!isset($_SESSION['wishlist'])){
    $_SESSION['wishlist'] = [];
}

if(in_array($id, $_SESSION['wishlist'])){
    $_SESSION['wishlist'] = array_diff($_SESSION['wishlist'], [$id]);
    $status = 'removed';
} else {
    $_SESSION['wishlist'][] = $id;
    $status = 'added';
}

echo json_encode([
    'status' => $status,
    'count' => count($_SESSION['wishlist'])
]);
?>