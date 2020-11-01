<?php 

class aadmin extends forall implements loginall {

  public $name;
  public $pass;
  public $email;
  public $full;

  function __construct($name,$pass,$mail,$full) {
    $this->name = $name;
    $this->pass = $pass;
    $this->email = $mail;
    $this->full = $full;
  }

	public static function login($name,$pass0) {
		  include "Connect.php";
		$stmt = $con->prepare("SELECT username,password from admin where username = ? AND password = ? ");
		$stmt->execute(array($name,$pass0));
		$count = $stmt->rowCount();
		return $count;
		
	
	  }
	  public static function login1_admin($name,$pass0) {
		  include "Connect.php";
		$stmt = $con->prepare("SELECT * from admin where username = ? AND password = ? ");
		$stmt->execute(array($name,$pass0));
		$row = $stmt->fetch();
		return $row;
	  }


  public function add_admin() {
	  include "Connect.php";
	  try{
          $stm = $con->prepare("insert into  admin(username,password,email,fullname,date) values(:user, :pass, :email,:full,now()) ") ;
		$stm->execute(array( 
			'user' => $this->name,
			'pass' => $this->pass,
			'email' =>$this->email,
			'full' => $this->full
		));
		echo "<div class = 'content'>";
		$msg =  "<div class = 'alert alert-success' >" . $stm->rowCount() . "Record registered" .  "</div>";
		redirect($msg,4);
	  echo "</div>";}
	  catch(PDOException $e){
		  $msg =  "<div class = 'alert alert-danger' >". "It s already exist" .  "</div>";
		redirect($msg,4);
	  }
  }
  public static function view_admin() {
	  include "Connect.php";
    $stmt=$con->prepare("select * from admin  order by id desc");
	$stmt->execute();
	$rows=$stmt->fetchAll();
	return $rows;
  }
  public  function edit_admin($userid) {
	  
		include "Connect.php";
		$fe = array();
		if(empty($this->name)){
			$fe[] = "You should put username ";
		}

		if(empty($this->email)){
			$fe[] = "You should put email ";
		}
		if(empty($this->full)){
			$fe[] = "You should put fullname ";
		}
		foreach($fe as $errors){
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
		}
		
		
		if(empty($fe)){
			$stmt2 = $con->prepare("select username from admin where username = ? and id != ?");
			$stmt2->execute(array($this->name, $userid));
			$count2 = $stmt2->rowCount();
			if($count2>0){
			echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'  >" . "Sorry this user is exists" . "</div>";
			redirect($msg,4);
			echo "</div>";
			}
			else{
		
		$stm = $con->prepare("update admin SET username = ?,email = ?,fullname = ?, password = ? WHERE id = ? ") ;
		$stm->execute(array($this->name, $this->email, $this->full,$this->pass, $userid));
		echo "<div class = 'content'>";
		echo "<h1 class = 'text-center'>Update member</h1>" . "<hr>";
		$msg ="<div class = 'alert alert-success'>" . $stm->rowCount() . ' Has Updated' . "</div>";
		redirect($msg,4);
		echo "</div>";
	}}
  }
  public static function delete_admin($userId) {
	  include "Connect.php";
            $stmt=$con->prepare("delete from admin where id = ?");
			$stmt->execute(array($userId));
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Delete page</h1>" . "<hr>";
				$msg = "<div class = 'alert alert-success' >" . $stmt->rowCount() ." Record Deleted"  . "</div>"; 
				redirect($msg,3);
				echo "</div>";
  }
  public static function view_parent() {
	  try{
	  include "Connect.php";
    $stmt=$con->prepare("select * from parent order by id asc");
	$stmt->execute();
	$rows=$stmt->fetchAll();
	  return $rows;}
	  catch(PDOException $e){
		  echo $e;
	  }
  }
  
