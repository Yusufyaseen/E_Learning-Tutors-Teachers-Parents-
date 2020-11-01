<?php 
session_start();
$nonav2 = "";
$pagetitle = "Manage Books";
include "Init.php";
if(isset($_SESSION['username'])){

if(isset($_GET['do'])){
	$do = $_GET['do'];
}
else{
	$do = "Manage";
}
if($do=="Manage"){
	
	
	$row1 = aadmin::view_book();
	
	if(! empty($row1)){
	?>
			
			<div class = "content1" >
			<h1 class = "text-center">Manage Books </h1><hr>
			<div class="table-responsive" id="#cont">
			<table class="main-color text-center table table-bordered" id="tbl">
				<thead>
				<tr>
					<td>Id</td>
					<td>name</td>
					<td>Link</td>
					<td>Tutor’s Name</td>
					<td>Tutor’s subject</td>
					<td>Registered Date</td>
					<td>Control</td>
				</tr>
				</thead>
				<?php
				foreach($row1 as $row){
					$stmt=$con->prepare("select course.*,tutor.username as tname from course  join tutor on course.tut = tutor.id  where course.tut = ?");
					$stmt->execute(array($row['tutid']));
					$rows=$stmt->fetch();
					echo "<tr>";
						echo "<td>" . $row['id'] . "</td>";
						echo "<td>" . $row['name'] . "</td>";
						echo "<td>" . '<a href = ' . $row['link'] . ' target = "blank">' . $row['name'] . '</a>'. "</td>";
						echo "<td>" . $rows['tname'] . "</td>";
						echo "<td>" . $row['cname'] . "</td>";
						echo "<td>" . $row['date'] . "</td>";
						echo "<td style = 'width:250px'>
									
									<a href='book.php?do=Edit&bookid=" . $row['id'] ."' style = 'padding:5px;margin-right:6px;width:70px;' class='btn btn-success col-lg-3'><i class = 'fa fa-edit'></i>Edit</a>
									<a href='book.php?do=Delete&bookid=" . $row['id'] ."'  style = 'padding:5px;margin-right:6px;width:70px;' class='btn btn-danger confirm col-lg-3'><i class = 'fa fa-close '></i>Delete</a> ";
						
						            if($row['approval']==0){
										echo "<a href='book.php?do=Activate&bookid=" . $row['id'] ."' style = 'padding:5px;width:80px;'class='btn btn-info confirm col-lg-3'><i class = 'fa fa-check'></i>Activate</a> ";
									}
						echo "</td>";
					echo "</tr>";
				}
				?>
			</table>
			</div>
				<a href = 'book.php?do=Add' class="btn btn-primary" id="aa"><i class="fa fa-plus"></i> New Book</a>
				</div>
			
<?php

}
else{
	echo "<div class = 'content'>";
	echo "<div class = 'no'>" . "There is not members to show" . "</div>";
	echo "</div>";
	echo "<div class = 'btn8'>" . "<a href = 'book.php?do=Add' class='btn btn-sm btn-primary'>" . "<i class='fa fa-plus'>" . "</i>" . ' Add Book' . "</a>" . "</div>";
} }
elseif($do=="Add"){?>
			  
			<div class = "content">
			<h1 class = "text-center" id = "cad"> Add New Book </h1><hr>
			<div class = "conc">
				<form class = "add" action = "?do=Insert" method = "post"> 
			    	<fieldset>
					<legend id = "lgd"><img class = 'img-responsive img' src ='../img/blog/3.jpg' alt = 'no'></legend>
					<label class = "col-sm-4 control-label">Name Of Book</label>
					<input type = "text" pattern = ".{4,}" title = "You should put more than 4 chars"  name = "name" class = "form-control" autocomplete = "off" autofocus = "on" required placeholder = "Enter your name" ?>
					<label class = "col-sm-2 control-label">Link </label>
					<input type = "link"  pattern = ".{10,}" title = "You should put more than 10 chars"  name = "link" class = "form-control" required placeholder = "Enter the link of the book" autocomplete = "off">
					
					<label class = "col-sm-2 control-label">Course </label>
					<select class = "form-control" name = "cid">
						<option value = "0">None</option>
						<?php 
							$stmt = $con->prepare("select * from course");
							$stmt->execute();
							$cate2 = $stmt->fetchAll();
							foreach($cate2 as $cates){
								echo "<option value = '" . $cates['id'] . "'>" . $cates['name'] . "</option>";
							}
							
						?>
					</select>
					<input type = "submit" value = "Add Book" class = "btn btn-primary" id = "bttn">
					</fieldset>
				</form>
			</div>
			</div>
<?php

}
elseif($do=="Insert"){
	if($_SERVER['REQUEST_METHOD']=="POST"){
		echo "<h1 class = 'text-center'>Insert member</h1>" . "<hr>";
		$name = filter_var(test_input($_POST['name']),FILTER_SANITIZE_STRING);
		$link = filter_var($_POST['link'],FILTER_SANITIZE_URL);
		$cid = $_POST['cid'];
		
		$fe = array();
		if(empty($name)){
			$fe[] = "You should put username ";
		}
		if(!filter_var($link, FILTER_VALIDATE_URL)){
			$fe[] = "You should put valid link ";
		}
		if(empty($link)){
			$fe[] = "You should put link ";
		}
		if(empty($cid)){
			$fe[] = "You should put email ";
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
		aadmin::add_book($name,$link,$cid);
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

	if(isset($_GET['bookid']) && is_numeric($_GET['bookid'])){
		$bookid = $_GET['bookid'];
		$stmt = $con->prepare("SELECT *  from book where id = ?  ");
		$stmt->execute(array($bookid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		$stmt = $con->prepare("SELECT *  from course where id = ?  ");
		$stmt->execute(array($row['cid']));
		$row20 = $stmt->fetch();
		
		if($count>0){ ?>
			<div class = "content">
			<h1 class = "text-center"> Edit Book </h1><hr>
			<div class = "conc">
				<form class = "edit" action = "?do=Update" method = "post"> 
				<fieldset>
					<legend id = "lgd"><img class = 'img-responsive img' src ='../img/courses/<?php echo $row20['image'] ?>' alt = 'no'></legend>
					<input type = "hidden" name = "id" value = "<?php echo $bookid ?>" >
					<label class = "col-sm-4 control-label">Name of the book </label>
					<input type = "text" pattern = ".{4,}" title = "You should put more than 4 chars"  name = "name" class = "form-control" autocomplete = "off" autofocus = "on" required placeholder = "Enter the name of the book" value = "<?php echo $row['name'] ?>" >
					<label class = "col-sm-4 control-label">Link of the book </label>
					<input type = "link" pattern = ".{10,}" title = "You should put more than 10 chars"  name = "link" class = "form-control" required placeholder = "Enter the link of the book"  value = "<?php echo $row['link'] ?>" >
					<label class = "col-sm-4 control-label">Change the course </label>
					<select class = "form-control" name = "cid">
						<option value = "0">None</option>
						<?php 
							$stmt = $con->prepare("select * from course");
							$stmt->execute();
							$cate2 = $stmt->fetchAll();
							foreach($cate2 as $cates){
								echo "<option value = '" . $cates['id'] . "'";
								if($cates['id']==$row['cid']){
									echo "selected";
								} 
								echo ">" . $cates['name'] . "</option>";
							}
							
						?>
					</select>
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
		$cid = $_POST['cid'];
		$name = filter_var(test_input($_POST['name']),FILTER_SANITIZE_STRING);
		$link = filter_var($_POST['link'],FILTER_SANITIZE_URL);
		
		$bookid = $_POST['id'];
			$fe = array();
		if(empty($name)){
			$fe[] = "You should put name of this book ";
		}
		if(!filter_var($link, FILTER_VALIDATE_URL)){
			$fe[] = "You should put valid link ";
		}
		if(empty($link)){
			$fe[] = "You should put link ";
		}
		if(empty($cid)){
			$fe[] = "You should put link ";
		}
		
		foreach($fe as $errors){
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
		}
		
		
		if(empty($fe)){
			
			aadmin::edit_book($name,$link,$cid,$bookid);
	}
			
	}
else{
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse this page directly</div>";
			redirect($msg,4);
} 
		}

else if($do=="Delete"){
		
		if(isset($_GET['bookid']) && is_numeric($_GET['bookid'])){
		$bookid = $_GET['bookid'];
		$stmt = $con->prepare("SELECT * from book where id = ? ");
		$stmt->execute(array($bookid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			aadmin::delete_book($bookid);
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
		if(isset($_GET['bookid']) && is_numeric($_GET['bookid'])){
		$bookid = $_GET['bookid'];
		$stmt = $con->prepare("SELECT * from book where id = ?  ");
		$stmt->execute(array($bookid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			$stmt=$con->prepare("update book set approval = 1 where id = ?");
			$stmt->execute(array($bookid));
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

			echo   "<div class = 'alert alert-danger'> Sorry you can not browse this page directly</div>";
			echo   "<div class = 'alert alert-info'> You will be go for login page in 4 seconds</div>";
	header("refresh:4;url='Login.php'");
			echo "</div>";
}

?>
