<?php
    require_once("../Lib/db.php");
    require_once("../Lib/lib.php");
    $confirm=$_GET['confirm'];

    if($confirm==="" || $confirm===null){
        echo "Please make sure your link is the same from the one we sent you";
        echo "<br><hr><a href=\"index.php\">Back</a>";
        exit();
    }


    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    $linkIdentifier = $GLOBALS['ligacao'];

    mysqli_select_db($linkIdentifier, $dataBaseName );

    $getid = "SELECT id FROM `$dataBaseName`.`auth-challenge` WHERE challenge='$confirm'";
    $result = $linkIdentifier->query($getid);
    $row = $result->fetch_row();
    if($row != null){
        $id = $row[0];

        $query = "UPDATE `$dataBaseName`.`auth-basic` SET valid='1' WHERE id='$id' ";

        if ($linkIdentifier->query($query) === TRUE) {
            mysqli_query( $linkIdentifier, "DELETE FROM `$dataBaseName`.`auth-challenge` WHERE id='$id'" );

            mysqli_query( $linkIdentifier, "INSERT INTO `$dataBaseName`.`auth-permissions`".
                          "(`role`, `id`) values " .
                          "('3', '$id')");
            echo "User activated with success";
            echo "<br><hr><a href=\"../index.php\">Back</a>";
        } else {
            echo "Please make sure your link is the same from the one we sent you";
            echo "<br><hr><a href=\"../index.php\">Back</a>";
        }
    }else{
        echo "Did you already confirm your mail?";
        echo "<br><hr><a href=\"../index.php\">Back</a>";
    }
    mysqli_close( $linkIdentifier );

?>
