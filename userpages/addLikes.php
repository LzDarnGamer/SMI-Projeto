<?php
	if ( !isset($_SESSION) ) {
	  session_start();
	}
	require_once("../Lib/db.php" );

	$id = $_POST['postID'];
	$value = $_POST['value'];

	$exists = false;

	dbConnect(ConfigFile);

	$dataBaseName = $GLOBALS['configDataBase']->db;

	mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );


    $GLOBALS['ligacao']->begin_transaction();
    $res1 = $GLOBALS['ligacao'] -> query("UPDATE `$dataBaseName`.`articles` SET likes=likes+(int)$value WHERE article_id=$id");


    if($res1 && mysqli_num_rows($check)>0){
        $GLOBALS['ligacao']->commit();
        dbDisconnect();
        echo true;
    }else{
        $GLOBALS['ligacao']->rollback();
        dbDisconnect();
        echo false;
    }
?>