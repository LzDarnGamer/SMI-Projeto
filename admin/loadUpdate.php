<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <?php echo "Delete: ".$_POST["delete"]; ?>
        <?php echo "Role: ".$_POST["role"]; ?>
        <?php echo "id: ".$_POST["id"]; ?>
    </body>    
</html>

<?php

require_once("../Lib/lib.php");
require_once("../Lib/db.php");
include( "../ensureAuth.php" );

$delete = $_POST["delete"];
$role = $_POST["role"];
$id = $_POST["id"];
echo "<br>";
echo "real role: ".getRoleFromUser($id)." New: ".$role;

if (strcmp($delete, "yes")) {
    echo "delete";
} else {
    if ($role == getRoleFromUser($id)) {
        echo "change role";
    } else {
        echo "Do nothing";
    }
}

?>