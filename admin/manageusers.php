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

}

if (!$isAdmin) { 
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
 }

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
                background-color: #f7a784;
                border: none;
                color: white;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                cursor: pointer;
                margin-right: 15px;
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
                <div class="container" style="width: 100%; height: 500px; text-align: center;">
                    <div class="hero__caption">
                        <span style="color: orangered">Welcome back, <?php if (!$isAdmin) { echo $username; } else { echo "Master"; } ?><span>
                    </div>
                    <div class="section-top-border">
					<h3 class="mb-30">Table</h3>
					<div class="progress-table-wrap">
						<div class="progress-table">
                            <div class="table-head">
								<div class="serial">#</div>
								<div class="country">Name</div>
								<div class="visit">Delete</div>
                                <div class="percentage">Roles</div>
                                <div class="percentage">Roles</div>
                            </div>
                            <?php
                                $users = getAllUsers();
                                $ids = getAllIds();
                                for ($i = 0; $i < count($users); $i ++) {
                                    if ($ids[$i] != $userId) {
                                    $_role = getRoleFromUser($ids[$i]);?>
                            
                            <form method="POST" action="loadUpdate.php" onsubmit="clicked<?php echo $i; ?>()">
                                <div class="table-row">
                                    <div class="serial"><?php echo $ids[$i]; ?></div>
                                    <div class="country"><?php echo $users[$i]; ?></div>
                                    <div class="visit">
                                        <select id="a<?php echo $i; ?>" class="nice-select" name="deleteFlag" required="true" form="articleForm" style="width: 100%; margin-bottom: 20px;" onchange="generateMoreSelector()">
                                            <option value="no">No</option>
                                            <option value="yes">Yes</option>
                                        </select>
                                    </div>

                                    <div class="percentage">
                                        <select id="b<?php echo $i; ?>" class="nice-select" name="roleName" required="true" form="articleForm" style="width: 100%; margin-bottom: 20px;" onchange="generateMoreSelector()">
                                            <?php
                                            
                                            $roles = array("administrator", "manager", "user", "guest");

                                            for ($j = 0; $j < count($roles); $j ++) {
                                                if ($roles[$j] != $_role) { ?>
                                                    <option value="<?php echo $roles[$j]; ?>"><?php echo $roles[$j]; ?></option>
                                                    <?php
                                                }
                                            }

                                            ?>
                                            
                                        </select>
                                    </div>

                                    <input type="hidden" name="id" value="<?php echo $ids[$i]; ?>">
                                    <input type="hidden" id="delete<?php echo $i; ?>"   name="delete"  value="">
                                    <input type="hidden" id="role<?php echo $i; ?>"     name="role"    value="">
                                    
                                    <script>
                                        function clicked<?php echo $i; ?>() {
                                            let del = document.getElementById("a<?php echo $i; ?>");
                                            let strDel = del.options[del.selectedIndex].value;
                                            let rol = document.getElementById("b<?php echo $i; ?>");
                                            let strRol = rol.options[rol.selectedIndex].value;
                                            
                                            document.getElementById("delete<?php echo $i; ?>").value = strDel;
                                            document.getElementById("role<?php echo $i; ?>").value = strRol;
                                        }
                                    </script>

                                    <div class="visit"><input type="submit" class="btn" value="Update User"></div>
                                </div>
                            </form>

                            <?php }
                            }
                            ?>
						</div>
					</div>
				</div>
                </div>

            </div>
        </div>
        <!--Hero Area End-->
        <!-- Popular Locations Start -->
        <?php
        $a = false;
        if($a) {
            if($numarticlesUser <=0) {
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
        }else {
        
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
                    
                </div>
            </div>
        </div>
        <?php }
        }?>
       

    </main>
    <footer>

        <?php 
        if(isset($articlesArray))
            echo var_dump($articlesArray); 
        ?>
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