  public static function add_parent($username,$pass0,$email,$full) {
	  include "Connect.php";
	  try{
          $stm = $con->prepare("insert into  parent(username,password,email,fullname,date,approval) values(:user, :pass, :email,:full,now(),1) ") ;
		$stm->execute(array( 
			'user' => $username,
			'pass' => $pass0,
			'email' =>$email,
			'full' => $full
		));
		echo "<div class = 'container'>";
		$msg =  "<div class = 'alert alert-info' >" . $stm->rowCount() . " Record registered" .  "</div>";
		echo $msg;
		echo "<div class = 'alert alert-success'>" . 'You Will Be Direct To Manage Page' . "</div>";
		header("refresh:3;url='parents.php?do=Manage'");
	  echo "</div>";}
	  catch(PDOException $e){
		  echo "<div class = 'content'>";
		$msg =  "<div class = 'alert alert-danger' >" . "Nothing has been added" .  "</div>";
		redirect($msg,4);
	  echo "</div>";
	  }
  }
  public static function edit_parent($name,$pass0,$email,$full,$userid) {
	  
		include "Connect.php";
		try{
		$stm = $con->prepare("update parent SET username = ?, password = ?,email = ?,fullname = ? WHERE id = ? ") ;
		$stm->execute(array($name,$pass0, $email, $full, $userid));
		echo "<div class = 'content'>";
		echo "<h1 class = 'text-center'>Update member</h1>" . "<hr>";
		$msg ="<div class = 'alert alert-success'>" . $stm->rowCount() . ' Record Has Updated' . "</div>";
		echo $msg;
		echo "<div class = 'alert alert-success'>" . 'You Will Be Direct To Manage Page' . "</div>";
		header("refresh:3;url='parents.php?do=Manage'");
		echo "</div>";}
		catch(PDOException $e){
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Error message</h1>" . "<hr>";
		$msg ="<div class = 'alert alert-danger'>" . 'Nothing has been updated' . "</div>";
		
		redirect($msg,4);
		echo "</div>";
		}
	}
	
	
	
	
	public static function delete_parent($userId) {
	  include "Connect.php";
            $stmt=$con->prepare("delete from parent where id = ?");
			$stmt->execute(array($userId));
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Delete page</h1>" . "<hr>";
				$msg = "<div class = 'alert alert-success' >" . $stmt->rowCount() ." Record Deleted"  . "</div>"; 
				redirect($msg,3);
				echo "</div>";
  }
  
  public static function add_tutor($username,$pass0,$email,$full,$img) {
	  include "Connect.php";
	  try{
          $stm = $con->prepare("insert into  tutor(username,password,email,fullname,image,date,approval) values(:user, :pass, :email , :full,:img,now(),1) ") ;
		$stm->execute(array( 
			'user' => $username,
			'pass' => $pass0,
			'email' =>$email,
			'full' => $full,
			'img' => $img
		));
		?>
		<div class = "container">
		<?php
		$msg =  "<div class = 'alert alert-success' >" . " 1 Row Inserted" .  "</div>";
		echo $msg;
		echo "<div class = 'alert alert-success'>" . 'You Will Be Direct To Manage Page' . "</div>";
		header("refresh:3;url='tutors.php?do=Manage'");
		?>
		</div> <?php
	 }
	  catch(PDOException $e){
		  echo "<div class = 'content'>";
		$msg =  "<div class = 'alert alert-danger' >" . " Nothing has been added" .  "</div>";
		redirect($msg,4);
	  echo "</div>";
	  }
  }
  public static function delete_tutor($userId) {
	  include "Connect.php";
            $stmt=$con->prepare("delete from tutor where id = ?");
			$stmt->execute(array($userId));
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Delete page</h1>" . "<hr>";
				$msg = "<div class = 'alert alert-success' >" . $stmt->rowCount() ." Record Deleted"  . "</div>"; 
				redirect($msg,3);
				echo "</div>";
  }
  
  
public static function add_book($name1,$link,$cid) {
	  include "Connect.php";
	  try{
          $stm = $con->prepare("insert into  book(name,link,cid,date,approval) values(:user, :link, :cid,now(),1) ") ;
		$stm->execute(array( 
			'user' => $name1,
			'link' => $link,
			'cid' =>$cid

		));
		echo "<div class = 'content'>";
		$msg =  "<div class = 'alert alert-success' >" . $stm->rowCount() . " Record registered" .  "</div>";
		redirect($msg,4);
	  echo "</div>";}
	  catch(PDOException $e){
		  echo "<div class = 'content'>";
		$msg =  "<div class = 'alert alert-danger' >" . " Nothing has been added" .  "</div>";
		redirect($msg,4);
	  echo "</div>";
	  }
  }
 
