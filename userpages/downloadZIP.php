<?php
	header('Content-type: "text/xml"; charset="utf8"');
	header('Content-Disposition: attachment; filename="articles.xml"');
	require_once("../Lib/db.php" );
	require_once("../Lib/lib.php" );
	$userID = $_GET['userID'];

	dbConnect(ConfigFile);

	$dataBaseName = $GLOBALS['configDataBase']->db;

	mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

	$query = "SELECT list FROM `$dataBaseName`.`cart` " . "WHERE `id`='$userID'";

	$result = mysqli_query($GLOBALS['ligacao'], $query);

	while ($array = mysqli_fetch_array($result)) {
        $list = $array["list"];
    }
	if($list==null){
		return;
	}

	$arr = explode(",", $list);

	mysqli_free_result($result);

	$doc = new DOMDocument();
	$doc->formatOutput = true;
	$root = $doc->createElement("articles");
	$doc->appendChild( $root );
	foreach ($arr as $item) {
		$subroot = $doc->createElement("article");
		$it = getArticle($item);

		$name = $doc->createElement("article_id");
		
		$name->appendChild($doc->createTextNode($it['article_id']));
		$subroot->appendChild( $name );

		$root->appendChild( $subroot );
	}
	echo $doc->saveXML();
	$doc->save('php://stdout');

?>