<?php
if(isset($_GET['del'])){
    session_start();
    $id=$_GET['rid'];
   
    unset($_SESSION['coupon_code']); 

    header("Location: shop.php?id=$id"); 
   
}

?>
<?php include('../config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<title>Shop</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="assets/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

<?php include('header.php'); ?>



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

    echo "<script>window.location.href='shop.php?id=$restaurant_id'</script>";
}

?>

<!-- Breadcrumb Section -->
<div class="breadcrumb-section breadcrumb-bg" style="background-image:url('assets/img/bannerbg1.jpg')">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 text-left">
				<div class="breadcrumb-text">
					<?php
					// Fetch restaurant details
					$resQuery = "SELECT * FROM restaurant WHERE resid = $restaurant_id";
					$resResult = $conn->query($resQuery);
					
					if ($resResult->num_rows > 0) {
						$resData = $resResult->fetch_assoc();
						echo '<div class="d-flex align-items-center gap-2">';
						echo '<div class="mr-3 border bg-white p-3"><img src="/zaapin/admin/uploads/' . $resData['image'] . '" width="200px" height="133px"></div>';
						echo '<div><h2 class="text-white">' . $resData['title'] . '</h2>';
						echo '<p>' . $resData['addr'] . ', ' . $resData['city'] . '</p></div>';
						echo '</div>';
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Product Section -->
<div class="product-section" style="margin-top:40px;padding-bottom:80px">
    <div class="container bg-white">
        <div class="row product-lists m-0 p-0">
         

            <!-- Our Menu Section -->
            <div class="col-md-8">
                <h5 class="text-black m-0 p-0">Our Menu</h5><br>
                <?php
                $sql = "SELECT * FROM product WHERE resid = $restaurant_id"; // ✅ Fixed query
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-md-12 m-0 p-0">
                            <ol class="list-group list-group-numbered m-0 p-0">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <img src="/zaapin/admin/uploads/'.$row['image'].'" width="100" height="85px">
                                        <p class="h5 text-warning">'.$row['productname'].'</p>
                                       
                                    </div>
                                     <strong>$'.$row['display_price'].'</strong>
                                    <div>
                                        <input type="number" id="qty_'.$row['productid'].'" value="1" min="1"><br>
                                        <button class="btn btn-primary btn-sm add-to-cart" data-id="'.$row['productid'].'" data-price="'.$row['display_price'].'" data-name="'.$row['productname'].'">Add To Cart</button>

                                    </div>
                                </li>
                            </ol>
                          </div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>


	
	
	<!-- jquery -->
	<script src="assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="assets/js/main.js"></script>
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