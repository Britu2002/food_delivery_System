<?php include('../config.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>Search</title>
	<style>
        .category-card {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            text-align: center;
            display: block;
            text-decoration: none;
            color: white;
        }

        .category-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        .category-card:hover img {
            transform: rotate(3deg) scale(1.05);
        }

        .category-name {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 10px;
            font-size: 18px;
        }
    </style>
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

</head>
<body>
	
	
<?php include('header.php') ?>
	
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section " style="background:url('assets/img/searchbg1.jpg')  no-repeat;background-size:100vw 100%">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						
						<h2 class="text-white" style="font-family:initial">Searching '<?php echo  isset($_GET['search_name'])?$_GET['search_name']:"" ?>'</h2>
                        <form action="" method="get" class="d-flex border ">
							<input type="text" placeholder="Search Your Favorite Food " autocomplete="off" required name="search_name" class=" text-white fw-bold form-control shadow-none bg-transparent border-0 col-11">
							<button type="submit" class="btn bg-transparent border-0 shadow-none  text-white rounded"> <i class="fas fa-search"></i></button>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->


            
         
            <?php
      $search_term=isset($_GET['search_name'])?$_GET['search_name']:"";
            $sql= "SELECT 
product.*,c.categoryname ,r.title
FROM product 
LEFT JOIN category c on product.categoryid=c.categoryid
LEFT JOIN restaurant r on product.resid=r.resid
WHERE c.categoryname LIKE'%$search_term%' or productname LIKE '%$search_term%' or title LIKE'%$search_term%';";
             

$res = mysqli_query($conn, $sql);

?>
<div class="container ">
   
    <div class="row mt-4">
        <?php
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                echo '<div class="col-md-3 mb-4">';
                echo '<a href="foodresto.php?id=' . urlencode($row["resid"]) . '" class="category-card">';
                echo '<img src="/zaapin/admin/uploads/' . $row["image"] . '" alt="' . $row["productname"] . '">';
                echo '<div class="category-name">' . $row["productname"].'<br>' .$row['display_price']. '</div>';
				
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo "<p class='text-center'>No Food found</p>";
        }
        ?>
    </div>
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
 
</script>
</body>
</html>