<?php
    if ( !isset($_SESSION) ) {
      session_start();
    }
    require_once("../Lib/db.php" );

    $id = $_POST['postID'];
    $value = $_POST['value'];

    dbConnect(ConfigFile);

    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );


    $query = "SELECT likes FROM `$dataBaseName`.`articles` WHERE article_id=$id";
    $result = mysqli_query($GLOBALS['ligacao'], $query);

    while ($array = mysqli_fetch_array($result)) {
        $amount = $array["likes"];
    }

    $total = $amount + $value;

    $GLOBALS['ligacao']->begin_transaction();
    $res1 = $GLOBALS['ligacao'] -> query("UPDATE `$dataBaseName`.`articles` SET likes=$total WHERE article_id=$id");

    echo $GLOBALS['ligacao'] -> error;
    if($res1){
        $GLOBALS['ligacao']->commit();
        dbDisconnect();
        echo true;
    }else{
        $GLOBALS['ligacao']->rollback();
        dbDisconnect();
        echo false
        ;
    }
?>