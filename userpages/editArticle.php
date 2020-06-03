<!DOCTYPE html>
<style>
  #map {
    height: 100%;
  }

  html,
  body {
    height: 100%; 
    margin: 0;
    padding: 0;
  }

  #my-input-searchbox {
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16), 0 0 0 1px rgba(0, 0, 0, 0.08);
    font-size: 15px;
    border-radius: 3px;
    border: 0;
    margin-top: 10px;
    width: 270px;
    height: 40px;
    text-overflow: ellipsis;
    padding: 0 1em;
  }
  input{
    color: #fff;
    border: none;
    font-size: 16px;
    font-weight: 500;
    width: 100%;
    height: 38px;
    background: #ff3d1c;
    border-radius: 30px;
    text-align: center;
    line-height: 35px;
    cursor: pointer;
  }
</style>


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

$articleid = $_GET['id'];
if($articleid == "" && $articleid == null){
  $title = "Invalid Arguments";
  $info = "Invalid arguments found";
  header("Location: ../responsePage.php?title=$title&info=$info");
  exit();
}
$article = getArticle($articleid);
$categorieID = getcategoryName($article['article_categorie_id']);
$subcategorieID = getsubcategoryName($article['article_subcategorie_id']);
$fileDetails = getFileDetails($article['article_image']);
$categories = getcategories();
$subcategories = getSubcategories();

$_SESSION['article'] = $article;
?>
<html class="js sizes customelements history pointerevents postmessage webgl websockets cssanimations csscolumns csscolumns-width csscolumns-span csscolumns-fill csscolumns-gap csscolumns-rule csscolumns-rulecolor csscolumns-rulestyle csscolumns-rulewidth csscolumns-breakbefore csscolumns-breakafter csscolumns-breakinside flexbox picture srcset webworkers sizes customelements history pointerevents postmessage webgl websockets cssanimations csscolumns csscolumns-width csscolumns-span csscolumns-fill csscolumns-gap csscolumns-rule csscolumns-rulecolor csscolumns-rulestyle csscolumns-rulewidth csscolumns-breakbefore csscolumns-breakafter csscolumns-breakinside flexbox picture srcset webworkers" lang="zxx"><head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo $language['createArt_edit'] ?></title>
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
  <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHfVOvuyvRGhi41p2KHLbSEbUHPg1buKk&libraries=places"></script>
<script>
  var myLatLon = new google.maps.LatLng(<?php echo $fileDetails['latitude']; ?>, <?php echo $fileDetails['longitude']; ?>);
  var lat = <?php echo $fileDetails['latitude']; ?>;
  var lng = <?php echo $fileDetails['longitude']; ?>;
  function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: myLatLon,
      zoom: 16,
      disableDefaultUI: true
    });

  // Create the search box and link it to the UI element.
  var input = document.getElementById('my-input-searchbox');
  var autocomplete = new google.maps.places.Autocomplete(input);
  map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
  var marker = new google.maps.Marker({
    position: myLatLon,
    map: map,
    title : "Location"
  });

  // Bias the SearchBox results towards current map's viewport.
  autocomplete.bindTo('bounds', map);
  // Set the data fields to return when the user selects a place.
  autocomplete.setFields(
    ['address_components', 'geometry', 'name']);

  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      console.log("Returned place contains no geometry");
      return;
    }
    var bounds = new google.maps.LatLngBounds();
    marker.setPosition(place.geometry.location);

    if (place.geometry.viewport) {
      // Only geocodes have viewport.
      bounds.union(place.geometry.viewport);
    } else {
      bounds.extend(place.geometry.location);
    }
    map.fitBounds(bounds);
    lat = marker.getPosition().lat();
    lng = marker.getPosition().lng();
  });
}
document.addEventListener("DOMContentLoaded", function(event) {
  initAutocomplete();
});

