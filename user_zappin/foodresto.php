<?php
if(isset($_GET['del'])){
    session_start();
    $id=$_GET['rid'];
   
    unset($_SESSION['coupon_code']); 

    header("Location: foodresto.php?id=$id"); 
   
}
?>
<?php 

include('../config.php');

    $id = isset($_GET['id'])?$_GET['id']:"";
    $name = isset($_GET['name'])?$_GET['name']:"";
?>
<?php 
$result=mysqli_query($conn,"select * from restaurant where resid=$id");
$res=mysqli_fetch_assoc($result);
$res_status = $res['status'];

$disabled = ($res_status != 'active') ? "disabled" : "";
$display = ($res_status != 'active') ? "" : "d-none";


$categoryQuery = "Select DISTINCT categoryname,category.categoryid,category.image FROM product left JOIN category on product.categoryid=category.categoryid where  resid=$id";
$categoryResult = mysqli_query($conn, $categoryQuery);

// Fetch products from the product table
$productQuery = "SELECT * FROM `product` WHERE resid=$id";
$productResult = mysqli_query($conn, $productQuery);

// Create an array to organize products by category
$productsByCategory = [];
while ($product = mysqli_fetch_assoc($productResult)) {
    $productsByCategory[$product['categoryid']][] = $product;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $name; ?></title>

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
         html {
            scroll-behavior: smooth;
        }
        /* body { background-color:#FFFAFA; } */
        .single-product-item {
            border-radius: 15px;
            /* box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); */
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            padding: 10px;
            margin-bottom: 30px;
        }
        .single-product-item:hover {
            /* transform: scale(1.05); */
            /* box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15); */
        }
        .product-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ff6600;
            margin-top: 15px;
        }
        .view-btn {
            background-color: #ff6600;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .view-btn:hover { background-color: #e65c00; }
        .veg-nonveg-icon {
            width: 30px;
            background-color: white;
            border-radius: 50%;
            padding: 3px;
        }
        .veg-nonveg-icon img { width: 20px; height: 20px; }
        .subcatimg:hover { transform: scale(1.3); }

        <style>
  @media (max-width: 768px) {
    .custom-sidebar {
      position: static !important;
      height: auto !important;
      overflow-y: visible !important;
      margin-top: 1rem;
    }

    .fr{
        float: none;
    }
    .top{
        top:0px
    }
  }

  @media (min-width: 992px) {
    .st {

      position: fixed;
      right:10px;

    }
    .fr{
        float: right;
    }
    .top{
        top:-82px
    }
   
  }
</style>
    </style>
</head>
<body  >

<?php include('header-2.php') ?>
<?php
$restaurant_id = $_GET['id'];
if ($_SESSION['resid'] != $restaurant_id) {
    $_SESSION['cart'] = []; 
    unset($_SESSION['coupon_code']);
}
$_SESSION['resid'] = $restaurant_id;

?>
<?php 
 
$total_price = 0;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $item) {
        $subtotal = $item['price'] * $item['qty'];
        $total_price += $subtotal;
    }
}

if (isset($_GET['delid'])) {
    $product_id = $_GET['delid'];

    // Remove the item from the cart
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }

    // Recalculate total price after deletion
    $total_price = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $subtotal = $item['price'] * $item['qty'];
            $total_price += $subtotal;
        }
    }

    // Check if cart is empty, then remove coupon code
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['coupon_code']);
    } else {
        // Check if applied coupon meets minimum cart conditions
        if (isset($_SESSION['coupon_code'])) {
            $coupon_id = $_SESSION['coupon_code'];
            $couponQuery = "SELECT * FROM offers WHERE coupenid=$coupon_id";
            $couponResult = mysqli_query($conn, $couponQuery);
            if ($couponResult->num_rows > 0) {
                $couponData = mysqli_fetch_assoc($couponResult);
                $min_cart_value = $couponData['min_value']; // Assuming this column exists in your DB
                
                if ($total_price < $min_cart_value) {
                    unset($_SESSION['coupon_code']); // Unset coupon if condition is not met
                }
            }
        }
    }

    echo "<script>window.location.href='foodresto.php?id=$restaurant_id'</script>";
}

