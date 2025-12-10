<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$total = 0;

// Check if cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Cart is empty.");
}

foreach ($_SESSION['cart'] as $productId => $item) {
    $query = mysqli_query($conn, "SELECT display_price FROM product WHERE productid = $productId");
    $row = mysqli_fetch_assoc($query);
    $subtotal = $row['display_price'] * $item['quantity'];
    $total += $subtotal;
}

// Payment processing logic
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $transaction_id = mysqli_real_escape_string($conn, $_POST['transaction_id']);
    $user_id = $_SESSION['user_id'];

    // Insert payment record into the database
    $sql = "INSERT INTO payments (user_id, amount, transaction_id, payment_date) 
            VALUES ($user_id, '$total', '$transaction_id', NOW())";
    echo $sql;
    return;
    if (mysqli_query($conn, $sql)) {
        // Clear the cart after successful payment
        unset($_SESSION['cart']);

        echo "<script>alert('Payment Successful!'); window.location.href='success.php';</script>";
    } else {
        echo "<script>alert('Payment Failed. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="card p-4">
        <h4 class="mb-3">Complete Your Payment</h4>
        <p>Total Amount: <strong>$<?php echo number_format($total, 2); ?></strong></p>
        <form id="payment-form" method="post">
            <div class="mb-3">
                <label for="transaction_id" class="form-label">Transaction ID</label>
                <input type="text" id="transaction_id" name="transaction_id" class="form-control" required>
            </div>
            <input type="hidden" name="amount" value="<?php echo $total; ?>">
            <button type="submit" class="btn btn-primary w-100">Confirm Payment</button>
        </form>
    </div>
</div>
</body>
</html>
