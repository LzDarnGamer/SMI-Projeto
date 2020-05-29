<!DOCTYPE html>

<?php 
    require_once("../Lib/lib.php");
    require_once("../Lib/db.php");
    include( "../ensureAuth.php" );

    $delete = $_POST["delete"];
    $role = $_POST["role"];
    $id = $_POST["id"];
 ?>
<html>
    <head></head>
    <body>
        <?php echo "Delete: ".$_POST["delete"]; ?>
        <?php echo "Role: ".$_POST["role"]; ?>
        <?php echo "id: ".$_POST["id"]; ?>
        <?php echo "<br>";
        echo "real role: ".(getRoleFromUser($id))." New: ".($role)." <br>";?>
    </body>    
</html>

<?php



if (strcmp($delete, "yes")) {
    echo "Delete";
} else {
    if (trim($role) === trim(getRoleFromUser($id))) {
        echo "Do nothing";
    } else {
        echo "Change Role";
    }
}

?>