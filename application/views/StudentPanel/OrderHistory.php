<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <title>Karmasu | Student | Order History</title>
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
							<div class="card" >
								<div class="card-header"><h5>Order Details</h5> </div>
								<ul class="list-group list-group-flush">
									<?php if (count($list)) : ?>
									<?php foreach ($list as $item) : ?>
									<li class="list-group-item">
										<a href="<?php echo base_url('Student/Receipt/'.$item->id);?>">
											<div class="media align-items-center">
												<img src="<?php if($item->itemtype=='Course'){ echo base_url('uploads/course/'.$item->item->banner); } else{ echo base_url('uploads/ebook/'.$item->item->banner); }?>" title="course-img" alt="course-img" class="img-fluid" style="height:150px;">
												<div class="media-body ml-3">
													<h5 class="mb-0 text-dark"><?php echo $item->item->name;?> (<?php echo $item->itemtype;?>) </h5><br>
													<p class="text-dark">Amount : <strong><i class="fa fa-inr"></i> <?php echo $item->price;?></strong></p>
													<p class="text-dark">Date : <strong><?php echo $item->date;?> <?php echo $item->time;?></strong></p>
													<p class="text-dark">Status : 
														<?php
															if($item->paymentstatus=='success'){
																echo '<strong class="text-success">Success</strong>';
															}
															else if($item->paymentstatus=='Pending'){
																echo '<strong class="text-warning">Pending</strong>';
															}
															else if($item->paymentstatus=='failed'){
																echo '<strong class="text-danger">Failed</strong>';
															}
														?>
														
													</p>
													<a href="<?php echo base_url('Student/Receipt/'.$item->id);?>" class="btn btn-info p-2" style="position:absolute;right:0px;top:0px;"> <i class="fa fa-file-pdf"></i> View Receipt</a>
													<a class="btn btn-success p-1" href="<?php echo base_url('Home/Invoice/'.$item->id);?>" target="_blank">  Invoice <i class="fa fa-angle-double-right"></i></a>
												</div>
											</div>
										</a>
									</li>
									
									<?php endforeach; ?>
									<?php endif; ?>
									<?php if (!count($list)) : ?>
									<p class="p-2">No Record Available.</p>
									<?php endif; ?>
								</ul>
								
							</div>
						</div>
					</div>
					
					<div class="overlay toggle-menu"></div>
					
				</div>
				<?php include("Footer.php"); ?>
			</div>
			
			
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