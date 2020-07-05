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

$categories = getcategories();
$subcategories = getSubcategories();

?>
<html class="js sizes customelements history pointerevents postmessage webgl websockets cssanimations csscolumns csscolumns-width csscolumns-span csscolumns-fill csscolumns-gap csscolumns-rule csscolumns-rulecolor csscolumns-rulestyle csscolumns-rulewidth csscolumns-breakbefore csscolumns-breakafter csscolumns-breakinside flexbox picture srcset webworkers sizes customelements history pointerevents postmessage webgl websockets cssanimations csscolumns csscolumns-width csscolumns-span csscolumns-fill csscolumns-gap csscolumns-rule csscolumns-rulecolor csscolumns-rulestyle csscolumns-rulewidth csscolumns-breakbefore csscolumns-breakafter csscolumns-breakinside flexbox picture srcset webworkers" lang="zxx"><head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo $language['createArt_title'] ?></title>
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
  <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHfVOvuyvRGhi41p2KHLbSEbUHPg1buKk&libraries=places"></script>
<script>
	var lat = null;
	var lng = null;
  function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {
        lat: 48,
        lng: 4
      },
      zoom: 4,
      disableDefaultUI: true
    });

  // Create the search box and link it to the UI element.
  var input = document.getElementById('my-input-searchbox');
  var autocomplete = new google.maps.places.Autocomplete(input);
  map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
  var marker = new google.maps.Marker({
    map: map
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



function generateMoreSelector(){
  var value = document.getElementById("article_categorie").value;
  var select = document.getElementById("article_subcategorie");
  if(value!=""){
    select.value = "";
    $(select).find('option').not(':first').remove();

    $.ajax({
      url: 'getSubcategories.php',
      type: 'POST',
      data : {name: value},
      success: function(data) {
        console.log(data);
        if(data != null){
          var arr = JSON.parse(data);
          for(var i = 0; i < arr.length; i++) {
            var obj = arr[i];
            var opt = document.createElement('option');
            opt.value = obj['subcategorie_title'];
            opt.innerHTML = obj['subcategorie_title'];
            select.appendChild(opt);
          }
        }
      }
    })
  }
};

$(document).ready(function(){
  $.noConflict();
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
              <h2><?php echo $language['createArt_yourArt'] ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Hero End -->
    <!-- listing Area Start -->
    <form 
    id="articleForm"
    action="processCreationArticle.php"
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
                  <input type="text" placeholder="<?php echo $language['createArt_arttitle'] ?>" name="article_title" required="true">
                </div>
                <!-- Select job items start -->
                <div class="input-form">
                  <select id="article_categorie" class="nice-select" name="article_categorie" required="true" form="articleForm" style="width: 100%; margin-bottom: 20px;" onchange="generateMoreSelector()">
                    <option value=""><?php echo $language['createArt_cat'] ?></option>
                    <?php
                    foreach($categories as $array){
                      echo "<option value=".$array['categorie_title'].">".$array['categorie_title']."</option>";
                    }
                    ?>
                  </select>

                  <select id="article_subcategorie" class="nice-select" name="article_subcategorie" required="true" form="articleForm" style="width: 100%; margin-bottom: 20px;">
                    <option value=""><?php echo $language['createArt_subcat'] ?></option>

                  </select>
                  <div style="width: 100%; margin-bottom: 20px;">
                    <select id="tags"
                    name="tags"
                    form="articleForm" 
                    multiple class="chosen-select" 
                    style="width: 100%;"
                    data-placeholder="Tags" >
                    <?php

                    foreach($categories as $array){
                      echo "<option value=".$array['categorie_title'].">".$array['categorie_title']."</option>";
                    }

                    foreach($subcategories as $array){
                      echo "<option value=".$array['subcategorie_title'].">".$array['subcategorie_title']."</option>";
                    }
                    ?>

                  </select>
                  <span id="tagsInfo"></span>
                </div>
              </div>

              <div class="select-job-items2">
                <textarea style="min-height: 200px" class="nice-select" name="article_context" cols="40" rows="5" placeholder="<?php echo $language['createArt_artCont'] ?>" required="true"></textarea>
              </div>

            </div>

            <div class="single-listing">
             <input style="right: 7px;" type="file" name="article_img" accept="image/*,video/*" required="true"> 
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
        <input type="hidden" name="articleTags" value="">
        <input type="hidden" name="lat" value="">
        <input type="hidden" name="lng" value="">
      </div>
    </div>
  </div>
</form>
<!-- listing-area Area End -->

</main>
<?php include_once("../Page_Elements/goup.php") ?>
<?php include_once("../Page_Elements/footer.php") ?>

  <!-- JS here -->
  <!-- Jquery Mobile Menu -->
  <script src="../assets/js/jquery.slicknav.min.js"></script>


  <!-- Nice-select, sticky -->
  <script src="../assets/js/jquery.nice-select.min.js"></script>
  <script src="../assets/js/jquery.sticky.js"></script>

  <!-- Jquery Plugins, main Jquery -->  
  <script src="../assets/js/plugins.js"></script>
  <script src="../assets/js/main.js"></script>

</body>

</html>