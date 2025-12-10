<?php  
 
include('../config.php'); // Database connection

// Fetch counts from database
$products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM product"))['total'];
$offers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM offers"))['total'];
$customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM customer "))['total'];
$agents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM agent "))['total'];
$resto = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM restaurant"))['total'];
$order_pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE delivery_status='1' and DATE(created_at) = CURDATE()" ))['total'];
$order_accepted = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE delivery_status='2' and DATE(created_at) = CURDATE()"))['total'];
$order_rejected = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE delivery_status='3' and DATE(created_at) = CURDATE()"))['total'];
$food_preparing = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM  orders WHERE delivery_status='4'  and DATE(created_at) = CURDATE()"))['total'];
$delivery_on_way = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE delivery_status='5' and DATE(created_at) = CURDATE()"))['total'];
$delivered_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE delivery_status='6' and DATE(created_at) = CURDATE()"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .content {
            padding: 20px;
        }
        .card-container {
            
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            display: flex;
           
        }
        .icon-container {
            min-width: 60px;
            min-height: 60px;
            border-radius: 10px 0 0 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-content {
            flex-grow: 1;
            text-align: left;
            padding-left: 15px;
        }
        .fs-4 a {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }
        .bg-warning{
          background-color:orange;
        }
        .h3_dashb{
          font-family: initial;
        }
    </style>
</head>
<body class="bg-light">

  <?php include('admin-header.php');  ?>
    <div class="content" id="mainContent">
        <h2 class="fw-bold mb-3 h3_dashb" >Dashboard</h2>
        <hr>
        <div class="container">
            <div class="row row-col-lg-3s-1 row-col-lg-3s-md-2 row-col-lg-3s-lg-3 g-4 justify-content-center">
                <div class="col-lg-3">
                    <div class="card-container">
                        <div class="icon-container bg-danger"><i class="text-white fa fa-building fa-3x"></i></div>
                        <div class="card-content">
                            <h5>Products</h5>
                            <p><b class="fs-4"><a class="text-warning" href="listproduct.php"><?= $products ?></a></b></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card-container">
                        <div class="icon-container bg-primary"><i class="text-white fa fa-ticket fa-3x"></i></div>
                        <div class="card-content">
                            <h5>Coupen</h5>
                            <p><b class="fs-4"><a class="text-warning" href="listoffer.php"><?= $offers ?></a></b></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card-container">
                        <div class="icon-container bg-warning"><i class="text-white fa fa-users fa-3x"></i></div>
                        <div class="card-content">
                            <h5>Customers</h5>
                            <p><b class="fs-4"><a class="text-warning" href="listuser.php?role=customer"><?= $customers ?></a></b></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card-container">
                        <div class="icon-container bg-warning"><i class="text-white fa fa-users fa-3x"></i></div>
                        <div class="card-content">
                            <h5>Delivery Agents</h5>
                            <p><b class="fs-4"><a class="text-warning" href="listuser.php?role=delivery"><?= $agents ?></a></b></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card-container">
                        <div class="icon-container bg-primary"><i class="text-white fa fa-cutlery fa-3x"></i></div>
                        <div class="card-content">
                            <h5>Restaurant</h5>
                            <p><b class="fs-4"><a class="text-warning" href="list-resto.php"><?=$resto ?></a></b></p>
                        </div>
                    </div>
                </div>

 
                <div class="col-lg-3">
                    <div class="card-container">
                        <div class="icon-container bg-primary"><i class="text-white fa fa-cutlery fa-3x"></i></div>
                        <div class="card-content">
                            <h5>Orders Pending</h5>
                            <p><b class="fs-4"><a class="text-warning" href="listorder.php?status=1"><?=$order_pending ?></a></b></p>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3">
                    <div class="card-container">
                        <div class="icon-container bg-danger"><i class="text-white fa fa-cutlery fa-3x"></i></div>
                        <div class="card-content">
                            <h5>Order Rejected</h5>
                            <p><b class="fs-4"><a class="text-warning" href="listorder.php?status=3"><?= $order_rejected ?></a></b></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card-container">
                        <div class="icon-container bg-info"><i class="text-white fa fa-cutlery fa-3x"></i></div>
                        <div class="card-content">
                            <h5>Food Perparing</h5>
                            <p><b class="fs-4"><a class="text-warning" href="listorder.php?status=4"><?= $food_preparing ?></a></b></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card-container">
                        <div class="icon-container bg-info"><i class="text-white fa fa-motorcycle fa-3x"></i></div>
                        <div class="card-content">
                            <h5>Delivery on the Way</h5>
                            <p><b class="fs-4"><a class="text-warning" href="listorder.php?status=5"><?= $delivery_on_way ?></a></b></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card-container">
                        <div class="icon-container bg-success"><i class="text-white fa fa-paper-plane fa-3x"></i></div>
                        <div class="card-content">
                            <h5>Delivered Orders</h5>
                            <p><b class="fs-4"><a class="text-warning" href="listorder.php?status=6"><?= $delivered_orders ?></a></b></p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</body>
</html>
