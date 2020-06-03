<?php
if (!isset($_SESSION) ) {
    session_start();
}
$lang = "en";
if(isset($_SESSION['lang'])){
	$lang = $_SESSION['lang'];
}
if(isset($_GET['lang'])){ 
	$lang = $_GET['lang'];
}
$_SESSION['lang'] = $lang;

require_once(realpath(dirname(__FILE__)) . "./lang/lang-".$lang.".php");
?>