<html class="js sizes customelements history pointerevents postmessage webgl websockets cssanimations csscolumns csscolumns-width csscolumns-span csscolumns-fill csscolumns-gap csscolumns-rule csscolumns-rulecolor csscolumns-rulestyle csscolumns-rulewidth csscolumns-breakbefore csscolumns-breakafter csscolumns-breakinside flexbox picture srcset webworkers" lang="zxx"><head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Directory HTML-5 Template </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<?php
    require_once("Lib/lib.php");
    require_once("Lib/db.php");
    include( "ensureAuth.php" );
    require_once("languageAddon.php");
    
    $users = getAllIds();
    for ($i = 0; $i < sizeof($users); $i ++) {
        $articlesArray = getArticles($users[$i]);
    }

        
?>

<body style="overflow: visible;">
    <!-- Preloader Start -->
    <div id="preloader-active" style="display: none;">
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
             <div class="header-bottom  header-sticky sticky-bar">
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
                                    <li><a href="catagori.html">Catagories</a></li>
                                    <li><a href="listing.html">Listing</a></li>
                                    <li><a href="#">Page</a>
                                        <ul class="submenu">
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="blog_details.html">Blog Details</a></li>
                                            <li><a href="elements.html">Element</a></li>
                                            <li><a href="listing_details.html">Listing details</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.html">Contact</a></li>
                                    <li class="add-list"><a href="listing_details.html"><i class="ti-plus"></i> add Listing</a></li>
                                    <li class="login"><a href="#">
                                        <i class="ti-user"></i> Sign in or Register</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"><div class="slicknav_menu"><a href="#" aria-haspopup="true" role="button" tabindex="0" class="slicknav_btn slicknav_collapsed" style="outline: none;"><span class="slicknav_menutxt">MENU</span><span class="slicknav_icon"><span class="slicknav_icon-bar"></span><span class="slicknav_icon-bar"></span><span class="slicknav_icon-bar"></span></span></a><ul class="slicknav_nav slicknav_hidden" aria-hidden="true" role="menu" style="display: none;">                                                                                                                                     
                                    <li><a href="index.html" role="menuitem" tabindex="-1">Home</a></li>
                                    <li><a href="about.html" role="menuitem" tabindex="-1">About</a></li>
                                    <li><a href="catagori.html" role="menuitem" tabindex="-1">Catagories</a></li>
                                    <li><a href="listing.html" role="menuitem" tabindex="-1">Listing</a></li>
                                    <li class="slicknav_collapsed slicknav_parent"><a href="#" role="menuitem" aria-haspopup="true" tabindex="-1" class="slicknav_item slicknav_row" style="outline: none;"><a href="#" tabindex="-1">Page</a>
                                        <span class="slicknav_arrow">+</span></a><ul class="submenu slicknav_hidden" role="menu" aria-hidden="true" style="display: none;">
                                            <li><a href="blog.html" role="menuitem" tabindex="-1">Blog</a></li>
                                            <li><a href="blog_details.html" role="menuitem" tabindex="-1">Blog Details</a></li>
                                            <li><a href="elements.html" role="menuitem" tabindex="-1">Element</a></li>
                                            <li><a href="listing_details.html" role="menuitem" tabindex="-1">Listing details</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.html" role="menuitem" tabindex="-1">Contact</a></li>
                                    <li class="add-list"><a href="listing_details.html" role="menuitem" tabindex="-1"><i class="ti-plus"></i> add Listing</a></li>
                                    <li class="login"><a href="#" role="menuitem" tabindex="-1">
                                        <i class="ti-user"></i> Sign in or Register</a>
                                    </li>
                                </ul></div></div>
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
<div class="hero-area2  slider-height2 hero-overly2 d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="hero-cap text-center pt-50">
                    <h2>Blog Area</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Hero End -->
