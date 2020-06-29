<?php 
$path = substr($_SERVER['PHP_SELF'], 0, 9);
?>

<div id="preloader-active">
	<div class="preloader d-flex align-items-center justify-content-center">
		<div class="preloader-inner position-relative">
			<div class="preloader-circle"></div>
			<div class="preloader-img pere-text">
				<img src="<?php echo $path?>assets/img/logo/loder.jpg" alt="">
			</div>
		</div>
	</div>
</div>
