
<?php include("../config.php"); ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
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
   

    </style>
    
</head>
<body class="bg-light">
    <?php include('header-2.php') ?>

    <div class=" cart-section container mt-150"  >
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary">Your Orders</h3>
            <a href="index.php" class="btn btn-dark">Explore Menu</a>
        </div>
        <div class="table-responsive">

        <table class="table bg-white shadow-sm p-2">
  <thead class="table-dark">
    <tr>
        <th scope="col">#</th>
      <th scope="col">Order Number</th>
      <th scope="col">Order OTP</th>
      <th scope="col">Date</th>
      <th scope="col">Amount</th>
      <th scope="col">Order Status</th>
      <th>Details</th>
    </tr>
  </thead>
  <tbody>
    
  
 
        <?php 
        if(isset($_SESSION['user_id'])){
            $id = $_SESSION['user_id'];
            $res = mysqli_query($conn, "SELECT * FROM orders WHERE customer_id = $id ORDER BY order_id DESC");
        }
        if(mysqli_num_rows($res) > 0){
            $count=1;
            while($row = mysqli_fetch_assoc($res)) { 

                // Delivery Status Mapping
                $order_status = $row['delivery_status'];
                switch ($order_status) {
                    case '1': $order_status_text = "Pending"; break;
                    case '2': $order_status_text = "Accepted";  break;
                    case '3': $order_status_text = "Rejected";  break;
                    case '4': $order_status_text = "Prepared";  break;
                    case '5': $order_status_text = "On the Way"; break;
                    case '6': $order_status_text = "Delivered"; break;
                    default: $order_status_text = "Unknown"; break;
                }
        ?>
        <tr>
        <th scope="row"><?php echo $count ?></th>
      <td ><?php echo $row['order_number']; ?></td>
      <td><?php echo $row['order_otp']; ?></td>
      <td><?php echo date('d M Y, h:i A', strtotime($row['created_at'])); ?></td>
      <td><?php echo $row['total']; ?></td>
      <td><span><?php echo $order_status_text; ?></span></td>
      <td> <a href="order_items.php?order_id=<?php echo $row['order_id']; ?>" class="btn btn-primary btn-sm">
                            <i class="fa fa-eye"></i> View Details
                        </a></td>
    </tr>

                

            <?php
            
        $count++;}
        } else {?>
          </tbody>
          </table>
        </div>
            <div class="card p-3 text-warning border border-warning text-center">
                <p class="mb-0">No Order History Found</p>
            </div>

        <?php } ?>
        
    </div>
  
</body>

<!-- JS Files -->
<script src="assets/js/jquery-1.11.3.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.countdown.js"></script>
<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery.meanmenu.min.js"></script>
<script src="assets/js/sticker.js"></script>
<script src="assets/js/main.js"></script>
</html>
