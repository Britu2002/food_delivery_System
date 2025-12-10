<?php
session_start();
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['id'];
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $quantity = $_POST['qty'];

    // Initialize the session cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the item already exists in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['qty'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'id'=> $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'qty' => $quantity
        ];
    }

    echo json_encode(["status" => "success", "message" => "Item added to cart"]);
}
?>
