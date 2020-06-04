<!DOCTYPE html>
<?php
if (!isset($_SESSION) ) {
  session_start();
}

require_once("../Lib/lib.php");
require_once("../Lib/db.php");
include( "../ensureAuth.php" );

$isAdmin = false;

$userId = $_SESSION['id'];
$username = $_SESSION['username'];
$role = getRoleFromUser($userId);

$isAdmin = false;
if ($role == "administrator") { $isAdmin = true; }
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
                                            <li class="login"><a href="../userpages/profilepage.php">
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
        <div class="nada">
            <div class="nada">
                <div class="container" style="width: 100%; height: 500px; text-align: center;">

                    <div class="section-top-border">
					<h3 class="mb-30">Table</h3>
                    
                    <div class="section-tittle text-center mb-80">
                            <span><?php if (!$isAdmin) { echo "No permissions to be in this page"; } else { echo "Manage Categories"; } ?></span>
                    </div>
                    
                    <?php if ($isAdmin) {?>
                        <table id="customers">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Delete</th>
                                <th>Submit</th>
                            </tr>
                            <?php 
                            $cat_ = getcategories();
                            $counter = 0;
                            foreach ($cat_ as $i) { ?>
                                <form method="POST" action="updateCategory.php">
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><input class="inpt" type="text" name="cate" value="<?php echo $i['categorie_title']; ?>" required></td>
                                        <input type="hidden" name="oldcate" value="<?php echo $i['categorie_title'];?>">
                                        <td><input type="checkbox" name="delete" value="yes"></td>
                                        
                                        <td><div class="visit"><input type="submit" class="btn" value="Update Category" ></div></td>
                                        <?php $counter ++; ?>
                                    </tr>
                                </form>
                            <?php } ?>
                            <form method="POST" action="insertCategory.php">
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><input class="inpt" type="text" name="newCate" placeholder="Insert New Category Here" required></td>
                                    <td><p style="text-align: center;">-</p></td>
                                    <td><div class="visit"><input type="submit" class="btn" value="Insert Category" ></div></td>
                                </tr>
                            </form>
                            
                        </table>
                    <?php } ?>
						
                </div>
                
                </div>

            </div>
        </div>
        
        <style>
        #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
        }
        </style>

        <!--Hero Area End-->
        <!-- Popular Locations Start -->


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