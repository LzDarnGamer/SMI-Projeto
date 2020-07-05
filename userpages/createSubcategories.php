<!DOCTYPE html>
<?php
  if (!isset($_SESSION) ) {
  session_start();
  }

  require_once("../Lib/lib.php");
  require_once("../Lib/db.php");
  include( "../ensureAuth.php" );
  require_once("../languageAddon.php");
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
  <title><?php echo $language['createsub_newsub'] ?></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="manifest" href="site.webmanifest">
  <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico">

  <!-- CSS here -->
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="../assets/css/slicknav.css">
  <link rel="stylesheet" href="../assets/css/flaticon.css">
  <link rel="stylesheet" href="../assets/css/price_rangs.css">
  <link rel="stylesheet" href="../assets/css/animate.min.css">
  <link rel="stylesheet" href="../assets/css/magnific-popup.css">
  <link rel="stylesheet" href="../assets/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="../assets/css/themify-icons.css">
  <link rel="stylesheet" href="../assets/css/slick.css">
  <link rel="stylesheet" href="../assets/css/nice-select.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <?php include_once("../Page_Elements/preloader.php") ?>
  
  <main>
    <?php include_once("../Page_Elements/header.php") ?>

  <!-- Hero Start-->
  <div class="hero-area3 hero-overly2 d-flex align-items-center ">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">
          <div class="hero-cap text-center pt-50 pb-20">
            <h2><?php echo $language['createsub_newsub'] ?></h2>
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
                <h4><?php echo $language['createArt_details'] ?></h4>
              </div>
            </div>
          </div>
          <!-- Job Category Listing start -->
          <div class="category-listing mb-80">
            <!-- single one -->
            <div class="single-listing">
              <div class="input-form">
                <select id="article_categorie" class="nice-select" name="article_categorie" required="true" style="width: 100%; margin-bottom: 20px;">
                  <option value=""><?php echo $language['createArt_cat'] ?></option>
                  <?php
                  foreach($categories as $array){
                    echo "<option value=".$array['categorie_title'].">".$array['categorie_title']."</option>";
                  }
                  ?>
                </select>
                <br><br>
            </div>
              <div class="input-form">
                <input type="text" placeholder="<?php echo $language['createsub_newsubtitle'] ?>" name="subcategory_title" pattern="[A-Za-z]+" required="true">

              </div>            



            <div class="single-listing">
              <input type="submit" class="btn list-btn mt-20" value="<?php echo $language['createArt_submit'] ?>">
            </div>
          </div>

        </div>
      </div>
      <div class="col-xl-8 col-lg-8 col-md-6">
        <div class="row">
          <div class="col-lg-12">
            <div class="count mb-35">
              <img style="width: 100%"  src="../assets/img/hero/h1_hero.jpg" alt="A image"/>  
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- listing-area Area End -->

</main>
<?php include_once("../Page_Elements/goup.php") ?>
<?php include_once("../Page_Elements/footer.php") ?>

<!-- JS here -->
<!-- All JS Custom Plugins Link Here here -->
<script src="../assets/js/vendor/modernizr-3.5.0.min.js"></script>
<!-- Jquery, Popper, Bootstrap -->
<script src="../assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<!-- Jquery Mobile Menu -->
<script src="../assets/js/jquery.slicknav.min.js"></script>

<!-- Jquery Slick , Owl-Carousel Plugins -->
<script src="../assets/js/owl.carousel.min.js"></script>
<script src="../assets/js/slick.min.js"></script>
<!-- One Page, Animated-HeadLin -->
<script src="../assets/js/wow.min.js"></script>
<script src="../assets/js/animated.headline.js"></script>
<script src="../assets/js/jquery.magnific-popup.js"></script>

<!-- Nice-select, sticky -->
<script src="../assets/js/jquery.nice-select.min.js"></script>
<script src="../assets/js/jquery.sticky.js"></script>

<!-- contact js -->
<script src="../assets/js/contact.js"></script>
<script src="../assets/js/jquery.form.js"></script>
<script src="../assets/js/jquery.validate.min.js"></script>
<script src="../assets/js/mail-script.js"></script>
<script src="../assets/js/jquery.ajaxchimp.min.js"></script>

<!-- Jquery Plugins, main Jquery -->  
<script src="../assets/js/plugins.js"></script>
<script src="../assets/js/main.js"></script>



</body>

</html>