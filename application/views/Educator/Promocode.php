<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html> 
<html lang="en"> 
    <head>
        <?php include("HeaderLinking.php"); ?>
	</head>
    
    <body>
        <!-- start loader -->
        <?php include("Loader.php"); ?>
        <!-- end loader -->
        <div id="wrapper">
            
            <?php include("Sidebar.php"); ?>
            
            <?php include("Topbar.php"); ?>
            
            <div class="clearfix"></div>
            
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row pt-2 pb-2">
                        <div class="col-sm-9">
                            <h4 class="page-title"> Promo Code</h4>
						</div>
                        <div class="col-sm-3">
                            
						</div>
					</div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        
                                        <table class="table table-bordered" id="example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Used History</th>
                                                    <th>Banner</th>
                                                    <th>Coupon</th>
                                                    <th>Discount</th>
                                                    <th>Discount Type</th>
                                                    <th>UPTO</th>
                                                    <th>Expiry Date</th>
                                                    <th>Description</th>
												</tr>
											</thead>
                                            <tbody>
                                                <?php
                                                    $sr = 1;
                                                    foreach ($list as $item) {
                                                        
													?>
                                                    <tr>
                                                        <td><?php echo $sr; ?></td>
														<td>
															<a href="<?php echo base_url('Educator/Promocode/UsedCouponHistory/'.$item->id);?>" class="btn btn-sm btn-primary" > <i class="fa fa fa-eye"></i> Used History</a>
														</td>
														<td> <label data-toggle="tooltip" data-placement="top"
															title="Offer ID: <?php echo $item->id; ?>"><a
																href="<?php echo base_url("uploads/offer/$item->banner"); ?>"
																target="_blank"><img
																	data-src="<?php echo base_url("uploads/offer/$item->banner"); ?>"
																	src="<?php echo base_url("images/Preloader2.jpg"); ?>"
																class="lazy" style="height:50px;" /> </a></label>
														</td>
														<td> <?php echo $item->coupon; ?> </td>
														<td>
															<?php if($item->discount_type=='Amount') {  echo '<i class="fa fa-rupee"></i>'.$item->discount; } else{ echo $item->discount.'%'; }?>
														</td>
														<td>
															<?php echo $item->discount_type; ?>
														</td>
														<td>
															<i class="fa fa-rupee"></i><?php echo $item->upto; ?>
														</td>
														<td>
															<?php echo $item->expiry_date; ?>
															<?php
																if(strtotime($item->expiry_date)>=strtotime(date('Y-m-d'))){
																	echo '<p class="text-primary">Valid</p>';
																}
																else{
																	echo '<p class="text-danger">Expired</p>';
																}
																?>
															</td>
															<td>
															<?php echo $item->description; ?>
														</td>
													</tr>
													<?php
														$sr++;
													}
												?>
											</tbody>
										</table>
										
									</div>
								</div>
							</div>
							
						</div>
					</div>
					<div class="overlay toggle-menu"></div>
				</div>
			</div>
			
			<?php include("Footer.php"); ?>
			<?php include("FooterLinking.php"); ?>
			
		</body>
		
	</html>		