<!DOCTYPE html>

<?php
require_once( "../Lib/lib.php" );
require_once("../languageAddon.php");

$serverName = $_SERVER['SERVER_NAME'];

$serverPortSSL = 443;
$serverPort = 80;

$name = webAppName();

$nextUrl = "https://" . $serverName . ":" . $serverPortSSL . $name . "processFormLogin.php";


?>

<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $language['log_title'] ?></title>
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
</head>
<script>
    function changeLanguage(type){
        window.location.href = "formLogin.php?lang=" + type;
    }
</script>
<body>
  <?php include_once("../Page_Elements/preloader.php") ?>
  
  <main>
    <?php include_once("../Page_Elements/header.php") ?>
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
       margin: 4px 2px;
       cursor: pointer;
   }

   .inpt {
    padding: 12px 20px;
    margin: 8px 0;
    box-sizing: border-box;
    border: none;
    border-radius: 4px;
}
</style>

<!-- Hero Area Start-->
<div class="slider-area hero-overly">
    <div class="single-slider hero-overly  slider-height d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-9">
                    <!-- Hero Caption -->
                    <div class="hero__caption">
                        <span style="color: orangered"><?php echo $language['log_title'] ?></span>
                    </div>
                    <!--Hero form -->
                    <form
                    action="processFormLogin.php"
                    onsubmit="return FormLoginValidator(this)"
                    method="POST">

                    <div style="text-align: center">
                       <input class="inpt" type="text" name="username" placeholder="<?php echo $language['log_name'] ?>" required> <br />
                       <input class="inpt" type="password" name="password" placeholder="<?php echo $language['log_pass'] ?>" required> <br />
                       <div style="background-color: red; font-size: 12px; display: inline-block;color: white">
                        <?php if(isset($_GET['returning'])) echo $_GET['returning']; ?>
                    </div><br />
                    <input class="btn" alt=""type="submit" value="<?php echo $language['signin'] ?>"> <br />
                    <input class="btn" alt=""type="reset" value="<?php echo $language['clear'] ?>"> <br />
                </div>	
            </form>	
        </div>
    </div>
</div>

</div>
</div>


</main>
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