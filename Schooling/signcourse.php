<!DOCTYPE html>
<?php
session_start();
include "Init3.php";
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
	 if($do == "sign_course"){
		 if(isset($_GET['id']) && is_numeric($_GET['id'])){
		 			?>
			<div class="limiter">
		    <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100"> <?php 
		
				$parentid = $_SESSION['pid'];
				$courseid = $_GET['id'];
				$stmt=$con->prepare("insert into conn(courseid , parentid , date) values(:cid , :pid , now())");
				$stmt->execute(array(
					'pid' => $_SESSION['pid'],
					'cid' => $_GET['id']
				));
				$count=$stmt->rowCount();
				echo "<div class = 'container'>";
				$msg = "<div class = 'alert alert-success'>" . 'Congratulation ' . $_SESSION['name'] . "</div>";
				redirect($msg,4);
				echo "</div>";
		 }
		else{
			echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'> Sorry you can not browse this page directly </div>";
			 redirect($msg,4);
			 echo "</div>";
		}

		

		
?>
</div>
</div>
</div>
<?php
	 }
		
	
	?>
	
	<div id="dropDownSelect1"></div>
	
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