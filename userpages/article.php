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

$type = $_GET['type'];
$Articleid = $_GET['id'];
if($type != "view" && $type != "eliminate" && $type != "edit"){
    echo "Invalid request found";
    exit();
}

if($type == "edit"){
    if(getPosterID($Articleid) != $userId){
        echo "You can only edit your articles";
        exit();
    }
}

$article = getArticle($articleid);
$fileDetails = getFileDetails($article['article_image']);
?>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> <?php echo $username ?>'s Article </title>
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
            zoom: 16,
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
</script>
<body>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/loder.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
        <div class="header-area header-transparent">
            <div class="main-header">
               <div class="header-bottom  header-sticky">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <!-- Logo -->
                        <div class="col-xl-2 col-lg-2 col-md-1">
                            <div class="logo">
                              <a href="../landingpage.php"><img src="assets/img/logo/logo.png" alt=""></a>
                          </div>
                      </div>
                      <div class="col-xl-10 col-lg-10 col-md-8">
                        <!-- Main-menu -->
                        <div class="main-menu f-right d-none d-lg-block">
                            <nav>
                                <ul id="navigation">                                                                                                                                     
                                            <li><a href="landingpage.php">Home</a></li>
                                            <li><a href="../about.php">About</a></li>
                                            <li class="login"><a href="profilepage.php">
                                                <i class="ti-user"></i> Me</a>
                                            </li>
                                            <li class="login"><a href="../Login_Registo/formLogin.php">
                                                <i class="ti-user"></i> Sign in</a>
                                            </li>
											<li class="login"><a href="../Login_Registo/formRegister.php">
                                                <i class="ti-user"></i> Register</a>
                                            </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->
</header>
<main>

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
                <img style="margin-bottom: 20px" width="auto" height="auto" class="img-fluid" 
                src="showFileImage.php?id=<?php echo $article['article_image']?>&size=full" 
                alt="Your article image">
                <div class="col-lg-8" style="text-align: center;">
                    <h3 class="mb-20">Article Context</h3>
                    <p class="mb-30"><?php echo $article['article_context'] ?>
                </p>
            </div>
        </div>
        <!-- Map -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h3 class="mb-30">Location</h3>
                <div id="map" style="height: 480px; position: relative; overflow: hidden;"></div>
            </div>
        </div>
    </div>


</div>
</div>

</main>
<footer>
    <!-- Footer Start-->
    <div class="footer-area">
        <div class="container">

            <div class="footer-bottom">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-xl-9 col-lg-8">
                        <div class="footer-copy-right">
                            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                              Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
                              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                          </div>
                      </div>
                      <div class="col-xl-3 col-lg-4">
                        <!-- Footer Social -->
                        <div class="footer-social f-right">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fas fa-globe"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
</footer>
<!-- Scroll Up -->
<div id="back-top" >
    <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
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