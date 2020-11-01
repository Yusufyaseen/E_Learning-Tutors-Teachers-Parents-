<?php 

class pparent implements loginall{

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
		$stmt = $con->prepare("SELECT username,password from parent where username = ? AND password = ? and approval = 1 ");
		$stmt->execute(array($name,$pass0));
		$count = $stmt->rowCount();
		return $count;
		
	
	  }
  public static function login1_parent($name,$pass0) {
		include "Connect.php";
		$stmt = $con->prepare("SELECT * from parent where username = ? AND password = ? and approval = 1 ");
		$stmt->execute(array($name,$pass0));
		$row = $stmt->fetch();
		return $row;
		
	
	  }
  public static function add_parent($username,$pass0,$email,$full) {
	  include "Connect.php";
	  try{
          $stm = $con->prepare("insert into  parent(username,password,email,fullname,date) values(:user, :pass, :email,:full,now()) ") ;
		$stm->execute(array( 
			'user' => $username,
			'pass' => $pass0,
			'email' =>$email,
			'full' => $full
		));
		echo "<div class = 'container'>";
		$msg =  "<div class = 'alert alert-info' >" . $stm->rowCount() . " Record registered" .  "</div>";
		echo "<div class = 'alert alert-primary' >" . 'Wait for approval' .  "</div>";
		redirect($msg,4);
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
		$msg ="<div class = 'alert alert-success'>" . $stm->rowCount() . ' Has Updated' . "</div>";
		echo $pass;
		redirect($msg,4);
		echo "</div>";}
		catch(PDOException $e){
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Error message</h1>" . "<hr>";
		$msg ="<div class = 'alert alert-danger'>" . 'Nothing has been updated' . "</div>";
		
		redirect($msg,4);
		echo "</div>";
		}
	}
  
  public static function view_parent() {
	  include "Connect.php";
    $stmt=$con->prepare("select parent.*, course.name as cname  from parent join course on course.id = parent.book order by id asc");
	$stmt->execute();
	$rows=$stmt->fetchAll();
	return $rows;
  }


}

?>