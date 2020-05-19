<!doctype html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Directory HTML-5 Template </title>
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
                                  <a href="index.html"><img src="assets/img/logo/logo.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-8">
                                <!-- Main-menu -->
                                <div class="main-menu f-right d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">                                                                                                                                     
                                            <li><a href="index.html">Home</a></li>
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
                                <span style="color: orangered">Register</span>
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
                                                        placeholder="Your Name"
                                                        required="true" 
                                                        onblur="nameCheck(this)"> <br /> <div id="nameCheck"></div> <br />

									<input class="inpt" type="email" 
                                                        name="email" 
                                                        placeholder="Your e-mail"
                                                        required="true" 
                                                        onblur="emailCheck(this)"> <div id="emailCheck"></div> <br />
									<input class="inpt" type="password" 
                                                        name="password"
                                                        id="password"
                                                        required="true"
                                                        placeholder="Password"> <br />
									<input class="inpt" type="password" 
                                                        name="repassword"
                                                        id="repassword"
                                                        required="true" 
                                                        placeholder="Confirm Password"> <br /> <div id="passwordCheck"></div> <br />
									<img class="captcha-image" style="border: 1px solid black" src="captcha.php" alt="catcha image"> <br />
									<input class="inpt" id="captcha" type="captcha" name="captcha" placeholder="captcha" required="true"> <br />
									<input class="btn" alt=""type="submit" value="Register">
									<input class="btn" alt=""type="reset" value="Reset">
									<input class="btn refresh-captcha" type="button" value="Refresh">
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
		    		document.getElementById("nameCheck").innerHTML = "Utilizador disponível";
		    		document.getElementById("nameCheck").style.color = 'lime';
		    	}else{
		   			document.getElementById("nameCheck").innerHTML = "Utilizador não disponível";
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
	        		document.getElementById("emailCheck").innerHTML = "Email disponível";
	        		document.getElementById("emailCheck").style.color = 'lime';
	        	}else{
	       			document.getElementById("emailCheck").innerHTML = "Email não disponível";
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