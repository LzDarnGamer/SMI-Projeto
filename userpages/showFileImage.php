<?php

require_once( "../Lib/lib.php" );
require_once( "../Lib/db.php" );

$id = $_GET['id'];
$size = $_GET['size'];

if($id == null || $size == null || $id=="" || $size == "" ){
	echo "Invalid request to server";
	exit();
}
$fileDetails = getFileDetails($id);

if($size == "thumb"){
	$thumbFileNameAux = $fileDetails['thumbFileName'];
	$thumbMimeFileName = $fileDetails['thumbMimeFileName'];
	$thumbTypeFileName = $fileDetails['thumbTypeFileName'];

	header("Content-type: $thumbMimeFileName/$thumbTypeFileName");
	header("Content-Length: " . filesize($thumbFileNameAux));

	//$thumbFileHandler = fopen($thumbFileNameAux, 'rb');
	//fpassthru($thumbFileHandler);
	//fclose($thumbFileHandler);

	//Como só precisamos do conteúdo da imagem podemos fazer dump direto para o buffer
	readfile($thumbFileNameAux);
	
}else if($size == "full"){
	$imageFileNameAux = $fileDetails['imageFileName'];
	$imageMimeFileName = $fileDetails['imageMimeFileName'];
	$imageTypeFileName = $fileDetails['imageTypeFileName'];

	header("Content-type: $imageMimeFileName/$imageTypeFileName");
	header("Content-Length: " . filesize($imageFileNameAux));

	//$thumbFileHandler = fopen($thumbFileNameAux, 'rb');
	//fpassthru($thumbFileHandler);
	//fclose($thumbFileHandler);

	//Como só precisamos do conteúdo da imagem podemos fazer dump direto para o buffer
	readfile($imageFileNameAux);
}
?>