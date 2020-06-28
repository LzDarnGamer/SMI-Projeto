<?php
    require_once("../Lib/lib.php");
    require_once("../Lib/db.php");
    include( "../ensureAuth.php" );

    $newCategory = $_POST["newCate"];
    
    if (!insertCat($newCategory)) {
        echo "Error inserting category";
    } else {
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

?>