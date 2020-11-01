<?php 
session_start();
$nonav2 = "";
$pagetitle = "Manage Parents";
if(isset($_SESSION['username'])){
include "Init.php";
if(isset($_GET['do'])){
	$do = $_GET['do'];
}
else{
	$do = "Manage";
}
if($do=="Manage"){
	
	
	$row1 = pparent::view_parent();
	if(! empty($row1)){
	?>
			
			<div class = "content1" >
			<h1 class = "text-center">Manage Parents </h1><hr>
			<div class="table-responsive" id="#cont">
			<table class="main-color text-center table table-bordered" id="tbl">
				<thead>
				<tr>
					<td>Id</td>
					<td>Username</td>
					<td>Fullname</td>
				    <td>Email</td>
					<td>Registered Date</td>
					<td>Control</td>
				</tr>
				</thead>
				<?php
				foreach($row1 as $row){
					echo "<tr>";
						echo "<td>" . $row['id'] . "</td>";
						echo "<td>" . $row['username'] . "</td>";
						echo "<td>" . $row['fullname'] . "</td>";
						echo "<td>" . $row['email'] . "</td>";
						echo "<td>" . $row['date'] . "</td>";
						echo "<td> 
									<a href='parents.php?do=Edit&userid=" . $row['id'] ."' class='btn btn-success'><i class = 'fa fa-edit'></i>Edit</a>
									<a href='parents.php?do=Delete&userid=" . $row['id'] ."' class='btn btn-danger confirm'><i class = 'fa fa-close'></i>Delete</a> ";

									if($row['approval']==0){
										echo "<a href='parents.php?do=Activate&userid=" . $row['id'] ."' class='btn btn-info confirm'><i class = 'fa fa-check'></i>Activate</a> ";
									}
						
						echo "</td>";
					echo "</tr>";
				}
				?>
			</table>
			</div>
				<a href = 'parents.php?do=Add' class="btn btn-primary" id="aa"><i class="fa fa-plus"></i> New Members</a>
				</div>
			
<?php

}
else{
	echo "<div class = 'content'>";
	echo "<div class = 'no'>" . "There is not members to show" . "</div>";
	echo "</div>";
	echo "<div class = 'btn8'>" . "<a href = 'Members.php?do=Add' class='btn btn-sm btn-primary'>" . "<i class='fa fa-plus'>" . "</i>" . ' Add Member' . "</a>" . "</div>";
} }
elseif($do=="Add"){?>
			  
			<div class = "content">
			<h1 class = "text-center" id = "cad"> Add new member </h1><hr>
			<div class = "conc">
				<form class = "add" action = "?do=Insert" method = "post"> 
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

}
elseif($do=="Insert"){
	if($_SERVER['REQUEST_METHOD']=="POST"){
		echo "<h1 class = 'text-center'>Insert member</h1>" . "<hr>";
		
		$username = $_POST['user'];
		$email = $_POST['email'];
		$fullname = $_POST['full'];
		$password = sha1($_POST['pass']);
		$fe = array();
		if(empty($username)){
			$fe[] = "You should put username ";
		}
		if(empty($password)){
			$fe[] = "You should put password ";
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
		/*$Count = check('username',"admin",$username);
		if($Count>0){
			echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'  >" . "Sorry this user is exists" . "</div>";
			redirect($msg,4);
			echo "</div>";
		}
		else{*/
		$admin = new aadmin($username,$password,$email,$fullname);
		$admin->add_admin();
	//c
}}

else{
	echo "<div class = 'content'>";
	$msg = "<div class = 'alert alert-danger'> Sorry you can not browse this page directly </div>";
	 redirect($msg,4);
	 echo "</div>";
}
}
elseif($do=="Edit"){ 

	if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
		$userId = $_GET['userid'];
		$stmt = $con->prepare("SELECT *  from admin where id = ?  ");
		$stmt->execute(array($userId));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){ ?>
			<div class = "content">
			<h1 class = "text-center"> Edit Admin </h1><hr>
			<div class = "conc">
				<form class = "edit" action = "?do=Update" method = "post"> 
				<fieldset>
					<legend id = "lgd"><img class = 'img-responsive img' src ='fo2.png' alt = 'no'></legend>
					<input type = "hidden" name = "id" value = "<?php echo $userId ?>" >
					<label class = "col-sm-1 control-label">Username </label>
					<input type = "text" name = "user" class = "form-control" autocomplete = "off" autofocus = "on" required placeholder = "Enter your name" value = "<?php echo $row['username'] ?>" >
					<label class = "col-sm-1 control-label">Password </label>
					<input type = "hidden" name = "oldpass" value = "<?php echo $row['password'] ?>">
					<input type = "password" name = "newpass" class = "form-control"  autocomplete = "new-password" placeholder = "Enter your password" >					
					<label class = "col-sm-1 control-label">E_mail </label>
					<input type = "email" name = "email" class = "form-control" required placeholder = "Enter your e_mail" value = "<?php echo $row['email'] ?>" >
					<label class = "col-sm-2 control-label">Full name </label>
					<input type = "text" name = "full" class = "form-control" required placeholder = "Enter your full name"  value = "<?php echo $row['fullname'] ?>" >
					<!--<label class = "col-sm-2 control-label">File</label>
					<input type = "file" name = "avatar" class = "form-control" required placeholder = "Enter your full name"  value = "<?php echo $row['avatar'] ?>" >-->
					<input type = "submit" value = "Save" class = "btn btn-primary" id = "btn">
				</fieldset>
				</form>
			</div>
			</div>

	<?php }
		else {
			echo "<div class='content'>";
			$msg = "<div class = 'alert alert-danger'>There is no such id here</div>";
			redirect($msg,4);
			echo "</div>";
		}
	}

}
elseif($do=="Update"){
	
	if($_SERVER['REQUEST_METHOD']=="POST"){
	    $userid = $_POST['id'];
		$username = $_POST['user'];
		$email = $_POST['email'];
		$fullname = $_POST['full'];

		if(empty($_POST['newpass'])){
			$pass = $_POST['oldpass'];
		}
		else{
			$pass = sha1 ($_POST['newpass']);
		}
		$ad = new aadmin($username,$pass,$email,$fullname);
		$ad->edit_admin($userid);
		
		}
else{
			
			echo   "<div class = 'alert alert-info'> You will be directed to Dashboared in 4 seconds</div>";
			header("refresh:4;url=Dash.php");
} 
		}

else if($do=="Delete"){
		
		if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
		$userId = $_GET['userid'];
		$stmt = $con->prepare("SELECT * from admin where id = ? ");
		$stmt->execute(array($userId));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			aadmin::delete_admin($userId);
			}
			
		else {
			echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'>Sorry this user id is not existed</div>";
			redirect($msg,4);
			echo "</div>";
		}


}}

include $tpl . "Footer.php";
}
else {
	include "Login.php";
}

?>
