<?php
$path = substr($_SERVER['PHP_SELF'], 0, 9);

if(isset($_SESSION['id'])){
	$cart = getCart($userId);
	$size = count($cart);
}
?>

<style>
	@import "https://fonts.googleapis.com/css?family=Lato:300,400,700";
	@import "https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css";
	*, *::before, *::after {
		box-sizing: border-box;
	}
	#noCSS {
		padding: 4px 20px 4px 20px;
		color: #fff;
		font-size: 15px;
		display: inherit;
		float: right;
		background-color: #f44a40;
	}
	.badge {
		background-color: rgb(99, 148, 248);
		border-radius: 15px;
		box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
		color: rgb(255, 255, 255);
		display: inline-block;
		font-size: 12px;
		height: 25px;
		line-height: 1;
		padding: 6px 7px;
		text-align: center;
		vertical-align: middle;
		white-space: nowrap;
		width: 25px;
	}
	.shopping-cart {
		background: rgb(255, 255, 255) none repeat scroll 0 0;
		border-radius: 3px;
		float: right;
		padding: 20px;
		position: absolute;
		width: 320px;
		z-index: 50;
		right: 60px;
   		top  : 85px;

		
	}
	.shopping-cart .shopping-cart-header {
		border-bottom: 1px solid rgb(232, 232, 232);
		padding-bottom: 15px;
	}
	.shopping-cart .shopping-cart-header .shopping-cart-total {
		float: right;
	}
	.shopping-cart .shopping-cart-items {
		padding-top: 20px;
	}
	.shopping-cart .shopping-cart-items li {
		margin-bottom: 18px;
	}
	.shopping-cart .shopping-cart-items img {
		float: left;
		margin-right: 12px;
	}
	.shopping-cart .shopping-cart-items .item-name {
		display: block;
		font-size: 16px;
		padding-top: 10px;
	}
	.shopping-cart .shopping-cart-items .item-price {
		color: rgb(99, 148, 248);
		font-size: 12px;
		margin-right: 8px;
	}
	.shopping-cart .shopping-cart-items .item-quantity {
		color: rgb(171, 176, 190);
		font-size: 13px;
	}
	.shopping-cart::after {
		-moz-border-bottom-colors: none;
		-moz-border-left-colors: none;
		-moz-border-right-colors: none;
		-moz-border-top-colors: none;
		border-color: rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) rgb(255, 255, 255);
		border-image: none;
		border-style: solid;
		border-width: 8px;
		bottom: 100%;
		content: " ";
		height: 0;
		left: 89%;
		margin-left: -8px;
		pointer-events: none;
		position: absolute;
		width: 0;
	}
	.cart-icon {
		color: rgb(81, 87, 131);
		float: left;
		font-size: 24px;
		margin-right: 7px;
	}

	.clearfix::after {
		clear: both;
		content: "";
		display: table;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		$('#download').click(function(event) {
			//setTimeout( 'window.location.reload()', 1000);
		});
		$("#noCSS").removeAttr("style");
		var items = document.getElementsByClassName("badge"), i, len;

		for (i = 0, len = items.length; i < len; i++) {
			items[i].innerHTML = <?php echo (isset($size) ? $size : 0) ?>;
		}

		$("#cart").on("click", function() {
			$(".shopping-cart").fadeToggle("fast");
		});
	})
	function delORZIP(id, type){
		console.log(type);
		$.ajax({
			url: '<?php echo $path ?>Userpages/downloadZIP.php',
			type: 'POST',
			data : {userID: id, mode: type},
			success: function(data) {
				location.reload();
			}
		})
	}
</script>
<header>    
	<!-- Header Start -->
	<div class="header-area header-transparent" style="background-color: #212529;">
		<div class="main-header">
			<div class="header-bottom  header-sticky">
				<div class="container-fluid">
					<div class="row align-items-center">
						<!-- Logo -->
						<div class="col-xl-2 col-lg-2 col-md-1">
							<div class="logo">
								<a href="<?php echo $path ?>landingpage.php"><img src="assets/img/logo/logo.png" alt=""></a>
							</div>
						</div>
						<div class="col-xl-10 col-lg-10 col-md-8">
							<!-- Main-menu -->
							<div class="main-menu f-right d-none d-lg-block">
								<nav>
									<ul id="navigation">
										<a target="_blank" href="<?php echo $path . "RSS/RSS.php?readonly=1"; ?>"><img style="width: 30px" src="<?php echo $path . "images/rssBtn.png"; ?>" alt="subscribe via rss" /></a>                                   
										<li><a href="#"><?php echo $language['language'] ?></a>
											<ul class="submenu">
												<li><a href="javascript:changeLanguage('pt')">Português</a></li>
												<li><a href="javascript:changeLanguage('en')">English</a></li>
												<li><a href="javascript:changeLanguage('fr')">Français</a></li>
											</ul>
										</li>               
										<li><a href="<?php echo $path.'landingpage.php' ?>"><?php echo $language['home'] ?></a></li>
										<li><a href="<?php echo $path.'articleFeed.php' ?>"><?php echo $language['about'] ?></a></li>

										<?php 

										if(!isset($_SESSION['id'])){ ?>
											<li id="signin" class="login"><a href="<?php echo $path.'Login_Registo/formLogin.php' ?>">
												<i class="ti-user"></i><?php echo $language['signin'] ?></a>
											</li>
											<li class="login"><a href="<?php echo $path.'Login_Registo/formRegister.php' ?>">
												<i class="ti-user"></i><?php echo $language['register'] ?></a>
											</li>
										<?php  }else{ ?>
											<li class="login"><a href="<?php echo $path.'Userpages/profilepage.php' ?>">
												<i class="ti-user"></i><?php echo $language['me'] ?></a>
											</li>
											<li class="login"><a href="<?php echo $path.'Login_Registo/logout.php' ?>">
												<i class="ti-user"></i><?php echo $language['signout'] ?></a>
											</li>
											<li>
												<a style="cursor: pointer;" id="cart">
													<i class="fa fa-shopping-cart"></i> 
													<?php echo $language['cart'] ?>
													<span class="badge">3</span></a>
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
		<div class="container">
			<div class="shopping-cart" style="display: none;">
				<div class="shopping-cart-header">
					<span><?php echo $language['totalimages'] ?></span>
					<i class="fa fa-shopping-cart cart-icon"></i>
					<div class="shopping-cart-total">
						<span class="main-color-text"><span class="badge">3</span></span>
					</div>
				</div>
				<?php 
				foreach ($cart as $item) {
					$it = getArticle($item); ?>
					<ul class="shopping-cart-items">
						<li class="clearfix" style="width: 100%">
							<img src="<?php echo $path?>Userpages/showFileImage.php?id=<?php echo $it['article_image']?>&size=thumb" alt="An Image" />
							<span class="item-name"><?php echo $it['article_title'] ?></span>
							<span class="item-price">ID = <?php echo $it['article_id'] ?></span>
							<span class="item-quantity">
								<a id="noCSS" href="<?php echo $path?>Userpages/article.php?type=view&id=<?php echo $it['article_id'] ?>">View</a>
							</span>
						</li>
					</ul>
				<?php } ?>


				<a href="<?php echo $path ?>userpages/downloadZIP.php?userID=<?php echo $userId ?>&mode=1"
					><button id="download" class="genric-btn danger">Download</button></a>  
					<button style="float: right;" onclick="delORZIP(<?php echo $userId ?>, 2)" class="genric-btn danger">Delete All</button> 
				</div>
			</div>
		</header>
		