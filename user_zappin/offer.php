<?php include('../config.php');
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product-<?php echo $name; ?></title>

    <!-- CSS Links -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

    <style>
        body { background-color:#f5f5f5; }
        .container{
            
        }
        .single-product-item {
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            padding: 10px;
            margin-bottom: 30px;
        }
        .single-product-item:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
        }
       
    </style>
</head>
<body >



<!-- Subcategory Slider -->
<div class="container px-5"  >
    <div class="row">
        <div class="col-md-12 p-2 m-2">
            <h5 class="fw-bold p-2">Offer & Coupen</h5>
            <div class="owl-carousel subcategory-slider ">
                <?php  
                $res = mysqli_query($conn, "SELECT * FROM offers order by coupenid desc");
                while ($row = mysqli_fetch_assoc($res)): ?>
                    <div class="item text-center">
         
                            <img src="/zaapin/admin/uploads/<?php echo $row['coupenophtoto'] ?>" alt="" width="500px" height="250px" class="subcatimg rounded">
                            <h6 class="fw-bold"><span class="orange-text"><?php echo $row['coupencode'] ?></span></h6>
                       
                    </div>
                <?php endwhile; ?>
            </div>
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

<!-- Owl Carousel Initialization -->
<script>
    $(document).ready(function(){
        $(".subcategory-slider").owlCarousel({
            loop: true,
          
            margin: 20,
            nav: true,
            dots: false,
            autoplay: true, 
        autoplayTimeout: 2000, 
        autoplayHoverPause: false, 
        smartSpeed: 1000, 

            responsive:{
                0:{ items: 2 },
                600:{ items: 3 },
                1000:{ items: 3 }
            },
            navText: [
                "<i class='fas fa-chevron-left' style='font-size:24px; color:black;background-color:white'></i>",
                "<i class='fas fa-chevron-right' style='font-size:24px; color:black;background-color:white'></i>"
            ]
        });
    });
</script>

</body>
</html>
