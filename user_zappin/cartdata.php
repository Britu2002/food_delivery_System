<?php
session_start();

if (isset($_POST['coupon_code'])) {
    include('../config.php');
    
   
    $couponCode = strtoupper($_POST['coupon_code']); 
    mysqli_query($conn,"SELECT * FROM offers WHERE coupencode = '$coupon_code'"); 
    $subtotal = 0;
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['quantity'] * $item['price'];
    }


}


header('Content-Type: application/json'); 

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


$productId = $_POST['id'] ?? null;
$action = $_POST['action'] ?? null;


if (!$productId || !$action) {
    $cart_count = array_sum(array_column($_SESSION['cart'], 'quantity'));
    echo json_encode([
        'cart_count' => $cart_count
    ]);
    exit;
}

if (!is_numeric($productId)) {
    echo json_encode(["error" => "Invalid product ID"]);
    exit;
}

if (!isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId] = ["quantity" => 0];
}

if ($action === "increase") {
    $_SESSION['cart'][$productId]['quantity'] += 1;
} elseif ($action === "decrease") {
    $_SESSION['cart'][$productId]['quantity'] -= 1;
    if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
        unset($_SESSION['cart'][$productId]);
       
    }
} elseif ($action === "remove") {
    unset($_SESSION['cart'][$productId]);
    
}


$cart_count = array_sum(array_column($_SESSION['cart'], 'quantity'));
if($cart_count ==0){
    unset($_SESSION['coupon_code']);
}

echo json_encode([
    'quantity' => $_SESSION['cart'][$productId]['quantity'] ?? 0,
    'cart_count' => $cart_count
]);
exit;
?>
