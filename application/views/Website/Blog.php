
<!doctype html>
<html class="no-js" lang="zxx">
	<head>
		<?php include 'CssLink.php';?>
	</head>
	<body>
		<?php include 'Header.php';?>
		<main>
			
			<div class="slider-area">
				<div class="single-sliders slider-height2 d-flex align-items-center">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-xl-5 col-lg-6 col-md-6">
								<div class="hero-caption hero-caption2">
									<h2>Blog</h2>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="great-stuffs section-padding">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							
							<div class="section-tittle text-center mb-55">
								<h2>Some of Our Great Stuffs</h2>
							</div>
						</div>
					</div>
					<div class="row">
						
						<?php
							for($i=1;$i<4;$i++)
							{
							?>
							<div class="col-lg-4 col-md-4 col-sm-6">
								<div class="single-location mb-40">
									<div class="location-img">
										<img src="<?= base_url();?>assets_web\img\gallery\xstuffs3.jpg.pagespeed.ic.ZeSX6nQVr4.jpg" alt="">
										<div class="location-details text-center">
											<span class="location-btn"></span>
											
											
										</div>
									</div>
									<h3><a href="<?= base_url();?>Home/BlogDetails">Online Learning Plateform</a></h3>
								</div> 
							</div>
						<?php }?>
					</div>
				</div>
			</div>
			
			
			
			
							</main>
							<?php include 'Footer.php';?>
							
							<div id="back-top">
								<a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
							</div>
							<?php include 'JsLink.php';?>
	</body>
</html>