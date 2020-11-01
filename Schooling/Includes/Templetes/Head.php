<!DOCTYPE html>
<?php 
session_start();
?>
<html>
	<meta charset="UTF-8">
	<title><?php gettitle(); ?></title>
	<meta name="description" content="WebUni Education Template">
	<meta name="keywords" content="webuni, education, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->   
	<link href="img/favicon.ico" rel="shortcut icon"/>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,500,500i,600,600i,700,700i,800,800i" rel="stylesheet">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/owl.carousel.css"/>
	<link rel="stylesheet" href="css/style.css"/>

	</head>
	<body>
	

	<!--<div id="preloder">
		<div class="loader"></div>
	</div>-->
	<!-- Header section -->
	<header class="header-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3">
					<div class="site-logo">
						<img src="img/logo.png" alt="">
					</div>
					
					
			
					<div class="nav-switch">
						<i class="fa fa-bars"></i>
					</div>
				</div>
				<div class="col-lg-9 col-md-9">
				<?php
						if(!isset($_SESSION['name']) && !isset($_SESSION['tname'])){ ?>
					<a href="login/login.php" target="_self" class="site-btn header-btn">Login [ Tutor - Parent ]</a>
						<?php }
						else if(isset($_SESSION['name']) || isset($_SESSION['tname'])){
							?>
					<a href="Logout.php" target="_self" class="site-btn header-btn">Logout</a>
						<?php }
						
					?>
					<nav class="main-menu">
						<ul>
							<li><a href="home.php">Home</a></li>
							<li><a href="#">About us</a></li>
							<?php 
							if(isset($_SESSION['name'])){ ?>
							<li><a href="courses.php">Courses</a></li>
							<?php }
								?>
								<?php 
							if(isset($_SESSION['tname'])){ ?>
							<li class = "text-capitalize"><a href="elements.php"><?= $_SESSION['tname'] ?>’s Courses</a></li>
							<?php }
								?>
							<li><a href="blog.html">News</a></li>
							<li><a href="contact.html">Contact</a></li>
							<?php 
							if(isset($_SESSION['name']) && !isset($_SESSION['tname'])){
								?>
								<h2 class = "text-capitalize" style = "color : #D32D4C; font-weight:bold ;font-size:20px;margin-left:695px;margin-top:20px ">Hi <span style = "font-weight:bold;color : #fff;font-size:30px;" ><?php echo $_SESSION['name']; ?></span></h2>
								<br>
								<br>
							<?php }
								if(isset($_SESSION['tname']) && !isset($_SESSION['name'])){
								?>
								<h2 class = "text-capitalize" style = "color : #D32D4C; font-weight:bold ;font-size:20px;margin-left:660px;margin-top:20px">Hi Dr : <span style = "font-weight:bold;color : #fff;font-size:30px;" ><?php echo $_SESSION['tname']; ?></span></h2>
								<br>
								<br>
							<?php }
							?>
							
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</header>

				<!--<li><a href="Dash.php" target="_self" >Home</a></li>
				<li><a href="../Login1.php" target="_self" >Visit Shop</a></li>
				<li><a href="Logout.php" target="_self">Logout</a></li>
				<li><a href="Admins.php?do=Manage">Admins</a></li>
				<li><a href="parents.php?do=Manage" target="_self">Parents</a></li>
				<li><a href="Items.php" target="_self">Items</a></li>
				<li><a href="Comments.php?do=Manage" target="_self">Comments</a></li>-->
			
