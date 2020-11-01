<?php 
session_start();
$nonav2 = "";
$pagetitle = "Manage Courses";
include "Init.php";
if(isset($_SESSION['username'])){

if(isset($_GET['do'])){
	$do = $_GET['do'];
}
else{
	$do = "Manage";
}
if($do=="Manage"){
	
	
	$row1 = aadmin::view_courses();
	
	if(! empty($row1)){
	?>
			
			<div class = "content1" >
			<h1 class = "text-center">Manage Courses </h1><hr>
			<div class="table-responsive" id="#cont">
			<table class="main-color text-center table table-bordered" id="tbl">
				<thead>
				<tr>
					<td>Id</td>
					<td>name</td>
					<td>Price</td>
					<td>Tutor Name</td>
					<td>Category Name</td>
					<td>Registered Date</td>
					<td>Control</td>
				</tr>
				</thead>
				<?php
				foreach($row1 as $row){
					$stmt=$con->prepare("select course.*,tutor.username as tname,cate.name as cname  from course  join tutor on course.tut = tutor.id join cate on course.catid = cate.id  where course.id = ? ");
					$stmt->execute(array($row['id']));
					$rowss=$stmt->fetch();
					echo "<tr>";
						echo "<td>" . $row['id'] . "</td>";
						echo "<td>" . $row['name'] . "</td>";
						echo "<td>" .'$'. $row['price'] . "</td>";
						echo "<td>" . $rowss['tname'] . "</td>";
						echo "<td>" . $rowss['cname'] . "</td>";
						echo "<td>" . $row['date'] . "</td>";
						echo "<td>
									
									<a href='courses.php?do=Edit&courseid=" . $row['id'] ."' class='btn btn-success'><i class = 'fa fa-edit'></i>Edit</a>
									<a href='courses.php?do=Delete&courseid=" . $row['id'] ."' class='btn btn-danger confirm'><i class = 'fa fa-close'></i>Delete</a> ";
						
						            if($row['approval']==0){
										echo "<a href='courses.php?do=Activate&courseid=" . $row['id'] ."' class='btn btn-info confirm'><i class = 'fa fa-check'></i>Activate</a> ";
									}
						echo "</td>";
					echo "</tr>";
				}
				?>
			</table>
			</div>
				<a href = 'courses.php?do=Add' class="btn btn-primary" id="aa"><i class="fa fa-plus"></i> New Course</a>
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
			<h1 class = "text-center" id = "cad"> Add New Course </h1><hr>
			<div class = "conc" style = "height:760px;">
				<form class = "add" action = "?do=Insert" method = "post"  enctype = "multipart/form-data"> 
			    	<fieldset>
					<legend id = "lgd"><img class = 'img-responsive img' src ='e.jpg' alt = 'no'></legend>
					<label class = "col-sm-4 control-label">Name Of Course</label>
					<input type = "text" pattern = ".{4,}" title = "You should put more than 4 chars"  name = "name" class = "form-control" autocomplete = "off" autofocus = "on" required placeholder = "Enter your name" ?>
					<label class = "col-sm-2 control-label">Description </label>
					<input type = "text" pattern = ".{8,}" title = "You should put more than 8 chars"  name = "des" class = "form-control" required placeholder = "Enter the description of the course" autocomplete = "off">
					<label class = "col-sm-2 control-label">Price </label>
					<input type = "number" name = "price" class = "form-control" required placeholder = "Enter the price of the course" autocomplete = "off">
					<label class = "col-sm-2 control-label">Image </label>
					<input class = "form-control" autocomplete = "off" type="file" name = "img" required>
					<label class = "col-sm-2 control-label">Category </label>
					<select class = "form-control" name = "cat">
						<option value = "0">None</option>
						<?php 
							$stmt = $con->prepare("select * from cate");
							$stmt->execute();
							$cate2 = $stmt->fetchAll();
							foreach($cate2 as $cates){
								echo "<option value = '" . $cates['id'] . "'>" . $cates['name'] . "</option>";
							}
							
						?>
					</select>
					<label class = "col-sm-2 control-label" style = "margin-top:7px;">Tutor </label>
					<select class = "form-control" name = "tutor">
						<option value = "0">None</option>
						<?php 
							$stmt = $con->prepare("select * from tutor");
							$stmt->execute();
							$cate2 = $stmt->fetchAll();
							foreach($cate2 as $cates){
								echo "<option value = '" . $cates['id'] . "'>" . $cates['username'] . "</option>";
							}
							
						?>
					</select>
					<input type = "submit" value = "Add Course" class = "btn btn-primary" id = "bttn">
					</fieldset>
				</form>
			</div>
			</div>
<?php

}
elseif($do=="Insert"){
	if($_SERVER['REQUEST_METHOD']=='POST'){
		echo "<div class = 'container'>";
		echo "<h1 class = 'text-center'>Insert Course</h1>" . "<hr>";
		$name = filter_var(test_input($_POST['name']),FILTER_SANITIZE_STRING);
		$des = filter_var(test_input($_POST['des']),FILTER_SANITIZE_STRING);
		$price = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
		$cat = $_POST['cat'];
		$tutor = $_POST['tutor'];
		$img1 = $_FILES['img']['name'];
		$imgsize = $_FILES['img']['size'];
		$imgtmp = $_FILES['img']['tmp_name'];
		$imgext = array("jpg","jpeg","png");
		$tmp = explode('.', $img1);
		$tmp2 = end($tmp);
		$imgallow = strtolower($tmp2);
		$fe = array();
		if(empty($name)){
			$fe[] = "You should put username ";
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
			
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
		}
		if(empty($fe)){
			move_uploaded_file($imgtmp,"..\img\courses\\" . $img1);
			aadmin::add_courses($name,$des,$price,$cat,$tutor,$img1);
			$msg = "<div class = 'alert alert-success text-capitalize'>" . $name .' Has Been Inserted' . "</div>";
			echo $msg;
			echo "<div class = 'alert alert-success text-capitalize'> You will be directed to your page in 2 seconds</div>";
			header("refresh:3;url='courses.php'");
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

	if(isset($_GET['courseid']) && is_numeric($_GET['courseid'])){
		$courseid = $_GET['courseid'];
		$stmt = $con->prepare("SELECT *  from course where id = ?  ");
		$stmt->execute(array($courseid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){ ?>
			<div class = "content">
			<h1 class = "text-center"> Edit Course </h1><hr>
			<div class = "conc" style = "height : 750px;" >
				<form class = "edit" action = "?do=Update" method = "post" enctype = "multipart/form-data"> 
				<fieldset>
					<legend id = "lgd"><img class = 'img-responsive img' src ='../img/courses/<?php echo $row['image']; ?>' alt = 'no'></legend>
					<input type = "hidden" name = "id" value = "<?php echo $courseid ?>" >
					<label class = "col-sm-4 control-label">Name of the course </label>
					<input type = "text" pattern = ".{4,}" title = "You should put more than 4 chars"  name = "name" class = "form-control" autocomplete = "off" autofocus = "on" required placeholder = "Enter the name of the book" value = "<?php echo $row['name'] ?>" >
					<label class = "col-sm-4 control-label">Description of the course </label>
					<input type = "des" pattern = ".{8,}" title = "You should put more than 8 chars"  name = "des" class = "form-control" required placeholder = "Enter the link of the book"  value = "<?php echo $row['descr'] ?>" >
					<label class = "col-sm-4 control-label">Price of the course </label>
					<input type = "number" name = "price" class = "form-control" required placeholder = "Enter the price of the book"  value = "<?php echo $row['price'] ?>" >
					<label class = "col-sm-4 control-label">Change The Image </label>
					<input style = "color:#fff;color:#000" class = "form-control" type="file" name = "imea">
					<input type="hidden"  name="g" value = "<?php echo $row['image']; ?>" >
					<label class = "col-sm-4 control-label">Change the category </label>
					<select class = "form-control" name = "cid">
						<option value = "0">None</option>
						<?php 
							$stmt = $con->prepare("select * from cate");
							$stmt->execute();
							$cate2 = $stmt->fetchAll();
							foreach($cate2 as $cates){
								echo "<option value = '" . $cates['id'] . "'";
								if($cates['id']==$row['catid']){
									echo "selected";
								} 
								echo ">" . $cates['name'] . "</option>";
							}
							
						?>
					</select>
					<br>
					<label class = "col-sm-4 control-label">Change the tutor </label>
					<select class = "form-control" name = "tutor">
						<option value = "0">None</option>
						<?php 
							$stmt = $con->prepare("select * from tutor");
							$stmt->execute();
							$cate2 = $stmt->fetchAll();
							foreach($cate2 as $cates){
								echo "<option value = '" . $cates['id'] . "'";
								if($cates['id']==$row['tut']){
									echo "selected";
								} 
								echo ">" . $cates['username'] . "</option>";
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
		$name = filter_var(test_input($_POST['name']),FILTER_SANITIZE_STRING);
		$des = filter_var(test_input($_POST['des']),FILTER_SANITIZE_STRING);
		$price = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
		$cid = $_POST['cid'];
		$tutor = $_POST['tutor'];
		$courseid = $_POST['id'];
		$image0 = $_FILES['imea']['name'];
		$imgsize = $_FILES['imea']['size'];
		$imgtmp = $_FILES['imea']['tmp_name'];
		$imgext = array("jpg","jpeg","png");
		$tmp1 = explode('.', $image0);
		$tmp2 = end($tmp1);
		$imgallow = strtolower($tmp2);
			$fe = array();
		if(empty($name)){
			$fe[] = "You should put name of this book ";
		}

		if(empty($des)){
			$fe[] = "You should put description ";
		}
		if(empty($cid)){
			$fe[] = "You should put category ";
		}
		if(empty($tutor)){
			$fe[] = "You should put tutor ";
		}
		if(!empty($image0)){
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
		
		
		if(empty($fe)){
			
			aadmin::edit_courses($name,$des,$price,$cid,$tutor,$image0,$courseid);
			move_uploaded_file($imgtmp,"..\img\courses\\" . $image0);
	}
			
	}
else{
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse this page directly</div>";
			redirect($msg,4);
} 
		}

else if($do=="Delete"){
		
		if(isset($_GET['courseid']) && is_numeric($_GET['courseid'])){
		$courseid = $_GET['courseid'];
		$stmt = $con->prepare("SELECT * from course where id = ? ");
		$stmt->execute(array($courseid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			aadmin::delete_courses($courseid);
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
		if(isset($_GET['courseid']) && is_numeric($_GET['courseid'])){
		$courseid = $_GET['courseid'];
		$stmt = $con->prepare("SELECT * from course where id = ?  ");
		$stmt->execute(array($courseid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			$stmt=$con->prepare("update course set approval = 1 where id = ?");
			$stmt->execute(array($courseid));
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
