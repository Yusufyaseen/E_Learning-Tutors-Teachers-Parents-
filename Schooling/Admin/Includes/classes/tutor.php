<?php 
class tutor extends forall implements loginall{

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
		$stmt = $con->prepare("SELECT username,password from tutor where username = ? AND password = ? and approval = 1 ");
		$stmt->execute(array($name,$pass0));
		$count = $stmt->rowCount();
		return $count;
		
	
	  }
  public static function login1_tutor($name,$pass0) {
		include "Connect.php";
		$stmt = $con->prepare("SELECT * from tutor where username = ? AND password = ? and approval = 1 ");
		$stmt->execute(array($name,$pass0));
		$row = $stmt->fetch();
		return $row;
		
	
	  }
	  public static function select_courses($ide) {
		include "Connect.php";
		$stmt=$con->prepare("select course.* ,tutor.fullname as tname ,tutor.image as image1, cate.name as cname  from course join tutor on course.tut = tutor.id join cate on course.catid = cate.id where course.tut = ?");
		$stmt->execute(array($ide));
		$row2=$stmt->fetchAll();
		return $row2;
	  }
		public static function edit_courses($namee,$des,$price,$catid,$image,$courseid) {
	  
		include "Connect.php";
		try{
		$stm = $con->prepare("update course SET name = ?,descr = ?,price = ?,catid = ?,image = ? WHERE id = ? ") ;
		$stm->execute(array($namee,$des,$price,$catid,$image,$courseid));
		   }
		catch(PDOException $e){
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Error message</h1>" . "<hr>";
		$msg ="<div class = 'alert alert-danger'>" . 'Nothing has been updated' .$e. "</div>";
		
		redirect($msg,4);
		echo "</div>";
		}
	}
  
	
  
	
	

}

?>