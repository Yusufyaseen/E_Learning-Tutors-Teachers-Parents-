<?php 
session_start();
$nonav2 = "";
$pagetitle = "Manage Tutors";
include "Init.php";
if(isset($_SESSION['username'])){

if(isset($_GET['do'])){
	$do = $_GET['do'];
}
else{
	$do = "Manage";
}
if($do=="Manage"){
	
	
	$row1 = aadmin::view_tutor();
	if(! empty($row1)){
	?>
			
			<div class = "content1" >
			<h1 class = "text-center">Manage Tutors </h1><hr>
			<div class="table-responsive" id="#cont">
			<table class="main-color text-center table table-bordered" id="tbl">
				<thead>
				<tr>
					<td>Id</td>
					<td>Username</td>
					<td>fullname</td>
					<td>Subject</td>
				    <td>Email</td>
				    <td>Price</td>
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
						echo "<td>" . $row['subject'] . "</td>";
						echo "<td>" . $row['email'] . "</td>";
						echo "<td>" . '$'. $row['price'] . "</td>";
						echo "<td>" . $row['date'] . "</td>";
						echo "<td> 
									<a href='tutors.php?do=Edit&userid=" . $row['id'] ."' class='btn btn-success'><i class = 'fa fa-edit'></i>Edit</a>
									<a href='tutors.php?do=Delete&userid=" . $row['id'] ."' class='btn btn-danger confirm'><i class = 'fa fa-close'></i>Delete</a> ";

									if($row['approval']==0){
										echo "<a href='tutors.php?do=Activate&userid=" . $row['id'] ."' class='btn btn-info confirm'><i class = 'fa fa-check'></i>Activate</a> ";
									}
						
						echo "</td>";
					echo "</tr>";
				}
				?>
			</table>
			</div>
				<a href = 'tutors.php?do=Add' class="btn btn-primary" id="aa"><i class="fa fa-plus"></i> New Tutor</a>
				</div>
			
<?php

}
else{
	echo "<div class = 'content'>";
	echo "<div class = 'no'>" . "There is not members to show" . "</div>";
	echo "</div>";
	echo "<div class = 'btn8'>" . "<a href = 'tutors.php?do=Add' class='btn btn-sm btn-primary'>" . "<i class='fa fa-plus'>" . "</i>" . ' Add Member' . "</a>" . "</div>";
} }
elseif($do=="Add"){?>
			  
			<div class = "content">
			<h1 class = "text-center" id = "cad"> Add New Tutor </h1><hr>
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
					<label class = "col-sm-2 control-label">Subject </label>
					<input type = "text" name = "subj" class = "form-control" required placeholder = "Enter your subject" autocomplete = "off">
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
		$subject = $_POST['subj'];
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
		aadmin::add_tutor($username,$password,$email,$fullname,$subject);
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
		$stmt = $con->prepare("SELECT *  from tutor where id = ?  ");
		$stmt->execute(array($userId));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){ ?>
			<div class = "content">
			<h1 class = "text-center"> Edit Parents </h1><hr>
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
elseif($do == 'Update'){
if($_SERVER['REQUEST_METHOD']=="POST"){
		$userid = $_POST['id'];
		$username = $_POST['user'];
		$email = $_POST['email'];
		$fullname = $_POST['full'];
		$fe = array();
		if(empty($username)){
			$fe[] = "You should put username ";
		}

		if(empty($email)){
			$fe[] = "You should put email ";
		}
		if(empty($fullname)){
			$fe[] = "You should put fullname ";
		}
		foreach($fe as $errors){
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
		}
		if(empty($_POST['newpass'])){
			$pass0 = $_POST['oldpass'];
		}
		else{
			$pass0 = sha1 ($_POST['newpass']);
		}
		
		if(empty($fe)){
			aadmin::edit_tutor($username,$pass0,$email,$fullname,$userid);
	}}
else{
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse this page directly</div>";
			redirect($msg,4);
} 
		}

else if($do=="Delete"){
		
		if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
		$userId = $_GET['userid'];
		$stmt = $con->prepare("SELECT * from tutor where id = ? ");
		$stmt->execute(array($userId));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			aadmin::delete_tutor($userId);
			}
			
		else {
			echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'>Sorry this user id is not existed</div>";
			redirect($msg,4);
			echo "</div>";
		}


}}
else if($do=="Activate"){
		echo "<h1 class = 'text-center'>Activate Parents</h1>" . "<hr>";
		if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
		$userId = $_GET['userid'];
		$stmt = $con->prepare("SELECT * from tutor where id = ?  ");
		$stmt->execute(array($userId));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			$stmt=$con->prepare("update tutor set approval = 1 where id = ?");
			$stmt->execute(array($userId));
			echo "<div class = 'content'>";
				$msg = "<div class = 'alert alert-success' >" . $stmt->rowCount() ." Record updated"  . "</div>"; 
				redirect($msg,3);
				echo "</div>";
			}
			
		else {
			echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'>Sorry this user id is not existed</div>";
			redirect($msg,4);
			echo "</div>";
		}


}		
		}
include $tpl . "Footer.php";
}
else {
	echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse this page directly</div>";
			redirect($msg,4);
			echo "</div>";
}

?>
