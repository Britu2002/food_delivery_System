<?php if(isset($_GET['logout'])){
    unset($_SESSION['userid']);
    header("Location:/zaapin/agent_login.php");
} ?> 

<?php
session_start();

$user_logged_in = isset($_SESSION['userid']);
?>



	
	<!-- header -->
	<div class="bg-warning p-2 top-header-area " id="sticker">
		<div class="mx-5">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="agent_index.php">
								<img src="/zaapin/img/logo-dark.png" alt="" >
							</a>
						</div>
					
						<nav class="main-menu">
							<ul class="d-flex justify-content-end align-items-center" >
							
								<li>
									<div class="header-icons">
										
										<ul  >
									<?php if(isset($_SESSION['userid'])): ?>
								<li>
									<a href="#"><i class="fas fa-user-circle"></i></a>
									<ul class="sub-menu" style="width:115px;left:-36px;">
									<li><a class="text-decoration-none" href="agent_profile.php?userid=<?php echo $_SESSION['userid'] ?>">My Profile</a></li>
    <li ><a  href="?logout=logout" class="text-decoration-none">Logout </a></li>
										
									</ul>
								</li>
<?php else : ?>

								<li>
									<a href="/zaapin/login.php" class="text-decoration-none">Login</a>
								</li>
<?php endif ; ?>
								
										</ul>
									
									
									</div>
								
								</li>
								
								
							</ul>
						</nav>
						
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->
     	

   
