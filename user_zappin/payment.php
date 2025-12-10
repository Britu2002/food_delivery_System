<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_SESSION['user_id']; 
   
    $amount = $_GET['total'];
   
    $discount = $_GET['discount'];
    $final=$amount-$discount;
    $payment_method = $_GET['method'];
    
    $transaction_id = $_POST['transaction_id'];
    $payment_status = "Complete"; 


  
        $sql = "INSERT INTO payments (customer_id, amount, payment_method, payment_status, transaction_id) 
        VALUES ('$customer_id', '$final', '$payment_method', '$payment_status', '$transaction_id')";
        
     $res=   mysqli_query($conn,$sql);
if ($res) {
    $payment_id= mysqli_insert_id($conn);
    echo "<script>alert('Payment Successful!.'); 
    window.location.href='summary.php?total=$amount&discount=$discount&method=$payment_method&paymentid=$payment_id';
    </script>";
} else {
    echo "Error: " . $conn->error;
}
    } 

   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Method</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .payment-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container" >
    <div class="payment-container">
        <h4 class="text-center mb-3">Payment via: <?php echo $_GET['method']; ?></h4>
        <p class="text-center">Total Pay: <strong>₹<?php echo $_GET['total']-$_GET['discount'] ?></strong></p>

        <form id="" action="" method="post">
            <input type="hidden" name="total" value="<?php echo $_GET['total']; ?>">
            <input type="hidden" name="discount" value="<?php echo $_GET['discount']; ?>">
            <input type="hidden" name="method" value="<?php echo $_GET['method']; ?>">
            <div class="mb-3" id="transaction_id_div">
                <label for="transaction_id" class="form-label">Transaction ID</label>
                <input type="text" id="transaction_id" name="transaction_id" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Confirm Payment</button>
            <a href="index.php" class="btn btn-danger w-100 mt-2">Cancel Order</a>
        </form>
    </div>
</div>

</body>
</html>
