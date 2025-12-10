<?php
session_start();
include('../config.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /zaapin/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's saved delivery address
$delivery_address = "";
$city = "";
$pincode = "";

$result = mysqli_query($conn, "SELECT address, city, pincode FROM customer WHERE cid = '$user_id'");
if ($row = mysqli_fetch_assoc($result)) {
    $delivery_address = $row['address'];
    $city = $row['city'];
    $pincode = $row['pincode'];
}

// Fetch restaurant's pincode
$restaurant_pincode = "";
$restaurant_id = $_SESSION['resid']; 

$res_query = mysqli_query($conn, "SELECT pincode FROM restaurant WHERE resid = '$restaurant_id'");
if ($res_data = mysqli_fetch_assoc($res_query)) {
    $restaurant_pincode = $res_data['pincode']; 
}

// Compare pincodes - Disable ordering if pincodes do NOT match
$disable_order = ($restaurant_pincode != $pincode);

// Calculate total and discount
$total_price = isset($_SESSION['final_price']) ? $_SESSION['final_price'] : 0;
$discount = 0;
$discount_percentage = 0;
 $coupon_id='NULL';

if (isset($_SESSION['coupon_code'])) {
    $coupon_id = $_SESSION['coupon_code'];
   
    $result = mysqli_query($conn, "SELECT * FROM offers WHERE coupenid = $coupon_id");
    $offers = mysqli_fetch_assoc($result);
    
    if ($offers) {
        $discount_percentage = $offers['coupenpercentage'];
        $discount = ($total_price * $discount_percentage) / 100;
        $total_price -= $discount;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$disable_order) {
    $payment_method = $_POST['payment_method'];

    // $delivery_address = mysqli_real_escape_string($conn, $_POST['delivery_address']);
    $order_number = "ORD" . time(); 
    $customer_id = $_SESSION['user_id'];
    $subtotal = $_SESSION['final_price'];
    $total = $subtotal - $discount;
    $total_items = count($_SESSION['cart']);
    $payment_status = ($payment_method == 'COD') ? 'Pending' : 'Complete';
    $order_otp = rand(100000, 999999);
    $created_at = date('Y-m-d H:i:s');

    // Insert into `orders` table (Added `resid` column)
    $query = "INSERT INTO `orders` (coupen_id,order_number, customer_id, resid, subtotal, total, discount, total_items, payment_method, payment_status, delivery_status, order_otp, created_at)
              VALUES ($coupon_id,'$order_number', '$customer_id', '$restaurant_id', '$subtotal', '$total', '$discount', '$total_items', '$payment_method', '$payment_status', '1', '$order_otp', '$created_at')";

    if (mysqli_query($conn, $query)) {
        $order_id = mysqli_insert_id($conn);

        // Insert order items into `order_item` table
        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['id'];
            $quantity = $item['qty'];
            $price = $item['price'];

            $insert_item = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('$order_id', '$product_id', '$quantity')";
            mysqli_query($conn, $insert_item);
        }

        // If not COD, insert payment record
        if ($payment_method != 'COD') {
            $payment_query = "INSERT INTO payments (customer_id, order_id, amount, payment_method, payment_status, transaction_id, created_at)
                              VALUES ('$customer_id', '$order_id', '$total', '$payment_method', 'Complete', 'TXN" . time() . "', '$created_at')";
            mysqli_query($conn, $payment_query);
        }

        // Clear cart session
        unset($_SESSION['cart']);
        unset($_SESSION['final_price']);
        unset($_SESSION['coupon_code']);

        header("Location: thankyou.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Set default payment method (Cash on Delivery)
$selected_payment_method = isset($_SESSION['payment_method']) ? $_SESSION['payment_method'] : 'COD';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Summary</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Cart Summary</h2>

        <!-- Alert if pincode does not match -->
        <?php if ($disable_order): ?>
            <div class="alert alert-danger text-center">
                🚫 <strong>Delivery is not available at your location!</strong> <br>
                Please <strong><a href="edit-user.php?userid<?php $user_id ?>" class="text-danger">Change Location</a></strong> or <strong><a href="index.php" class="text-danger">Choose Another Restaurant</a></strong>.
            </div>
        <?php endif; ?>

        <div class="card shadow p-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            $subtotal = $item['price'] * $item['qty'];
                            echo "<tr>
                                    <td>{$item['name']}</td>
                                    <td>{$item['qty']}</td>
                                    <td>\${$item['price']}</td>
                                    <td>\${$subtotal}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>Your cart is empty</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <hr>
            <p class="text-right"><strong>Total Price:</strong> $<?php echo number_format($_SESSION['final_price'], 2); ?></p>
            <?php if ($discount > 0): ?>
                <p class="text-right text-success"><strong>Discount (<?php echo $discount_percentage; ?>%):</strong> -$<?php echo number_format($discount, 2); ?></p>
                <p class="text-right"><strong>Final Total:</strong> $<?php echo number_format($total_price, 2); ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label><strong>Select Payment Method:</strong></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="COD" id="cod" <?php echo ($selected_payment_method == 'COD') ? 'checked' : ''; ?> required>
                        <label class="form-check-label" for="cod">Cash on Delivery</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="card" id="credit_card" <?php echo ($selected_payment_method == 'card') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="credit_card">Credit Card</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="upi" id="upi" <?php echo ($selected_payment_method == 'upi') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="UPI">UPI</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="paypal" id="credit_card" <?php echo ($selected_payment_method == 'paypal') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="credit_card">Paypal</label>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <?php if (!$disable_order): ?>
                        <button type="submit" class="btn btn-danger">Order Now</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
