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
								<div class="card-header">Notification
									<div class="card-action">
										<span class="badge badge-pill badge-dark m-1"><?php echo $notificationCount;?></span>
									</div>
								</div>
								
								<ul class="list-group list-group-flush">
									<?php if (count($notificationList)) : ?>
									<?php foreach ($notificationList as $item) : ?>
									<li class="list-group-item">
										<div class="media align-items-center">
											<span class="badge badge-pill badge-danger  m-1 p-3" ><strong ><?php echo substr(strtoupper($item->title),0,1);?></strong></span>
											<div class="media-body ml-3">
												<h6 class="mb-0"><?php echo $item->title;?> </h6>
												<p class="mb-0 small-font"><?php echo $item->message;?></p>
												<?php if(!empty($item->link)){ ?>
												<a href="<?php echo $item->link;?>" target="_blank">Read More <i class="fas fa-angle-double-right"></i> </a>
												<?php } ?>
											</div>
											<div class="star">
											<?php if(!empty($item->image)){ ?>
												<img src="<?=base_url('uploads/notification/'.$item->image);?>" class="img-fluid" style="height:100px;"/>
												<?php } ?>
												<small class="ml-4"><?php echo $item->since;?></small>
												
											</div>
										</div>
									</li>
									
									
									<?php endforeach; ?>
									<?php endif; ?>
									
									<?php if (!count($notificationList)) : ?>
									<li class="list-group-item">
										<div class="media align-items-center">
											No Notification Available.
										</div>
									</li>
									
									<?php endif; ?>
								</ul> 
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