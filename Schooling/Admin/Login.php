<?php 
session_start();
$nonav = "";
$pagetitle = "Login";
include "Init.php";
if($_SERVER['REQUEST_METHOD']=="POST"){
	$username = $_POST['user'];
	$hashed = sha1($_POST['pass']);
	$count = aadmin::login($username,$hashed);
	
	if ($count>0){
		$row = aadmin::login1_admin($username,$hashed);
		$_SESSION['username']=$username;
		$_SESSION['id']=$row['id'];
		header('location:Dash.php');
}
else{
}

}
?>
	
	<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
		<h4>Admin login</h4>
		<input type = "text" class = "form-control" class = "control" name = "user" placeholder = "Enter your name" autocomplete = "off"/>
		<input type = "password" class = "form-control" class = "control" name = "pass" placeholder = "Enter your password" autocomplete = "new-password"/>
		<input type = "submit" value = "Login" class = "btn btn-primary btn-block"/>
	</form>
	
<?php include $tpl . "Footer.php"; ?>