<!DOCTYPE html>
<?php 
require_once("languageAddon.php");
?>
<html class="no-js" lang="zxx">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo $language['noperm_title'] ?></title>
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
<script>
  function changeLanguage(type){
    window.location.href = "noPrivilege.php?lang=" + type;
  }
</script>
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
                    <li><a href="#"><?php echo $language['language'] ?></a>
                      <ul class="submenu">
                        <li><a href="javascript:changeLanguage('pt')">Português</a></li>
                        <li><a href="javascript:changeLanguage('en')">English</a></li>
                        <li><a href="javascript:changeLanguage('fr')">Français</a></li>
                      </ul>
                    </li>               
                    <li><a href="landingpage.php"><?php echo $language['home'] ?></a></li>
                    <li><a href="about.php"><?php echo $language['about'] ?></a></li>

                    <?php 
                    if(!isset($_SESSION['id'])){ ?>
                      <li id="signin" class="login"><a href="Login_Registo/formLogin.php">
                        <i class="ti-user"></i><?php echo $language['signin'] ?></a>
                      </li>
                      <li class="login"><a href="Login_Registo/formRegister.php">
                        <i class="ti-user"></i><?php echo $language['register'] ?></a>
                      </li>
                    <?php  }else{ ?>
                      <li class="login"><a href="userpages/profilepage.php">
                        <i class="ti-user"></i><?php echo $language['me'] ?></a>
                      </li>
                      <li class="login"><a href="logout.php">
                        <i class="ti-user"></i><?php echo $language['signout'] ?></a>
                      </li>
                    <?php } ?>
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
  <div class="hero-area3 hero-overly2 d-flex align-items-center ">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">
          <div class="hero-cap text-center pt-50 pb-20">
            <h2><?php echo $language['noperm_text'] ?></h2>

            <script>
              function goback () { window.location = "landingpage.php"; }
            </script>
            <input class="btn" type="button" value="Go to main page" onclick="goback()"><br>
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
              <p ><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> <?php echo $language['copyright'] ?> 
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer End-->
  </footer>


</body>

</html>