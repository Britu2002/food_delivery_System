<?php 
session_start();
include '../config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "error: User not logged in!";
    exit();
}

$customer_id = $_SESSION['user_id'];
$delivery_address = mysqli_real_escape_string($conn, $_POST['address']);
$order_pincode = mysqli_real_escape_string($conn, $_POST['pincode']);

// Validate Pincode (Indian 6-digit format)
if (!preg_match("/^[0-9]{6}$/", $order_pincode)) {
    echo "error: Invalid Pincode!";
    exit();
}

// Check if cart is empty
if (empty($_SESSION['cart'])) {
    echo "error: Your cart is empty!";
    exit();
}

// Generate unique order number
$order_number = "ORD-" . strtoupper(substr(md5(time()), 0, 10));

// Calculate total amount and total items
$total_amount = 0;
$total_items = count($_SESSION['cart']);

$product_query = $conn->prepare("SELECT display_price FROM product WHERE productid = ?");
foreach ($_SESSION['cart'] as $productId => $item) {
    $product_query->bind_param("i", $productId);
    $product_query->execute();
    $result = $product_query->get_result()->fetch_assoc();

    if (!$result) {
        echo "error: Product not found!";
        exit();
    }

    $subtotal = $result['display_price'] * $item['quantity'];
    $total_amount += $subtotal;
}

// Start Transaction
$conn->begin_transaction();

try {
    // Insert Order with default delivery_status = 1
    $order_query = $conn->prepare("
        INSERT INTO orders 
        (order_number, customer_id, order_pincode, amount, total_items, delivery_address, delivery_status, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, 1, NOW())");
    $order_query->bind_param("sisdss", $order_number, $customer_id, $order_pincode, $total_amount, $total_items, $delivery_address);
    $order_query->execute();
    $order_id = $conn->insert_id; // Get last inserted order ID

    // Commit transaction
    $conn->commit();

    // Return success with order_id
    echo json_encode(["status" => "success", "order_id" => $order_id]);
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    error_log("Order Processing Error: " . $e->getMessage());
    echo json_encode(["status" => "error", "message" => "Something went wrong!"]);
}

?>