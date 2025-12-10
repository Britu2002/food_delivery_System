<?php include("../config.php"); ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Items</title>
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
    <style>
    </style>
</head>
<body class="bg-light">
    <?php include('header-2.php'); ?>
    
   
   <?php 
        if(isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];
            $order_query = mysqli_query($conn, "SELECT * FROM orders left JOIN offers on orders.coupen_id =offers.coupenid WHERE order_id = $order_id");
            $order = mysqli_fetch_assoc($order_query);

            $subtotal = $order['subtotal'];
            $discount = $order['discount']; 
            $net_total =$order['total'];
            $order_otp = isset($order['order_otp']) ? $order['order_otp'] : "N/A"; 
        ?>
        <div class="container " style="margin-top:80px">
        <div class="bg-white rounded p-4 rounded shadow-sm mt-150">
            <div class="border-bottom border-dark mb-3 text-center">
                <span><strong>Order Number:</strong> </span><span><?php echo $order['order_number']; ?></span><br>
                <span><strong>Order Date:</strong> <?php echo date("Y-m-d", strtotime($order['created_at'])); ?></span><br>
                <!-- <span><strong>Order Status:</strong> <?php //echo $order['delivery_status']; ?></span> -->
                <span><strong>Order OTP:</strong> <span class="text-success"><?php echo $order_otp; ?></span></span>
            </div>
            
          
            <div>
            <div class="table-responsive">

            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Image</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $items_query = mysqli_query($conn, "SELECT oi.*, p.productname, p.display_price ,p.image
FROM order_items oi
LEFT JOIN product p ON oi.product_id = p.productid where  oi.order_id = $order_id;");
$count=1;
                while ($item = mysqli_fetch_assoc($items_query)) { ?>
                      <tr>
                      <td><?php echo $count; ?></td> 
                            <td><?php echo $item['productname']; ?></td>
                            <td><img src="/zaapin/admin/uploads/<?php echo $item['image'] ?>" width="50px" height="50px"></td>
                            <td><?php echo number_format($item['display_price'], 0); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($item['display_price'] * $item['quantity'], 0); ?></td>
                        </tr>

                <?php 
            $count++;
            } ?>
                   <tr>
                   <td colspan="6" class="">
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
        </div>
            
            </div>

            
            <div class="total-box ">
            
                    
            
            
                
               
                <!-- <button class="btn btn-track">Track Order</button> -->
            </div>
            <div class="row mt-3">
                <!-- <div class="col"> <a class="btn btn-dark text-white w-100" href="track_order.php?orderid=<?php //echo $_GET['order_id'] ?>">Track Order</a></div> -->
                <div class="col">    <a class="btn btn-dark text-white w-100" href="order_history.php">back</a></div>
                   
                
                </div> 
        </div>
        <?php } else { ?>
            <p class="text-danger">No order details found.</p>
        <?php } ?>
    </div>

</body>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.countdown.js"></script>
<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery.meanmenu.min.js"></script>
<script src="assets/js/sticker.js"></script>
<script src="assets/js/main.js"></script>
<script>



fetchCartCount()


function fetchCartCount() {
    $.ajax({
        url: "cartdata.php",
        type: "POST",
        success: function(response) {
            $("#cart-count").text(response.cart_count);
        }
    });
} 
  

</script>
</html>
