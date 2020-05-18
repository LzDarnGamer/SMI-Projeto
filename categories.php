<!DOCTYPE html>

<?php
	require_once("Lib/lib.php");
    require_once("Lib/db.php");
	$categories = getcategories();
	$baseUrl = url();
    $type = $_GET['cat']

?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title><?php echo $type ?></title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <header>
        <h1><?php echo $type ?></h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin imperdiet quis nunc a venenatis. Morbi eu fermentum nisi. Aenean neque nulla, tincidunt sit amet est ac, varius egestas metus. Aliquam nec varius ante, vel consectetur nisi. Aenean id elit vitae lorem pharetra tincidunt. Aenean dictum ultrices nibh non suscipit. Vestibulum placerat tincidunt orci quis iaculis. Duis viverra lorem at velit accumsan, ac commodo lacus suscipit</p>
    </header>

    <body>


    </body>
</html>