<?php
 function fetch_data()  
 {  
      $output = '';  
      $connect = mysqli_connect("localhost", "root", "", "schooling");  
      $sql = "select * from tutor order by id asc";  
      $result = mysqli_query($connect, $sql);  
      foreach($result as $row)  
{	  
      $output .= '<tr>  
                          <td >'.$row["id"].'</td>  
                          <td>'.$row["username"].'</td>  
                          <td>'.$row["fullname"].'</td>  
                          <td>'.$row["email"].'</td>  
                          <td>'.$row["date"].'</td>  
                     </tr>  
                          ';  
      }  
      return $output;  
 }  
 if(isset($_POST["create_pdf"]))  
 {  
		
      require_once('tcpdf_min/tcpdf.php');  
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      //$obj_pdf->SetTitle("Expodddrt HTML Table data to PDF using TCPDF in PHP");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('Courier New');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(FALSE, 20);  
      $obj_pdf->SetFont('helvetica', '', 12);  
      $obj_pdf->AddPage();  
      $content = '';  
      $content .= '  
      <h3 align="center" style = "color:#e51d1d">Export HTML Table data to PDF using TCPDF in PHP</h3><br /><br /> <br />  
      <table border="1" cellspacing="0" cellpadding="5">  
           <tr>  
                <th width="10%">ID</th>  
                <th width="15%">Name</th>  
                <th width="30%">Fullname</th>  
                <th width="30%">email</th>  
                <th width="15%">date</th>  
           </tr>  
      ';  
      $content .= fetch_data();  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('sample.pdf', 'I');  
 }  

 ?>  

