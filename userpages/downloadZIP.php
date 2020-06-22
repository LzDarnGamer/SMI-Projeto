<?php
	require_once("../Lib/db.php" );
	require_once("../Lib/lib.php" );
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    	$userID = $_POST['userID'];
		$mode = $_POST['mode'];
	}else if($_SERVER['REQUEST_METHOD'] === 'GET'){
		$userID = $_GET['userID'];
		$mode = $_GET['mode'];
	}

	if($mode==1){
		header('Content-disposition: attachment; filename="articles.xml"');
		header('Content-type: "text/xml"; charset="utf8"');
		dbConnect(ConfigFile);

		$dataBaseName = $GLOBALS['configDataBase']->db;

		mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

		$query = "SELECT list FROM `$dataBaseName`.`cart` " . "WHERE `id`='$userID'";

		$result = mysqli_query($GLOBALS['ligacao'], $query);

		while ($array = mysqli_fetch_array($result)) {
	        $list = $array["list"];
	    }
		if(!isset($list)){
			header("Location: javascript:history.go(-1) ");
			return;
		}
		header('Content-type: "text/xml"; charset="utf8"');
		header('Content-Disposition: attachment; filename="articles.xml"');
		$arr = explode(",", $list);

		mysqli_free_result($result);

		$doc = new DOMDocument('1.0', 'utf-8');
		$doc->formatOutput = true;
		$root = $doc->createElement("articles");
		$doc->appendChild($root);
		foreach ($arr as $item) {
			$subroot = $doc->createElement("article");
			$it = getArticle($item);




			$article_id = $doc->createElement("article_id");
			$article_id->appendChild($doc->createTextNode($it['article_id']));

			$article_categorie_id = $doc->createElement("article_categorie_id");
			$article_categorie_id->appendChild($doc->createTextNode($it['article_categorie_id']));

			$article_subcategorie_id = $doc->createElement("article_subcategorie_id");
			$article_subcategorie_id->appendChild($doc->createTextNode($it['article_subcategorie_id']));

			$poster_id = $doc->createElement("poster_id");
			$poster_id->appendChild($doc->createTextNode($it['poster_id']));

			$article_title = $doc->createElement("article_title");
			$article_title->appendChild($doc->createTextNode($it['article_title']));

			$article_context = $doc->createElement("article_context");
			$article_context->appendChild($doc->createTextNode($it['article_context']));

			$article_image = $doc->createElement("article_image");
			$article_image->appendChild($doc->createTextNode($it['article_image']));

			$article_timestamp = $doc->createElement("article_timestamp");
			$article_timestamp->appendChild($doc->createTextNode($it['article_timestamp']));

			$likes = $doc->createElement("likes");
			$likes->appendChild($doc->createTextNode($it['likes']));

			$tags = $doc->createElement("tags");
			$tags->appendChild($doc->createTextNode($it['tags']));

			$visible = $doc->createElement("visible");
			$visible->appendChild($doc->createTextNode($it['visible']));

			
			$subroot->appendChild($article_id);
			$subroot->appendChild($article_categorie_id);
			$subroot->appendChild($article_subcategorie_id);
			$subroot->appendChild($poster_id);
			$subroot->appendChild($article_title);
			$subroot->appendChild($article_context);
			$subroot->appendChild($article_image);
			$subroot->appendChild($article_timestamp);
			$subroot->appendChild($likes);
			$subroot->appendChild($tags);
			$subroot->appendChild($visible);

			$root->appendChild( $subroot );
		}
		echo $doc->saveXML();
		$doc->save('php://stdout');
	}
	dbConnect(ConfigFile);
	$dataBaseName = $GLOBALS['configDataBase']->db;
	$query = "DELETE FROM `$dataBaseName`.`cart` " . "WHERE `id`='$userID'";
	mysqli_query($GLOBALS['ligacao'], $query);
	dbDisconnect();
	
?>