?>

<div style="width: 100%; height: 90%; background-image: url('/zaapin/admin/uploads/<?php echo $res['image'] ?>'); background-size: cover; background-position: center; "> </div>

<div class="container mt-4 mb-0">
    <div class="row align-items-start mb-0">
        <!-- Image -->
        <div class="col-md-3 text-center" style="position: relative; top: -80px;">
            <img src="/zaapin/admin/uploads/<?php echo $res['image'] ?>" alt="logo"
                class="img-fluid"
                style="width: 250px; height: 170px; border-radius: 50% 50% 0% 0%; border: 5px solid #fff;">
        </div>

        <!-- Details -->
        <div class="col-md-6">
            <h2 style="font-size: 32px; font-weight: 700; line-height: 1.2;" class="m-0 p-0"><?php echo $res['title'] ?></h2>
            <p style="color: #757575; font-family: Nunito; font-weight: 400; font-size: 18px;" class="m-0 p-0">
                <i class="fa fa-location-arrow"></i>
                <?php echo $res['addr'] . " " . $res['city'] . "-" . $res['pincode']; ?>
            </p>
            <p style="color: rgb(232, 149, 42); font-size: 18px;" class="m-0 p-0">
                <i class="fa fa-phone"></i> <?php echo $res['phone']; ?> &nbsp; &nbsp;
                <i class="fa fa-envelope"></i> <?php echo $res['email']; ?>
            </p>
            
        </div>

        <!-- Working Hours -->
        <div class="col-md-3 text-center">
            <p style="background-color: #FFCC00; padding: 10px 20px; font-weight: 500; border-color: #FFCC00;">
                <b>Working Hours</b><br>
                <span><?php echo $res['o_days'] ?> (<?php echo $res['o_hr'] ?> - <?php echo $res['c_hr'] ?>)</span>
            </p>
        </div>
    </div>
</div>


