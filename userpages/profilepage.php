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
$numarticlesUser = getnumArticles($userId);
$articlesArray = getArticles($userId);

echo var_dump($articlesArray);
?>
<html>
<head>
    <html class="js sizes customelements history pointerevents postmessage webgl websockets cssanimations csscolumns csscolumns-width csscolumns-span csscolumns-fill csscolumns-gap csscolumns-rule csscolumns-rulecolor csscolumns-rulestyle csscolumns-rulewidth csscolumns-breakbefore csscolumns-breakafter csscolumns-breakinside flexbox picture srcset webworkers" lang="zxx"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Profile of <?php echo $username ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

        <!-- CSS here -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/slicknav.css">
        <link rel="stylesheet" href="assets/css/flaticon.css">
        <link rel="stylesheet" href="assets/css/animate.min.css">
        <link rel="stylesheet" href="assets/css/magnific-popup.css">
        <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="assets/css/themify-icons.css">
        <link rel="stylesheet" href="assets/css/slick.css">
        <link rel="stylesheet" href="assets/css/nice-select.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <header>
       <p>Welcome back, <?php echo $username ?> </p>
       <p>DEBUG: ID =  <?php echo $userId ?> </p>
   </header>

   <body>
       <h5><a href="manageArticles.php">Manage Articles</a></h5>
       <h5><a href="createArticle.php">Create Article</a></h5>
       <?php
       echo $numarticlesUser;
       if($numarticlesUser <=0 ){
          echo "<p> No articles to show, it's time to write some </p>";
      }
      ?>
      <div class="categories-area section-padding30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-tittle text-center mb-80">
                        <span>Your beautiful articles</span>
                        <h2>Your articles are here</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                for ($i=0; $i < count($articlesArray); $i++) {
                    echo <<< EOT
                    <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-cat text-center mb-50">
                    <div class="cat-icon">
                    <img style="border-radius: 50%" width="80" height="80" src="showFileImage.php?id={$articlesArray[$i]['article_image']}&size=thumb" alt="Minha Figura">
                    </div>
                    <br>
                    <div class="cat-cap">
                    <h5><a href="article.php?type=view&id={$articlesArray[$i]['article_id']}">{$articlesArray[$i]['article_title']}</a></h5>
                    <p>{$articlesArray[$i]['article_context']}</p>
                    <a href="article.php?type=view&id={$articlesArray[$i]['article_id']}">View article</a>
                    <br>
                    <a href="article.php?type=edit&id={$articlesArray[$i]['article_id']}">Edit article</a>
                    <br>
                    <a href="article.php?type=eliminate&id={$articlesArray[$i]['article_id']}">Eliminate article</a>
                    </div>
                    </div>
                    </div>
                    EOT;
                }
                ?>
            </div>
        </div>
    </div>




    <!-- Scroll Up -->
    <div id="back-top" style="display: block;">
        <a title="Go to Top" href="file:///C:/xampp/htdocs/smi/g37/Testes%20Design/index%20-%20C%C3%B3pia.html#"> <i class="fas fa-level-up-alt"></i></a>
    </div>


    <!-- JS here -->
    <!-- All JS Custom Plugins Link Here here -->
    <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <!-- Jquery Mobile Menu -->
    <script src="./assets/js/jquery.slicknav.min.js"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="./assets/js/owl.carousel.min.js"></script>
    <script src="./assets/js/slick.min.js"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="./assets/js/wow.min.js"></script>
    <script src="./assets/js/animated.headline.js"></script>
    <script src="./assets/js/jquery.magnific-popup.js"></script>

    <!-- Nice-select, sticky -->
    <script src="./assets/js/jquery.nice-select.min.js"></script>
    <script src="./assets/js/jquery.sticky.js"></script>

    <!-- contact js -->
    <script src="./assets/js/contact.js"></script>
    <script src="./assets/js/jquery.form.js"></script>
    <script src="./assets/js/jquery.validate.min.js"></script>
    <script src="./assets/js/mail-script.js"></script>
    <script src="./assets/js/jquery.ajaxchimp.min.js"></script>

    <!-- Jquery Plugins, main Jquery -->    
    <script src="./assets/js/plugins.js"></script>
    <script src="./assets/js/main.js"></script>




</body>
</html>