<!--================Blog Area =================-->
<section class="blog_area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="blog_left_sidebar">
                    <?php
                    for ($i = 0; $i < sizeof($articlesArray); $i ++) {
                        if($articlesArray[$i]['visible'] != 0) {
                            $truncated = (mb_strlen($articlesArray[$i]['article_context'], 'UTF-8') > 80) ? mb_substr($articlesArray[$i]['article_context'], 0, 80, 'UTF-8') . '...' : $articlesArray[$i]['article_context'];
                    ?>
                        <article class="blog_item">
                            <div class="blog_item_img">
                                <img class="card-img rounded-0" src="userpages/showFileImage.php?id=<?php echo $articlesArray[$i]['article_image']; ?>&size=full" alt="">
                                <a href="#" class="blog_item_date">
                                    <h3><?php 
                                        $date=date_create($articlesArray[$i]['article_timestamp']);
                                        echo date_format($date,"d"); ?></h3>
                                    <p>
                                        <?php echo date_format($date,"M")." '".date_format($date,"y"); ?>
                                    </p>
                                </a>
                            </div>
                            <div class="blog_details">
                                <a class="d-inline-block" href="<?php echo "userpages/article.php?type=view&id={$articlesArray[$i]['article_id']}"; ?>">
                                    <h2><?php echo $articlesArray[$i]['article_title']; ?></h2>
                                </a>
                                <p><?php echo $truncated; ?></p>
                                <ul class="blog-info-link">
                                    <li><a href="#"><i class="fa fa-user"></i><?php
                                        echo getNameFromUser($articlesArray[$i]['poster_id']);
                                    ?></a></li>
                                    <li><a href="#"><i class="fa fa-comments"></i> 03 Comments</a></li>
                                </ul>
                            </div>
                        </article>
                    <?php
                        }
                    }
                    ?>

                    

                    

                    

                    

                    <nav class="blog-pagination justify-content-center d-flex">
                        <ul class="pagination">
                            <li class="page-item">
                                <a href="#" class="page-link" aria-label="Previous">
                                    <i class="ti-angle-left"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a href="#" class="page-link">1</a>
                            </li>
                            <li class="page-item active">
                                <a href="#" class="page-link">2</a>
                            </li>
                            <li class="page-item">
                                <a href="#" class="page-link" aria-label="Next">
                                    <i class="ti-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                    <aside class="single_sidebar_widget search_widget">
                        <form action="#">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search Keyword" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search Keyword'" pattern="[A-Za-z]+">
                                    <div class="input-group-append">
                                        <button class="btns" type="button"><i class="ti-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn" type="submit">Search</button>
                        </form>
                    </aside>

                    <aside class="single_sidebar_widget post_category_widget">
                        <h4 class="widget_title">Category</h4>
                        <ul class="list cat-list">
                            <li>
                                <a href="#" class="d-flex">
                                    <p>Monuments</p>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="d-flex">
                                    <p>Cities</p>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="d-flex">
                                    <p>Beaches</p>
                                </a>
                            </li>
                            
                            
                            
                        </ul>
                    </aside>

                    
                    <aside class="single_sidebar_widget tag_cloud_widget">
                        <h4 class="widget_title">Sub categories</h4>
                        <ul class="list">
                            <li>
                                <a href="#">project</a>
                            </li>
                            <li>
                                <a href="#">love</a>
                            </li>
                            <li>
                                <a href="#">technology</a>
                            </li>
                            <li>
                                <a href="#">travel</a>
                            </li>
                            <li>
                                <a href="#">restaurant</a>
                            </li>
                            <li>
                                <a href="#">life style</a>
                            </li>
                            <li>
                                <a href="#">design</a>
                            </li>
                            <li>
                                <a href="#">illustration</a>
                            </li>
                        </ul>
                    </aside>

                    


                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">Newsletter</h4>

                        <form action="#">
                            <div class="form-group">
                                <input type="email" class="form-control" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email'" placeholder="Enter email" required="">
                            </div>
                            <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn" type="submit">Subscribe</button>
                        </form>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================Blog Area =================-->

</main>
<footer>
    <!-- Footer Start-->
    <div class="footer-area">
        <div class="container">
         <div class="footer-top footer-padding">
            <div class="row justify-content-between">
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                    <div class="single-footer-caption mb-50">
                        <div class="single-footer-caption mb-30">
                            <!-- logo -->
                            <div class="footer-logo">
                                <a href="index.html"><img src="assets/img/logo/logo2_footer.png" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>All packages</h4>
                            <ul>
                                <li><a href="#">Package-1</a></li>
                                <li><a href="#">Package-2</a></li>
                                <li><a href="#">Package-3</a></li>
                                <li><a href="#">Custome</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>Quick Link</h4>
                            <ul>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">News &amp; Articles</a></li>
                                <li><a href="#">Privacy Policy</a></li>     
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>+1 514 648 256</h4>
                            <ul>
                                <li><a href="#">youremail@gmail.com</a></li>
                            </ul>
                            <p>123 East 26th Street, Fifth Floor, New York, NY 10011</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-xl-9 col-lg-9 ">
                    <div class="footer-copy-right">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                          Copyright ©<script>document.write(new Date().getFullYear());</script>2020 All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                      </div>
                  </div>
                  <div class="col-xl-3 col-lg-3">
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
<div id="back-top" style="display: block;">
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

<!-- Nice-select, sticky -->
<script src="./assets/js/jquery.nice-select.min.js"></script>
<script src="./assets/js/jquery.sticky.js"></script>
<script src="./assets/js/jquery.magnific-popup.js"></script>

<!-- contact js -->
<script src="./assets/js/contact.js"></script>
<script src="./assets/js/jquery.form.js"></script>
<script src="./assets/js/jquery.validate.min.js"></script>
<script src="./assets/js/mail-script.js"></script>
<script src="./assets/js/jquery.ajaxchimp.min.js"></script>

<!-- Jquery Plugins, main Jquery -->	
<script src="./assets/js/plugins.js"></script>
<script src="./assets/js/main.js"></script>


</body></html>