<?php 
session_start();
$nonav2 = "";
$pagetitle = "Manage Categories";
include "Init.php";
if(isset($_SESSION['username'])){

if(isset($_GET['do'])){
	$do = $_GET['do'];
}
else{
	$do = "Manage";
}
if($do=="Manage"){
	
	
	$row1 = aadmin::view_category();
	if(! empty($row1)){
	?>
			
			<div class = "content1" >
			<h1 class = "text-center">Manage Categories </h1><hr>
			<div class="table-responsive" id="#cont">
			<table class="main-color text-center table table-bordered" id="tbl">
				<thead>
				<tr>
					<td>Id</td>
					<td>Name</td>
					<td>Description</td>
					<td>Date</td>
					<td>Control</td>
				</tr>
				</thead>
				<?php
				foreach($row1 as $row){
					echo "<tr>";
						echo "<td>" . $row['id'] . "</td>";
						echo "<td>" . $row['name'] . "</td>";
						echo "<td>" . $row['des'] . "</td>";
						echo "<td>" . $row['date'] . "</td>";
						echo "<td> 
									<a href='categories.php?do=Edit&catid=" . $row['id'] ."' class='btn btn-success'><i class = 'fa fa-edit'></i>Edit</a>
									<a href='categories.php?do=Delete&catid=" . $row['id'] ."' class='btn btn-danger confirm'><i class = 'fa fa-close'></i>Delete</a> ";

									
						
						echo "</td>";
					echo "</tr>";
				}
				?>
			</table>
			</div>
				<a href = 'categories.php?do=Add' class="btn btn-primary" id="aa"><i class="fa fa-plus"></i> New Category</a>
				</div>
			
<?php

}
else{
	echo "<div class = 'content'>";
	echo "<div class = 'no'>" . "There is not members to show" . "</div>";
	echo "</div>";
	echo "<div class = 'btn8'>" . "<a href = 'categories.php?do=Add' class='btn btn-sm btn-primary'>" . "<i class='fa fa-plus'>" . "</i>" . ' Add Member' . "</a>" . "</div>";
} }
elseif($do=="Add"){?>
			  
			<div class = "content">
			<h1 class = "text-center" id = "cad"> Add New Category </h1><hr>
			<div class = "conc">
				<form class = "add" action = "?do=Insert" method = "post"> 
			    	<fieldset>
					<legend id = "lgd"><img class = 'img-responsive img' src ='../img/categories/1.jpg' alt = 'no'></legend>
					<label class = "col-sm-4 control-label">Category Name </label>
					<input type = "text" pattern = ".{4,}" title = "You should put more than 4 chars"  name = "name" class = "form-control" autocomplete = "off" autofocus = "on" required placeholder = "Enter the name" ?>
					<label class = "col-sm-1 control-label">Description </label>
					<input type = "text" pattern = ".{8,}" title = "You should put more than 8 chars"  name = "desc" class = "form-control" placeholder = "Enter the description">
					
					<input type = "submit" value = "Add Category" class = "btn btn-primary" id = "bttn">
					</fieldset>
				</form>
			</div>
			</div>
<?php

}
elseif($do=="Insert"){
	if($_SERVER['REQUEST_METHOD']=="POST"){
		echo "<h1 class = 'text-center'>Insert member</h1>" . "<hr>";
		$desc = $_POST['desc'];
		$name = filter_var(test_input($_POST['name']),FILTER_SANITIZE_STRING);
		$desc = filter_var(test_input($_POST['desc']),FILTER_SANITIZE_STRING);
		$fe = array();
		if(empty($name)){
			$fe[] = "You should put name ";
		}
		if(empty($desc)){
			$fe[] = "You should put description ";
		}
		
		
		foreach($fe as $errors){
			echo "<div class = 'content'>";
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
			echo "</div>";
		}
		if(empty($fe)){
		
		aadmin::add_category($name,$desc);
	
}}

else{
	echo "<div class = 'content'>";
	$msg = "<div class = 'alert alert-danger'> Sorry you can not browse this page directly </div>";
	 redirect($msg,4);
	 echo "</div>";
}
}
elseif($do=="Edit"){ 

	if(isset($_GET['catid']) && is_numeric($_GET['catid'])){
		$catid = $_GET['catid'];
		$stmt = $con->prepare("SELECT *  from cate where id = ?  ");
		$stmt->execute(array($catid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){ ?>
			<div class = "content">
			<h1 class = "text-center"> Edit Parents </h1><hr>
			<div class = "conc">
				<form class = "edit" action = "?do=Update" method = "post"> 
				<fieldset>
					<legend id = "lgd"><img class = 'img-responsive img' src ='fo2.png' alt = 'no'></legend>
					<input type = "hidden" name = "id" value = "<?php echo $catid ?>" >
					<label class = "col-sm-1 control-label">name </label>
					<input type = "text" pattern = ".{4,}" title = "You should put more than 4 chars"  name = "name" class = "form-control" autocomplete = "off" autofocus = "on" required placeholder = "Enter the name" value = "<?php echo $row['name'] ?>" >
					<label class = "col-sm-1 control-label">Description </label>
					<input type = "text" pattern = ".{8,}" title = "You should put more than 8 chars"  value = "<?php echo $row['des'] ?>" name = "desc" class = "form-control"  placeholder = "Enter the description" >					
					
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
		$catid = $_POST['id'];
		$name = filter_var(test_input($_POST['name']),FILTER_SANITIZE_STRING);
		$desc = filter_var(test_input($_POST['desc']),FILTER_SANITIZE_STRING);
		$fe = array();
		if(empty($name)){
			$fe[] = "You should put username ";
		}

		if(empty($desc)){
			$fe[] = "You should put email ";
		}
		
		foreach($fe as $errors){
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
		}
		
		
		if(empty($fe)){
			aadmin::edit_category($name,$desc,$catid);
	}}
else{
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse this page directly</div>";
			redirect($msg,4);
} 
		}

else if($do=="Delete"){
		
		if(isset($_GET['catid']) && is_numeric($_GET['catid'])){
		$catid = $_GET['catid'];
		$stmt = $con->prepare("SELECT * from cate where id = ? ");
		$stmt->execute(array($catid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			aadmin::delete_category($catid);
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
	echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse this page directly</div>";
			redirect($msg,4);
			echo "</div>";
}

?>