<section class="bg-light">
   <div class="container">
   
    <div class="row ">
         <!-- products -->
        <div  class="col-md-7 mt-3 bg-white p-3 shaodow rounded ">
        
        <h3 class="fw-bold p-2" style="font-size: 20px; font-weight: 700; text-align: left;margin-bottom: 10px;">Category </h3>
        
        <ul class="nav nav-pills" id="categoryPills" role="tablist">
        <?php
        $i = 0; // For setting the active class on the first tab
        while ($category = mysqli_fetch_assoc($categoryResult)) {
            $activeClass = ($i == 0) ? 'active' : ''; // First tab will be active by default
        ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo $activeClass; ?>" id="pill-<?php echo $category['categoryid']; ?>-tab" data-bs-toggle="pill" href="#pill-<?php echo $category['categoryid']; ?>" role="tab" aria-controls="pill-<?php echo $category['categoryid']; ?>" aria-selected="true">
                    <?php echo $category['categoryname']; ?>
                </a>
            </li>
        <?php
        $i++;
        }
        ?>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="categoryPillsContent">
        <?php
        // Reset the result pointer for category data and loop through again
        mysqli_data_seek($categoryResult, 0);
        $i = 0; // Reset counter for content active class
        while ($category = mysqli_fetch_assoc($categoryResult)) {
            $activeClass = ($i == 0) ? 'show active' : ''; // Set active class for the first content tab
        ?>
            <div class="tab-pane fade <?php echo $activeClass; ?>" id="pill-<?php echo $category['categoryid']; ?>" role="tabpanel" aria-labelledby="pill-<?php echo $category['categoryid']; ?>-tab">
            

                <!-- Display products for this category -->
                <div class="row mt-4">
                    <?php
                    // Check if products exist for this category
                    if (isset($productsByCategory[$category['categoryid']])) {
                        foreach ($productsByCategory[$category['categoryid']] as $product) {
                            $maxProductNameLength = 30;  // Limit for product name
$maxDespLength = 50;  // Limit for description
                            $productName = (strlen($product['productname']) > $maxProductNameLength) ? substr($product['productname'], 0, $maxProductNameLength) . '...' : $product['productname'];


$desp = (strlen($product['desp']) > $maxDespLength) ? substr($product['desp'], 0, $maxDespLength) . '...' : $product['desp'];
                    ?>
                       <div class="col-md-12 border-bottom border-light-subtle mt-3">
    <div class="card bg-white border-0" style="border-radius: 10px; overflow: hidden;">
        <div class="d-flex " style="background-color: #f4f4f4; ">
            <!-- Image on the left -->
            <div class="card-title bg-white m-0 rounded">
            <img src="/zaapin/admin/uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['productname']; ?>" class="img-fluid rounded"  style="width: 100px; height: 100px;" >
            </div>

            
            <!-- Content on the right -->
            <div class="card-body bg-white d-flex flex-column justify-content-center" style="width: 60%; padding: 15px;">
                <h5 class="card-title"><?php echo $productName ?></h5>
                <p class="card-text"><?php echo $desp; ?></p>
                <p class="card-text text-danger m-0 p-0" style="font-size:20px"><strong class="fs-3 text-danger"></strong> ₹<?php echo $product['display_price'];?></p>
                <!-- Order Now Button -->
                 <div class="d-flex justify-content-end align-items-center mt-2">
                 <input class='m-1 p-0' type='number' id='qty_<?php echo $product['productid'];?>' value='1' min='1'>
                 <fieldset <?php echo $res['Working_status']!='open'?"disabled":"" ?>>
                 <button  class='btn btn-warning add-to-cart ' data-id='<?php echo  $product['productid']?>' data-price='<?php  echo $product['display_price']?>' data-name='<?php echo $product['productname'] ?>'>Order Now</button>
               
                 </fieldset>
                 <small class="text-danger "><?php echo $res['Working_status']!='open'?"Resturant is closed Now ":"" ?></small>
                 <!-- <a href="#" class="btn btn-warning">Order Now</a> -->
                 </div>
             
            </div>
        </div>
    </div>
</div>



                    <?php
                        }
                    } else {
                        echo "<p>No products available in this category.</p>";
                    }
                    ?>
                </div>
            </div>
        <?php
        $i++;
        }
        ?>
    </div>
   
    




        </div>
