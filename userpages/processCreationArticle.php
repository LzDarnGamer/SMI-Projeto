<?php
    if ( !isset($_SESSION) ) {
      session_start();
    }
    require_once("../Lib/db.php");
    require_once("../Lib/lib.php");
    include( "../ensureAuth.php" );
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

    $article_categorie = filter_input( 
        $_INPUT_METHOD, 
        'article_categorie', 
        FILTER_SANITIZE_STRING, 
        $flags);


    $article_context = filter_input( 
            $_INPUT_METHOD, 
            'article_context', 
            FILTER_SANITIZE_STRING, 
            $flags);


    $timestamp = date("d/m/Y");

    if ( $article_title===null || $article_categorie==null || $article_context===null
        ||$article_title==="" || $article_categorie=="" || $article_context==="") {
      echo "Invalid arguments.";
      echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
      exit();
    }


    #Image management

    $article_img = $_FILES['article_img']['name'];
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["article_img"]["name"]);

    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    $extensions_arr = array("jpg","jpeg","png","gif");

    
    if (!in_array($imageFileType, $extensions_arr)) {
        echo "Invalid image format";
        echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
        exit(); 
    }


    $image_base64 = base64_encode(file_get_contents($_FILES['article_img']['tmp_name']) );
    $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;


    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    $linkIdentifier = $GLOBALS['ligacao'];

    mysqli_select_db($linkIdentifier, $dataBaseName );

    $categorieID = getCategoryID($article_categorie);

    $query = 
            "INSERT INTO `$dataBaseName`.`articles` " .
            "(`article_categorie_id`, `poster_id`, `article_title`, `article_context`, `article_image`, `article_timestamp` ) values " .
            "('$categorieID', '$userId', '$article_title', '$article_context', '$article_img', STR_TO_DATE('$timestamp','%d/%m/%y'))";
    
    
    mysqli_query( $linkIdentifier, $query );

    echo $linkIdentifier -> error;

    move_uploaded_file($_FILES['article_img']['tmp_name'],$target_dir.$article_img);

    $recordsInserted = mysqli_affected_rows( $linkIdentifier );
  
    if ( $recordsInserted==-1 ) {
        echo "There where some errors processing your request please try again";
        echo "<br><hr><a href=\"profilepage.php\">Back</a>";
    }
    else {
        echo "Article posted sucessfully";
        echo "<br><hr><a href=\"profilepage.php\">Back</a>";
    }
?>
