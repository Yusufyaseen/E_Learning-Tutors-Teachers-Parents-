<?php 

class aadmin {

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


  public function add_admin() {
	  include "Connect.php";
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
		echo "</div>";
  }
  public static function view_admin() {
	  include "Connect.php";
    $stmt=$con->prepare("select * from admin  order by id desc");
	$stmt->execute();
	$rows=$stmt->fetchAll();
	return $rows;
  }
}

?>