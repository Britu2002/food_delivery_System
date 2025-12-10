<?php session_start();

 ?>

	<!-- header -->
	<div style="background-color:#051922;height:65px"class="p-2 top-header-area" id="sticker">
	<div class="mx-5">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="index.php">
								<img src="/zaapin/img/logo-dark.png" alt=""  style="filter: invert(60%) sepia(99%) saturate(683%) hue-rotate(348deg) brightness(101%) contrast(99%);">
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul class="d-flex justify-content-end" >
							<?php if(isset($_SESSION['user_id'])): ?>
								<li><a href="#"><i class="fas fa-user-circle"></i></a>
									<ul class="sub-menu">
										<li><a class="text-decoration-none" href="user_profile.php?userid=<?php echo $_SESSION['user_id'] ?>">My Profile</a></li>
										<li><a class="text-decoration-none" href="order_history.php">Order History</a></li>
										<li><a class="text-decoration-none" href="Logout.php">Logout</a></li>
										
									</ul>
								</li>
								<?php else: ?>
										<li class="current-list-item"><a href="/zaapin/login.php" class="text-white"><i class="fas fa-user-circle"></i></a>
									<?php endif; ?>
								<!-- <li class="current-list-item"><a href="index.php">Home</a> -->
									<!-- <ul class="sub-menu">
										<li><a href="index.php">Static Home</a></li>
										<li><a href="index_2.php">Slider Home</a></li>
									</ul> -->
								<!-- </li> -->
								<!-- <li><a href="about.php">About</a></li> -->
								<!-- <li><a href="#">Pages</a>
									<ul class="sub-menu">
										<li><a href="404.php">404 page</a></li>
										<li><a href="about.php">About</a></li>
										<li><a href="cart.php">Cart</a></li>
										<li><a href="checkout.php">Check Out</a></li>
										<li><a href="contact.php">Contact</a></li>
										<li><a href="news.php">News</a></li>
										<li><a href="shop.php">Shop</a></li>
									</ul>
								</li> -->
								<!-- <li><a href="news.php">News</a>
									<ul class="sub-menu">
										<li><a href="news.php">News</a></li>
										<li><a href="single-news.php">Single News</a></li>
									</ul>
								</li> -->
								<!-- <li><a href="contact.php">Contact</a></li> -->
								<!-- <li><a href="shop.php">Menu</a>
									<ul class="sub-menu">
										<li><a href="shop.php">Shop</a></li>
										<li><a href="checkout.php">Check Out</a></li>
										<li><a href="single-product.php">Single Product</a></li>
										<li><a href="cart.php">Cart</a></li>
									</ul>
								</li> -->
								
								<!-- <li><a class="shopping-cart text-decoration-none"  href="cart.php"><i class="fas fa-shopping-cart"></i><strong id="cart-count" class="bg-danger px-1 text-white rounded ml-1"><?php //echo $cart_count; ?></strong></a></li> -->
								<li>	<a class="mobile-hide search-bar-icon" href="#"><i class="fas fa-search"></i></a></li>
							</ul>
						</nav>
						
						<a class="mobile-show search-bar-icon " href="#"><i class="fas fa-search"></i></a>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->
     	
	<!-- search area -->
	<div class="search-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<span class="close-btn"><i class="fas fa-window-close"></i></span>
					<div class="search-bar">
						<div class="search-bar-tablecell">
							<h3>Search For:</h3>
							<form action="search.php" method="get">
							<input type="text"  placeholder="Search Your Favorite Food" required name="search_name" style="font-size:20px" >
							<button type="submit">Search <i class="fas fa-search"></i></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end search area -->
   