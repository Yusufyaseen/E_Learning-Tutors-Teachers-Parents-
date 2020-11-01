<?php

function getcates(){
	global $con;
	$stmt = $con->prepare("select * from categories order by id asc ");
	$stmt->execute();
	$row = $stmt->fetchAll();
	return $row;
}
function getall($table, $order,$approve = NULL){
	global $con;
	if($approve == Null){
		$sql = NULL;
	}
	else{
		$sql = $approve;
	}
	$stmt = $con->prepare("select * from $table $sql order by id $order ");
	$stmt->execute(array($table));
	$all = $stmt->fetchAll();
	return $all;
}
function getitems($where,$value,$approve = NULL){
	global $con;
	if($approve == NULL){
		$modify = "and approve = 1";
	}
	else{
		$modify = NUll;
	}
	$stmt = $con->prepare("select * from items where $where = ? $modify order by id asc ");
	$stmt->execute(array($value));
	$row = $stmt->fetchAll();
	return $row;
}

function getstatus($value){
	global $con;
	$stmt = $con->prepare("select username from user where username = ? and regstatus = 0");
	$stmt->execute(array($value));
	$row = $stmt->rowCount();
	return $row;
}


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
		$url = "home.php";
		$link = "Home page";
	}
	echo $themsg;
	echo   "<div class = 'alert alert-success'> You will be directed in $link in $seconds seconds</div>";
	header("refresh:$seconds;url=$url");
	exit();
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function check($select,$from,$value){
	global $con;
	$stmt = $con->prepare("select $select from $from where $select = ?");
	$stmt->execute(array($value));
	$count = $stmt->rowCount();
	return $count;
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
function countitems3($item,$table,$where){
	global $con;
	$stmt=$con->prepare("select count($item)  from $table where $where = 1");
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
function test($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
}

?>