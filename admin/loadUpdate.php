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

if ($delete == "Yes" || $delete == "yes") {
    deleteUser($id);
    echo "Delete user";
} else {
    if (trim($role) === trim(getRoleFromUser($id))) {
        echo "Do nothing";
    } else {
        $roleid = 0;
        switch ($role) {
            case "administrator" : $roleid = 1;
                break;
            case "manager": $roleid = 2;
                break;
            case "user": $roleid = 3;
                break;
            case "guest": $roleid = 4;
                break;
        }
        updateRole($id, $roleid);
        echo "Change Role";
    }
}

header("Location: manageusers.php");


?>