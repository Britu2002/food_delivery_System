<?php
if(isset($_GET['del'])){
    session_start();
    $id=$_GET['rid'];
   
    unset($_SESSION['coupon_code']); 

    header("Location: products.php?id=$id"); 
   
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
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            padding: 10px;
            margin-bottom: 30px;
        }
        .single-product-item:hover {
            /* transform: scale(1.05); */
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
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
  }

  @media (min-width: 992px) {
    .st {
      position: fixed;
      right:10px;

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

    echo "<script>window.location.href='products.php?id=$restaurant_id'</script>";
}

?>
<div class=" bg-white border px-5 pt-4  mb-5  " style="margin-top:50px">


   <div class="row">
    <div class="col-md-8 border-right">
    <div class="container mt-4">
        <h2 class="fw-bold"><?php echo $res['title'] ?></h2>
        <!-- <p class="text-muted">Dessert, Chicken</p> -->
        <img src="/zaapin/admin/uploads/<?php echo $res['image'] ?>" class="img-fluid rounded " style="width:810px;height:400px" alt="Food Image">
        <p class="text-left p-1 m-0"><i class="fa-solid fa-location-dot"></i>
                            <?php 
        $full_address = $res['addr'] . ', ' . $res['city']. '- ' . $res['pincode'];
       
        echo $full_address; 
    ?>
                        </p>
                            <p class='text-left p-1 m-0'> <strong>Opening : </strong> <?php echo $res['o_days']; ?> (<?php echo $res['o_hr'] . ' - ' . $res['c_hr']; ?>)</p>
                    
        <!-- <button class="btn btn-primary">Table Order</button> -->
        <!-- <button class="btn btn-info">COUPON: off10</button> -->
        <hr>
        <div class="mt-3">
        <!-- Subcategory Slider -->

        

<div class="row">
    <div class="col-md-12 p-2 m-2">
        <span class="fw-bold p-2">Category </span>
        <div class="owl-carousel subcategory-slider ">
            <?php  
            $res = mysqli_query($conn, "Select DISTINCT categoryname,category.categoryid,category.image FROM product left JOIN category on product.categoryid=category.categoryid where  resid=$id;");
            while ($row = mysqli_fetch_assoc($res)):
                $subcat_id = $row['categoryid'];
                $count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM product WHERE categoryid = '$subcat_id'");
                $count_result = mysqli_fetch_assoc($count_query);
                $item_count = $count_result['total'];
             ?>
            
                <div class="item text-center">
                    <a href="#<?php echo $row['categoryname'] ?>" class="d-flex flex-column align-items-center">
                        <img src="/zaapin/admin/uploads/<?php echo $row['image'] ?>" alt="" width="85px" height="85px" class="subcatimg rounded-circle">
                        <h6 class="fw-bold"><span class="orange-text"><?php echo $row['categoryname'] ?> : <?php echo  $item_count ?></span>
                      
                    </h6>
                      
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</div>  
<hr>
<!-- product -->
<div class="container mt-4">
    <?php 
    $sql = "SELECT DISTINCT c.categoryid, c.categoryname, p.productid, p.productname, p.prodect_type,desp, p.display_price, p.image 
            FROM product p 
            JOIN category c ON p.categoryid = c.categoryid 
            WHERE p.resid = $id 
            ORDER BY c.categoryid";
    
    $food = mysqli_query($conn, $sql);

    $categories = [];
  
    
    // Fetch data and organize it category-wise
    while ($row = mysqli_fetch_assoc($food)) {
        $categories[$row['categoryname']][] = $row;
    }
   
    
    // Display products category-wise
    foreach ($categories as $categoryName => $products) {
        echo "<h3 class='mt-4' id='$categoryName'>$categoryName</h3>";
        echo "<div class='row'>";
        
        foreach ($products as $product) {
            echo "<div class='col-md-6 mb-4 rounded' >";
            echo "    <div class='card d-flex flex-row'>";
         
            echo "        <img src='/zaapin/admin/uploads/{$product['image']}' class='img-fluid' style='width: 150px;height: 150px; object-fit: cover;' alt='{$product['productname']}'>";
          
            echo "        <div class='card-body'>";
            echo "            <h5 class='card-title m-0 '>{$product['productname']}</h5>";
        
            $fulldesp = $product['desp'];
            $short_desp = (strlen($fulldesp) > 100) ? substr($fulldesp, 0, 50) . '...' : $fulldesp;
           
           echo " <small class='card-text text-muted p-1 m-0'>{$short_desp}</small>";
           echo "         <div>
                                        <input class='m-1 p-0' type='number' id='qty_{$product['productid']}' value='1' min='1'><br>
                                      
                                        <button {$disabled}   class='btn btn-danger btn-sm add-to-cart' data-id='{$product['productid']}' data-price='{$product['display_price']}' data-name='{$product['productname']}'>Add</button>
                                        <small class='text-danger {$display}' >Resturant is not active  </small>

                                    </div>";
            
            echo "          ";
            echo "        </div>";
            echo "    </div>";
            echo "</div>";
        }

        echo "</div>"; // End of row
    }
    ?>
</div>

 <!-- emdproduct -->
            
        </div>
    </div> 
    </div>


<!-- cart start -->
<div class="col-md-4   p-0  st"  >
                <div class="row ml-2">
                    <div class="col-md-12 mb-4">
                        <h5 class="text-black">OFFER</h5>
                        <div class="card bg-white shadow-sm">
                            <div class="card-body p-1 d-flex align-items-center justify-content-around">
                                <i class="fa-solid fa-ticket fa-2x text-primary"></i>
                                <?php 
                                if (isset($_SESSION['coupon_code'])):
                                    $coupon_id = $_SESSION['coupon_code']; // ✅ Corrected: Separate variable for coupon ID
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
            </div>

        <!-- endcart -->
    
   </div>


</div>






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
$(document).ready(function(){
    $(".subcategory-slider").owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: false,
        responsive:{
            0:{ items: 2 },
            600:{ items: 3 },
            1000:{ items: 6 }
        },
        navText: [
            "<i class='fas fa-chevron-left' style='font-size:24px; color:#ff6600;'></i>",
            "<i class='fas fa-chevron-right' style='font-size:24px; color:#ff6600;'></i>"
        ]
    });

   

});

</script>
	<script>
$(document).ready(function () {
    $(".add-to-cart").click(function () {
        var product_id = $(this).data("id");
        var product_name = $(this).data("name");
        var product_price = $(this).data("price");
        var quantity = $("#qty_" + product_id).val();
console.log(product_id);
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
