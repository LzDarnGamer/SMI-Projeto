<!DOCTYPE html>

<?php
	require_once("Lib/lib.php");
	require_once("Lib/db.php");
	$categories = getcategories();
	$baseUrl = url();
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Title</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <header></header>

    <body>
    	<ul>
    		<li><a href="userpages/profilepage.php">Profile</a></li>
    		<li><a href="Login_Registo/formLogin.php">Login</a></li>
    		<li><a href="Login_Registo/formRegister.php">Register</a></li>

    	<?php
	    	foreach($categories as $array){
			    echo '<li><a href="' . $baseUrl . "categories.php?cat=" .$array['categorie_title'] . '">' .  $array['categorie_title'] . "</a></li>";
			}
		?>
		</ul>
    </body>
</html>