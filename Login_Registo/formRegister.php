<!DOCTYPE html>
<?php
require_once("../Lib/lib.php");
require_once("../Lib/db.php");
require_once("../languageAddon.php");
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $language['res_title'] ?> </title>
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
                                <span style="color: orangered"><?php echo $language['res_reg'] ?></span>
                            </div>
                            <!--Hero form -->
                            <form 
                                action="processRegisterRequest.php"
                                name="FormLogin"
                                onsubmit="return checkPassword(this)" 
                                method="post">
                                <div style="text-align: center">
									<input class="inpt" type="text" 
                                                        name="name" 
                                                        placeholder="<?php echo $language['res_name'] ?>"
                                                        required="true" 
                                                        onblur="nameCheck(this)">  <div id="nameCheck"></div> 

									<input class="inpt" type="email" 
                                                        name="email" 
                                                        placeholder="<?php echo $language['res_pass'] ?>"
                                                        required="true" 
                                                        onblur="emailCheck(this)">  <div id="emailCheck"></div> 
									<input class="inpt" type="password" 
                                                        name="password"
                                                        id="password"
                                                        required="true"
                                                        placeholder="Password"> <br />
									<input class="inpt" type="password" 
                                                        name="repassword"
                                                        id="repassword"
                                                        required="true" 
                                                        placeholder="<?php echo $language['res_conpass'] ?>"> <div id="passwordCheck"></div> <br/><br/>
									<img class="captcha-image" style="border: 1px solid black" src="captcha.php" alt="catcha image"
                                    width="200" height="50"> <br />
									<input class="inpt" id="captcha" type="captcha" name="captcha" placeholder="captcha" required="true"> <br />
									<input class="btn" alt=""type="submit" value="<?php echo $language['res_reg'] ?>">
									<input class="btn" alt=""type="reset" value="Reset">
									<input class="btn refresh-captcha" type="button" value="<?php echo $language['res_refresh'] ?>">
                                </div>	
                            </form>	
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--Hero Area End-->
    </main>

    <script>
	document.getElementById('captcha').value = "";
	var refreshButton = document.querySelector(".refresh-captcha");
	refreshButton.onclick = function() {
	  document.querySelector(".captcha-image").src = 'captcha.php?' + Date.now();
	}

	function nameCheck(e){
		if(e.value!=""){
			$.ajax({
	        url: 'checkfunctions.php',
	        type: 'POST',
		    data : {field:"name", value: e.value},
			success: function(data) {
		    	if(data === "true"){
		    		document.getElementById("nameCheck").innerHTML = "User available";
		    		document.getElementById("nameCheck").style.color = 'lime';
		    	}else{
		   			document.getElementById("nameCheck").innerHTML = "User not available";
		    		document.getElementById("nameCheck").style.color = 'red';
		    	}
	        }
	    	})
    	}else{
    		document.getElementById("nameCheck").innerHTML = "";
    	}
	};



    function emailCheck(e){
    	var pattern = /[^@\s]+@[^@\s]+\.[^@\s]+$/
    	if(pattern.test(e.value)){
			$.ajax({
	        url: 'checkfunctions.php',
	        type: 'POST',
		    data : {field:"email", value: e.value},
			success: function(data) {
	        	if(data === "true"){
	        		document.getElementById("emailCheck").innerHTML = "Email available";
	        		document.getElementById("emailCheck").style.color = 'lime';
	        	}else{
	       			document.getElementById("emailCheck").innerHTML = "Email not available";
	        		document.getElementById("emailCheck").style.color = 'red';
	        	}
	        }
	    	})
		}else{
			document.getElementById("emailCheck").innerHTML = "";
		}
    };

    function checkPassword(form) {
        password1 = form.password.value; 
		password2 = form.repassword.value;
		if(password1 != password2){
			document.getElementById("passwordCheck").innerHTML = "Passwords don't match";
			document.getElementById("passwordCheck").style.color = 'red';
			return false;
		}
		return true;
    }
    
    function changeLanguage(type){
           window.location.href = "formRegister.php?lang=" + type;
    }
</script>

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