<!DOCTYPE html>
<?php
session_start();

include "../Init3.php";
?>
<html lang="en">
<head>
	<title>Sign Up Page</title>
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
		if($do == "sign_tutor"){
			
			?>
			<div class="limiter">
		    <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100"> <?php 
				if($_SERVER['REQUEST_METHOD']=="POST"){
				$username = filter_var(test_input($_POST['user']),FILTER_SANITIZE_STRING);
				$email = filter_var(test_input($_POST['email']),FILTER_SANITIZE_EMAIL);
				$fullname = filter_var(test_input($_POST['full']),FILTER_SANITIZE_STRING);
				$password = sha1($_POST['pass']);
				$img1 = $_FILES['img0']['name'];
				$imgsize = $_FILES['img0']['size'];
				$imgtmp = $_FILES['img0']['tmp_name'];
				$imgext = array("jpg","jpeg","png");
				$tmp = explode('.', $img1);
				$tmp2 = end($tmp);
				$imgallow = strtolower($tmp2);
				$fe = array();
				if(empty($username)){
					$fe[] = "You should put username ";
				}
				if(empty($password)){
					$fe[] = "You should put password ";
				}
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$fe[] = "You should put valid mail ";
				}
				if(empty($email)){
					$fe[] = "You should put email ";
				}
				if(empty($fullname)){
					$fe[] = "You should put fullname ";
				}
				if(empty($img1)){
					$fe[] = "You Should Put Image ";
				}
				if($imgsize > 8388608){
					$fe[] = "You Should Put Image Less Than Or Equal to 8 Byte";
				}
				
				if(!empty($img1) && !in_array($imgallow,$imgext)){
					$fe[] =  "You Are Bitch Sir";
				}

				
				foreach($fe as $errors){
					echo "<div class = 'content'>";
					echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
					echo "</div>";
				}
				if(empty($fe)){
				move_uploaded_file($imgtmp,"..\img\authors\\" . $img1);
				tutor::add_tutor($username,$password,$email,$fullname,$img1);
		}}

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
		
		else if($do == "edit_tutor"){
			
			?>
			<div class="limiter">
		    <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100"> <?php 
				if($_SERVER['REQUEST_METHOD']=="POST"){
				$username = filter_var(test_input($_POST['user']),FILTER_SANITIZE_STRING);
				$email = filter_var(test_input($_POST['email']),FILTER_SANITIZE_EMAIL);
				$fullname = filter_var(test_input($_POST['full']),FILTER_SANITIZE_STRING);
				$image0 = $_FILES['imgagge']['name'];
				$imgsize = $_FILES['imgagge']['size'];
				$imgtmp = $_FILES['imgagge']['tmp_name'];
				$imgext = array("jpg","jpeg","png");
				$tmp1 = explode('.', $image0);
				$tmp2 = end($tmp1);
				$imgallow = strtolower($tmp2);
				$fe = array();
				if(empty($username)){
					$fe[] = "You should put username ";
				}
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$fe[] = "You should put valid mail ";
				}

				if(empty($email)){
					$fe[] = "You should put email ";
				}
				if(empty($fullname)){
					$fe[] = "You should put fullname ";
				}
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$fe[] = "You should put valid mail ";
				}if(!empty($image0)){
				if($imgsize > 8388608){
					$fe[] = "You Should Put Image Less Than Or Equal to 8 Byte";
				}
				
				if(!in_array($imgallow,$imgext)){
					$fe[] =  "You Are Bitch Sir";
				}
				
				}
				else if(empty($image0)){$image0 = $_POST['g'];}
				
				foreach($fe as $errors){
					echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
				}
				if(empty($_POST['newpass'])){
					$password = $_POST['oldpass'];
				}
				else{
					$password = sha1 ($_POST['newpass']);
				}
				if(empty($fe)){
				move_uploaded_file($imgtmp,"..\img\authors\\" . $image0);
				tutor::edit_tutor($username,$password,$email,$fullname,$_SESSION['tid'],$image0);
				
				}}

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
		
		
	
	 else if($do == "sign_parent"){
		 			?>
			<div class="limiter">
		    <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100"> <?php 
		
		if($_SERVER['REQUEST_METHOD']=="POST"){
				$username = filter_var(test_input($_POST['user']),FILTER_SANITIZE_STRING);
				$email = filter_var(test_input($_POST['email']),FILTER_SANITIZE_EMAIL);
				$fullname = filter_var(test_input($_POST['full']),FILTER_SANITIZE_STRING);
				$password = sha1($_POST['pass']);
				$fe = array();
				if(empty($username)){
					$fe[] = "You should put username ";
				}
				if(empty($password)){
					$fe[] = "You should put password ";
				}
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$fe[] = "You should put valid mail ";
				}
				if(empty($email)){
					$fe[] = "You should put email ";
				}
				if(empty($fullname)){
					$fe[] = "You should put fullname ";
				}
				
				foreach($fe as $errors){
					echo "<div class = 'content'>";
					echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
					echo "</div>";
				}
				if(empty($fe)){
				pparent::add_parent($username,$password,$email,$fullname);
		}}

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