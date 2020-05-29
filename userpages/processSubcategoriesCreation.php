<?php
    session_start();
    require_once("../Lib/db.php");
    require_once("../Lib/lib.php");
    include( "../ensureAuth.php" );
    $userId = $_SESSION['id'];
    $username = $_SESSION['username'];
    $role = getRoleFromUser($userId);
    if($role != "manager" && $role != "administrator"){
        header("Location: ../noPrivilege.php");
        exit();
    }
    if ( $_SERVER['REQUEST_METHOD'] == 'POST') {
      $_INPUT_METHOD = INPUT_POST;
    } else {
      $_INPUT_METHOD = INPUT_GET;
    }
    
    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $article_categorie = filter_input( 
        $_INPUT_METHOD, 
        'article_categorie', 
        FILTER_SANITIZE_STRING, 
        $flags);

    $subcategorie_title = filter_input( 
        $_INPUT_METHOD, 
        'subcategory_title', 
        FILTER_SANITIZE_STRING, 
        $flags);

    if ( $subcategorie_title===null || $subcategorie_title=="" || $article_categorie===null || $article_categorie=="") {
      $title = "Invalid arguments";
      $info = "Invalid subcategory or category title";
      header("Location: ../responsePage.php?title=$title&info=$info");
      exit();
    }
    
    $categorie_id = getCategoryID($article_categorie, false);

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    $linkIdentifier = $GLOBALS['ligacao'];

    mysqli_select_db($linkIdentifier, $dataBaseName );


    $query = 
            "INSERT INTO `$dataBaseName`.`subcategories` " .
            "(`categorie_id`, `subcategorie_title`) values " .
            "('$categorie_id', '$subcategorie_title')";
     

    mysqli_query( $linkIdentifier, $query );

    $recordsInserted = mysqli_affected_rows( $linkIdentifier );
  
    if ( $recordsInserted==-1 ) {
      $title = "Invalid Subcategory";
      $info = "Subcategory already exists";
      header("Location: ../responsePage.php?title=$title&info=$info");
      dbDisconnect();
      exit();
    }
    else {
        header("Location: profilepage.php");
        dbDisconnect();
        exit();
    }



?>
