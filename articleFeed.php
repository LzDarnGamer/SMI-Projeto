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

    $userId = $_SESSION['id'];
    $username = $_SESSION['username'];

    $loggedIn = false;
    if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
        $loggedIn = true;
    }
    
    $users = getAllIds();
    for ($i = 0; $i < sizeof($users); $i ++) {
        $articlesArray = getArticles($users[$i]);
    }

    $FilterCategory = isset($_GET['FilterCategory']) ? $_GET['FilterCategory'] : null;
    $FilterSubCategory = isset($_GET['FilterSubCategory']) ? $_GET['FilterSubCategory'] : null;
    $FilterUsername = isset($_GET['FilterUsername']) ? $_GET['FilterUsername'] : null;
?>

<body style="overflow: visible;">
<?php include_once("Page_Elements/preloader.php") ?>
<main>
<?php include_once("Page_Elements/header.php") ?>
<!-- Hero Start-->
<div class="hero-area2  slider-height2 hero-overly2 d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="hero-cap text-center pt-50">
                    <h2>Your Feed</h2>
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

                    $counter = 0;

                    for ($i = 0; $i < sizeof($articlesArray); $i ++) {

                        if((!$loggedIn && $articlesArray[$i]['visible'] != 0) || ($loggedIn)) {
                            if (isset($FilterCategory)) {
                                if (getcategoryName($articlesArray[$i]['article_categorie_id']) != $FilterCategory) {
                                    $counter ++;
                                    continue;
                                }
                            } else if (isset($FilterSubCategory)) {
                                if (getsubcategoryName($articlesArray[$i]['article_subcategorie_id']) != $FilterSubCategory) {
                                    $counter ++;
                                    continue;
                                }
                            } else if (isset($FilterUsername)) {
                                if (getUser($articlesArray[$i]['poster_id']) != $FilterUsername) {
                                    $counter ++;
                                    continue;
                                }
                            }
                            

                            $description = (mb_strlen($articlesArray[$i]['article_context'], 'UTF-8') > 80) ? mb_substr($articlesArray[$i]['article_context'], 0, 80, 'UTF-8') . '...' : $articlesArray[$i]['article_context'];
                    ?>
                        <article class="blog_item">
                            <div class="blog_item_img">
                                <img class="card-img rounded-0" style="border: 3px solid;" src="userpages/showFileImage.php?id=<?php echo $articlesArray[$i]['article_image']; ?>&size=full" alt="">
                                <!-- Data -->
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
                                <!-- Title -->
                                <a class="d-inline-block" href="<?php echo "userpages/article.php?type=view&id={$articlesArray[$i]['article_id']}"; ?>">
                                    <h2><?php echo $articlesArray[$i]['article_title']; ?></h2>
                                </a>
                                <!-- Descricao -->
                                <p><?php echo $description; ?></p>
                                <p>
                                    <form method="POST" action="comments/AddComment.php" id="com<?php echo $i; ?>">
                                        <textarea style="width: 100%;" maxlength="95" name="comment" form="com<?php echo $i; ?>" required></textarea>
                                        <input type="hidden" value="<?php echo $userId; ?>" name="posterId">
                                        <input type="hidden" value="<?php echo $articlesArray[$i]['article_id']; ?>" name="articleId">
                                        <input style="margin-top: 10px; float: right; width: 100px; cursor: pointer;" type="submit" value="Post">
                                    </form>
                                </p>
                                
                                <br>

                                <?php
                                $comments = getComments($articlesArray[$i]['article_id']);
                                //echo var_dump($articlesArray[$i]['article_id']);
                                //echo var_dump($comments);
                                if (isset($comments)) {
                                    if (sizeof($comments) > 0) {

                                        echo "<a class=\"d-inline-block\" style=\"margin-bottom: 10px;\"> Comments </a>";

                                        for ($j = 0; $j < sizeof($comments); $j ++) {

                                            echo "<p style=\"background-color: coral;\">";
                                                echo $comments[$j]['text'];
                                                echo "<a style=\"float: right;\">";
                                                    echo "<small>" . getNameFromUser($comments[$j]['userId']) . "</small>";
                                                echo "</a>";
                                            echo "</p>";
        
                                        }
                                    }
                                }
                                ?>

                                <ul class="blog-info-link">
                                    <li><a><i class="fa fa-user"></i><?php
                                        echo getNameFromUser($articlesArray[$i]['poster_id']);
                                    ?></a></li>
                                    <!--
                                    <li><a href="#"><i class="fa fa-comments"></i> 03 Comments</a></li>
                                    -->
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
                        <form method="GET">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="FilterUsername" placeholder="Search By User" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search By User'">
                                    <div class="input-group-append">
                                        <button class="btns" type="button"><i class="ti-search" style="cursor: help;"></i></button>
                                    </div>
                                </div>
                            </div>
                            <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn" type="submit">Search</button>
                        </form>
                    </aside>
                    

                    <!-- Category -->
                    <aside class="single_sidebar_widget post_category_widget">
                        <h4 class="widget_title">Category</h4>
                        <ul class="list cat-list">
                            <form method="GET">
                                <?php
                                $cc = getcategories();
                                foreach ($cc as $cat) {
                                ?>
                                    <li>
                                        <input style="cursor: pointer; width: 100%;" name="FilterCategory" type="submit" class="d-flex" value="<?php echo $cat['categorie_title']; ?>">
                                    </li>
                                <?php
                                }
                                ?>
                            </form>
                            
                        </ul>
                    </aside>

                    <!-- Sub Categories -->
                    <aside class="single_sidebar_widget tag_cloud_widget">
                        <h4 class="widget_title">Sub categories</h4>
                        <form method="GET">
                            <ul class="list">
                                <?php
                                $subcc = getSubcategories();
                                foreach ($subcc as $subCat) {
                                ?>
                                <li>
                                    <input type="submit" style="cursor: pointer; margin: 3px; " name="FilterSubCategory" value="<?php echo $subCat['subcategorie_title']; ?>">
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </form>
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