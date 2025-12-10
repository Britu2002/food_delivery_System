<?php
include '../config.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>

  
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
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .card { border-radius: 12px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .btn-custom { background-color: #ff6600; color: white; font-weight: bold; border-radius: 8px; transition: 0.3s; }
        .btn-custom:hover { background-color: #cc5500; }
        .product-img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>
<?php include('header-2.php');
if(isset($_SESSION['user_id'])){
    $id=	$_SESSION['user_id'];
    $result=mysqli_query($conn,"select * from users where userid =$id");
    $row=mysqli_fetch_assoc($result);
    }
?>

<div class=" container "  style="margin-top:80px;">
    <div class="row card p-4 bg-white">
        <!-- Billing Details -->
        <div class="col-md-12">
            <div class="">
                <h4 class="mb-3">contact Details</h4>
                <form id="checkout-form">
                   
                   
                    <div class="mb-3">
                        <label>Delivery Address</label>
                        <textarea name="address" class="form-control" required id="address" >Loading...</textarea >
                    </div>
					
                    
                    
                 
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-12">
            <div class="">
                <h4 class="mb-3">Order Details</h4>
                <ul class="list-group mb-3">
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $productId => $item) {
                        $query = mysqli_query($conn, "SELECT p.*, MIN(ap.img) AS img FROM product p 
                                                      LEFT JOIN add_photos ap ON p.productid = ap.entityid 
                                                      WHERE p.productid = $productId GROUP BY p.productid");
                        $row = mysqli_fetch_assoc($query);
                        $subtotal = $row['display_price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <img src="/zaapin/admin/uploads/<?php echo $row['img']; ?>" class="product-img me-2">
                            <span><?php echo $row['productname']; ?> (x<?php echo $item['quantity']; ?>)</span>
                            <strong>$<?php echo number_format($subtotal, 2); ?></strong>
                        </li>
                    <?php } ?>
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <strong>Total</strong>
                        <strong>$<?php echo number_format($total, 2); ?></strong>
                    </li>
                </ul>

                <button type="submit" class="btn btn-danger w-100 mt-3">Place Order</button>
                    <!-- <a href="payment.php" class="btn btn-danger w-100 mt-3">payment</a> -->
                </form>
            </div>
        </div>
    </div>
</div>


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
$(document).ready(function () {
    fetchCartCount();

    $("#checkout-form").submit(function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: "process_checkout.php",
            type: "POST",
            data: formData,
            dataType: "json", // Ensure jQuery parses JSON automatically
            success: function (response) {
                if (response.status === "success") {
                   
                    window.location.href = "payment.php?orderid=" + response.order_id;
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Something went wrong. Please try again.");
            }
        });
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
<script>
    
    function getCurrentAddress() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          const latitude = position.coords.latitude;
          const longitude = position.coords.longitude;

          console.log(`Latitude: ${latitude}, Longitude: ${longitude}`);

          const url = `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`;

          fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log(data)
              if (data.error) {
                document.getElementById('address').textContent = 'No address found';
              } else {
                document.getElementById('address').textContent = data.display_name;
              }
            })
            .catch(error => {
              document.getElementById('address').textContent = 'Error: ' + error.message;
            });
        }, function(error) {
          document.getElementById('address').textContent = 'Error: ' + error.message;
        });
      } else {
        document.getElementById('address').textContent = 'Geolocation is not supported by this browser.';
      }
    }

    // Call the function to get the current address
    getCurrentAddress();
  </script>
</body>
</html>
