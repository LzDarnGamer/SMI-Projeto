<!DOCTYPE html>
<?php
if ( !isset($_SESSION) ) {
  session_start();
}

require_once("../Lib/lib.php");
require_once("../Lib/db.php");
include( "../ensureAuth.php" );
require_once("../languageAddon.php");
$userId = $_SESSION['id'];
$username = $_SESSION['username'];

$type = $_GET['type'];
$articleid = $_GET['id'];
if($type != "view" && $type != "eliminate" && $type != "edit"){
    $title = "Invalid Arguments";
    $info = "Invalid arguments found";
    header("Location: ../responsePage.php?title=$title&info=$info");
    exit();
}

if($type == "edit") {
    if(getPosterID($articleid) != $userId){
        $title = "Invalid Permission";
        $info = "You can only edit your articles";
        header("Location: ../responsePage.php?title=$title&info=$info");
        exit();
    }
    header("Location: editArticle.php?id=$articleid");
}




if($type == "eliminate") {
    if(getPosterID($articleid) != $userId){
        $title = "Invalid Permission";
        $info = "You can only delete your articles";
        header("Location: ../responsePage.php?title=$title&info=$info");
        exit();
    }
    $result = deleteArticle($articleid, getPosterID($articleid));

    if($result){
        header("Location: profilepage.php");
    }else{
        $title = "Invalid Arguments";
        $info = "Some errors found while processing your request";
        header("Location: ../responsePage.php?title=$title&info=$info");
        
    }
    exit();
}

$article = getArticle($articleid);
if($article == null){
    $title = "Invalid Arguments";
    $info = "Invalid Arguments Found";
    header("Location: ../responsePage.php?title=$title&info=$info");
}
$fileDetails = getFileDetails($article['article_image']);

?>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> <?php echo $username ?>'s <?php echo $language['articles']; ?> </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
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
</head>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHfVOvuyvRGhi41p2KHLbSEbUHPg1buKk&libraries=places"></script>
<script>
    var myLatLon = new google.maps.LatLng(<?php echo $fileDetails['latitude']; ?>, <?php echo $fileDetails['longitude']; ?>);
    function initAutocomplete() {
        var myOptions = {
            zoom: 4,
            center: myLatLon,
        };

        var map = new google.maps.Map(document.getElementById("map"), myOptions);
        new google.maps.Marker({
            position: myLatLon,
            map: map,
            title: "Location"
        });

    }
    document.addEventListener("DOMContentLoaded", function(event) {
      initAutocomplete();
  });
    function changeLanguage(type){
        window.location.href = "article.php?type=view&id=15&lang=" + type;
    }

    function addToCart(id){
        $.ajax({
            url: 'addcart.php',
            type: 'POST',
            data : {userID:<?php echo $userId ?>, value: id},
            success: function(data) {
                var items = document.getElementsByClassName("badge"), i, len;
                for (i = 0, len = items.length; i < len; i++) {
                    items[i].innerHTML = data;
                }

                location.reload();
            }
        })
    }
</script>
<body>
  <?php include_once("../Page_Elements/preloader.php") ?>
  
  <main>
    <?php include_once("../Page_Elements/header.php") ?>
    <!-- Hero Start-->
    <div class="hero-area2  slider-height2 hero-overly2 d-flex align-items-center ">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center pt-50">
                        <h2> <?php echo $article['article_title'] ?> </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Hero End -->
    <!-- Listing caption start-->


    <div class="listing-caption section-padding">

        <div class="container">

            <div class="row justify-content-center">
                <?php
                
                if ($fileDetails['mimeFileName'] == "image") {
                    $src = "showFileImage.php?id=".$article['article_image']."&size=full";
                    ?>
                    <img style="margin-bottom: 20px; border: 3px solid;" width="800px" height="800px" class="img-fluid" 
                    src="showFileImage.php?id=<?php echo $article['article_image']?>&size=full" 
                    alt="Your article image">
                    <?php 
                } else if ($fileDetails['mimeFileName'] == "video" || $fileDetails['mimeFileName'] == "audio") {
                    $src = "getFileContents.php?id=".$article['article_image'];
                    ?>
                    <video  controls>
                      <source src="getFileContents.php?id=<?php echo $article['article_image']?>" type="video/mp4">
                          Your browser does not support the video tag.
                      </video> 
                  <?php } ?> 


                  <div class="col-lg-8" style="text-align: center;"><br>
                    <h3 class="mb-20"><?php echo $language['createArt_artCont'] ?></h3>
                    <p class="mb-30"><?php echo $article['article_context'] ?> </p>
                </div>

                <?php
                $comments = getComments($articleid);

                if (isset($comments)) {
                    if (sizeof($comments) > 0) {
                        ?>
                        <div class="col-lg-8" style="text-align: center;"><br>
                            <h3 class="mb-20">Comments</h3>
                            <?php
                            
                            for ($i = 0; $i < sizeof($comments); $i ++) {
                                echo "<p style=\"background-color: coral; text-align: left;\">";
                                    echo $comments[$i]['text'];
                                    echo "<a style=\"float: right;\">";
                                        echo "<small>" . getNameFromUser($comments[$i]['userId']) . "</small>";
                                    echo "</a>";
                                echo "</p>";
                            }

                            ?>
                        </div>

                        <?php
                    }
                }
                ?>
            </div>
            <!-- Map -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h3 class="mb-30">Google Maps</h3>
                    <div id="map" style="height: 480px; position: relative; overflow: hidden;"></div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8" style="text-align: center;"><br>
                <a download="<?php echo $article['article_title'] ?>" href="<?php echo $src ?>"><button class="genric-btn danger">Download Photo</button></a>
                <a><button onclick="addToCart(<?php echo $articleid?>)" class="genric-btn danger"><?php echo $language['Art_addtocart'] ?></button></a>            
            </div>
        </div>
    </div>

</main>
<?php include_once("../Page_Elements/goup.php") ?>
<?php include_once("../Page_Elements/footer.php") ?>

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