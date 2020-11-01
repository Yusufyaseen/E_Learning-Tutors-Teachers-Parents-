<!DOCTYPE html>
<?php
session_start();
include "Init3.php";

?>
<html lang="en">
<head>
	<title>Manage Page</title>
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
		$count = "";
		if(isset($_GET['do'])){
			$do = $_GET['do']; 
			
		}
		else{
			header('location:elements.php');
		} 
		
					?>
					
<div class="limiter">

		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			
			<div class="wrap-login100">
				<?php 
				if($do == "edit"){ 
				if(isset($_GET['courseid']) && is_numeric($_GET['courseid'])){
					$courseid = $_GET['courseid'];
					$stmt = $con->prepare("SELECT * from course where id = ?  ");
					$stmt->execute(array($courseid));
					$row0 = $stmt->fetch();
					$count = $stmt->rowCount();
					if($count>0) {
					
					?>
					<h1 style = "margin-left:130px;font-weight:bold;color:#fff;text-shadow : 1px 1px 2px #000;">Editing</h1><br>
				<form class="login100-form validate-form" action = "?do=update" method = "post" enctype = "multipart/form-data">
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27 text-capitalize">
						 <?php echo $row0['name']; ?> course
					</span>


					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input autocomplete = "off" value = "<?php echo $row0['name'] ?>" class="input100" type="text" autofocus = "on" name="username" placeholder="Username">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Enter Price">
						<input autocomplete = "off"  value = "<?php echo $row0['price'] ?>"  class="input100" type="number"  name="price" placeholder="Price">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Enter Image">
						<input style = "color:#fff;font-weight:550" type="file" name="imma">
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Enter Description">
						<input autocomplete = "off"  value = "<?php echo $row0['descr'] ?>"  class="input100" type="text"  name="descr" placeholder="Description">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
						<input  value = "<?php echo $courseid ?>" type="hidden"  name="id" >
						<input  value = "<?php echo $row0['name'] ?>" type="hidden"  name="n" >
						<input  value = "<?php echo $row0['descr'] ?>" type="hidden"  name="d" >
						<input  value = "<?php echo $row0['price'] ?>" type="hidden"  name="p" >
						<input  value = "<?php echo $row0['image'] ?>" type="hidden"  name="g" >
					</div>
					
					<select style = "background:#fcfcfc;width:100%;margin-bottom:40px;height:40px;border-radius:10px;padding-left:10px;" name = "cid">
						<option value = "0">None</option>
						<?php 
							$stmt = $con->prepare("select * from cate");
							$stmt->execute();
							$cate2 = $stmt->fetchAll();
							foreach($cate2 as $cates){
								echo "<option value = '" . $cates['id'] . "'";
								if($cates['id']==$row0['catid']){
									echo "selected";
								} 
								echo ">" . $cates['name'] . "</option>";
							}
							
						?>
						
					</select>
					<br>
						<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Edit
						</button>
					</div>

					<br>
				</form>
				<br>
				<hr>
				<br>

				<?php }else{
					echo "<div class = 'alert alert-success text-capitalize'> You are spy</div>";
					header("refresh:3;url='elements.php'");
				}}
					else{
						echo "<div class = 'alert alert-success text-capitalize'> You are bitch</div>";
						header("refresh:3;url='elements.php'");
					}
				}
	
		elseif($do == 'update'){
if($_SERVER['REQUEST_METHOD']=="POST"){
		$name = $_POST['username'];
		$des = $_POST['descr'];
		$price = $_POST['price'];
		$cid = $_POST['cid'];
		$courseid = $_POST['id'];
		//$img1 = $_FILES['image']['name'];
		$image0 = $_FILES['imma']['name'];
		$imgsize = $_FILES['imma']['size'];
		$imgtmp = $_FILES['imma']['tmp_name'];
		$imgext = array("jpg","jpeg","png");
		$tmp1 = explode('.', $image0);
		$tmp2 = end($tmp1);
		$imgallow = strtolower($tmp2);
		if(empty($name)){$name = $_POST['n'];}
		if(empty($des)){$des = $_POST['d'];}
		if(empty($price)){$price = $_POST['p'];}
		$fe = array();
		if(!empty($image0)){
		if($imgsize > 8388608){
			$fe[] = "You Should Put Image Less Than Or Equal to 8 Byte";
		}
		
		if(!in_array($imgallow,$imgext)){
			$fe[] =  "You Are Bitch Sir";
		}
		
		}
		else if(empty($image0)){$image0 = $_POST['g'];}
		foreach($fe as $ff){
			echo "<div class = 'alert alert-success text-capitalize'>" . $ff . "</div>";
		}
		if(empty($fe)){
			move_uploaded_file($imgtmp,"img\courses\\" . $image0);
			tutor::edit_courses($name,$des,$price,$cid,$image0,$courseid);
		
		           $msg = "<div class = 'alert alert-success text-capitalize'>" . $_POST['n'] .' Has Been Updated' . "</div>";
					 echo $msg;
					echo "<div class = 'alert alert-success text-capitalize'> You will be directed to your page in 3 seconds</div>";
					header("refresh:3;url='elements.php'");
		
}
else{
			$msg = "<div class = 'alert alert-danger'>There Is Some Errors I Your Inputs</div>";
			redirect($msg,3);
} 
		}}
				
				else if($do == "delete"){ 
				if(isset($_GET['courseid']) && is_numeric($_GET['courseid'])){
					$courseid = $_GET['courseid'];
					$stmt = $con->prepare("SELECT * from course where id = ?  ");
					$stmt->execute(array($courseid));
					$row = $stmt->fetch();
					$count = $stmt->rowCount();
					if($count>0) {
 ?>
					
					
					<h1 style = "margin-left:120px;font-weight:bold;color:#fff;text-shadow : 1px 1px 2px #000;">Deleting</h1><br>
					<?php
					tutor::delete_courses($courseid);
					 $msg = "<div class = 'alert alert-success text-capitalize'>" . $row['name'] .' Has Been Deleted' . "</div>";
					 echo $msg;
					echo "<div class = 'alert alert-success text-capitalize'> You will be directed to your page in 2 seconds</div>";
					header("refresh:3;url='elements.php'");
					?>
				<br>
				<br>

					<?php } else{
					echo "<div class = 'alert alert-success text-capitalize'> You are spy</div>";
					header("refresh:3;url='elements.php'");
				}}
					else{
						echo "<div class = 'alert alert-success text-capitalize'> You are bitch</div>";
						header("refresh:3;url='elements.php'");
					}}
					
					//Add course
					else if($do=="add"){?>
					<h1 style = "margin-left:130px;font-weight:bold;color:#fff;text-shadow : 1px 1px 2px #000;">Adding</h1><br>
				   <form class="login100-form validate-form" action = "?do=insert" method = "post" enctype = "multipart/form-data">
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27 text-capitalize">
						 Add A New Course
					</span>


					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input autocomplete = "off" class="input100" type="text" autofocus = "on" name="username" placeholder="Username" required>
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Enter Price">
						<input autocomplete = "off" class="input100" type="number"  name="price" placeholder="Price" required>
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>
					
					<div class="wrap-input100 validate-input" data-validate = "Enter Description">
						<input autocomplete = "off" class="input100" type="text"  name="descr" placeholder="Description" required>
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>
					
					<div class="wrap-input100 validate-input" data-validate = "Enter Image">
						<input style = "color:#fff;font-weight:550" type="file"  name="img" required>
					</div>
					
					<select style = "background:#fcfcfc;width:100%;margin-bottom:40px;height:40px;border-radius:10px;padding-left:10px;" name = "cid">
						<option value = "0">None</option>
						<?php 
							$stmt = $con->prepare("select * from cate");
							$stmt->execute();
							$cate2 = $stmt->fetchAll();
							foreach($cate2 as $cates){
								echo "<option value = '" . $cates['id'] . "'";
								echo ">" . $cates['name'] . "</option>";
							}
							
						?>
						
					</select>
					<br>
						<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Add
						</button>
					</div>

					<br>
				</form>
			</div>
			</div>
<?php

}
elseif($do=="insert"){
	if($_SERVER['REQUEST_METHOD']=="POST"){
		
		$name = $_POST['username'];
		$des = $_POST['descr'];
		$price = $_POST['price'];
		$cat = $_POST['cid'];
		$tutor = $_SESSION['tid'];
		$img = $_FILES['img']['name'];
		$imgsize = $_FILES['img']['size'];
		$imgtmp = $_FILES['img']['tmp_name'];
		$imgext = array("jpg","jpeg","png");
		$tmp = explode('.', $img);
		$tmp2 = end($tmp);
		$imgallow = strtolower($tmp2);
		$fe = array();
		if(empty($name)){
			$fe[] = "You should put username ";
		}

		if(empty($img)){
			$fe[] = "You should put image for this course";
		}
		if(empty($des)){
			$fe[] = "You should put password ";
		}
		if(empty($price)){
			$fe[] = "You should put price ";
		}
		if(empty($cat)){
			$fe[] = "You should put category ";
		}
		if(empty($tutor)){
			$fe[] = "You should put tutor ";
		}
		
		if(empty($img)){
			$fe[] = "You Should Put Image ";
		}
		if($imgsize > 8388608){
			$fe[] = "You Should Put Image Less Than Or Equal to 8 Byte";
		}
		
		if(!empty($img) && !in_array($imgallow,$imgext)){
			$fe[] =  "You Are Bitch Sir";
		}
		
		foreach($fe as $errors){
			echo "<div class = 'content'>";
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
			echo "</div>";
		}
		if(empty($fe)){
			move_uploaded_file($imgtmp,"img\courses\\" . $img);
		tutor::add_courses($name,$des,$price,$cat,$tutor,$img);
		$msg = "<div class = 'alert alert-success text-capitalize'>" . $name .' Has Been Inserted' . "</div>";
		echo $msg;
		echo "<div class = 'alert alert-success text-capitalize'> You will be directed to your page in 2 seconds</div>";
		header("refresh:3;url='elements.php'");
		
	}}}
					//End
					
					
					
					//Add book
					else if($do=="add_book"){
						if(isset($_GET['courseid']) && is_numeric($_GET['courseid'])){
						$courseid = $_GET['courseid'];
						$stmt = $con->prepare("SELECT * from course where id = ?  ");
						$stmt->execute(array($courseid));
						$row0 = $stmt->fetch();
						$count = $stmt->rowCount();
					if($count>0) {
						?>
					<h1 style = "margin-left:132px;font-size:45px;font-weight:bold;color:#fff;text-shadow : 1px 1px 2px #000;">Books</h1><br>
				   <form class="login100-form validate-form" action = "?do=insertbook" method = "post" >
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27 text-capitalize">
						 Add A New Book
					</span>
						<input   type="hidden"  name="cid"value = "<?php echo $courseid; ?>">
					<div class="wrap-input100 validate-input" data-validate = "Enter Name For Book">
						<input autocomplete = "off" class="input100" type="text"  name="bname" placeholder="Name For The Book For Course">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Enter Link For Book">
						<input autocomplete = "off" class="input100" type="link"  name="blink" placeholder="Link For The Book For Course">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Add Book
						</button>
					</div>

					<br>
				</form>
			</div>
			</div>
<?php

						}}
						else{
							$msg = "<div class = 'alert alert-success text-capitalize'>" .' You Are Bitch' . "</div>";
							echo $msg;
							echo "<div class = 'alert alert-success text-capitalize'> You will be directed to your page in 2 seconds</div>";
							header("refresh:3;url='elements.php'");
						}
					}
else if($do=="insertbook"){
	if($_SERVER['REQUEST_METHOD']=="POST"){
		
		$blink = $_POST['blink'];
		$bname = $_POST['bname'];
		$cid = $_POST['cid'];
		
		$fe = array();

		if(empty($blink)){
			$fe[] = "You should put link for course’s book ";
		}
		if(empty($bname)){
			$fe[] = "You should put link for course’s name ";
		}
		
		foreach($fe as $errors){
			echo "<div class = 'container-login100'>";
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
			echo "</div>";
		}
		if(empty($fe)){
			tutor::add_book($bname,$blink,$cid);
		
	}}}
					//End book
					
					
					
					
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