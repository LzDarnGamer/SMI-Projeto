<?php
    require_once("../Lib/lib.php");
    require_once("../Lib/db.php");
    include( "../ensureAuth.php" );
    require_once("../languageAddon.php");

    $userId = $_SESSION['id'];
    $username = $_SESSION['username'];

    $loggedIn = false;
    if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
        $loggedIn = true;
    }
    
    $users = getAllIds();
    $articlesArray = getAllArticles();
    
    /*for ($i = 0; $i < sizeof($users); $i ++) {
        $articlesArray = getArticles($users[$i]);
    }*/

    $FilterCategory = isset($_GET['FilterCategory']) ? $_GET['FilterCategory'] : null;
    $FilterSubCategory = isset($_GET['FilterSubCategory']) ? $_GET['FilterSubCategory'] : null;
    $FilterUsername = isset($_GET['FilterUsername']) ? $_GET['FilterUsername'] : null;
?>
<html class="js sizes customelements history pointerevents postmessage webgl websockets cssanimations csscolumns csscolumns-width csscolumns-span csscolumns-fill csscolumns-gap csscolumns-rule csscolumns-rulecolor csscolumns-rulestyle csscolumns-rulewidth csscolumns-breakbefore csscolumns-breakafter csscolumns-breakinside flexbox picture srcset webworkers" lang="zxx"><head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> <?php echo $language['feed_yourfeed'] ?> </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.css">
    <link rel="stylesheet" href="../assets/css/animate.min.css">
    <link rel="stylesheet" href="../assets/css/magnific-popup.css">
    <link rel="stylesheet" href="../assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/slick.css">
    <link rel="stylesheet" href="../assets/css/nice-select.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">

</head>

<body style="overflow: visible;">

<style>

.autocomplete {
  /*the container must be positioned relative:*/
  position: relative;
  display: inline-block;
}


