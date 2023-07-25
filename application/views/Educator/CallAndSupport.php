<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">  
    <head>
        <?php include("HeaderLinking.php"); ?>
	</head>
    
    <body>
        <?php include("Loader.php"); ?>
        <div id="wrapper">
            
            <?php include("Sidebar.php"); ?>
            
            <?php include("Topbar.php"); ?>
            
            <div class="clearfix"></div>
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header"><h5>Call and Support </h5></div>
								<div class="card-body">
									<p style="font-size:16px;"><strong> Call Us: </strong> <i class="bi bi-telephone-forward"></i> <a class="text-info" href="tel:<?php echo $NeedHelp->help_mobile;?>">+91 <?php echo $NeedHelp->help_mobile;?></a></p>
									<p style="font-size:16px;"><strong> Email Us: </strong> <i class="bi bi-envelope"></i> <a class="text-info" href="mailto:<?php echo $NeedHelp->help_email;?>"> <?php echo $NeedHelp->help_email;?></a></p>
								</div>
							</div>
						</div>
					</div>
                    
                    <div class="overlay toggle-menu"></div>
				</div>
			</div>
            <?php include("Footer.php"); ?>
            
		</div>
        
        <?php  include("FooterLinking.php");  ?>
        
        <script>
            $(function() {
                $(".knob").knob();
			});
		</script>
        <script src="<?php base_url("assets_panel/js/index.js"); ?>"></script>
        
	</body>
    
</html>