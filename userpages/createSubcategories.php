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
  if($role != "manager" && $role != "administrator"){
    header("Location: ../noPrivilege.php");
    exit();
  }

  $categories = getcategories();

?>

<html class="js sizes customelements history pointerevents postmessage webgl websockets cssanimations csscolumns csscolumns-width csscolumns-span csscolumns-fill csscolumns-gap csscolumns-rule csscolumns-rulecolor csscolumns-rulestyle csscolumns-rulewidth csscolumns-breakbefore csscolumns-breakafter csscolumns-breakinside flexbox picture srcset webworkers sizes customelements history pointerevents postmessage webgl websockets cssanimations csscolumns csscolumns-width csscolumns-span csscolumns-fill csscolumns-gap csscolumns-rule csscolumns-rulecolor csscolumns-rulestyle csscolumns-rulewidth csscolumns-breakbefore csscolumns-breakafter csscolumns-breakinside flexbox picture srcset webworkers" lang="zxx"><head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Create Subcategories</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="manifest" href="site.webmanifest">
  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

  <!-- CSS here -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/css/slicknav.css">
  <link rel="stylesheet" href="assets/css/flaticon.css">
  <link rel="stylesheet" href="assets/css/price_rangs.css">
  <link rel="stylesheet" href="assets/css/animate.min.css">
  <link rel="stylesheet" href="assets/css/magnific-popup.css">
  <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="assets/css/themify-icons.css">
  <link rel="stylesheet" href="assets/css/slick.css">
  <link rel="stylesheet" href="assets/css/nice-select.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

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
                    <li class="login"><a href="#">
                      <i class="ti-user"></i> Sign out</a>
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
              </ul></div><div class="slicknav_menu"><a href="#" aria-haspopup="true" role="button" tabindex="0" class="slicknav_btn slicknav_collapsed" style="outline: none;"><span class="slicknav_menutxt">MENU</span><span class="slicknav_icon"><span class="slicknav_icon-bar"></span><span class="slicknav_icon-bar"></span><span class="slicknav_icon-bar"></span></span></a><ul class="slicknav_nav slicknav_hidden" aria-hidden="true" role="menu" style="display: none;">                                                                                                                                     
                <li><a href="index.html" role="menuitem" tabindex="-1">Home</a></li>
                <li><a href="about.html" role="menuitem" tabindex="-1">About</a></li>
                <li><a href="catagori.html" role="menuitem" tabindex="-1">Catagories</a></li>
                <li><a href="listing.html" role="menuitem" tabindex="-1">Listing</a></li>
                <li class="slicknav_collapsed slicknav_parent"><a href="#" role="menuitem" aria-haspopup="true" tabindex="-1" class="slicknav_item slicknav_row" style="outline: none;"></a><a href="#" tabindex="-1">Page</a>
                  <span class="slicknav_arrow">+</span><ul class="submenu slicknav_hidden" role="menu" aria-hidden="true" style="display: none;">
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
  <div class="hero-area3 hero-overly2 d-flex align-items-center ">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">
          <div class="hero-cap text-center pt-50 pb-20">
            <h2>New subcategory</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Hero End -->
  <!-- listing Area Start -->
  <form
  action="processSubcategoriesCreation.php"
  name="FormArticle"
  method="post" >
  <div class="listing-area pt-120 pb-120">
    <div class="container">
      <div class="row">
        <!-- Left content -->
        <div class="col-xl-4 col-lg-4 col-md-6">
          <div class="row">
            <div class="col-12">
              <div class="small-section-tittle2 mb-45">
                <h4>Details</h4>
              </div>
            </div>
          </div>
          <!-- Job Category Listing start -->
          <div class="category-listing mb-50">
            <!-- single one -->
            <div class="single-listing">
              <div class="input-form">
                <select id="article_categorie" class="nice-select" name="article_categorie" required="true" style="width: 100%; margin-bottom: 20px;">
                  <option value="">Choose Category</option>
                  <?php
                  foreach($categories as $array){
                    echo "<option value=".$array['categorie_title'].">".$array['categorie_title']."</option>";
                  }
                  ?>
                </select>
            </div>
              <div class="input-form">
                <input type="text" placeholder="New subcategory title" name="subcategory_title" pattern="[A-Za-z]+" required="true">

              </div>            



            <div class="single-listing">
              <input type="submit" class="btn list-btn mt-20" value="submit">
            </div>
          </div>

        </div>
      </div>
      <div class="col-xl-8 col-lg-8 col-md-6">
        <div class="row">
          <div class="col-lg-12">
            <div class="count mb-35">
              <img style="width: 100%"  src="assets/img/hero/h1_hero.jpg" alt="A image"/>  
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- listing-area Area End -->

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
  <!-- Scroll Up -->
  <div id="back-top" style="display: block;">
    <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
  </div>



</body>

</html>