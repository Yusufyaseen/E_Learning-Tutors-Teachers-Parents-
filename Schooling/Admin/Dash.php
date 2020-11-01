<?php 
SESSION_start();
$pagetitle = "Dashboared";
if(isset($_SESSION['username'])){
include "Init.php";

?>
<div class = "content">
			<h1 class = "text-center" id = "cad"> Add new admin </h1><hr>
			<div class = "conc">
				<form class = "add" action = "<?php echo $_SERVER["PHP_SELF"];?>" method = "post"> 
			    	<fieldset>
					<legend id = "lgd"><img class = 'img-responsive img' src ='e.jpg' alt = 'no'></legend>
					<label class = "col-sm-1 control-label">Username </label>
					<input type = "text" name = "user" class = "form-control" autocomplete = "off" autofocus = "on" required placeholder = "Enter your name" ?>
					<label class = "col-sm-1 control-label">Password </label>
					<input type = "password" name = "pass" class = "form-control"  autocomplete = "new-password" placeholder = "Enter your password">
					<label class = "col-sm-1 control-label">E_mail </label>
					<input type = "email" name = "email" class = "form-control" required placeholder = "Enter your e_mail" autocomplete = "off">
					<label class = "col-sm-2 control-label">Full name </label>
					<input type = "text" name = "full" class = "form-control" required placeholder = "Enter your full name" autocomplete = "off">
					<input type = "submit" value = "Add member" class = "btn btn-primary" id = "bttn">
					</fieldset>
				</form>
			</div>
</div>
<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
		//echo "<h1 class = 'text-center'>Insert member</h1>" . "<hr>";
		
		$name = $_POST['user'];
		$email = $_POST['email'];
		$full = $_POST['full'];
		$pass= sha1($_POST['pass']);
		$fe = array();
		if(empty($name)){
			$fe[] = "You should put username ";
		}
		if(empty($pass)){
			$fe[] = "You should put password ";
		}
		if(empty($email)){
			$fe[] = "You should put email ";
		}
		if(empty($full)){
			$fe[] = "You should put fullname ";
		}
		
		foreach($fe as $errors){
			echo "<div class = 'content'>";
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
			echo "</div>";
		}
		if(empty($fe)){
		
		 $ad = new aadmin($name,$pass,$email,$full);
		 
	     $ad->add_admin();
	
}}

/*else{
	echo "<div class = 'content'>";
	$msg = "<div class = 'alert alert-danger'> Sorry you can not browse this page directly </div>";
	 redirect($msg,4);
	 echo "</div>";
}*/
?>

<?php
include $tpl . "Footer.php";
}
?>


