<?php
	require_once("../Lib/db.php" );

	$userID = $_POST['userID'];
	$value = $_POST['value'];

	dbConnect(ConfigFile);

	$dataBaseName = $GLOBALS['configDataBase']->db;

	mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );


	$query = "SELECT list FROM `$dataBaseName`.`cart` " . "WHERE `id`='$userID'";

	$result = mysqli_query($GLOBALS['ligacao'], $query);

	while ($array = mysqli_fetch_array($result)) {
        $list = $array["list"];
    }
	if(!isset($list) || $list==null){
		$sql = "INSERT INTO `cart`(`id`,`list`) VALUES ('$userID', '$value')";
		mysqli_query($GLOBALS['ligacao'], $sql);
		echo 1;
		return;
	}

	$arr = explode(",", $list);

	mysqli_free_result($result);

	if(in_array($value, $arr)){
		echo count($arr);
	}else{
		array_push($arr, $value);
		$list = implode(",", $arr);
		$query = "UPDATE `$dataBaseName`.`cart` SET `list`='$list' WHERE `id`='$userID'";
		mysqli_query($GLOBALS['ligacao'], $query);
		echo count($arr);
	}
	

	dbDisconnect();

?>