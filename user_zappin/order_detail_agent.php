
<?php
include('../config.php'); 

$order_id = $_GET['orderid']; 

$sql = "SELECT oi.*, p.productname, p.display_price, o.subtotal, o.discount, o.total, offers.coupencode, o.order_number, o.payment_status, o.payment_method,o.delivery_status FROM order_items oi LEFT JOIN `orders` o ON oi.order_id = o.order_id LEFT JOIN offers ON o.coupen_id=offers.coupenid JOIN product p ON oi.product_id = p.productid WHERE oi.order_id = ?; ";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if Order Exists
if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
    ?>

    <?php if(isset($_GET['otp'])){

$order_id = $_GET['orderid'];
$otp = $_GET['otp'];

$res=mysqli_query($conn,"select * from orders where `order_id`=$order_id and order_otp='$otp'");

if(mysqli_num_rows($res)==1){
    mysqli_query($conn,"UPDATE `orders` SET `payment_status`='Complete',`delivery_status`=6 WHERE `order_id`=$order_id");
    echo "<script>
    alert('order Complete')
    window.location.href='agent_index.php'
    </script>";
}else{
    echo "<script>
    alert('Wrong Otp')
    </script>"   ;
}

    } ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Details</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"  />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      
    </head>
    <body class="bg-light">
        <?php include('header_agent.php'); ?>
        <div class="">
     
        <div class="row justify-content-center">
            <div class="col-lg-8  border bg-white p-4"style="margin-top:100px;">
        
            <h4 class="text-center">Order No: <?php echo $order['order_number']; ?></h4>
            <p class="text-center text-muted">Order Date: 04-05-2024</p>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $count = 1;
                    $result->data_seek(0); // Reset pointer for looping
                    while ($row = $result->fetch_assoc()) { 
                    ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $row['productname']; ?></td>
                            <td><?php echo number_format($row['display_price'], 0); ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo number_format($row['display_price'] * $row['quantity'], 0); ?></td>
                        </tr>

                    <?php } ?>
                    <tr>
                      <td colspan="5" class="">
                      <strong class="">
                        <span> total Price -</span><?php echo $order['subtotal'],"/-".""?><br>
                              
                              Coupen Code Applied - <span class="text-success"> <?php echo $order['coupencode'],"".""?> </span> <br>
                              Discount   <span class="text-danger"> <?php echo ($order['discount']>0)?"-".$order['discount']:"0"?> </span><br>
                              Net Price  <span><?php echo    $order['total']."/-"; ?></span>
                            </strong>
                      </td>
                      
                      
                    </tr>
                  
                </tbody>
            </table>
            
          
       
            <div class="mb-2 ">
            <p><strong>payment Type:</strong> <?php echo $order['payment_method'] ?></p>
                <p><strong>Payment Status :</strong> <span class=""><?php echo $order['payment_status'] ?></span></p>
               
               
              
                
              
            </div>
   <?php if($order['delivery_status']==5): ?>         
<form>
    <input type="hidden" name="orderid" value=<?php echo $_GET['orderid'] ?>>
<input type="text" class="form-control mb-3" name="otp"  placeholder="Enter Order OTP" required>

         
            <div class="row">
                <div class="col">
                <button class="btn btn-dark w-100" type="submit" >Confirm</button>
                </div> 
                    <?php  elseif($order['delivery_status']==6):?>
                        <div class="row">
                        <div class="col">
                        <button class="btn btn-success w-100"  >Order Delivered</button>
                    </div>
               
                <?php endif; ?>
                <div class="col">
                    <a href="agent_index.php" class="btn btn-dark w-100">back</a>
                </div>
            </div>
            </form>
            
                    </div>
                    </div>
                    </div>

    </body>
    </html>

    <?php
} else {
    echo "<h4 class='text-center text-danger'>No Order Found!</h4>";
}

$stmt->close();
$conn->close();
?>

