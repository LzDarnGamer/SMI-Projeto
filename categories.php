<!doctype html>

<?php
require_once("Lib/lib.php");
require_once("Lib/db.php");
$categories = getcategories();
$baseUrl = url();
$type = $_GET['cat']
?>

<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Directory HTML-5 Template </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="manifest" href="site.webmanifaest">
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
                                        <a href="index.html"><img src="assets/img/logo/logo.png" alt=""></a>
                                    </div>
                                </div>
                                <div class="col-xl-10 col-lg-10 col-md-8">
                                    <!-- Main-menu -->
                                    <div class="main-menu f-right d-none d-lg-block">
                                        <nav>
                                            <ul id="navigation">                                                                                                                                     
                                                <li><a href="index.html">Home</a></li>
                                                <li><a href="about.html">About</a></li>
                                                <li class="add-list"><a href="listing_details.html"><i class="ti-plus"></i> add Listing</a></li>
                                                <li class="login"><a href="Login_Registo/formLogin.php">
                                                    <i class="ti-user"></i> Sign </a>
                                                </li>
                                                <li class="login"><a href="Login_Registo/formRegister.php">
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
                                <h2><?php echo $type ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Hero End -->
            <!-- Categories Area Start -->
            <div class="categories-area section-padding30">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Section Tittle -->
                            <div class="section-tittle text-center mb-80">
                                <span>Isto não é como começa, é como acaba</span>
                                <h2>Featured <?php echo $type ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-cat text-center mb-50">
                                <div class="cat-icon">
                                    <span class="flaticon-bed"></span>
                                </div>
                                <div class="cat-cap">
                                    <h5><a href="#">Leving Hotel</a></h5>
                                    <p>Must explain your how this keind denoun pleasure</p>
                                    <a href="#">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-cat text-center mb-50">
                                <div class="cat-icon">
                                    <span class="flaticon-drink"></span>
                                </div>
                                <div class="cat-cap">
                                    <h5><a href="#">Night Life</a></h5>
                                    <p>Must explain your how this keind denoun pleasure</p>
                                    <a href="#">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-cat text-center mb-50">
                                <div class="cat-icon">
                                    <span class="flaticon-home"></span>
                                </div>
                                <div class="cat-cap">
                                    <h5><a href="#">Culture Place</a></h5>
                                    <p>Must explain your how this keind denoun pleasure</p>
                                    <a href="#">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-cat text-center mb-50">
                                <div class="cat-icon">
                                    <span class="flaticon-food"></span>
                                </div>
                                <div class="cat-cap">
                                    <h5><a href="#">Resturent</a></h5>
                                    <p>Must explain your how this keind denoun pleasure</p>
                                    <a href="#">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-cat text-center mb-50">
                                <div class="cat-icon">
                                    <span class="flaticon-drink"></span>
                                </div>
                                <div class="cat-cap">
                                    <h5><a href="#">Night Life</a></h5>
                                    <p>Must explain your how this keind denoun pleasure</p>
                                    <a href="#">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-cat text-center mb-50">
                                <div class="cat-icon">
                                    <span class="flaticon-bed"></span>
                                </div>
                                <div class="cat-cap">
                                    <h5><a href="#">Leving Hotel</a></h5>
                                    <p>Must explain your how this keind denoun pleasure</p>
                                    <a href="#">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-cat text-center mb-50">
                                <div class="cat-icon">
                                    <span class="flaticon-food"></span>
                                </div>
                                <div class="cat-cap">
                                    <h5><a href="#">Resturent</a></h5>
                                    <p>Must explain your how this keind denoun pleasure</p>
                                    <a href="#">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-cat text-center mb-50">
                                <div class="cat-icon">
                                    <span class="flaticon-drink"></span>
                                </div>
                                <div class="cat-cap">
                                    <h5><a href="#">Night Life</a></h5>
                                    <p>Must explain your how this keind denoun pleasure</p>
                                    <a href="#">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Categories Area End -->

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
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End-->
        </footer>

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