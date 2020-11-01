<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php gettitle(); ?></title>
		<link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css"/>
		<link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css"/>
		<link rel="stylesheet" href="<?php echo $css ?>jquery.selectBoxIt.css"/>
		<link rel="stylesheet" href="<?php echo $css ?>ui.css"/>
		<link rel="stylesheet" href="<?php echo $css ?>Front1.css"/>
	</head>
	<body>
	<html>
	<html>
<head>
	<style>
	 .nav
{
	background-color:#000;

	height:65px;
}

  .nav h2
{
	float :left;
	margin-top:12px;
	color:#9b9595;
	margin-left:20px;
	font-size:35px;
}

  .nav h2 mark
{
	color:#fff;
	font-size:30px;
	background:none;
}


  .nav ul{
	list-style:none;
	margin:auto;
	float:right;
	margin-top:23px;


}
 .nav li{
	float :left;
	margin-right:20px;
	font-weight:bold

}

  .nav li a{
	text-decoration:none;
	color:#dddbdb;
	position:relative;
	bottom:20px;
	right:0px;
	transition:all linear 0.4s;

	
}

  .nav li a:hover{
	color:#222;
	background:#eee;
	padding:5px;
	border-radius:5px;
	text-decoration:none
}
.log1{
	color:#d3c4c4;
	font-weight:bold;
	position:relative;
	top:3px;
	transition:all ease-out 0.3s;
}
.log1:hover{
	color:#222;
	background:#eee;
	padding:5px;
	border-radius:5px;
	text-decoration:none
	
}
.upper .link{
	position:relative;
	font-weight:bold;
	font-size:17px;
	bottom:12px
}
.upper .link a{
	color:#777;
	transition:all linear 0.3s;
}
.upper .link a:hover{
	color:#222;
	background:#fff;
	padding:5px;
	border-radius:5px;
	text-decoration:none;
}

.upper{
	height:20px;
	position:relative;
}
	</style>
</head>
		<div class = "upper">
			<div class = "content">
			<div class = "link">
				<a href = "Loog.php?do=Login" class = "log">Login</a>
				|
				<a href = "Loog.php?do=Sign" class = "sgn">Sign Up</a>
			</div>
			</div>
		</div>

<div class="navbar-responsive">
<div class="nav">

		<h2>E<mark>_Commerce</mark></h2>
		<div class = 'content'>
		<a href="Login1.php" target="_self" class = "log1">Home Page</a>
			<ul>
			<?php
				$cates = getcates();
				foreach($cates as $cat){
					echo "<li>" . "<a href = 'Cate1.php?pageid=" . $cat['id'] . "&pagename=" . str_replace(" ","-",$cat['name']) . "'>" . $cat['name'] . "</a>" . "</li>";
				}
				?>
			</ul>
		</div>
		</div>
		</div>
		</html>