.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff;
  border-bottom: 1px solid #d4d4d4;
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9;
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important;
  color: #ffffff;
}
</style>
<script>
    function changeLanguage(type){
        window.location.href = "articleFeed.php?lang=" + type;
    }
    function addLike(div, id){
        if(div.getElementsByTagName("i")[0].className === "fa fa-eye-slash"){

            $.ajax({
                url: 'changeVisibility.php',
                type: 'POST',
                data : {postID: id, value: 1},
                success: function(data) {
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


<?php //include_once("../Page_Elements/preloader.php") ?>
<main>
<?php include_once("../Page_Elements/header.php") ?>
<!-- Hero Start-->
<div class="hero-area2  slider-height2 hero-overly2 d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="hero-cap text-center pt-50">
                    <h2><?php echo $language['feed_yourfeed'] ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Hero End -->
<!--================Blog Area =================-->
<section class="blog_area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="blog_left_sidebar">
                    <?php  

                    $counter = 0;

                    for ($i = 0; $i < sizeof($articlesArray); $i ++) {

                        if((!$loggedIn && $articlesArray[$i]['visible'] != 0) || ($loggedIn)) {
                            if (isset($FilterCategory)) {
                                if (getcategoryName($articlesArray[$i]['article_categorie_id']) != $FilterCategory) {
                                    $counter ++;
                                    continue;
                                }
                            } else if (isset($FilterSubCategory)) {
                                if (getsubcategoryName($articlesArray[$i]['article_subcategorie_id']) != $FilterSubCategory) {
                                    $counter ++;
                                    continue;
                                }
                            } else if (isset($FilterUsername)) {
                                if (getUser($articlesArray[$i]['poster_id']) != $FilterUsername) {
                                    $counter ++;
                                    continue;
                                }
                            }
                            

                            $description = (mb_strlen($articlesArray[$i]['article_context'], 'UTF-8') > 80) ? mb_substr($articlesArray[$i]['article_context'], 0, 80, 'UTF-8') . '...' : $articlesArray[$i]['article_context'];
                    ?>
                        <article class="blog_item">
                            <div class="blog_item_img">
                                <img class="card-img rounded-0" style="border: 3px solid;" src="../userpages/showFileImage.php?id=<?php echo $articlesArray[$i]['article_image']; ?>&size=full" alt="">
                                <!-- Data -->
                                <div class="blog_item_date">
                                    <h3><?php 
                                        $date=date_create($articlesArray[$i]['article_timestamp']);
                                        echo date_format($date,"d"); ?></h3>
                                    <p>
                                        <?php echo date_format($date,"M")." '".date_format($date,"y"); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="blog_details">
                                <!-- Title -->
                                <a class="d-inline-block" href="<?php echo "../userpages/article.php?type=view&id={$articlesArray[$i]['article_id']}"; ?>">
                                    <h2><?php echo $articlesArray[$i]['article_title']; ?></h2>
                                </a>
                                <!-- Descricao -->
                                <p><?php echo $description; ?></p>
                                <p>
                                    <form method="POST" action="../comments/AddComment.php" id="com<?php echo $i; ?>">
                                        <textarea style="width: 100%;" maxlength="95" name="comment" form="com<?php echo $i; ?>" required></textarea>
                                        <input type="hidden" value="<?php echo $userId; ?>" name="posterId">
                                        <input type="hidden" value="<?php echo $articlesArray[$i]['article_id']; ?>" name="articleId">
                                        <input style="margin-top: 10px; float: right; width: 100px; cursor: pointer;" type="submit" value="<?php echo $language['feed_comment'] ?>">
                                    </form>
                                </p>
                                
                                <br>

                                <?php
                                $comments = getComments($articlesArray[$i]['article_id']);
                                if (isset($comments)) {
                                    if (sizeof($comments) > 0) {

                                        echo "<a class=\"d-inline-block\" style=\"margin-bottom: 10px;\"> ". $language['feed_comments'] . " </a>";

                                        for ($j = 0; $j < sizeof($comments); $j ++) {

                                            echo "<p style=\"background-color: coral;\">";
                                                echo $comments[$j]['text'];
                                                echo "<a style=\"float: right; margin: 0px 10px 0px 0px\">";
                                                    echo "<small>" . "by " . getNameFromUser($comments[$j]['userId']) . " on " . $comments[$j]['timestamp'] . "</small>";
                                                echo "</a>";
                                            echo "</p>";
        
                                        }
                                    }
                                }
                                ?>

                                <ul class="blog-info-link">
                                    <li><a><i class="fa fa-user"></i><?php
                                        echo getNameFromUser($articlesArray[$i]['poster_id']);
                                    ?></a></li>
                                    <li><a><i class="fa fa-comments"></i><?php echo sizeof($comments). " " . $language['feed_comments']?> </a></li>
                                    <li><a  style="cursor: pointer;" onclick="addLike(this, <?php echo $articlesArray[$i]['article_id'] ?>)"><i class="fa fa-heart-o"></i><?php echo $articlesArray[$i]['likes']. " Likes"?> </a></li>
                                </ul>
                            </div>
                        </article>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
      
            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                    <aside class="single_sidebar_widget search_widget">
                        <form autocomplete="off" method="GET">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="autocomplete" style="width:100%;">
                                        <input id="myInput" type="text" class="form-control" name="FilterUsername" 
                                        placeholder="<?php echo $language['feed_searchuser'] ?>" 
                                        onfocus="this.placeholder = ''" 
                                        onblur="this.placeholder = <?php echo $language['feed_searchuser']?>"> 
                                    </div>
                                </div>
                            </div>
                            <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn" type="submit"><?php echo $language['feed_search']; ?></button>
                        </form>
                    </aside>
                    

                    <!-- Category -->
                    <aside class="single_sidebar_widget post_category_widget">
                        <h4 class="widget_title"><?php echo $language['feed_category']?></h4>
                        <ul class="list cat-list">
                            <form method="GET">
                                <?php
                                $cc = getcategories();
                                foreach ($cc as $cat) {
                                ?>
                                    <li>
                                        <input style="cursor: pointer; width: 100%;" name="FilterCategory" type="submit" class="d-flex" value="<?php echo $cat['categorie_title']; ?>">
                                    </li>
                                <?php
                                }
                                ?>
                            </form>
                            
                        </ul>
                    </aside>

                    <!-- Sub Categories -->
                    <aside class="single_sidebar_widget tag_cloud_widget">
                        <h4 class="widget_title"><?php echo $language['feed_subcategory'] ?></h4>
                        <form method="GET">
                            <ul class="list">
                                <?php
                                $subcc = getSubcategories();
                                foreach ($subcc as $subCat) {
                                ?>
                                <li>
                                    <input type="submit" style="cursor: pointer; margin: 3px; " name="FilterSubCategory" value="<?php echo $subCat['subcategorie_title']; ?>">
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </form>
                    </aside>

                    


                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">Newsletter</h4>

                        <form method="POST" action="subscribe.php">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" onfocus="this.placeholder = ''" onblur="this.placeholder = '<?php echo $language['m_subscribe2'] ?>'" placeholder="<?php echo $language['m_subscribe2'] ?>" required="">
                            </div>
                            <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn" type="submit">Subscribe</button>
                        </form>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================Blog Area =================-->

</main>
<?php include_once("../Page_Elements/footer.php") ?>
<?php include_once("../Page_Elements/goup.php") ?>

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

<!-- Nice-select, sticky -->
<script src="../assets/js/jquery.nice-select.min.js"></script>
<script src="../assets/js/jquery.sticky.js"></script>
<script src="../assets/js/jquery.magnific-popup.js"></script>

<!-- contact js -->
<script src="../assets/js/contact.js"></script>
<script src="../assets/js/jquery.form.js"></script>
<script src="../assets/js/jquery.validate.min.js"></script>
<script src="../assets/js/mail-script.js"></script>
<script src="../assets/js/jquery.ajaxchimp.min.js"></script>

<!-- Jquery Plugins, main Jquery -->	
<script src="../assets/js/plugins.js"></script>
<script src="../assets/js/main.js"></script>
<script>
    var countries = [<?php 
    $allUsers = getAllUsers ();
    for ($i = 0; $i < sizeof($allUsers); $i ++) {
        if ($i != sizeof($allUsers) - 1) {
            echo "'" . $allUsers[$i] . "', ";
        } else {
            echo "'" . $allUsers[$i] . "'";
        }
    }
    ?>];
    function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
}
autocomplete(document.getElementById("myInput"), countries);
</script>

</body></html>