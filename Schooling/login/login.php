<!DOCTYPE html>
<?php
session_start();
include "../Init3.php";
?>
<html lang="en">
<head>
	<title>Login Page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
<?php
		if(isset($_GET['do'])){
			$do = $_GET['do']; 
			
		}
		else{
			$do = "parent";
		} ?>
<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100">
				
				<div class="container-login100-form-btn">
						<a href = "login.php?do=parent"><button class="btn" style = " width:200px;height:60px; border-radius:50px;font-weight:700;font-size:17px; <?php if($do=="parent"){?> background:#222;color:#fff" <?php } else { ?> background:#fff;" <?php } ?> >
							Login For Parent
						</button></a>
					</div>
					<br>
					<div class="container-login100-form-btn">
						<a href = "login.php?do=tutor"><button class="btn" style = " width:200px;height:60px; border-radius:50px;font-weight:700;font-size:17px; <?php if($do=="tutor"){?> background:#222;color:#fff;" <?php } else { ?> background:#fff;" <?php } ?> >
							Login For Tutors 
						</button></a>
					</div>
					<br><hr><br>
	<?php
		if($do == "parent"){ ?>
			
				<form class="login100-form validate-form" action = "login.php?do=log_parent" method = "post" >
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27 text-capitalize">
						Log in As A Parent
					</span>


					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input autocomplete = "off"  class="input100" type="text" autofocus = "on" name="username" placeholder="Username">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input autocomplete = "new-password" class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
						<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<br>
				</form>
				<br>
				<hr>
				<br>

		<?php }
		else if($do == "tutor"){ ?>
			
				<form class="login100-form validate-form" action = "login.php?do=log_tutor" method = "post">
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27 text-capitalize">
						Log in As A Tutor
					</span>


					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input autocomplete = "off" class="input100" type="text" autofocus = "on" name="username" placeholder="Username">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input autocomplete = "new-password" class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<br>
				</form>

	<?php	}
	
	else if($do == "log_parent"){
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$user = $_POST['username'];
			$hashed = sha1($_POST['pass']);
			$fe = array();
		if(empty($user)){
			$fe[] = "You should put username ";
		}
		if(empty($hashed)){
			$fe[] = "You should put password ";
		}
		
		foreach($fe as $errors){
			echo "<div class = 'content'>";
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
			echo "</div>";
		}
		if(empty($fe)){
		$count = pparent::login($user,$hashed);
		if($count>0){
			
			$row = pparent::login1_parent($user,$hashed);
			$_SESSION['name']=$user;
			$_SESSION['pid']=$row['id'];
			$msg = "<div class = 'alert alert-success text-capitalize'>" .'Welcome '. $row['username'] . "</div>";
			echo $msg;
			echo "<div class = 'alert alert-success text-capitalize'>" .'You will be go to home now'. "</div>";
			header("refresh:2;url='../home.php'");
		}
		else{
			$msg = "<div class = 'alert alert-danger'>" .'Sorry your username or your password is incorrect'. "</div>";
			echo $msg;
			
		}
}}

else{
	echo "<div class = 'content'>";
	$msg = "<div class = 'alert alert-danger'> Sorry you can not browse this page directly </div>";
	 redirect($msg,4);
	 echo "</div>";
}
		}
		
		else if($do == "log_tutor"){

		if($_SERVER['REQUEST_METHOD']=="POST"){
			$user = $_POST['username'];
			$hashed = sha1($_POST['pass']);
			$fe = array();
		if(empty($user)){
			$fe[] = "You should put username ";
		}
		if(empty($hashed)){
			$fe[] = "You should put password ";
		}
		
		foreach($fe as $errors){
			echo "<div class = 'content'>";
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
			echo "</div>";
		}
		if(empty($fe)){
		$count = tutor::login($user,$hashed);
		if($count>0){
			$row = tutor::login1_tutor($user,$hashed);
			$_SESSION['tname']=$user;
			$_SESSION['tid']=$row['id'];
			$msg = "<div class = 'alert alert-success text-capitalize'>" .'Welcome Dr : '. $row['username'] . "</div>";
			 echo $msg;
			 echo "<div class = 'alert alert-success text-capitalize'>" .'You will be go to home now'. "</div>";
			
			header("refresh:3;url='../elements.php'");
		}
		else{
			$msg = "<div class = 'alert alert-danger'>" .'Sorry your username or your password is incorrect'. "</div>";
			echo $msg;
			
		}
}}

else{
	echo "<div class = 'content'>";
	$msg = "<div class = 'alert alert-danger'> Sorry you can not browse this page directly </div>";
	 redirect($msg,4);
	 echo "</div>";
	 
}
		}
	
	?>
	
	
	
	<div id="dropDownSelect1"></div>
	</div>
</div>
</div>
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>