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

?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Create Article</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
 <form 
      id="articleForm"
      action="processCreationArticle.php"
      onsubmit="return FormLoginValidator(this)"
      name="FormArticle"
      enctype="multipart/form-data"
      method="post" >
      <table>
        <tr>
          <td>Article Title:</td>
          <td><textarea 
               name="article_title" 
               cols="40" 
               rows="1" 
               placeholder="Article Title"
               required="true"></textarea>
        </tr>
        <tr>
        <td>Article Category:</td>
        <td><select name="article_categorie" required="true" form="articleForm">
            <option value="">Choose Category</option>
            <?php
            // A sample product array
            $categories = getCategories();
            ?>
            <?php
            // Iterating through the product array
            foreach($categories as $item){
            ?>
                <option value="<?php echo $item['categorie_title']; ?>"><?php echo $item['categorie_title']; ?></option>
            <?php
            }
            ?>
            </select></td>
        </tr>
        <tr>
          <td>Article Context:</td>
          <td><textarea 
               name="article_context" 
               cols="40" 
               rows="5" 
               placeholder="Article Context"
               required="true"></textarea>
        </tr>
        <tr>
          <td>Article Image:</td>
          <td><input 
               type="file"
               name="article_img"
               accept="image/*"
               required="true"></td>
        </tr>
        <tr>
          <td>
            <input type="submit" value="Send">
          </td>
          <td>
            <input type="reset" value="Reset">
          </td>
        </tr>        
      </table>
    </form>
    </body>
</html>

