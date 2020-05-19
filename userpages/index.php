<?php
	require_once("../Lib/lib.php");
	require_once("../Lib/db.php");
	$baseUrl = url();
	header( "Location: " . $baseUrl . "profilepage.php" );
?>