<!-- close products -->


        <!-- offer -->
        <div  class="col-md-4 mt-3 bg-white shadow-none offset-md-1 p-3">
        <!-- <h4>Offer</h4> -->

        <!-- cart start -->
        <div class="row ml-2">
                    <div class="col-md-12 mb-4">
                        <h5 class="text-black">OFFER</h5>
                        <div class="card bg-white ">
                            <div class="card-body p-1 d-flex align-items-center justify-content-around">
                                <i class="fa-solid fa-ticket fa-2x text-primary"></i>
                                <?php 
                                if (isset($_SESSION['coupon_code'])):
                                    $coupon_id = $_SESSION['coupon_code']; 
                                    $result = mysqli_query($conn, "SELECT * FROM offers WHERE coupenid=$coupon_id");
                                    $offers = mysqli_fetch_assoc($result);
                                ?>
                                    <div class="text-dark">
                                        <span><strong>Offer Applied</strong></span>
                                        <span class="p-1" style="background-color:#e0f2f7"><strong><?php echo $offers['coupencode']; ?></strong></span><br>
                                        <input type="hidden" id="percent" value="<?php echo $offers['coupenpercentage']; ?>">
                                        <small class="text-danger"><strong>Save <?php echo $offers['coupenpercentage']; ?>% off with this offer</strong></small>
                                    </div>
                                    <div>
                                        <a href="?rid=<?php echo $_GET['id'] ?>&del=del"><i class="fa fa-trash text-danger"></i></a>
                                    </div>
                                <?php else: ?>
                                    <a href="apply_coupen_page.php?total=<?php echo $total_price; ?>&id=<?php echo $restaurant_id; ?>" id="applyCoupon" class="d-flex align-items-center">
                                        <div class="text-dark">
                                            <span><strong>Select offer / Apply coupon</strong></span><br>
                                            <small>Get discount with your order</small>
                                        </div>
                                        <i class="fa-solid fa-chevron-right text-dark fa-2x ml-2"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12  ">
                        <h5 class="text-black ">Cart</h5>    
                        <div class="card bg-white shadow-sm">
                            <div class="card-body">
                                <?php
                                if (!empty($_SESSION['cart'])) {
                                    foreach ($_SESSION['cart'] as $key => $item) {
                                        $subtotal = $item['price'] * $item['qty'];
                                    
                                        echo '<div class="d-flex  align-items-center mb-2">
                                        <div class="mr-2"><a href="?delid=' . $key . '&id=' . $restaurant_id . '" class="text-danger "><i class="fa fa-x"></i></a></div>
                                              <div class="flex-grow-1"><p class="m-0"><strong>' . $item['name'] . '</strong> (x' . $item['qty'] . ')</p></div>
                                              <div  class=""><p class="m-0">' . $subtotal . '</p></div>
                                              
                                              </div>';
                                    }
                                    echo '<hr><p class="text-right">Total: ' . $total_price . '</p>';
                                    $discount = 0;
$final_price = $total_price;

if (isset($_SESSION['coupon_code'])) {
    $coupon_id = $_SESSION['coupon_code']; 
    $result = mysqli_query($conn, "SELECT * FROM offers WHERE coupenid=$coupon_id");
    $offers = mysqli_fetch_assoc($result);
    
    if ($offers) {
        $discount_percentage = $offers['coupenpercentage'];
        $discount = ($total_price * $discount_percentage) / 100;
        $final_price = $total_price - $discount;
    }
}

// Store the final price in session for checkout
$_SESSION['final_price'] = $final_price;
 if ($discount > 0){ 
    ?>
        <p class="text-right text-success">Discount (<?php echo $discount_percentage; ?>%): -<?php echo number_format($discount, 0); ?></p>
        <p class="text-right ">Final Total: <?php echo number_format($final_price, 0); ?></p>
    <?php

 }
 ?><div class="d-flex justify-content-center "><a href="checkout_summary.php?id=<?php echo $_GET['id'] ?>" class="text-center btn btn-danger">CheckOut</a></div><?php


                                } else {
                                    echo '<p class="text-center">Your cart is empty</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
         <!-- end start -->
        </div>
        <!-- close offer -->
        
    </div>
   </div>
   
</section>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<!-- Scripts -->
<script src="assets/js/jquery-1.11.3.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.countdown.js"></script>
<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery.meanmenu.min.js"></script>
<script src="assets/js/sticker.js"></script>
<script src="assets/js/main.js"></script>

<!-- Owl Carousel Initialization -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
    let firstTab = document.querySelector('.nav-pills .nav-link');
    if (firstTab) {
        firstTab.classList.add('active');
    }
});



</script>
	<script>
$(document).ready(function () {
    $(".add-to-cart").click(function () {
        var product_id = $(this).data("id");
        var product_name = $(this).data("name");
        var product_price = $(this).data("price");
        var quantity = $("#qty_" + product_id).val();
        // console.log("hello");
// console.log(product_name+" "+ product_price+" "+ quantity);
        $.ajax({
            url: "add-to-cart.php",
            type: "POST",
            data: {
                id: product_id,
                name: product_name,
                price: product_price,
                qty: quantity
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    alert("Added to cart successfully!");
                    location.reload(); // Reload page to update cart
                }
            }
        });
    });
});
</script>

</body>
</html>
