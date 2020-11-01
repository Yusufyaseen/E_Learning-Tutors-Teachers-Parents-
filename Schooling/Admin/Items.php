<?php 
session_start();
$nonav2 = "";
$pagetitle = "Items";
if(isset($_SESSION['username'])){
include "Init.php";
if(isset($_GET['do'])){
	$do = $_GET['do'];
}
else{
	$do = "Manage";
}
if($do=="Manage"){
	$query = "";
	if(isset($_GET['page']) && $_GET['page']=="pending"){
		$query = "and approve = 0";
	}
	$stmt=$con->prepare("SELECT items.*,categories.name as cate_name,user.username from items
INNER JOIN categories on categories.id = items.cat_id
INNER JOIN user on user.userid = items.member_id order by id desc");
	$stmt->execute();
	$rows=$stmt->fetchAll();
	if(!empty($rows)){
	?>
			
			<div class = "content1">
			<h1 class = "text-center">Manage Items </h1><hr>
			<div class="table-responsive" id="#cont">
			<table class="main-color text-center table table-bordered" id="tbl">
				<thead>
				<tr>
					<td>ID</td>
					<td>Name</td>
					<td>Description</td>
				    <td>Price</td>
					<td>Country</td>
					<td>Username</td>
					<td>Category name</td>
					<td>Date</td>
					<td>Control</td>
				</tr>
				</thead>
				<?php
				foreach($rows as $row){
					echo "<tr>";
						echo "<td>" . $row['id'] . "</td>";
						echo "<td>" . $row['name'] . "</td>";
						echo "<td >" . $row['description'] . "</td>";
						echo "<td>" . $row['price'] . "</td>";
						echo "<td>" . $row['country'] . "</td>";
						echo "<td>" . $row['username'] . "</td>";
						echo "<td>" . $row['cate_name'] . "</td>";
						echo "<td id = 'dte'>" . $row['date'] . "</td>";
						echo "<td id = 'td'> 
									<a href='Items.php?do=Edit&itemid=" . $row['id'] ."' class='btn btn-success'><i class = 'fa fa-edit'></i>Edit</a>
									<a href='Items.php?do=Delete&itemid=" . $row['id'] ."' class='btn btn-danger confirm'><i class = 'fa fa-close'></i>Delete</a>
									<a id = 'coo' href='Items.php?do=Comment&itemid=" . $row['id'] ."' class='btn btn-success'><i class = 'fa fa-edit'></i>Comment</a>	";
									if($row['approve']==0){
										echo "<a href='items.php?do=Approve&itemid=" . $row['id'] ."' class='btn btn-info confirm' id = 'btn0'><i check = 'fa fa-check'></i>Approve</a> ";
									}
						echo "</td>";
					echo "</tr>";
				}
				?>
			</table>
			</div>
				<a href = 'Items.php?do=Add' class="btn btn-sm btn-primary" id="aa"><i class="fa fa-plus"></i> New Item</a>
				</div> 
			
<?php
}
else{
	echo "<div class = 'content'>";
	echo "<div class = 'no'>" . "There is not items to show" . "</div>";
	echo "</div>";
	echo "<div class = 'btn8'>" . "<a href = 'Items.php?do=Add' class='btn btn-sm btn-primary'>" . "<i class='fa fa-plus'>" . "</i>" . ' Add Item' . "</a>" . "</div>";
}
}
elseif($do=="Add"){
	?>
			  
			<div class = "content item">
			<h1 class = "text-center">Edit Category </h1><hr>
			<div class = "conc">
				<form class = "add" action = "?do=Insert" method = "post"> 
					<label class = "col-sm-1 control-label">Name </label>
					<input type = "text" name = "name" class = "form-control" autocomplete = "off" required autofocus = "on"  placeholder = "Enter your Item " >
					<label class = "col-sm-1 control-label">Description </label>
					<input type = "text" name = "desc" class = "form-control" autocomplete = "off" required autofocus = "on"  placeholder = "Enter your description " >
					<label class = "col-sm-1 control-label">Price </label>
					<input type = "text" name = "price" class = "form-control" autocomplete = "off" required autofocus = "on"  placeholder = "Price of the item " >
					<label class = "col-sm-1 control-label">Country </label>
					<input type = "text" name = "country" class = "form-control" autocomplete = "off" required autofocus = "on"  placeholder = "Country of the item " >
					<label class = "col-sm-1 control-label">Tags </label>
					<input type = "text" name = "tags" class = "form-control" autocomplete = "off"  autofocus = "on"  placeholder = "Tags of the item " >
					<div class = "sts">
					<label class = "col-sm-1 control-label">Status </label>
					<select class = "form-control" name = "status">
					<option value = "0" >None</option>
						<option value = "1" >New</option>
						<option value = "2" >Used</option>
						<option value = "3" >Like New</option>
						<option value = "4" >Very old</option>
					</select>
					<label class = "col-sm-1 control-label">Member </label>
					<select class = "form-control" name = "member">
					<option value = "0" >None</option>
						<?php 
							$stm = $con->prepare("select * from user");
							$stm->execute();
							$users = $stm->fetchAll();
							foreach($users as $row){
								echo "<option value = '" . $row['userid'] . "'>" . $row['username'] . "</option>";
							}
						?>
					</select>
					<label class = "col-sm-1 control-label">Categories </label>
					<select class = "form-control" name = "category">
					<option value = "0" >None</option>
						<?php 
							$stm = $con->prepare("select * from categories where parent = 0 ");
							$stm->execute();
							$cate = $stm->fetchAll();
							foreach($cate as $rows){
								echo "<option id = 'opt0' value = '" . $rows['id'] . "'>" . $rows['name'] . "</option>";
								$stmt2 = $con->prepare("select * from categories where parent = " . $rows['id'] . " order by id desc");
								$stmt2->execute();
								$cat = $stmt2->fetchAll();
								if(! empty($cat)){
									foreach($cat as $cat0){
										echo "<option value = '" . $cat0['id'] . "'>" . "......." . $cat0['name'] . "</option>";
									}
								}
							}
						?>
					</select>
					</div>
					<input type = "submit" value = "Add Item" class = "btn btn-primary btn-sm" id = "bttn">
				</form>
			</div>
			</div>
<?php
}
elseif($do=="Insert"){
	if($_SERVER['REQUEST_METHOD']=="POST"){
		echo "<h1 class = 'text-center'>Insert Items</h1>" . "<hr>";
		$name = $_POST['name'];
		$description = $_POST['desc'];
		$price = $_POST['price'];
		$country = $_POST['country'];
		$status = $_POST['status'];
		$member = $_POST['member'];
		$cat = $_POST['category'];
		$tag = $_POST['tags'];
		$fe = array();
		if(empty($name)){
			$fe[] = "You should put the name of item ";
		}
		if(empty($description)){
			$fe[] = "You should put description ";
		}
		if(empty($price)){
			$fe[] = "You should put price ";
		}
		if(empty($country)){
			$fe[] = "You should put country ";
		}
		if($status == 0){
			$fe[] = "You should put status ";
		}
		if($member == 0){
			$fe[] = "You should put the member ";
		}
		if($cat == 0){
			$fe[] = "You should put the category ";
		}
		foreach($fe as $errors){
			echo "<div class = 'content'>";
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
			echo "</div>";
		}
		if(empty($fe)){
		$stm = $con->prepare("insert into  items(name,description,price,country,status,date,member_id,cat_id,tags) values(:user, :desc, :price, :country,:status,now(), :member, :cat, :tags) ") ;
		$stm->execute(array( 
			'user' => $name,
			'desc' => $description,
			'price' => $price,
			'country' => $country,
			'status' => $status,
			'member' => $member,
			'cat' => $cat,
			'tags' => $tag
			));
		echo "<div class = 'content'>";
		$msg =  "<div class = 'alert alert-success' >" . $stm->rowCount() . " Record registered" .  "</div>";
		redirect($msg,4);
		echo "</div>";
	}
}

else{
	echo "<div class = 'content'>";
	$msg = "<div class = 'alert alert-danger'> Sorry you can not browse this page directly </div>";
	 redirect($msg,4);
	 echo "</div>";
}}

elseif($do=="Edit"){ 
if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){
		$itemid = $_GET['itemid'];
		$stmt = $con->prepare("SELECT *  from items where id = ?  ");
		$stmt->execute(array($itemid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if ($count>0){ ?>
		  
			  <div class = "content item">
			  <h1 class = "text-center"> Edit Items </h1><hr>
				<form class = "add" action = "?do=Update" method = "post"> 
				<input type = "hidden" name = "id" value = "<?php echo $itemid ?>" >
					<label class = "col-sm-1 control-label">Name </label>
					<input type = "text" name = "name" class = "form-control" autocomplete = "off" required autofocus = "on"  placeholder = "Enter your Item " value = "<?php echo $row['name'] ?>" >
					<label class = "col-sm-1 control-label">Description </label>
					<input type = "text" name = "desc" class = "form-control" autocomplete = "off" required autofocus = "on"  placeholder = "Enter your description" value = "<?php echo $row['description'] ?> " >
					<label class = "col-sm-1 control-label">Price </label>
					<input type = "text" name = "price" class = "form-control" autocomplete = "off" required autofocus = "on"  placeholder = "Price of the item " value = "<?php echo $row['price'] ?>" >
					<label class = "col-sm-1 control-label">Country </label>
					<input type = "text" name = "country" class = "form-control" autocomplete = "off" required autofocus = "on"  placeholder = "Country of the item " value = "<?php echo $row['country'] ?>" >
					<label class = "col-sm-1 control-label">Tags </label>
					<input type = "text" name = "tags" class = "form-control" autocomplete = "off"  autofocus = "on"  placeholder = "Tags of the item " value = "<?php echo $row['tags'] ?>" >
					<div class = "sts">
					<label class = "col-sm-1 control-label">Status </label>
					<select class = "form-control" name = "status" >
						<option value = "1"  <?php if($row['status']==1){echo "selected";} ?>>New</option>
						<option value = "2" <?php if($row['status']==2){echo "selected";} ?> >Used</option>
						<option value = "3" <?php if($row['status']==3){echo "selected";} ?> >Like New</option>
						<option value = "4" <?php if($row['status']==4){echo "selected";} ?> >Very old</option>
					</select>
					<label class = "col-sm-1 control-label">Member </label>
					<select class = "form-control" name = "member">
					<option value = "0" >......</option>
						<?php 
							$stm = $con->prepare("select * from user");
							$stm->execute();
							$users = $stm->fetchAll();
							foreach($users as $item){
								echo "<option value = '" . $item['userid'] . "'";
								if($row['member_id']==$item['userid']){ echo "selected"; }
								echo ">". $item['username'] . "</option>";
							}
						?>
					</select>
					<label class = "col-sm-1 control-label">Categories </label>
					<select class = "form-control" name = "category">
					<option value = "0" >......</option>
						<?php 
							$stm = $con->prepare("select * from categories");
							$stm->execute();
							$cate = $stm->fetchAll();
							foreach($cate as $cat){
								echo "<option  value = '" . $cat['id'] . "'";
								if($row['cat_id']==$cat['id']){ echo "selected"; }
								echo ">". $cat['name'] . "</option>";
							}
						?>
					</select>
					</div>
					<input type = "submit" value = "Save Item" class = "btn btn-primary btn-sm" id = "bttn">
				</form>
		
			</div>

	<?php
	}
		else {
			echo "<div class='content'>";
			$msg = "<div class = 'alert alert-danger'>there is no such id</div>";
			redirect($msg,4);
			echo "</div>";
		}
	}
}
elseif($do=="Update"){
	
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$name = $_POST['name'];
		$description = $_POST['desc'];
		$price = $_POST['price'];
		$country = $_POST['country'];
		$status = $_POST['status'];
		$member = $_POST['member'];
		$cat = $_POST['category'];
		$tag = $_POST['tags'];
		$itemid = $_POST['id'];
		$fe = array();
		if(empty($name)){
			$fe[] = "You should put username ";
		}

		if(empty($description)){
			$fe[] = "You should put description ";
		}
		if(empty($price)){
			$fe[] = "You should put price ";
		}
		if(empty($country)){
			$fe[] = "You should put country ";
		}
		foreach($fe as $errors){
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
		}
		
		if(empty($fe)){
		$stm = $con->prepare("update items SET name = ?,description = ?,price = ?, country = ?, status = ?, member_id = ?, cat_id = ?, tags = ? WHERE id = ? ") ;
		$stm->execute(array($name, $description, $price,$country, $status, $member, $cat,$tag,$itemid));
		echo "<div class = 'content'>";
		echo "<h1 class = 'text-center'>Update Item</h1>" . "<hr>";
		$msg ="<div class = 'alert alert-success'>" . $stm->rowCount() . ' Has Updated' . "</div>";
		redirect($msg,4);
		echo "</div>";
	}}
else{
		echo "<div class = 'content'>";
		
		$msg ="<div class = 'alert alert-danger'>" . 'Sorry you can not brose this page directly' . "</div>";
		redirect($msg,4);
		echo "</div>";
}
}
elseif($do=="Delete"){
	
		if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){
		$itemid = $_GET['itemid'];
		$stmt = $con->prepare("SELECT * from items where id = ?  ");
		$stmt->execute(array($itemid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			$stmt=$con->prepare("delete from items where id = ?");
			$stmt->execute(array($itemid));
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Delete Item</h1>" . "<hr>";
				$msg = "<div class = 'alert alert-success' >" . $stmt->rowCount() ." Record Deleted"  . "</div>"; 
				redirect($msg,3);
				echo "</div>";
			}
			
		else {
			echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse this page directly</div>";
			redirect($msg,4);
			echo "</div>";
		}



}}
elseif($do=="Approve"){
	
		if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){
		$itemid = $_GET['itemid'];
		$stmt = $con->prepare("SELECT * from items where id = ?  ");
		$stmt->execute(array($itemid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			$stmt=$con->prepare("update items set approve = 1 where id = ?");
			$stmt->execute(array($itemid));
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Activate members</h1>" . "<hr>";
				$msg = "<div class = 'alert alert-success' >" . $stmt->rowCount() ." Record Updated"  . "</div>"; 
				redirect($msg,3);
				echo "</div>";
			}
			
		else {
			echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse this page directly</div>";
			redirect($msg,4);
			echo "</div>";
		}


}

}
elseif($do=="Comment"){
	if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){
		$itemid = $_GET['itemid'];
	$stmt=$con->prepare("select comments.*,user.username as username from comments
	inner join user on user.userid = comments.user_id
	where item_id = $itemid
	");
	$stmt->execute();
	$rows=$stmt->fetchAll();
	if(!empty($rows)){
	?>
			
			<div class = "content1">
			<h1 class = "text-center">Manage Comment </h1><hr>
			<div class="table-responsive" id="#cont">
			<table class="main-color text-center table table-bordered" id="tbl">
				<thead>
				<tr>
					<td>ID</td>
					<td>Comment</td>
					<td>Username</td>
					<td>Added Date</td>
					<td>Control</td>
				</tr>
				</thead>
				<?php
				foreach($rows as $row){
					echo "<tr>";
						echo "<td>" . $row['id'] . "</td>";
						echo "<td>" . $row['comment'] . "</td>";
						echo "<td>" . $row['username'] . "</td>";
						echo "<td>" . $row['date'] . "</td>";
						echo "<td> 
									<a href='Comments.php?do=Edit&comid=" . $row['id'] ."' class='btn btn-success'><i class = 'fa fa-edit'></i>Edit</a>
									<a href='Comments.php?do=Delete&comid=" . $row['id'] ."' class='btn btn-danger confirm'><i class = 'fa fa-close'></i>Delete</a> ";
									if($row['status']==0){
										echo "<a href='Comments.php?do=Approve&comid=" . $row['id'] ."' class='btn btn-info confirm'><i class = 'fa fa-check'></i>Approve</a> ";
									}
						echo "</td>";
					echo "</tr>";
				}
				?>
			</table>
			</div>
				</div>
<?php 
}
else{
	echo "<div class = 'content'>";
				$msg = "<div class = 'alert alert-danger' >" . 'There is not comments here' . "</div>"; 
				redirect($msg,3);
				echo "</div>";
}
}
}
		
include $tpl . "Footer.php";
}
else {
	include "Login.php";
}

?>