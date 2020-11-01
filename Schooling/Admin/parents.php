<?php 
session_start();
$nonav2 = "";
$pagetitle = "Manage Parents";
include "Init.php";
if(isset($_SESSION['username'])){

if(isset($_GET['do'])){
	$do = $_GET['do'];
}
else{
	$do = "Manage";
}
if($do=="Manage"){
	
	
	/*$stmt=$con->prepare("select parent.*, course.name as cname  from parent join course on course.id = parent.book order by id asc");
	$stmt->execute();
	$rows=$stmt->fetchAll();*/
	  $rows = aadmin::view_parent();
	if(! empty($rows)){
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
				foreach($rows as $row){
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
				<a href = 'parents.php?do=Add' class="btn btn-primary" id="aa"><i class="fa fa-plus"></i> New Parent</a>
				</div>
			
<?php

}
else{
	echo "<div class = 'content'>";
	echo "<div class = 'no'>" . "There is not members to show" . "</div>";
	echo "</div>";
	echo "<div class = 'btn8'>" . "<a href = 'parents.php?do=Add' class='btn btn-sm btn-primary'>" . "<i class='fa fa-plus'>" . "</i>" . ' Add Parent' . "</a>" . "</div>";
} }


if($do=="Manage1"){
	
	
	$stmt=$con->prepare("select conn.*, course.name as cname,parent.id as id,parent.username as username,parent.fullname as fullname,parent.date as date,parent.email as email  from conn join course on course.id = conn.courseid join parent on parent.id = conn.parentid order by id asc");
	$stmt->execute();
	$rows=$stmt->fetchAll();
	if(! empty($rows)){
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
				    <td>Course</td>
					<td>Registered Date</td>
					<td>Control</td>
				</tr>
				</thead>
				<?php
				foreach($rows as $row){
					echo "<tr>";
						echo "<td>" . $row['id'] . "</td>";
						echo "<td>" . $row['username'] . "</td>";
						echo "<td>" . $row['fullname'] . "</td>";
						echo "<td>" . $row['email'] . "</td>";
						
						echo "<td>" . $row['cname'] . "</td>";
						echo "<td>" . $row['date'] . "</td>";
						echo "<td> 
									<a href='parents.php?do=Delete1&userid=" . $row['id'] ."&courseid=" . $row['courseid'] ."' class='btn btn-danger confirm'><i class = 'fa fa-close'></i>Delete</a> ";

									if($row['approval']==0){
										echo "<a href='parents.php?do=Activate1&userid=" . $row['id'] ."&courseid=" . $row['courseid'] ."' class='btn btn-info confirm'><i class = 'fa fa-check'></i>Activate</a> ";
									}
						
						echo "</td>";
					echo "</tr>";
				}
				?>
			</table>
			</div>
				<a href = 'parents.php?do=Add' class="btn btn-primary" id="aa"><i class="fa fa-plus"></i> New Parent</a>
				</div>
			
<?php

}
else{
	echo "<div class = 'content'>";
	echo "<div class = 'no'>" . "There Is Not Parents In Courses" . "</div>";
	echo "</div>";
	//echo "<div class = 'btn8'>" . "<a href = 'parents.php?do=Add' class='btn btn-sm btn-primary'>" . "<i class='fa fa-plus'>" . "</i>" . ' Add Parent' . "</a>" . "</div>";
} }


elseif($do=="Add"){?>
			  
			<div class = "content">
			<h1 class = "text-center" id = "cad"> Add new parent </h1><hr>
			<div class = "conc">
				<form class = "add" action = "?do=Insert" method = "post"> 
			    	<fieldset>
					<legend id = "lgd"><img class = 'img-responsive img' src ='../img/courses/8.jpg' alt = 'no'></legend>
					<label class = "col-sm-1 control-label">Username </label>
					<input type = "text" pattern = ".{4,}" title = "You should put more than 4 chars" name = "user" class = "form-control" autocomplete = "off" autofocus = "on" required placeholder = "Enter your name" ?>
					<label class = "col-sm-1 control-label">Password </label>
					<input type = "password" pattern = ".{6,}" title = "You should put more than 6 chars"  name = "pass" class = "form-control" autocomplete = "new-password" placeholder = "Enter your password">
					<label class = "col-sm-1 control-label">E_mail </label>
					<input type = "email" pattern = ".{6,}" title = "You should put more than 6 chars"  name = "email" class = "form-control" required placeholder = "Enter your e_mail" autocomplete = "off">
					<label class = "col-sm-2 control-label">Full name </label>
					<input type = "text" pattern = ".{6,}" title = "You should put more than 6 chars"  name = "full" class = "form-control" required placeholder = "Enter your full name" autocomplete = "off">
					
					<input type = "submit" value = "Add member" class = "btn btn-primary" id = "bttn">
					</fieldset>
				</form>
			</div>
			</div>
<?php

}
elseif($do=="Insert"){
	if($_SERVER['REQUEST_METHOD']=="POST"){
		echo "<div class = 'container'>";
		echo "<h1 class = 'text-center'>Insert member</h1>" . "<hr>";
		$username = filter_var(test_input($_POST['user']),FILTER_SANITIZE_STRING);
		$email = filter_var(test_input($_POST['email']),FILTER_SANITIZE_EMAIL);
		$fullname = filter_var(test_input($_POST['full']),FILTER_SANITIZE_STRING);
		$pass = sha1($_POST['pass']);
		$fe = array();
		if(empty($username)){
			$fe[] = "You should put username ";
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$fe[] = "You should put valid mail ";
		}
		if(empty($pass)){
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

		aadmin::add_parent($username,$pass,$email,$fullname);
}
echo "</div>";
}

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
		$stmt = $con->prepare("SELECT *  from parent where id = ?  ");
		$stmt->execute(array($userId));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){ ?>
			<div class = "content">
			<h1 class = "text-center"> Edit Parents </h1><hr>
			<div class = "conc">
				<form class = "edit" action = "?do=Update" method = "post"> 
				<fieldset>
					<legend id = "lgd"><img class = 'img-responsive img' src ='../img/c/4.jpg' alt = 'no'></legend>
					<input type = "hidden" name = "id" value = "<?php echo $userId ?>" >
					<label class = "col-sm-1 control-label">Username </label>
					<input type = "text" pattern = ".{4,}" title = "You should put more than 4 chars"  name = "user" class = "form-control" autocomplete = "off" autofocus = "on" required placeholder = "Enter your name" value = "<?php echo $row['username'] ?>" >
					<label class = "col-sm-1 control-label">Password </label>
					<input type = "hidden" name = "oldpass" value = "<?php echo $row['password'] ?>">
					<input type = "password"  pattern = ".{6,}" title = "You should put more than 6 chars" name = "newpass" class = "form-control"  autocomplete = "new-password" placeholder = "Enter your password" >					
					<label class = "col-sm-1 control-label">E_mail </label>
					<input type = "email" pattern = ".{6,}" title = "You should put more than 6 chars"  name = "email" class = "form-control" required placeholder = "Enter your e_mail" value = "<?php echo $row['email'] ?>" >
					<label class = "col-sm-2 control-label">Full name </label>
					<input type = "text" pattern = ".{6,}" title = "You should put more than 6 chars"  name = "full" class = "form-control" required placeholder = "Enter your full name"  value = "<?php echo $row['fullname'] ?>" >
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
		$username = filter_var(test_input($_POST['user']),FILTER_SANITIZE_STRING);
		$email = filter_var(test_input($_POST['email']),FILTER_SANITIZE_EMAIL);
		$fullname = filter_var(test_input($_POST['full']),FILTER_SANITIZE_STRING);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$fe[] = "You should put valid mail ";
		}
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
			aadmin::edit_parent($username,$pass0,$email,$fullname,$userid);
	}}
