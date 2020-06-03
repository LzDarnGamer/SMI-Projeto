<!DOCTYPE html>
<?php
    if ( !isset($_SESSION) ) {
      session_start();
    }

	require_once("../Lib/lib.php");
	require_once("../Lib/db.php");
	include( "../ensureAuth.php" );
	$userId = $_SESSION['id'];
	$username = $_SESSION['username'];
	$articlesUser = getArticles($userId);

?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Profile of <?php echo $username ?></title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <header>
    	<p>Welcome back, <?php echo $username ?> </p>
    	<p>DEBUG: ID =  <?php echo $userId ?> </p>
    </header>

    <body>
    	<a href="manageArticles.php">Manage Articles</a>
    	<?php
    	if(count($articlesUser)<=0){
    		echo "<p> No articles to show, it's time to write some </p>";
    	}
    	?>
    </body>
</html>

