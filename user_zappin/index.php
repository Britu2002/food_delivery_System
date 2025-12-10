<?php include('../config.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="">
	<meta name="" content="width=device-width, initial-scale=1">
	<meta name="" content="">

	<!-- title -->
	<title><?php echo $website_name; ?></title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
	a {
    text-decoration: none;
}

html, body {
  height: 100%;
  width: 100%;
  font-family: sans-serif;
}

.hero-section {
  background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
  url('/zaapin/user_zappin/assets/img/bannerbg1.jpg'); /* replace with your image path */
  background-size: cover;        /* Ensures image covers entire div */
  background-position: center;   /* Keeps the image centered */
  background-repeat: no-repeat;  /* Prevents repeating */
  height: 100vh;                 /* Full viewport height */
  width: 100vw;                  /* Full viewport width */
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
}


  /* .hero-section {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                url('/zaapin/user_zappin/assets/img/bgdish.jpg') no-repeat center center;
    background-size: contain;
	
    height: 70vh;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    animation: zoomBackground 10s ease-in-out infinite;
  } */

  @keyframes zoomBackground {
    0% { background-size: 100%; }
    50% { background-size: 110%; }
    100% { background-size: 100%; }
  }

  /* Responsive Adjustments */
  @media (max-width: 768px) {
    .hero-section {
      height: 50vh; /* Adjust height for smaller screens */
    }
  }

  @media (max-width: 480px) {
    .hero-section {
      height: 40vh; /* Smaller height for mobile */
    }
  }

  .hero-title {
	font-size: 50px;
  font-weight: 700;
  line-height: 1.3;
  color: #fff;
  font-family: merienda;
  }

  /* Responsive Font Size */
  @media (max-width: 768px) {
    .hero-title {
      font-size: 40px;
    }
  }

  @media (max-width: 480px) {
    .hero-title {
      font-size: 30px;
    }
  }

</style>
</head>
<body class="bg-white">
	<?php include('header.php') ?>
	
	<div class="hero-section mb-0">
  <div class="container text-center">
    <h1 class="hero-title">Enjoy Our Delicious Meal</h1>
	<div class="hero-btns">
								<a href="cat.php" class="boxed-btn text-decoration-none" >Order Food </a>
								<a href="contact.php" class="bordered-btn text-decoration-none">Contact Us</a>
							</div>
  </div>
</div>

	<!-- end hero area -->
	


	<!-- features list section -->
	<div class="list-section pt-80 pb-80">
		<div class="container">

			<div class="row">
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon">
							<i class="fas fa-shipping-fast"></i>
						</div>
						<div class="content">
							<h3>Free Shipping</h3>
							<p>When order over $75</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon">
							<i class="fas fa-phone-volume"></i>
						</div>
						<div class="content">
							<h3>24/7 Support</h3>
							<p>Get support all day</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="list-box d-flex justify-content-start align-items-center">
						<div class="list-icon">
							<i class="fas fa-sync"></i>
						</div>
						<div class="content">
							<h3>Refund</h3>
							<p>Get refund within 3 days!</p>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<?php  include('cat.php')?>
	<?php  include('order-step.php')?>

	<!-- end features list section -->
<?php  include('category.php')?>

	<
	
	

	
	
	



	<?php include('footer.php') ?>
	
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
$(document).ready(function(){


  
fetchCartCount()
});

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
</body>
</html>