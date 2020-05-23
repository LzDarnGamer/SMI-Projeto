<?php
require_once("../Lib/db.php" );
require_once("../Lib/lib.php" );

$value = $_POST['name'];
$id = getCategoryID($value);
if($id==null){
	exit();
}
dbConnect(ConfigFile);

$dataBaseName = $GLOBALS['configDataBase']->db;

mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

$result = $GLOBALS['ligacao']->query("SELECT subcategorie_title FROM `$dataBaseName`.`subcategories` WHERE categorie_id='$id'");

if(mysqli_num_rows($result)>0){
	$subcats;
	while ($row = mysqli_fetch_assoc($result)) {
    	$subcats[] = $row;
	}
	
	mysqli_free_result($result);

	dbDisconnect();

	echo json_encode($subcats);
}else{
	echo false;
}


?>