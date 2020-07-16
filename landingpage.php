<!DOCTYPE html>

<?php
require_once("Lib/lib.php");
require_once("Lib/db.php");
require_once("languageAddon.php");
$categories = getcategories();
$baseUrl = url();
if (!isset($_SESSION) ) {
    session_start();
}

$userId = $_SESSION['id'];
$username = $_SESSION['username'];
$countsPerCat = countArticlesPerCategory();
for ($i=0; $i < count($countsPerCat); $i++) { 
    $countsCatNames[] = getcategoryName($countsPerCat[$i][0]);
}
?>


<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $language['title'] ?></title>
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
    <script>
        function searchClicked() {
            let e = document.getElementById("select1");
            let strUser = e.options[e.selectedIndex].text;

            switch (strUser) {
                <?php
                foreach($categories as $array){
                    echo 'case "' . $array['categorie_title'] . '" : window.location.replace("' . $baseUrl . "articleFeed.php?FilterCategory=" .$array['categorie_title'] . '"); break;';
                    foreach($categories as $array) {
                        echo 'case "' . $array['categorie_title'] . '" : window.location.replace("' . $baseUrl . "categories.php?cat=" .$array['categorie_title'] . '"); break;';
                    }
                }
                ?>
                
                default : alert("No category has been chosen");
            }
        }

        function changeLanguage(type){
            window.location.href = "landingPage.php?lang=" + type;
        }

        <?php
        if (isset($_GET['newsletter'])) {
            if ($_GET['newsletter'] == 0) {
                echo "window.onload = function() { alert('Newsletter subscription failed'); }";
            } else {
                echo "window.onload = function() { alert('Newsletter subscription complete'); }";
            }
        }
        ?>

    </script>

</head>

