
<?php 
    require_once("../Lib/lib.php");
    require_once("../Lib/db.php");
    include( "../ensureAuth.php" );

    echo var_dump($_POST);

    $cat = $_POST["cate"];
    $oldCategory = $_POST["oldcate"];
    updateCat($oldCategory, $cat);
 ?>
 <html>
     <body>

        <?php echo $cat." ".$oldCategory; ?>
     </body>
     </html>