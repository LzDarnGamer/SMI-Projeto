<?php

if ( !isset($_SESSION) ) {
	session_start();
}
require_once( "../Lib/db.php" );
require_once( "../Lib/lib.php" );

include_once( "../Lib/config.php" );
include( "../ensureAuth.php" );

$email = $_POST['email'];

$ajuda = false;

$flags[] = FILTER_NULL_ON_FAILURE;

$email = filter_input( 
	INPUT_POST, 
	'email', 
	FILTER_SANITIZE_EMAIL, 
	$flags);

$subs = getAllSubscriptions();
for ($i = 0; $i < sizeof($subs); $i ++) {
	
	if ($email === $subs[$i]['email']) {
		$ajuda = true;
	}
}

if (trim($email) == "" || $ajuda) {
	header( "Location: " . $baseUrl . "../landingpage.php" );
}

$work = subscribeNewsletter($email);

if ($work == "true") {
	header( "Location: " . $baseUrl . "../landingpage.php?newsletter=1" );
} else {
	header( "Location: " . $baseUrl . "../landingpage.php?newsletter=0" );
}

?>