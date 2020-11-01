<?php
 session_start();
 $pagetitle = "Show Item";
 include "Init.php"; 
 if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){
	 $itemid = $_GET['itemid'];
 }
 $stmt = $con->prepare("select items.*,categories.name as category_name,user.username from items
INNER JOIN categories on categories.id = items.cat_id
INNER JOIN user on user.userid = items.member_id where items.id = ? and approve = 1 ");
 $stmt->execute(array($itemid));
 $row = $stmt->fetch();
 $count = $stmt->rowCount();
 if($count>0){
?>
<div class = "content">
<h1 class = "text-center"><?php echo $row['username'] . "’s Profile" ?></h1><hr>
	<div class = "row">
	  <div class = "col-md-4">
	  <img class = 'img-responsive img ' id = "imgg1" src ="items/<?php echo $row['image'] ?>" alt = 'no' />
	  </div>
	  <div class = "col-md-8 info2">
	  <h2 id = "name0"> <?php echo $row['name'] ?> </h2>
	  <p id = "dsc"> <?php echo $row['description'] ?> </p>
	  <ul class = "list-unstyled">
	  <li><i class = "fa fa-calendar fa-fw"></i> Date : <?php echo $row['date'] ?> </li>
	  <li><i class = "fa fa-money fa-fw"></i> price :  $<?php echo $row['price'] ?> </li>
	  <li><i class = "fa fa-building fa-fw"></i> Made in : <?php echo $row['country'] ?> </li>
	  <li><i class = "fa fa-tags fa-fw"></i> Category : <a href = "Cate1.php?pageid=<?php echo $row['cat_id'] ?>"><?php echo $row['category_name'] ?></a> </li>
	  <li><i class = "fa fa-user fa-fw"></i> Added by :  <a href = "Profile.php"><?php echo $row['username'] ?></a> </li>
	  <li>
	  <i class = "fa fa-user fa-fw"></i>
	  Tags : 
		<?php 
		  $all = explode(",",$row['tags']);
		  foreach($all as $tags){
			  $lower = strtolower($tags);
			  echo "<a id = 'tag' href = 'Tags.php?name={$lower}'>" . $tags . "</a>" . " ";
		  }
		?>
	  </li>
	  </ul>
	  </div>
	</div>
	<!--<hr id = "hrr">
	<div class = "rat">
	<h3 id = "ratt">Rating</h3>
	<a class = "btn btn-primary" href = "item.php?itemid=<?php echo $row['id'] ?>&rate=<?php echo $row['id'] ?>" id = "ra">Rate</a>
	<?php echo countitems3("rate","items","rate") ?>
	<meter min="0" max="<?php echo countitems3("username","user","regstatus") ?>"  value="0.9" high="0.7"  low="0.2"></meter>
	</div> -->
	<hr id = "hrr">
	<?php  
	   if(isset($_GET['rate']) && is_numeric($_GET['rate'])){
		   $rate = $_GET['rate'];
		   $stmt = $con->prepare("update items set rate = 1 where id = ?");
		   $stmt->execute(array($rate));
		   $count = $stmt->rowCount();
		   $msg ="<div class = 'alert alert-success'>" . $count . ' Has Updated' . "</div>";
		   echo $msg;
	   }
	?>
	<?php if(isset($_SESSION['user'])){ ?>
		<div class = "row">
			<div class = "col-md-4">
			   <img class = 'img-responsive img ' id = "imgg2"  src ='com.jpg' alt = 'no' />
			</div>
			<div class = "col-md-8"> 
				<div class = "addcomment">
				<h3 id = "opt1">Add your comment</h3>
					<form action = "<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $row['id'] ?>" method = "POST">
					  <textarea class = "form-control" name = "comment" required></textarea>
					  <input class = "btn btn-primary" type = "submit" value = "Add Comment">
					</form>
					<?php 
						if($_SERVER['REQUEST_METHOD']=="POST"){
							$comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
							$userid = $row['member_id'];
							$itemid = $row['id'];
							if(!empty($comment)){
							$stmt = $con->prepare("insert into comments(comment,status,date,item_id,user_id) values(:comment,0,now(),:itemid,:userid)");
							$stmt->execute(array(
							'comment' => $comment,
							'itemid' => $itemid,
							'userid' => $userid
							));
							$count = $stmt->rowCount();
							
							if($count>0){
								echo "<div class='content'>";
								echo "<div class = 'alert alert-success'>You have put a comment</div>";
								echo "</div>";
							}}
							else{
								echo "<div class='content'>";
								echo  "<div class = 'alert alert-danger'>You should put a comment</div>";
								echo "</div>";
							}
						}
					?>
				</div>
			</div>
		</div>
	
	<?php }
	else{
		echo "<div class = 'btn btn-primary'>" . "<a id = 'ln' href = 'Log.php?do=Login'>" . "Login  " . "</a>" . "or" . "<a id = 'ln' href = 'Log.php?do=Sign'>" . "  Sign  " . "</a>" . "to read the comments" . "</div>";
	}?>
	<hr id = "hrr">
	<?php
			$stmt=$con->prepare("select comments.*,user.username as username from comments
			inner join user on user.userid = comments.user_id
			where status = 1 and item_id = ?
			order by id desc
			");
			$stmt->execute(array($row['id']));
			$rows=$stmt->fetchAll();
			?>
	<div class = "row" id = "com">
			<?php 
			
			foreach($rows as $comment){
			//echo "<div class = 'comment-show'>";
			echo "<div class = 'row' id = 'come'>";
				echo "<div class = 'col-md-4 text-center'>"  . "<img class = 'img-responsive  img-thumb ' src ='fo4.jpg' alt = 'no' />" . "<P id = 'usr'>" . $comment['username'] . "</p>" . "<br>" . "</div>";
				echo "<p class = 'col-md-8 parag'>" . $comment['comment'] . "<br>" . "</p>";	
			echo "</div>";
		//	echo "</div>";
			echo "<hr id = 'hrr2'>";
		}
		?>
	</div>
	
<?php
 }
 else{
		echo "<div class='content'>";
		$msg = "<div class = 'alert alert-danger'>There is no such id here or this item is not aprroval</div>";
		redirect($msg,4);
		echo "</div>";
 }
?>
<?php 
 include $tpl . "Footer.php" 
 ?>