<?php
if (!isset($_SESSION)) {
    session_start();
}

if ( !isset($_SESSION['username']) ) {
    $_SESSION['locationAfterAuth'] = $_SERVER['REQUEST_URI'];

	$title = "Not logged in";
  	$info = "Please login first before accessing this page";
  	header("Location: ../responsePage.php?title=$title&info=$info");
  	exit();
}
?>