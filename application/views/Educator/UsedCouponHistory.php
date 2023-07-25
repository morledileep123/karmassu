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
                            <h4 class="page-title">{ <?php echo $list[0]->coupon;?> } Used Coupon History</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="Dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="Promocode">Promocode</a></li>
							</ol>
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
                                                    <th>Invoice</th>
													<th>Purchased Item</th>
                                                   
													<th>Price</th>
													<th>Order ID</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
												</tr>
											</thead>
                                            <tbody>
                                                <?php
                                                    $sr = 1;
                                                    foreach ($history as $item) {
                                                        
													?>
													<tr>
														<td><?php echo $sr; ?></td>
														<td>
															<a class="btn btn-success p-1" href="<?php echo base_url('Home/Invoice/'.$item->id);?>" target="_blank">  Invoice <i class="fa fa-angle-double-right"></i></a>
														</td>
														<td>
															<?php echo $item->itemtype;?>
															<a href="<?php if($item->itemtype=='Course'){ echo base_url("Educator/ManageCourses/Details/$item->itemid");  } else{ echo base_url("Educator/ManageEBooks/Details/$item->itemid");} ?>"
															class="btn btn-sm btn-info waves-effect waves-light">
															<i class="fa fa-eye"></i> </a>
														</td>
														
														<td>
															<i class="fa fa-inr"></i> <?php echo $item->price; ?>
														</td>
														<td>
															<?php echo $item->orderid; ?>
														</td>
														
														<td>
															<?php echo $item->date; ?>
														</td>
														<td>
															<?php echo $item->time; ?>
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
			<!--Modal Start-->
            <div class="modal fade" id="VerifyModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-primary">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white">Verify Payment</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
							</button>
						</div>
                        <div class="modal-body">
                            
						</div>
					</form>
				</div>
			</div>
		</div>
        <!--Modal End-->
		<?php include("Footer.php"); ?>
	</div>
	<?php include("FooterLinking.php"); ?>
	
	<script>
		function VerifyPayment(id) {
			$("#VerifyModal").modal("show");
			$("#VerifyModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
			$("#VerifyModal .modal-body").load("<?php echo base_url('Educator/VerifyPayment/') ?>" + id);
		}
	</script>
</body>

</html>