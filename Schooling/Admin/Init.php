<?php

include "Connect.php";
$tpl = "Includes/Templetes/";
$lang = "Includes/Languages/";
$func = "Includes/Functions/";
$css = "Layout/Css/";
$js = "Layout/Js/";
$classes = "Includes/classes/";
include $func . "Func.php";
include $lang . "Eng.php";
include $tpl . "Header.php" ;
include_once "Includes/classes/all.php";
if(!isset($nonav)){
	include "Nav.php";
}
?>