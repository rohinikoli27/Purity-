<?php include("db.php"); ?>

<?php
if(empty($_SESSION['cart'])){
    header("Location: cart.php");
    exit();
}

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$customer_name = $_POST['customer_name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$payment_method = $_POST['payment_method'];

// Calculate grand total
$grandTotal = 0;
$cartItems = [];

foreach($_SESSION['cart'] as $id => $qty){
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    $product = mysqli_fetch_assoc($result);
    if($product){
        $subtotal = $product['price'] * $qty;
        $grandTotal += $subtotal;
        $cartItems[] = ['id' => $id, 'qty' => $qty, 'price' => $product['price']];
    }
}

// Insert into orders table
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$stmt = mysqli_prepare($conn, "INSERT INTO orders (user_id, total_amount, status, customer_name, phone, address, payment_method) VALUES (?, ?, 'Pending', ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "idssss", $user_id, $grandTotal, $customer_name, $phone, $address, $payment_method);

if(!mysqli_stmt_execute($stmt)){
    die("Order insert failed: " . mysqli_error($conn));
}

$order_id = mysqli_insert_id($conn);

// Insert each item into order_items
foreach($cartItems as $item){
    $stmt2 = mysqli_prepare($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt2, "iiid", $order_id, $item['id'], $item['qty'], $item['price']);
    mysqli_stmt_execute($stmt2);
}

// Clear the cart
unset($_SESSION['cart']);

header("Location: order-success.php?order_id=" . $order_id);
exit();
?>