function FormLoginValidator(form){
  if(lat == null || lng == null){
   document.getElementById("mapsinfo").innerHTML = "Please select a area in the map";
   document.getElementById("mapsinfo").style.color = 'red';
   return false;
 } else {
   document.getElementById("mapsinfo").innerHTML = "";
   form.lat.value = lat;
   form.lng.value = lng;

   var multipleSelection = document.getElementById('chosen-choices').getElementsByTagName('span');
   if(multipleSelection.length < 1){
    document.getElementById("tagsInfo").innerHTML = "Please select at least one tag";
    document.getElementById("tagsInfo").style.color = 'red';
    return false;
  }else{
    var tagsText = "";
    for(var i = 0 ; i < multipleSelection.length; i++){
      tagsText += multipleSelection[i].innerHTML + ",";
    }
    form.articleTags.value = tagsText;
    return true;
  }
}
}

$(function(){
  $(".chosen-select").chosen();
  $(".chosen-choices").attr('id', 'chosen-choices');;
});

function changeLanguage(type){
  window.location.href = "createArticle.php?lang=" + type;
}
</script>
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
              <h2>Edit article</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Hero End -->
    <!-- listing Area Start -->
    <form 
    id="articleForm"
    action="processEditArticle.php" 
    onsubmit="return FormLoginValidator(this)"
    name="FormArticle"
    enctype="multipart/form-data"
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
            <div class="category-listing mb-50">
              <!-- single one -->
              <div class="single-listing">
                <!-- input -->
                <div class="input-form">
                  <input type="text" placeholder="Article title" name="article_title" required="true" value="<?php echo $article['article_title'] ?>">
                </div>
                <!-- Select job items start -->
                <div class="input-form">
                  <select id="article_categorie" class="nice-select" name="article_categorie" disabled="true" form="articleForm" style="width: 100%; margin-bottom: 20px;" onchange="generateMoreSelector()">
                    <option value=""><?php echo $categorieID ?></option>
                  </select>

                  <select id="article_subcategorie" class="nice-select" name="article_subcategorie" disabled="true" form="articleForm" style="width: 100%; margin-bottom: 20px;">
                    <option value=""><?php echo $subcategorieID ?></option>

                  </select>


                  <div class="select-job-items2">
                    <textarea style="min-height: 200px" class="nice-select" name="article_context" cols="40" rows="5" placeholder="<?php echo $language['createArt_artCont'] ?>" required="true"><?php echo $article['article_context'] ?></textarea>
                  </div>

                  <div class="select-job-items2">
                    <div style="margin-bottom: 20px;">
                      <select id="tags"
                      name="tags"
                      multiple class="chosen-select" 
                      style="width: 100%;"
                      data-placeholder="Tags" >
                      <?php
                      $tags = $article['tags'];
                      $tagsArray = explode(",",$tags);

                      foreach($categories as $array){
                        if(in_array($array['categorie_title']  , $tagsArray)){
                          echo "<option selected value=".$array['categorie_title'].">".$array['categorie_title']."</option>";
                        }else{
                          echo "<option value=".$array['categorie_title'].">".$array['categorie_title']."</option>";
                        }
                      }
                      foreach($subcategories as $array){
                        if(in_array($array['subcategorie_title']  , $tagsArray)){
                          echo "<option selected value=".$array['subcategorie_title'].">".$array['subcategorie_title']."</option>";
                        }else{
                          echo "<option value=".$array['subcategorie_title'].">".$array['subcategorie_title']."</option>";
                        }
                      }
                      ?>

                    </select>
                    <span id="tagsInfo"></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="single-listing">
             <input type="submit" class="btn list-btn mt-20" value="<?php echo $language['createArt_submit'] ?>">
           </div>
         </div>
         <!-- Job Category Listing End -->
       </div>
       <!-- Right content -->
       <div class="col-xl-8 col-lg-8 col-md-6">
        <div class="row">
          <div class="col-lg-12">
            <div class="count mb-35">
              <span>Google Maps</span>
              <br>
              <span id="mapsinfo"></span>
            </div>
          </div>
        </div>
        <input style="background: #fff; color: #000" id="my-input-searchbox" type="text" placeholder="<?php echo $language['createArt_search'] ?>">
        <div id="map"></div>
        <input type="hidden" name="lat" value="">
        <input type="hidden" name="lng" value="">
        <input type="hidden" name="articleTags" value="">
      </div>
    </div>
  </div>
</form>
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