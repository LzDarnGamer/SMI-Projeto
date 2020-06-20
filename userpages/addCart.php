<?php
	require_once("../Lib/db.php" );

	$field = $_POST['field'];
	$value = $_POST['value'];

	$exists = "false";

	dbConnect(ConfigFile);

	$dataBaseName = $GLOBALS['configDataBase']->db;

	mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );


	$query = "SELECT * FROM `$dataBaseName`.`auth-basic` " .
	        "WHERE `$field`='$value'";

	$result = mysqli_query($GLOBALS['ligacao'], $query);

	$numRows = mysqli_num_rows($result);

	if ($numRows == 0) {
	    $exists = "true";
	}

	mysqli_free_result($result);

	dbDisconnect();

	echo $exists;
?>