
<?php 
    require_once("../Lib/lib.php");
    require_once("../Lib/db.php");
    include( "../ensureAuth.php" );

    $cat = $_POST["cate"];
    $oldCategory = $_POST["oldcate"];

    if (isset($_POST["delete"])) {
        deleteCategory($oldCategory);
    } else {
        updateCat($oldCategory, $cat);
    }
    
    header("Location: manageCategories.php");
    
    exit();
 ?>