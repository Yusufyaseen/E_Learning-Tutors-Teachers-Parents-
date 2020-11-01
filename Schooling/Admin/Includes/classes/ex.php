<?php
class forall{
	public static function add_tutor($username,$pass0,$email,$full,$img) {
	  include "Connect.php";
	  try{
          $stm = $con->prepare("insert into  tutor(username,password,email,fullname,image,date) values(:user, :pass, :email , :full,:img,now()) ") ;
		$stm->execute(array( 
			'user' => $username,
			'pass' => $pass0,
			'email' =>$email,
			'full' => $full,
			'img' => $img
		));
		$msg =  "<div class = 'alert alert-success' >" . " 1 Row Inserted" .  "</div>";
		echo "<div class = 'alert alert-primary' >" . 'Wait for approval' .  "</div>";
		redirect($msg,4);
	  }
	  catch(PDOException $e){
		  echo "<div class = 'content'>";
		$msg =  "<div class = 'alert alert-danger' >" . " Nothing has been added" .$e.  "</div>";
		redirect($msg,4);
	  echo "</div>";
	  }
  }
  
  public static function edit_tutor($name,$pass0,$email,$full,$userid,$img) {
	  
		include "Connect.php";
		try{
		$stm = $con->prepare("update tutor SET username = ?,email = ?,fullname = ?, password = ? ,image = ? WHERE id = ? ") ;
		$stm->execute(array($name, $email, $full,$pass0,$img, $userid));
		echo "<div class = 'content'>";
		echo "<h1 class = 'text-center'>Update member</h1>" . "<hr>";
		$msg ="<div class = 'alert alert-info'>" . $stm->rowCount() . ' Has Updated' . "</div>";
		redirect($msg,2);
		echo "</div>";}
		catch(PDOException $e){
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Error message</h1>" . "<hr>";
		$msg ="<div class = 'alert alert-danger'>" . 'Nothing has been updated' .$e. "</div>";
		
		redirect($msg,4);
		echo "</div>";
		}
	}

    public static function view_tutor() {
		include "Connect.php";
		$stmt=$con->prepare("select * from tutor order by id asc");
		$stmt->execute();
		$rows=$stmt->fetchAll();
		return $rows;
  }
  
  /* Books */
  
   public static function view_book() {
	  include "Connect.php";
    $stmt=$con->prepare("select book.*,course.tut as tutid,course.name as cname from book  join course on course.id = book.cid order by book.id desc");
	$stmt->execute();
	$rows=$stmt->fetchAll();
	return $rows;
  }
  public static function edit_book($name0,$link,$cid,$bookid) {
	  
		include "Connect.php";
		try{
		$stm = $con->prepare("update book SET name = ?,link = ?,cid = ? WHERE id = ? ") ;
		$stm->execute(array($name0,$link,$cid, $bookid));
		echo "<div class = 'content'>";
		echo "<h1 class = 'text-center'>Update Book</h1>" . "<hr>";
		$msg ="<div class = 'alert alert-success'>" . $stm->rowCount() . ' Has Updated' . "</div>";
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
	
	public static function delete_book($bookid) {
	  include "Connect.php";
            $stmt=$con->prepare("delete from book where id = ?");
			$stmt->execute(array($bookid));
			echo "<div class = 'content'>";
			echo "<h1 class = 'text-center'>Delete page</h1>" . "<hr>";
				$msg = "<div class = 'alert alert-success' >" . $stmt->rowCount() ." Record Deleted"  . "</div>"; 
				redirect($msg,3);
				echo "</div>";
  }
  
  public static function add_book($name1,$link,$cid) {
	  include "Connect.php";
	  try{
          $stm = $con->prepare("insert into  book(name,link,cid,date) values(:user, :link, :cid,now()) ") ;
		$stm->execute(array( 
			'user' => $name1,
			'link' => $link,
			'cid' =>$cid

		));
		$count = $stm->rowCount();
		echo "<div class = 'container'>";
			echo   "<div class = 'alert alert-success'>" .$count .' Record Is Registered' ."</div>";
			echo   "<div class = 'alert alert-success'> You will be directed to your page in 3 seconds</div>";
		header("refresh:3;url='elements.php'");
	  echo "</div>";}
	  catch(PDOException $e){
		  echo "<div class = 'content'>";
		$msg =  "<div class = 'alert alert-danger' >" . " Nothing has been added" .  "</div>";
		redirect($msg,4);
	  echo "</div>";
	  }
  }
  
  
  /* End Books */
  
  /*Courses*/
  
  
  public static function add_courses($name1,$des,$price,$cat,$tutor,$img) {
	  include "Connect.php";
	  try{
		  $stm = $con->prepare("insert into  course(name,descr,price,catid,tut,image,date) values(:namee , :des , :price , :cat,:tutor ,:img, now()) ") ;
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
			
  }
  

  /*Courses*/
}
?>