 public static function view_category() {
	  include "Connect.php";
    $stmt=$con->prepare("select * from cate order by id asc");
	$stmt->execute();
	$rows=$stmt->fetchAll();
	return $rows;
  }
  public static function edit_category($name0,$desc,$catid) {
	  
		include "Connect.php";
		try{
		$stm = $con->prepare("update cate SET name = ?,des = ? WHERE id = ? ") ;
		$stm->execute(array($name0,$desc,$catid));
		echo "<div class = 'content'>";
		echo "<h1 class = 'text-center'>Update Book</h1>" . "<hr>";
		$msg ="<div class = 'alert alert-success'>" . $stm->rowCount() . ' Has Updated' . "</div>";
		redirect($msg,4);
		echo "</div>";}
		catch(PDOException $e){
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Error message</h1>" . "<hr>";
		$msg ="<div class = 'alert alert-danger'>" . 'Nothing has been updated' .$e. "</div>";
		
		redirect($msg,4);
		echo "</div>";
		}
	}
	
	public static function delete_category($cateid) {
	  include "Connect.php";
            $stmt=$con->prepare("delete from cate where id = ?");
			$stmt->execute(array($cateid));
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Delete page</h1>" . "<hr>";
				$msg = "<div class = 'alert alert-success' >" . $stmt->rowCount() ." Record Deleted"  . "</div>"; 
				redirect($msg,3);
				echo "</div>";
  }
  
  public static function add_category($name1,$des) {
	  include "Connect.php";
	  try{
		  $stm = $con->prepare("insert into  cate(name,des,date) values(:user , :d , now()) ") ;
		$stm->execute(array( 
			'user' => $name1,
			'd' => $des

		));
		echo "<div class = 'content'>";
		$msg =  "<div class = 'alert alert-success' >" . $stm->rowCount() . " Record registered" .  "</div>";
		redirect($msg,4);
	  echo "</div>";}
	  catch(PDOException $e){
		  echo "<div class = 'content'>";
		$msg =  "<div class = 'alert alert-danger' >" . " Nothing has been added" . $e . "</div>";
		redirect($msg,4);
	  echo "</div>";
	  }
  }
  
  
  
  public static function view_courses() {
	  include "Connect.php";
    $stmt=$con->prepare("select * from course order by id asc");
	$stmt->execute();
	$rows=$stmt->fetchAll();
	return $rows;
  }
  public static function edit_courses($namee,$des,$price,$catid,$tutor,$image,$courseid) {
	  
		include "Connect.php";
		try{
		$stm = $con->prepare("update course SET name = ?,descr = ?,price = ?,catid = ?,tut = ?,image = ? WHERE id = ? ") ;
		$stm->execute(array($namee,$des,$price,$catid,$tutor,$image,$courseid));
		echo "<div class = 'content'>";
		echo "<h1 class = 'text-center'>Update Book</h1>" . "<hr>";
		$msg ="<div  class='alert alert-info'>" . $stm->rowCount() . ' Has Updated' . "</div>";
		$msg2 ="<div class = 'alert alert-success'>" . 'You Will Be Directed Now' . "</div>";
		echo $msg;
		echo $msg2;
		header("refresh:3;url='courses.php'");
		echo "</div>";}
		catch(PDOException $e){
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Error message</h1>" . "<hr>";
		$msg ="<div class = 'alert alert-danger'>" . 'Nothing has been updated' .$e. "</div>";
		
		redirect($msg,400);
		echo "</div>";
		}
	}
	
	 public static function add_courses($name1,$des,$price,$cat,$tutor,$img) {
	  include "Connect.php";
	  try{
		  $stm = $con->prepare("insert into  course(name,descr,price,catid,tut,image,date,approval) values(:namee , :des , :price , :cat,:tutor ,:img, now(),1) ") ;
		$stm->execute(array( 
			'namee' => $name1,
			'des' => $des,
			'price' => $price,
			'cat' => $cat,
			'tutor' => $tutor,
			'img' => $img
		));
		}
	  catch(PDOException $e){
		  echo "<div class = 'content'>";
		$msg =  "<div class = 'alert alert-danger' >" . " Nothing has been added" . $e . "</div>";
		redirect($msg,3);
	  echo "</div>";
	  }
  }
	public static function delete_courses($courseid) {
	  include "Connect.php";
            $stmt=$con->prepare("delete from course where id = ?");
			$stmt->execute(array($courseid));
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Delete page</h1>" . "<hr>";
				$msg = "<div class = 'alert alert-success' >" . $stmt->rowCount() ." Record Deleted"  . "</div>"; 
				redirect($msg,3);
				echo "</div>";
  }
  
  
  
  
}

?>