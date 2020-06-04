<?php
    require_once("../Lib/lib.php");
    require_once("../Lib/db.php");
    include( "../ensureAuth.php" );

    $newCategory = $_POST["newCate"];
    
    echo insertCat($newCategory);
    exit();

?>