<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <title>Karmasu | Student | Offers</title>
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
						<?php if (count($offersList)) : ?>
						<?php foreach ($offersList as $item) : ?>
						<div class="col-sm-3">
							<div class="card">
								<div class="card-header p-0">
									<img src="<?php echo base_url('uploads/offer/'.$item->banner);?>" class="card-img-top" style="height:250px;">
								</div>
								<div class="card-body">
									
									<h5 class="text-center">Get <?php if($item->discount_type=='Amount'){ echo '<i class="fa fa-inr"></i>'.$item->discount .' off'; } else{ echo $item->discount.'% off UPTO <i class="fa fa-inr"></i>'.$item->upto;}?> </h5>
									<center class="p-2"> <i class="text-center">No of coupon: <?php echo $item->used_coupon;?>/<?php echo $item->used_coupon;?></i></center>
									<h5 class="text-center text-success p-2 " style="border:2px dotted" id="clipboard<?php echo $item->id;?>"><?php echo $item->coupon;?> <a href="javascript:void(0);" onclick="copyToClipboard('clipboard<?php echo $item->id;?>')" class="text-success"><i class="fa fa-copy"></i></a></h5>
									<center class="p-2"> <i class="text-center">Expiry Date: <?php echo $item->expiry_date;?></i>
										
									</center>
									<p><?php echo $item->description;?></p>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
						<?php endif; ?>
						<?php if (!count($offersList)) : ?>
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									<p>No Offers Available.</p>
								</div>
							</div>
						</div>
						<?php endif; ?>
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
        <script>
			function copyToClipboard(containerid) {
				var range = document.createRange();
				range.selectNode(document.getElementById(containerid));
				window.getSelection().removeAllRanges(); 
				window.getSelection().addRange(range); 
				document.execCommand("copy");
				window.getSelection().removeAllRanges();
			}
		</script>
	</body>
	
</html>