<?php 
session_start();
$pagetitle = "Manage Tutors";
include "Init.php";
if(isset($_SESSION['username'])){  
if(isset($_GET['do'])){
	$do = $_GET['do'];
}
else{
	$do = "Manage";
}
if($do=="Manage"){
	
	
	$row1 = aadmin::view_tutor();
	if(! empty($row1)){
	?>
			
			<div class = "content1" >
			<h1 class = "text-center">Manage Tutors </h1><hr>
			<div class="table-responsive" id="#cont">
			<table class="main-color text-center table table-bordered" id="tbl">
				<thead>
				<tr>
					<td>Id</td>
					<td>Username</td>
					<td>fullname</td>
				    <td>Email</td>
					<td>Registered Date</td>
					<td>Control</td>
				</tr>
				</thead>
				<?php
				foreach($row1 as $row){
					echo "<tr>";
						echo "<td>" . $row['id'] . "</td>";
						echo "<td>" . $row['username'] . "</td>";
						echo "<td>" . $row['fullname'] . "</td>";
						echo "<td>" . $row['email'] . "</td>";
						echo "<td>" . $row['date'] . "</td>";
						echo "<td> 
									<a href='tutors.php?do=Edit&userid=" . $row['id'] ."' class='btn btn-success'><i class = 'fa fa-edit'></i>Edit</a>
									<a href='tutors.php?do=Delete&userid=" . $row['id'] ."' class='btn btn-danger confirm'><i class = 'fa fa-close'></i>Delete</a> ";

									if($row['approval']==0){
										echo "<a href='tutors.php?do=Activate&userid=" . $row['id'] ."' class='btn btn-info confirm'><i class = 'fa fa-check'></i>Activate</a> ";
									}
						
						echo "</td>";
					echo "</tr>";
				}
				?>
			</table>
			</div>
				<a  href = 'tutors.php?do=Add' class="btn btn-primary col-lg-1" id="aa" style = "display:inline ;width:130px;"><i class="fa fa-plus"></i> New Tutor</a>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" class=" col-lg-4" style = "margin-top:20px">  
                          <input type="submit" name="create_pdf" class="btn btn-danger" value="Create PDF" />  
                </form> 
				</div>
				 
			
<?php

}
else{
	echo "<div class = 'content'>";
	echo "<div class = 'no'>" . "There is not members to show" . "</div>";
	echo "</div>";
	echo "<div class = 'btn8'>" . "<a href = 'tutors.php?do=Add' class='btn btn-sm btn-primary'>" . "<i class='fa fa-plus'>" . "</i>" . ' Add Member' . "</a>" . "</div>";
} }

elseif($do=="Add"){?>
			  
			<div class = "content">
			<h1 class = "text-center" id = "cad"> Add New Tutor </h1><hr>
			<div class = "conc" style = "height:700px;" >
				<form class = "add" action = "?do=Insert" method = "post" enctype = "multipart/form-data"> 
			    	<fieldset>
					<legend id = "lgd"><img class = 'img-responsive img' src ='../img/blog/1.jpg' alt = 'no'></legend>
					<label class = "col-sm-1 control-label">Username </label>
					<input type = "text" pattern = ".{4,}" title = "You should put more than 4 chars"  name = "user" class = "form-control" autocomplete = "off" autofocus = "on" required placeholder = "Enter your name" ?>
					<label class = "col-sm-1 control-label">Password </label>
					<input type = "password" pattern = ".{6,}" title = "You should put more than 6 chars"  name = "pass" class = "form-control"  autocomplete = "new-password" placeholder = "Enter your password">
					<label class = "col-sm-1 control-label">E_mail </label>
					<input type = "email"  pattern = ".{6,}" title = "You should put more than 6 chars"  name = "email" class = "form-control" required placeholder = "Enter your e_mail" autocomplete = "off">
					<label class = "col-sm-2 control-label">Full name </label>
					<input type = "text"  pattern = ".{6,}" title = "You should put more than 6 chars" name = "full" class = "form-control" required placeholder = "Enter your full name" autocomplete = "off">
					<label class = "col-sm-2 control-label">Image </label>
					<input type = "file" name = "img0" class = "form-control" required  >
					
					
					<input type = "submit" value = "Add member" class = "btn btn-primary" id = "bttn">
					</fieldset>
				</form>
			</div>
			</div>
<?php

}
elseif($do=="Insert"){
	if($_SERVER['REQUEST_METHOD']=="POST"){
		echo "<div class = 'container'>";
		echo "<h1 class = 'text-center'>Insert member</h1>" . "<hr>";
		$username = filter_var(test_input($_POST['user']),FILTER_SANITIZE_STRING);
		$email = filter_var(test_input($_POST['email']),FILTER_SANITIZE_EMAIL);
		$fullname = filter_var(test_input($_POST['full']),FILTER_SANITIZE_STRING);
		$password = sha1($_POST['pass']);
		$img1 = $_FILES['img0']['name'];
		$imgsize = $_FILES['img0']['size'];
		$imgtmp = $_FILES['img0']['tmp_name'];
		$imgext = array("jpg","jpeg","png");
		$tmp = explode('.', $img1);
		$tmp2 = end($tmp);
		$imgallow = strtolower($tmp2);
		$fe = array();
		if(empty($username)){
			$fe[] = "You should put username ";
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$fe[] = "You should put valid mail ";
		}
		if(empty($password)){
			$fe[] = "You should put password ";
		}
		if(empty($email)){
			$fe[] = "You should put email ";
		}
		if(empty($fullname)){
			$fe[] = "You should put fullname ";
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
			echo "<div class = 'content'>";
			echo "<div class = 'alert alert-danger'>" . $errors . "</div>";
			echo "</div>";
		}
		if(empty($fe)){
		move_uploaded_file($imgtmp,"..\img\authors\\" . $img1);
		aadmin::add_tutor($username,$password,$email,$fullname,$img1);
	//c
}}

else{
	echo "<div class = 'content'>";
	$msg = "<div class = 'alert alert-danger'> Sorry you can not browse this page directly </div>";
	 redirect($msg,4);
	 echo "</div>";
	 echo "</div>";
}
}
elseif($do=="Edit"){ 

	if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
		$userId = $_GET['userid'];
		$stmt = $con->prepare("SELECT *  from tutor where id = ?  ");
		$stmt->execute(array($userId));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){ ?>
			<div class = "content">
			<h1 class = "text-center"> Edit Tutor </h1><hr>
			<div class = "conc" style = "height:690px;">
				<form class = "edit" action = "?do=Update" method = "post" enctype = "multipart/form-data"> 
				<fieldset>
					<legend id = "lgd"><img class = 'img-responsive img' src ='../img/authors/<?php echo $row['image'] ?>' alt = 'no'></legend>
					<input type = "hidden" name = "id" value = "<?php echo $userId ?>" >
					<label class = "col-sm-1 control-label">Username </label>
					<input type = "text"  pattern = ".{4,}" title = "You should put more than 4 chars" name = "user" class = "form-control" autocomplete = "off" autofocus = "on" required placeholder = "Enter your name" value = "<?php echo $row['username'] ?>" >
					<label class = "col-sm-1 control-label">Password </label>
					<input type = "hidden" name = "oldpass" value = "<?php echo $row['password'] ?>">
					<input type = "password"  pattern = ".{6,}" title = "You should put more than 6 chars" name = "newpass" class = "form-control"  autocomplete = "new-password" placeholder = "Enter your password" >					
					<label class = "col-sm-1 control-label">E_mail </label>
					<input type = "email" pattern = ".{6,}" title = "You should put more than 6 chars"  name = "email" class = "form-control" required placeholder = "Enter your e_mail" value = "<?php echo $row['email'] ?>" >
					<label class = "col-sm-2 control-label">Full name </label>
					<input type = "text" pattern = ".{6,}" title = "You should put more than 6 chars"  name = "full" class = "form-control" required placeholder = "Enter your full name"  value = "<?php echo $row['fullname'] ?>" >
					<label class = "col-sm-2 control-label">File</label>
					<input type = "file" name = "imaag" class = "form-control" >
					<input type="hidden"  name="g" value = "<?php echo $row['image']; ?>" >
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
		$userid = $_POST['id'];
		$username = filter_var(test_input($_POST['user']),FILTER_SANITIZE_STRING);
		$email = filter_var(test_input($_POST['email']),FILTER_SANITIZE_EMAIL);
		$fullname = filter_var(test_input($_POST['full']),FILTER_SANITIZE_STRING);
		$image0 = $_FILES['imaag']['name'];
		$imgsize = $_FILES['imaag']['size'];
		$imgtmp = $_FILES['imaag']['tmp_name'];
		$imgext = array("jpg","jpeg","png");
		$tmp1 = explode('.', $image0);
		$tmp2 = end($tmp1);
		$imgallow = strtolower($tmp2);
		$fe = array();
		if(empty($username)){
			$fe[] = "You should put username ";
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$fe[] = "You should put valid mail ";
		}

		if(empty($email)){
			$fe[] = "You should put email ";
		}
		if(empty($fullname)){
			$fe[] = "You should put fullname ";
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
		if(empty($_POST['newpass'])){
			$pass0 = $_POST['oldpass'];
		}
		else{
			$pass0 = sha1 ($_POST['newpass']);
		}
		
		
		
		if(empty($fe)){
			move_uploaded_file($imgtmp,"..\img\authors\\" . $image0);
			aadmin::edit_tutor($username,$pass0,$email,$fullname,$userid,$image0);
			
	}}
else{
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse this page directly</div>";
			redirect($msg,4);
} 
		}

else if($do=="Delete"){
		
		if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
		$userId = $_GET['userid'];
		$stmt = $con->prepare("SELECT * from tutor where id = ? ");
		$stmt->execute(array($userId));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			aadmin::delete_tutor($userId);
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
		if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
		$userId = $_GET['userid'];
		$stmt = $con->prepare("SELECT * from tutor where id = ?  ");
		$stmt->execute(array($userId));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count>0){
			$stmt=$con->prepare("update tutor set approval = 1 where id = ?");
			$stmt->execute(array($userId));
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
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse this page directly</div>";
			redirect($msg,4);
			echo "</div>";
}

?>
