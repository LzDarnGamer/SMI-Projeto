<!DOCTYPE html>
<?php
if (!isset($_SESSION) ) {
  session_start();
}

require_once("../Lib/lib.php");
require_once("../Lib/db.php");
include( "../ensureAuth.php" );
$userId = $_SESSION['id'];
$username = $_SESSION['username'];
$role = getRoleFromUser($userId);
switch ($role) {
    case 'value':
        # code...
        break;
    
    default:
        # code...
        break;
}
$numarticlesUser = getnumArticles($userId);
$articlesArray = getArticles($userId);

?>

<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $username?>'s Profile</title>
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
        <style>
            .btn {
                background-color: #ff3d1c;
                border: none;
                height: 50px;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin-top: 30px;
                cursor: pointer;
            }   

        </style>

   
        </head>

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
       <div class="header-area header-transparent" style="background-color: #212529">
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
                                            <li><a href="../landingpage.php">Home</a></li>
                                            <li><a href="../about.php">About</a></li>
                                            <li class="login"><a href="profilepage.php">
                                                <i class="ti-user"></i> Me</a>
                                            </li>
                                            <li class="login"><a href="../logout.php">
                                                <i class="ti-user"></i> Sign out</a>
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

        <!-- Hero Area Start-->
        <div class="slider-area hero-overly">
            <div class="single-slider hero-overly  slider-height d-flex align-items-center">
                <div class="container" style="width: 100%; height: 500px;">
                    <div class="hero__caption">
                        <span style="color: orangered">Welcome back, <?php echo $username ?><span>
                            <script>
                            function createArticles () {
                                window.location = "createArticle.php";
                            }
                            </script>
                            <input class="btn" type="button" value="Create Articles" onclick="createArticles()">
                    </div>
                </div>

            </div>
        </div>
        <!--Hero Area End-->
        <!-- Popular Locations Start -->
        <?php
        if($numarticlesUser <=0 ){
            ?>
            <div class="popular-location section-padding30">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Section Tittle -->
                            <div class="section-tittle text-center mb-80">
                                <span>No articles to show, it's time to write some</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
        ?>

        <div class="categories-area section-padding30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Section Tittle -->
                        <div class="section-tittle text-center mb-80">
                            <span>Your beautiful articles</span>
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
        <?php } ?>
       

    </main>
    <footer>

        <?php 
        echo var_dump($articlesArray); 
        ?>
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