<?php
include("../config.php");

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $query = "UPDATE orders SET delivery_status = 5 WHERE order_id = $order_id";
   
   mysqli_query($conn,$query);
    
   echo "<script>
   alert('status update');
   window.location.href='agent_index.php?orderid=$order_id';
   </script>";

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Orders</title>
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
<body class="bg-light ">
    <?php include('header_agent.php'); ?>
    <?php

include("../config.php");

// Ensure the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['userid'];

// Fetch orders assigned to the delivery agent
$res = mysqli_query($conn, "SELECT
    o.order_id, 
    o.order_number,
    u.name as fullname, 
    u.mobile,
    u.address,u.city,u.pincode,
    o.delivery_status,
    o.created_at 
    FROM orders o 
    LEFT JOIN customer u ON o.customer_id = u.cid 
    WHERE o.delivery_boy_id = $id
    AND DATE(o.created_at) = CURDATE()
    AND delivery_status < 6
");

?>
    <div class="  position-relative  overflow-y ">
        <h2 class="text-center text-primary">Assigned Deliveries</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8 mb-5">
                <?php if (mysqli_num_rows($res) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($res)): ?>
                        <div class="card shadow-sm p-4 my-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="order_detail_agent.php?orderid=<?php echo $row['order_id']?>">
                                    <h5 class="text-dark"><strong>Order #<?php echo $row['order_number']; ?></strong></h5>
                                </a>
                                <span class="badge <?php echo getOrderStatusClass($row['delivery_status']); ?> p-2">
                                    <?php echo getOrderStatusText($row['delivery_status']); ?>
                                </span>
                            </div>
                            <hr>
                            <p><strong>Customer:</strong> <?php echo $row['fullname']; ?></p>
                            <p><strong>Address:</strong> <?php echo $row['address']." ".$row['city'].",".$row['pincode']; ?></p>
                            <p><strong>Contact:</strong> 
                                <a href="tel:<?php echo $row['mobile']; ?>" class="btn btn-outline-success btn-sm">Call <?php echo $row['mobile']; ?></a>
                                <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($row['address']); ?>" 
                                    target="_blank" class="btn btn-outline-primary btn-sm">View Location</a>
                            </p>
                            <small class="text-muted">Order Date: <?php echo $row['created_at']; ?></small>
                            
                            <!-- Order Status Update Form -->
                            <!-- <form class="update-status-form mt-3" method="POST">
                                <input type="hidden" name="order_id" value="<?php// echo $row['order_id']; ?>">
                                <select name="delivery_status" class="form-select form-select-sm">
                                    <option value="4" <?php //echo $row['delivery_status'] == 4 ? 'selected' : ''; ?>>Prepared Food</option>
                                    <option value="5" <?php //echo $row['delivery_status'] == 5 ? 'selected' : ''; ?>>Order on Way</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary update-status-btn mt-2">Update</button>
                            </form> -->
                            <div class="mt-3 d-flex gap-2 ">
                                <a href="order_detail_agent.php?orderid=<?php echo $row['order_id']; ?>" class="btn btn-primary btn-sm btn-custom">View Details</a>
                           <fieldset <?php echo ($row['delivery_status']==5)?"disabled":"" ?>>
                              <a href="?order_id=<?php echo $row['order_id']?>" class="btn btn-warning btn-sm btn-custom"><?php echo ($row['delivery_status']<=4)?"Pick UP":"Order on Way" ?></a>
                              </fieldset>
      
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-warning text-center mt-5">No Orders Assigned</div>
                <?php endif; ?>
            </div>
        </div>
        <footer class="bg-black text-white fixed-bottom py-3 ">
    <div class="px-5  d-flex justify-content-between align-items-center">
        <a href="agent_index.php" class="text-white text-decoration-none">
            <i class="fa-solid fa-clock"></i> Pending Orders
        </a>
        <a href="delivered_orders.php" class="text-white text-decoration-none">
            <i class="fa-solid fa-check"></i> Delivered Orders
        </a>
    </div>
</footer>
    </div>
  



    <script src="assets/bootstrap/js/bootstrap.min.js"></script>



</body>
</html>

<?php
function getOrderStatusText($status) {
    switch ($status) {
        case '1': return "Order Pending";
        case '2': return "Order Accepted";
        case '3': return "Order Rejected";
        case '4': return "Prepared Food";
        case '5': return "On the Way";
        case '6': return "Delivered";
        default: return "Unknown Status";
    }
}

function getOrderStatusClass($status) {
    switch ($status) {
        case '1': return "bg-info text-white";
        case '2': return "bg-success text-white";
        case '3': return "bg-danger text-white";
        case '4': return "bg-primary text-white";
        case '5': return "bg-warning text-dark";
        case '6': return "bg-success text-white";
        default: return "bg-secondary text-white";
    }
}
?>
