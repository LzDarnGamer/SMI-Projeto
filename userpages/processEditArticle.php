<?php
    if ( !isset($_SESSION) ) {
      session_start();
    }
    require_once("../Lib/db.php");
    require_once("../Lib/lib.php");
    require_once( "../Lib/lib-coords.php" );
	require_once( "../Lib/ImageResize-class.php" );

	include_once( "../Lib/config.php" );
    include( "../ensureAuth.php" );
    header('Content-Type: text/html; charset=utf-8');

	// Maximum time allowed for the upload
	set_time_limit( 300 );



    $userId = $_SESSION['id'];
    $username = $_SESSION['username'];

    if ( $_SERVER['REQUEST_METHOD'] == 'POST') {
      $_INPUT_METHOD = INPUT_POST;
    } else {
      $_INPUT_METHOD = INPUT_GET;
    }
    
    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $article_title = filter_input( 
            $_INPUT_METHOD, 
            'article_title', 
            FILTER_SANITIZE_STRING, 
            $flags);

    $article_context = filter_input( 
            $_INPUT_METHOD, 
            'article_context', 
            FILTER_SANITIZE_STRING, 
            $flags);



    $Userlat = filter_input( 
            $_INPUT_METHOD, 
            'lat', 
            FILTER_SANITIZE_STRING, 
            $flags);
    $Userlng = filter_input( 
            $_INPUT_METHOD, 
            'lng', 
            FILTER_SANITIZE_STRING, 
            $flags);


    $tags = filter_input( 
            $_INPUT_METHOD, 
            'articleTags', 
            FILTER_SANITIZE_STRING, 
            $flags);


    if ( $article_title===null || $article_context===null || $tags === null || $Userlat === null || $Userlng === null 
        ||$article_title==="" || $article_context==="" || $tags === "" || $Userlat === "" || $Userlng === "" 
        || !isset($_SESSION['article'])) {
      $title = "Invalid arguments";
      $info = "Invalid arguments were given";
      header("Location: ../responsePage.php?title=$title&info=$info");
      exit();
    }

    $article = $_SESSION['article'];

	// Write information about file into the data base
	dbConnect(ConfigFile);

    $linkIdentifier = $GLOBALS['ligacao'];
    $dataBaseName = $GLOBALS['configDataBase']->db;

	mysqli_select_db($linkIdentifier, $dataBaseName);

	###########################Transaction##########################

	$linkIdentifier -> begin_transaction();
	$updateArticle = $linkIdentifier -> query("UPDATE `$dataBaseName`.`articles` SET article_title='$article_title', 
												article_context='$article_context', tags ='$tags' 
												WHERE article_id=" . $article['article_id']);
	$updateImage = $linkIdentifier -> query("UPDATE `$dataBaseName`.`images-details` SET latitude='$Userlat', longitude='$Userlng' 
											WHERE id=" . $article['article_image']);
	$linkIdentifier -> commit();

	###########################Transaction##########################

	if($updateArticle && $updateImage){
		dbDisconnect();
		unset ($_SESSION["article"]);
      	header("Location: profilepage.php");
    }else{
    	$linkIdentifier -> rollback();
		dbDisconnect();
		unset ($_SESSION["article"]);
	    $title = "Processing Error";
	    $info = "There where some errors processing your request please try again";
      	header("Location: ../responsePage.php?title=$title&info=$info");
      	exit();
    }

  

