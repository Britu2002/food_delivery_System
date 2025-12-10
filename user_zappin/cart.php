<?php

include '../config.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart</title>

    <!-- Stylesheets -->
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
</head>
<body class="bg-light">

<?php include('header-2.php'); ?>


<!-- Empty Cart Message -->
<div id="oops" class="card mt-150 mx-5 p-5 text-center shadow-lg col-md-8" style="display: <?php echo (empty($_SESSION['cart'])) ? 'block' : 'none'; ?>;">
    <div class="my-3">
        <img src="https://localhost/zaapin/user_zappin/assets/img/shoping-bag.jpg" class="rounded-circle" alt="img" style="width:100px;height:100px">
    </div>
    <h4 class="fw-bold">Your Cart is Empty</h4>
    <span>Please add menu's in your plate!</span><br>
    <a href="products.php" class="btn mt-2 bg-dark text-white">Order Now</a>
</div>

<!-- Cart Section -->
<div class="cart-section mb-150" style="display: <?php echo (!empty($_SESSION['cart'])) ? 'block' : 'none'; ?>;margin-top:80px">
    <div class="container">
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8 col-md-12">
                <div class="cart-table-wrap">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><h5>Your Cart</h5></div>
                        <div><a href="products.php" class="btn text-primary"><strong>Explore Menu</strong></a></div>
                    </div>
                    <table class="cart-table">
                        <thead class="text-white" style="background-color:#051922;">
                            <tr class="table-head-row">
                                <th class="product-remove"></th>
                                <th class="product-image">Product Image</th>
                                <th class="product-name">Name</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-total">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($_SESSION['cart'])) {
                                $cart_items = $_SESSION['cart'];
                                $product_ids = array_keys($cart_items);
                                $ids = implode(",", $product_ids);
                                
                                $query = "SELECT *  FROM product   WHERE productid IN ($ids)" ;
                                $result = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <tr class="table-body-row bg-white" id="row-<?php echo $row['productid']; ?>">
                                        <td class="product-remove">
                                            <a href="#" class="remove-btn" data-id="<?php echo $row['productid']; ?>">
                                                <i class="far fa-window-close"></i>
                                            </a>
                                        </td>
                                        <td class="product-image"><img src="/zaapin/admin/uploads/<?php echo $row['image'] ?>" alt=""></td>
                                        <td class="product-name"><?php echo $row['productname'] ?></td>
                                        <td class="product-price"><?php echo $row['display_price'] ?></td>
                                        <td class="product-quantity">
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item"><a class="page-link decrease-btn" data-id="<?php echo $row['productid']; ?>"><i class="fa fa-minus"></i></a></li>
                                                <li class="page-item"><a class="page-link quantity-text" id="qty-<?php echo $row['productid']; ?>"><?php echo $_SESSION['cart'][$row['productid']]['quantity']; ?></a></li>
                                                <li class="page-item"><a class="page-link increase-btn" data-id="<?php echo $row['productid']; ?>"><i class="fa fa-plus"></i></a></li>
                                            </ul>
                                        </td>
                                        <td class="product-total"><?php echo $row['display_price'] * $_SESSION['cart'][$row['productid']]['quantity']; ?></td>
                                    </tr>
                                <?php endwhile; 
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <!-- Delivery Address Section -->
                <div class="mb-3">
                  
  


                    
                    <input type="hidden" id="hasAddress" value="<?php echo (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) ? '1' : '0'; ?>">
                </div>

                <!-- Offers Section -->
                <div class="mb-3">
                    <h6 class="py-2 m-0">Offers</h6>
                    <div class="card bg-white shadow-sm">
                        <div class="card-body p-1 d-flex align-items-center justify-content-around">
                            <i class="fa-solid fa-ticket fa-2x text-primary"></i>
                            <?php if(isset($_SESSION['coupon_code'])):
                                $id = $_SESSION['coupon_code'];
                                $result = mysqli_query($conn, "SELECT * FROM offers WHERE coupenid=$id");
                                $offers = mysqli_fetch_assoc($result);
                            ?>
                                <div class="text-dark">
                                    <span><strong>Offer Applied</strong></span>
                                    <span class="p-1" style="background-color:#e0f2f7"><strong><?php echo $offers['coupencode'] ?></strong></span><br>
                                    <input type="hidden" id="percent" value="<?php echo $offers['coupenpercentage'] ?>">
                                    <small class="text-danger"><strong>Save <?php echo $offers['coupenpercentage'] ?>% off with this offer</strong></small>
                                </div>
                                <div>
                                    <a href="remove_discount.php"><i class="fa fa-trash text-danger"></i></a>
                                </div>
                            <?php else: ?>
                                <a href="apply_coupen_page.php?total=" id="applyCoupon" class="d-flex align-items-center">
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

                <!-- Price Details Section -->
                <div class="mb-3">
                    <h6 class="py-2 m-0">Price Details</h6>
                    <div class="card bg-white shadow-sm">
                        <div class="card-body p-2 m-2">
                            <div class="row p-2">
                                <div class="col"><strong>Sub Total :</strong></div>
                                <div class="col-4 subtotal"></div>
                            </div>
                            <div class="row p-2">
                                <div class="col"><strong>Discount :</strong></div>
                                <div class="col-4" id="dis">Rs. 0</div>
                            </div>
                            <div class="row p-2">
                                <div class="col"><strong>Grand Total :</strong></div>
                                <div class="col-4 total"></div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <div class="row">
                                            <div class="col-5">
                                                <a id="payment" href="payment_options.php?total="  class="d-block btn">
                                                    <div class="d-flex align-items-center justify-content-around">
                                                        <div class="p-2 bg-light rounded">
                                                            <i class="fa-solid fa-indian-rupee-sign border border-dark p-2 rounded-circle bg-white"></i>
                                                        </div>
                                                        <small>Cash on Delivery</small>
                                                        <i class="fa-solid fa-chevron-down ml-2"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a id="checkoutLink" href="summary.php" class="d-block btn btn-danger text-white p-2 h-100">
                                                    <div class="d-flex align-items-center justify-content-around h-100">    
                                                        <div>
                                                            <span><strong>Pay </strong></span>
                                                            <i class="fa-solid fa-indian-rupee-sign mx-1"></i>
                                                            <span class="total"></span>
                                                        </div>
                                                        <i class="fa-solid fa-chevron-right ml-2"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <a href="/zaapin/login.php" class="d-block btn btn-danger text-white p-2" onclick="alert('Please login first to proceed to checkout!');">
                                            <i class="fa-solid fa-sign-in-alt"></i> Login to Checkout
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div> <!-- End Cart Summary -->
        </div>
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
<script>
$(document).ready(function(){
    $(".increase-btn, .decrease-btn, .remove-btn").click(function() {
        let productId = $(this).data("id");
        let action = $(this).hasClass("increase-btn") ? "increase" : 
                     $(this).hasClass("decrease-btn") ? "decrease" : "remove";

        $.ajax({
            url: "cartdata.php",
            type: "POST",
            data: { id: productId, action: action },
            dataType: "json",
            success: function(response) {
             
                if (response.quantity <= 0 || action === "remove") {
                    $("#cart-count").text(response.cart_count);
                    $("#row-" + productId).fadeOut(500, function() {
                        $(this).remove();
                        updateCartTotal();
                    });
                } else {
                    $("#cart-count").text(response.cart_count);
                    $("#qty-" + productId).text(response.quantity);
                    let productPrice = parseFloat($("#row-" + productId).find(".product-price").text());
                    $("#row-" + productId).find(".product-total").text((productPrice * response.quantity).toFixed(0));
                    updateCartTotal();
                }

                if (response.cart_count == 0) {
                    $(".cart-section").fadeOut(300);
                    $("#oops").fadeIn(300);
                }
            }
        });
    });

    function updateCartTotal() {
        let subtotal = 0;

        $(".table-body-row").each(function() {
            subtotal += parseFloat($(this).find(".product-total").text()) || 0;
        });

        let discountPercentage = $("#percent").val() || 0;
        let discountAmount = (subtotal * discountPercentage) / 100;
        let total = subtotal - discountAmount;

        $(".subtotal").text(subtotal.toFixed(0));
        $("#dis").text(discountAmount.toFixed(0));
        $(".total").text(total.toFixed(0));
        
        // Update checkout and coupon links with the current total
        $("#checkoutLink").attr("href", "summary.php?discount=" + discountAmount.toFixed(0)+"&"+"total="+ subtotal.toFixed(0));
        $("#applyCoupon").attr("href", "apply_coupen_page.php?total=" + subtotal.toFixed(0));
        $("#payment").attr("href", "payment_options.php?discount=" + discountAmount.toFixed(0)+"&"+"total="+ subtotal.toFixed(0));
    }  

    updateCartTotal();
    fetchCartCount();

    // Prevent checkout if no address is set
    $("#checkoutLink,#payment").click(function(e){
        if ($("#hasAddress").val() == '0') {
            e.preventDefault();
            alert("Please select your address before proceeding to checkout!");
            window.location.href = "change_location.php";
        }
    });
});

function fetchCartCount() {
    $.ajax({
        url: "cartdata.php",
        type: "POST",
        success: function(response) {
            $("#cart-count").text(response.cart_count);
           
                        updateCartTotal();
        }
    });
}
</script>
</body>
</html>