else{
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse this page directly</div>";
			redirect($msg,4);
} 
		}

else if($do=="Delete"){
		
		if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
		$userId = $_GET['userid'];
		$stmt = $con->prepare("SELECT * from parent where id = ? ");
		$stmt->execute(array($userId));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			aadmin::delete_parent($userId);
			}
			
		else {
			echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'>Sorry this user id is not existed</div>";
			redirect($msg,4);
			echo "</div>";
		}


}}
else if($do=="Delete1"){
		if(isset($_GET['courseid']) && is_numeric($_GET['courseid'])){
			$cid = $_GET['courseid']; 
		if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
		$userId = $_GET['userid'];
		$stmt = $con->prepare("SELECT * from parent where id = ? ");
		$stmt->execute(array($userId));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
				$stmt = $con->prepare("delete from conn where parentid = ? and courseid = ?  ");
				$stmt->execute(array($userId,$cid));
				echo "<div class = 'content'>";
				$msg = "<div class = 'alert alert-success' >" . $stmt->rowCount() ." Record Deleted"  . "</div>"; 
				redirect($msg,3);
				echo "</div>";
			}
			
		else {
			echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'>Sorry this user id is not existed</div>";
			redirect($msg,4);
			echo "</div>";
		}


		}}}
else if($do=="Activate"){
	
		echo "<h1 class = 'text-center'>Activate Parents</h1>" . "<hr>";
		if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
		$userId = $_GET['userid'];
		$stmt = $con->prepare("SELECT * from parent where id = ?  ");
		$stmt->execute(array($userId));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			$stmt=$con->prepare("update parent set approval = 1 where id = ?");
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
		
		else if($do=="Activate1"){
			if(isset($_GET['courseid']) && is_numeric($_GET['courseid'])){
				$cid = $_GET['courseid'];
		echo "<h1 class = 'text-center'>Activate Parents</h1>" . "<hr>";
		if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
		$userId = $_GET['userid'];
		$stmt = $con->prepare("SELECT * from conn where parentid = ?  ");
		$stmt->execute(array($userId));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			$stmt=$con->prepare("update conn set approval = 1 where parentid = ? and courseid = ?");
			$stmt->execute(array($userId,$cid));
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
			else{
				$msg = "<div class = 'alert alert-danger'>Sorry you can not do anything</div>";
				redirect($msg,4);
			}
		}
		
include $tpl . "Footer.php";
}
else {
	echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse thiss page directly</div>";
			redirect($msg,4);
			echo "</div>";
}

?>
