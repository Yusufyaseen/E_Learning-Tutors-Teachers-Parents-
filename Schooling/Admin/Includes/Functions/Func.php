<?php



function gettitle(){
	global $pagetitle;
	if(isset($pagetitle)){
		echo $pagetitle;
	}
	else 
		echo "default";
}

function redirect($themsg,$seconds){
	
	if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!==""){
		$url = $_SERVER['HTTP_REFERER'];
		$link = "Previous page";
	}
	else{
		$url = "Login.php";
		$link = "Home page";
	}
	echo $themsg;
	echo   "<div class = 'alert alert-info'> You will be directed in $link in $seconds seconds</div>";
	header("refresh:$seconds;url=$url");
	exit();
}

function check($select,$from,$value){
	global $con;
	$stmt = $con->prepare("select $select from $from where $select = ?");
	$stmt->execute(array($value));
	$count = $stmt->rowCount();
	return $count;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function countitems($item,$table){
	global $con;
	$stmt=$con->prepare("select count($item) from $table");
	$stmt->execute();
	return $stmt->fetchColumn();
}
function countitems2($item,$table,$where){
	global $con;
	$stmt=$con->prepare("select count($item)  from $table where $where = 0");
	$stmt->execute();
	return $stmt->fetchColumn();
}

function getlatest($select, $from, $order, $limit){
	global $con;
	$stmt = $con->prepare("select $select from $from order by $order desc limit $limit");
	$stmt->execute();
	$row = $stmt->fetchAll();
	return $row;
}

?>