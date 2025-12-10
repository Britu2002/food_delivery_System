<?php  
session_start();
include('../config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $order_number = uniqid("ORD-");
    $customer_id = $_SESSION['user_id']; 
    $subtotal = $_GET['total']; 
    $discount = $_GET['discount']; 
  $total=$subtotal-$discount;
    $total_items = $_POST['count_items'];
    $order_otp = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
    $delivery_address = $_POST['address'];
    
    $payment_method = isset($_POST['method']) ? $_GET['method'] : "COD";
    $payment_status = isset($_POST['method']) ? "Complete" : "Pending";
    $copenid=isset($_SESSION['coupon_code'])?$_SESSION['coupon_code']:"NULL";

    // Insert order
    $insertOrderQuery = "INSERT INTO orders (order_number, customer_id, subtotal, discount,total, total_items, payment_method, payment_status,order_otp,coupen_code)
                         VALUES ('$order_number', $customer_id, '$subtotal', '$discount','$total', '$total_items','$payment_method','$payment_status','$order_otp',$copenid)";


    $res = mysqli_query($conn, $insertOrderQuery);

    if ($res) {
        $order_id = mysqli_insert_id($conn); // Last inserted order_id
        
        // Insert order items
        foreach ($_SESSION['cart'] as $productId => $item) {
            
            
         
            $quantity = $item['quantity'];

            $insertItemQuery = "INSERT INTO order_items (order_id, product_id, quantity ) 
                                VALUES ($order_id, $productId, $quantity)";
            mysqli_query($conn, $insertItemQuery);
        }

        // Update payments table if online payment
        if (isset($_POST['paymentid'])) {
            $payment_id = $_POST['paymentid'];
            $updatePaymentQuery = "UPDATE payments SET order_id = $order_id WHERE payment_id = $payment_id";
            mysqli_query($conn, $updatePaymentQuery);
        }

        // Clear coupon & cart session
        unset($_SESSION['coupon_code']);
        unset($_SESSION['cart']);

        echo "<script>
              alert('Order placed successfully!');
              window.location.href='thankyou.php';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Order Summary</title>
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">
 
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  
 
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f8f9fa;
      margin: 0;
      padding: 20px;
    }
    .summary-container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      padding: 30px;
      border: 1px solid #e0e0e0;
    }
    .summary-header {
      background: rgb(22, 27, 51);
      padding: 20px;
      border-radius: 10px;
      color: #fff;
      text-align: center;
      margin-bottom: 20px;
    }
    h4, h5 {
      margin: 0;
      font-weight: 500;
    }
    h5 {
      margin-bottom: 10px;
      color: #333;
      border-bottom: 2px solid rgb(33, 24, 70);
      padding-bottom: 5px;
    }
    .summary-section {
      margin-bottom: 30px;
    }
    .summary-section p {
      font-size: 1rem;
      color: #555;
      margin: 5px 0;
    }
    .order-details p {
      display: flex;
      justify-content: space-between;
      font-size: 1.1rem;
    }
    .order-items {
      list-style: none;
      padding: 0;
    }
    .order-items li {
      background: #f1f1f1;
      margin-bottom: 10px;
      padding: 10px;
      border-radius: 5px;
      transition: background 0.3s ease;
    }
    .order-items li:hover {
      background: #e0e0e0;
    }
  </style>
</head>
<body>
  <form action="" method="post">
    <?php
       if(isset($_GET['paymentid'])){
echo    "<input type='hidden' name='paymentid' value='$_GET[paymentid]'>
<input type='hidden' name='method' value='$_GET[method]'>
<input type='hidden' name='discount' value='$_GET[discount]'>
"; 
       }
    ?>

  <div class="summary-container">
    <div class="summary-header">
      <h4>Order Summary</h4>
    </div>
    
    <!-- Delivery Address -->
    <div class="summary-section">
      <h5>Delivery Address</h5>
      <div class="d-flex justify-content-between align-items center">

     
      
        <?php if(isset($_SESSION['user_id'])){
       $id= $_SESSION['user_id'];
     $res=   mysqli_query($conn,"select address,city,pincode from customer where cid=$id");
   $user=  mysqli_fetch_assoc($res);
      ?>
        <p><?php   echo $user['address']." " .$user['city'].",".$user['pincode']; ?></p>
        <a href='edit-user.php?userid=<?php echo $id ?>'>change location</a>
      <?php
      } ?>
      
  
       </div>
    </div>
    
    
    
    <!-- Order Items: Displayed only if the order is COD -->
    <div class="summary-section">
      <h5>Order </h5>
      <ul class="list-group border mb-3">
                    <?php
                    include '../config.php';
                    $total = 0;
                    $count_items=0;
                    foreach ($_SESSION['cart'] as $productId => $item) {
                        $query = mysqli_query($conn, "SELECT p.* FROM product p 
                                                     
                                                      WHERE p.productid = $productId ");
                        $row = mysqli_fetch_assoc($query);
                        $subtotal = $row['display_price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <li class="list-group-item border-0 d-flex justify-content-between align-items-center">
        
                            <span><?php echo $row['productname']; ?> (x<?php echo $item['quantity']; ?>)</span>
                            <strong><?php echo number_format($subtotal, 0); ?></strong>
                        </li>
                        
                    <?php 
                  $count_items=$count_items+1;
                  } ?>

                  <input type="hidden" name="count_items" id="" value="<?php echo $count_items; ?>">
                  <input type="hidden" name="address" id="" value="<?php echo $user['pincode']; ?>">
                  <input type="hidden" name="count_items" id="" value="<?php echo $count_items; ?>">
                    <div class="border-top m-0"></div>
                    <li class="list-group-item  border-0 d-flex justify-content-between align-items-center">
        
        <span> <strong>Total</strong></span>
        <strong><?php echo number_format($total, 0); ?></strong>
    </li>
    <li class="list-group-item  border-0 d-flex justify-content-between align-items-center">
        
        <span> <strong>Discount</strong></span>
        <strong><?php echo  $_GET['discount'] ?></strong>
    </li>
   
    <li class="list-group-item  border-0 d-flex justify-content-between align-items-center">
        
        <span> <strong>Total Amount</strong></span>
        <strong><?php echo $total- $_GET['discount']; ?></strong>
    </li>
   
                </ul>

    </div>
    <!-- Order Details -->
    <div class="summary-section order-details">
      <h5>Payment Details</h5>

  
      <p><span>Payment Type:</span> 
        <?php if(isset($_GET['method'])): ?>
          <span> <?php echo $_GET['method'] ?>  </span>
          <?php else: ?>
            <span>   Cash on Delivery</span>
      <?php endif; ?>
      </p>
    </div>
<div class="d-flex justify-content-center">
    <button class="btn btn-danger">Place Order</button>
    </div>
  </div>
  </form>
</body>
</html>
