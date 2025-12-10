<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$order_query = mysqli_query($conn, "SELECT * FROM orders WHERE  customer_id = '{$_SESSION['user_id']}'");
$order = mysqli_fetch_assoc($order_query);

if (!$order) {
    echo "<script>alert('Invalid Order!'); window.location.href='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5 text-center">
        <div class="card p-4">
            <h2 class="text-success">Thank You! </h2>
            <p>Your order has been placed successfully.</p>
            <h4>Order Number: <strong>#<?php echo $order['order_number']; ?></strong></h4>
            <p><strong>Total Amount:</strong> $<?php echo number_format($order['amount'], 2); ?></p>
           

            <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
        </div>
    </div>
</body>
</html>