<body>
    <?php include_once("Page_Elements/preloader.php") ?>

    <main>
        <?php include_once("Page_Elements/header.php") ?>
        <!-- Hero Area Start-->
        <div class="slider-area hero-overly">
            <div class="single-slider hero-overly  slider-height d-flex align-items-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-lg-9">
                            <!-- Hero Caption -->
                            <div class="hero__caption">
                                <span style="color: orangered"><?php echo $language['m_explore'] ?></span>
                                <h1><?php echo $language['m_discover'] ?></h1>
                            </div>
                            <!--Hero form -->
                            <form action="#" class="search-box">
                                <div class="select-form">
                                    <div class="select-itms">
                                        <select name="select" id="select1">
                                            <option value=""><?php echo $language['allcats'] ?></option>
                                            <?php
                                            foreach($categories as $array){
                                              echo "<option value=".$array['categorie_title'].">".$array['categorie_title']."</option>";
                                          }
                                          ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="search-form">
                                <input type="button" value="<?php echo $language['search'] ?>" onclick="searchClicked()" style="   width: 100%; 
                                height: 60px;
                                background: #ff3d1c;
                                font-size: 20px;
                                line-height: 1;
                                text-align: center;
                                color: #fff;
                                display: block;
                                padding: 15px;
                                border-radius: 0px;
                                text-transform: capitalize;
                                line-height: 31px;
                                font-size: 15px;
                                cursor: pointer;"/>
                            </div>	
                        </form>	
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--Hero Area End-->
    <!-- Popular Locations Start -->
    <div class="popular-location section-padding30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Section Tittle -->
                    <div class="section-tittle text-center mb-80">
                        <span style="font-size: 40px"><?php echo $language['m_mostVisited'] ?></span>
                        <h2><?php echo $language['m_discover'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $c = 0;
                foreach($categories as $array){
                    (in_array($array['categorie_title'], $countsCatNames)) ? 
                    ($value = $countsPerCat[$c]['amount'] AND $c++) : $value = 0;
                        //echo "<option value=".$array['categorie_title'].">".$array['categorie_title']."</option>";
                    echo '<div class="col-lg-4 col-md-6 col-sm-6">';
                    echo '<div class="single-location mb-30">';
                    echo '<div class="location-img">';
                    echo '<img src="assets/img/gallery/'. $array['categorie_title'] .'.png" alt="'. $array['categorie_title'] .' Image">';
                    echo '</div>';
                    echo '<div class="location-details">';
                    echo "<p>" . $array['categorie_title'] . "</p>";
                    echo '<a href="Feed/articleFeed.php?FilterCategory='.$array['categorie_title'].'" class="location-btn">'. $value .' <i class="ti-plus"></i> Locations</a>';
                    echo '</div></div></div>';
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Popular Locations End -->
    <!-- Services Area Start -->
    <div class="services-area pt-150 pb-150 section-bg" data-background="assets/img/gallery/section_bg02.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Section Tittle -->
                    <div class="section-tittle section-tittle2 text-center mb-80">
                        <span style="font-size: 40px"><?php echo $language['m_easy'] ?></span>
                        <h2><?php echo $language['m_how'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-lg-3 col-md-6">
                    <div class="single-services text-center mb-50">
                        <div class="services-icon">
                            <span class="flaticon-list"></span>
                        </div>
                        <div class="services-cap">
                            <h5><a><?php echo $language['m_first'] ?></a></h5>
                        </div>
                        <!-- Shpape -->
                        <img class="shape1 d-none d-lg-block" src="assets/img/icon/serices1.png" alt="">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single-services text-center mb-50">
                        <div class="services-icon">
                            <span class="flaticon-problem"></span>
                        </div>
                        <div class="services-cap">
                            <h5><a><?php echo $language['m_second'] ?></a></h5>
                        </div>
                        <img class="shape2 d-none d-lg-block" src="assets/img/icon/serices2.png" alt="">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single-services text-center mb-50">
                        <div class="services-icon">
                            <span class="flaticon-respect"></span>
                        </div>
                        <div class="services-cap">
                            <h5><a><?php echo $language['m_third'] ?></a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services Area End -->

    <!-- peoples-visit Start -->
    <div class="peoples-visit dining-padding-top">
        <!-- Single Left img -->
        <div class="single-visit left-img">
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-lg-8">
                        <div class="visit-caption">
                            <span style="font-size: 40px"><<?php echo $language['m_span1'] ?></span>
                            <h3><?php echo $language['m_h3'] ?></h3>
                            <p><?php echo $language['m_p'] ?></p>
                            <!--Single Visit categories -->
                            <div class="visit-categories mb-40">
                                <div class="visit-location">
                                    <span class="flaticon-travel"></span>
                                </div>
                                <div class="visit-cap">
                                    <h4><?php echo $language['m_h4'] ?></h4>
                                    <p><?php echo $language['m_p1'] ?></p>
                                </div>
                            </div>
                            <!--Single Visit categories -->
                            <div class="visit-categories">
                                <div class="visit-location">
                                    <span class="flaticon-work"></span>
                                </div>
                                <div class="visit-cap">
                                    <h4><?php echo $language['m_h4_1'] ?></h4>
                                    <p><?php echo $language['m_p2'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- peoples-visit End -->
    
    <!-- Subscribe Area Start -->
    <div class="subscribe-area section-bg pt-150 pb-150" data-background="assets/img/gallery/section_bg04.jpg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <!-- Section Tittle -->
                    <div class="section-tittle section-tittle2 text-center mb-40">
                        <span style="font-size: 40px"><?php echo $language['m_subscribe'] ?></span>
                        <h2><?php echo $language['m_subscribe1'] ?></h2>
                    </div> 
                    <!--Hero form -->
                    <form method="POST" action="Feed/subscribe.php" class="search-box">
                        <div class="input-form">
                            <input type="email" name="email" placeholder="<?php echo $language['m_subscribe2'] ?>" required>
                        </div>
                        <div class="search-form" style="cursor: pointer;">
                            <a><input type="submit" style="background-color: transparent; border-style: none; cursor: pointer;" value="<?php echo $language['m_subscribe3'] ?>"></a>
                        </div>	
                    </form>	
                </div>
            </div>
        </div>
    </div>
    <!-- Subscribe Area End -->


</main>
<?php include_once("Page_Elements/footer.php") ?>
<?php include_once("Page_Elements/goup.php") ?>


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