<!DOCTYPE html>
<?php
if (!isset($_SESSION) ) {
  session_start();
}

require_once("../Lib/lib.php");
require_once("../Lib/db.php");
include( "../ensureAuth.php" );
require_once("../languageAddon.php");
$isAdmin = false;

$userId = $_SESSION['id'];
$username = $_SESSION['username'];
$role = getRoleFromUser($userId);


switch ($role) {
    case 'manager':
    $numarticlesUser = getnumArticles($userId);
    $articlesArray = getArticles($userId);
    break;
    case 'administrator':
    $isAdmin = true;
    break;
    case 'user':
    $userSubscriptionsIDS = getSubsciptions($userId);
    break;
    default:
    header("Location: ../noPrivelege.php");
    break;
}
?>

<script>
    function createArticles () { window.location = "createArticle.php"; }
    function createSubcategory () { window.location = "createSubcategories.php"; }
    function manageUsers () { window.location = "../admin/manageusers.php"; }
    function manageCategories () { window.location = "../admin/manageCategories.php"; }
    function openFeed () { window.location = "../articleFeed.php"; }

    function confirmBox(){
        return confirm("Are you sure you want to delete");
    }
    function changeLanguage(type){
        window.location.href = "profilePage.php?lang=" + type;
    }

    function changeVisibility(div, id){
        if(div.getElementsByTagName("i")[0].className === "fa fa-eye-slash"){

            $.ajax({
                url: 'changeVisibility.php',
                type: 'POST',
                data : {postID: id, value: 1},
                success: function(data) {
                    console.log(data);
                    div.getElementsByTagName("i")[0].className = "fa fa-eye";
                }
            })
        }else{
            $.ajax({
                url: 'changeVisibility.php',
                type: 'POST',
                data : {postID: id, value: 0},
                success: function(data) {
                    div.getElementsByTagName("i")[0].className = "fa fa-eye-slash";
                }
            })
        }
        
    }
</script>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $username?>'s <?php echo $language['profilepg_title'] ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <?php include_once("../Page_Elements/preloader.php") ?>

    <main>

        <?php include_once("../Page_Elements/header.php") ?>

        <!-- Hero Area Start-->
        <div class="slider-area hero-overly">
            <div class="single-slider hero-overly  slider-height d-flex align-items-center">
                <div class="container" style="width: 100%; height: 500px;">
                    <div class="hero__caption">
                        <span style="color: orangered"><?php echo $language['profilepg_welcome'] ?>, <?php if (!$isAdmin) { echo $username; } else { echo "Master"; } ?><span>
                            <?php
                            if($role == "manager") {
                                ?>
                                <input class="btn" type="button" value="<?php echo $language['profilepg_createArt'] ?>" onclick="createArticles()"><br>
                                <input class="btn" type="button" value="<?php echo $language['profilepg_createSub'] ?>" onclick="createSubcategory()">
                            <?php } else if ($role == "administrator") { ?>
                                <input class="btn" style="width: 350px;" type="button" value="Configure Database">      <br />
                                <input class="btn" style="width: 350px;" type="button" value="Manage E-mail services">  <br />
                                <input class="btn" style="width: 350px;" type="button" value="Manage Categories" onclick="manageCategories()">       <br />
                                <input class="btn" style="width: 350px;" type="button" value="Manage Users"             onclick="manageUsers()"> <br />
                                <input class="btn" style="width: 350px;" type="button" value="Create Articles" onclick="createArticles()"><br>
                                <input class="btn" style="width: 350px;" type="button" value="Create Subcategories" onclick="createSubcategory()"><br>
                                <input class="btn" style="width: 350px;" type="button" value="Check Your Feed" onclick="openFeed()">
                            <?php } else if ($role == "user"){
                                /*
                                if(count($userSubscriptionsIDS)==0){
                                    $NonCatarticles = getArticlesOrderLikes(10);
                                    for ($i=0; $i < count($NonCatarticles); $i++) {
                                        echo <<< EOT
                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                        <div class="single-cat text-center mb-50">
                                        <div class="cat-icon">
                                        <img style="border-radius: 50%" width="80" height="80" src="showFileImage.php?id={$articlesArray[$i]['article_image']}&size=thumb" alt="Figura">
                                        </div>
                                        <br>
                                        <div class="cat-cap">
                                        <h5><a href="article.php?type=view&id={$articlesArray[$i]['article_id']}">{$articlesArray[$i]['article_title']}</a></h5>
                                        <p>{$articlesArray[$i]['article_context']}</p>
                                        <a href="article.php?type=view&id={$articlesArray[$i]['article_id']}">View article</a>
                                        </div>
                                        </div>
                                        </div>
                                        EOT;
                                    }
                                }
                                */
                                ?>

                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <!--Hero Area End-->
            <!-- Popular Locations Start -->
            <?php
            if(isset($numarticlesUser) && isset($articlesArray)){
                if($numarticlesUser <=0 ){
                    ?>
                    <div class="popular-location section-padding30">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Section Tittle -->
                                    <div class="section-tittle text-center mb-80">
                                        <span><?php echo $language['profilepg_haveArt'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }else {

                    ?>

                    <div class="categories-area section-padding30">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Section Tittle -->
                                    <div class="section-tittle text-center mb-80">
                                        <span style="font-size: 60px"><?php echo $language['profilepg_yourArt'] ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <?php
                                for ($i=0; $i < count($articlesArray); $i++) {
                                    if($articlesArray[$i]['visible']==0){
                                        $icon = "fa fa-eye-slash";
                                        $visible = "Invisible to guests";
                                    }else{
                                        $icon = "fa fa-eye";
                                        $visible = "Visible to guests";
                                    }
                                    $truncated = (mb_strlen($articlesArray[$i]['article_context'], 'UTF-8') > 80) ? mb_substr($articlesArray[$i]['article_context'], 0, 80, 'UTF-8') . '...' : $articlesArray[$i]['article_context'];
                                    echo <<< EOT
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="single-cat text-center mb-50">
                                    <div class="cat-icon">
                                    <img style="border-radius: 50%" width="80" height="80" src="showFileImage.php?id={$articlesArray[$i]['article_image']}&size=thumb" alt="Minha Figura">
                                    </div>
                                    <br>
                                    <div class="cat-cap">
                                    <h5><a href="article.php?type=view&id={$articlesArray[$i]['article_id']}">{$articlesArray[$i]['article_title']}</a></h5>
                                    <p>{$truncated}</p>
                                    <a href="article.php?type=view&id={$articlesArray[$i]['article_id']}">View article</a>
                                    <br>
                                    <a href="article.php?type=edit&id={$articlesArray[$i]['article_id']}">Edit article</a>
                                    <br>
                                    <a onclick="return confirmBox();" href="article.php?type=eliminate&id={$articlesArray[$i]['article_id']}">Eliminate article</a>
                                    <br><br>
                                    <a style="cursor: pointer;" onclick="changeVisibility(this, {$articlesArray[$i]['article_id']} );" title="{$visible}"><i class="{$icon}"></i></a>
                                    </div>
                                    </div>
                                    </div>
                                    EOT;
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                <?php }
            }else{

            }  ?>


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