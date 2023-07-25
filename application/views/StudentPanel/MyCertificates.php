<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?> 
<!DOCTYPE html> 
<html lang="en">  
    <head>
        <title>Karmasu | Student | <?php echo $action;?></title>
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
					<?php
						if (isset($action)) 
						{
							switch ($action) 
							{
								
								case 'My Certificates';
							?>
							
							<div class="row">
								<div class="col-sm-12 p-2"><h5 class="pull-left"><?php echo $action;?></h5></div>
								<?php
									if(count($certificateList)){
										foreach($certificateList as $item){
										?>
										<div class="col-sm-3">
											<div class="card">
												<div class="card-header p-0">
													<a href="<?php echo base_url('Student/MyCertificates/'.$item->refno);?>">
														<?php if($item->itemtype=='Course') { ?>
															<img src="<?php echo base_url('uploads/course/'.$item->item->banner);?>" class="img-fluid"/>
															<?php } else { ?>
															<img src="<?php echo base_url('uploads/live_video/'.$item->item->thumbnail);?>"  class="img-fluid">
														<?php }?>
													</a>
												</div>
												<div class="card-body">
													<?php if($item->itemtype=='Course') { ?>
														<h5 class="card-title"><?php echo $item->item->name;?></h5>
														<?php } else { ?>
														<h5 class="card-title"><?php echo $item->item->title;?></h5>
													<?php }?>
													
													<h6><i class="fa fa-user-circle"></i> <?php echo  $item->item->author->name;?></h6>
													<p>Type: <?php echo $item->itemtype;?></p>
													<p>Reference No: <?php echo $item->refno;?></p>
													<p>Issued On: <?php echo $item->issuedon;?></p>
													<ul class="list-group list-group-flush list shadow-none p-0">
														<li class="list-group-item d-flex justify-content-between align-items-center p-1">
															
															<a href="<?php echo base_url("Student/MyCertificates/".$item->refno) ?>" class="btn btn-dark p-2"><i class="fa fa-certificate"></i> View Certificate</a>
															
														</li>
													</ul>
												</div>
											</div>
										</div>
									<?php } } else{ ?>
									<div class="col-sm-12">
										<center>
											<img src="<?php echo base_url('image/NoRecordFound.png');?>" title="img not found" alt="img not found" class="img-fluid"/>
											<br><br>
											<br><br><br><br>
										</center>
									</div>
								<?php } ?>
							</div>	
							<?php
								break;
								
								case 'My Certificates Description';
							?>
							
							<div class="row">
								<div class="col-sm-12 p-2"><h5 class="pull-left"><?php echo $action;?></h5></div>
								<?php
									if(count($certificateList)){
										foreach($certificateList as $item){
										?>
										
										<div class="col-sm-4">
											<div class="card">
												<div class="card-header p-0">
													<a href="<?php echo base_url('Student/MyCertificates/'.$item->refno);?>">
														<?php if($item->itemtype=='Course') { ?>
															<img src="<?php echo base_url('uploads/course/'.$item->item->banner);?>" class="img-fluid"/>
															<?php } else { ?>
															<img src="<?php echo base_url('uploads/live_video/'.$item->item->thumbnail);?>"  class="img-fluid">
														<?php }?>
													</a>
												</div>
												<div class="card-body">
													<?php if($item->itemtype=='Course') { ?>
														<h5 class="card-title"><?php echo $item->item->name;?></h5>
														<?php } else { ?>
														<h5 class="card-title"><?php echo $item->item->title;?></h5>
													<?php }?>
													
													<h6><i class="fa fa-user-circle"></i> <?php echo  $item->item->author->name;?></h6>
													<p>Type: <?php echo $item->itemtype;?></p>
													<p>Reference No: <?php echo $item->refno;?></p>
													<p>Issued On: <?php echo $item->issuedon;?></p>
													<ul class="list-group list-group-flush list shadow-none p-0">
														<li class="list-group-item d-flex justify-content-between align-items-center p-1">
															
															<a href="<?php echo base_url("Home/Certificate/".$item->refno) ?>" class="btn btn-dark p-2" target="_blank"><i class="fa fa-certificate"></i> Get Certificate</a>
															
														</li>
													</ul>
												</div>
											</div>
										</div>
										
										<div class="col-sm-8">
											<div class="card">
												<div class="card-header">
													<h6>Certificate Details</h6>
												</div>
												<div class="card-body ">
													<div class="table-responsive">
														<table class="table table-bordered ">
															<tr>
																<th>Reference No : </th>
																<td><?php echo $item->refno;?></td>
															</tr>
															<tr>
																<th>Issued On : </th>
																<td><?php echo $item->issuedon;?></td>
															</tr>
															<tr>
																<th>Grade : </th>
																<td><?php echo $item->grade;?></td>
															</tr>
															<tr>
																<th>Duration : </th>
																<td><?php echo $item->duration;?></td>
															</tr>
															<tr>
																<th>From Date : </th>
																<td><?php echo $item->from_date;?></td>
															</tr>
															<tr>
																<th>To Date : </th>
																<td><?php echo $item->to_date;?></td>
															</tr>
															<tr>
																<th>Certificate Type : </th>
																<td><?php echo $item->itemtype;?></td>
															</tr>
															<tr>
																<th colspan="2"><a href="javascript:void(0);" data-toggle="modal" data-target="#AddModal" class="btn btn-danger p-2" ><i class="fa fa-check-circle"></i> Order To Hard Copy</a></th>
															</tr>
														</table>
													</div>
												</div>
											</div>
										</div>
										
										<div class="col-sm-12">
											<div class="card">
												<div class="card-header">
													<h6>Order History</h6>
												</div>
												<div class="card-body">
													
													<div class="table-responsive">
														
														<table class="table table-bordered wrap" id="example" style="width:100%;">
															<thead>
																<tr>
																	<th>#</th>
																	<th>Payment Status</th>
																	<th>Order Status</th>
																	<th>Reference No</th>
																	<th>Name</th>
																	<th>Mobile No</th>
																	<th>Alt Mobile No</th>
																	<th>Email</th>
																	<th>Address</th>
																	<th>Pincode</th>
																	<th>State</th>
																	<th>Country</th>
																	<th>Distance</th>
																	<th>Certificate Charge</th>
																	<th>KM Charge</th>
																	<th>Amount</th>
																	<th>Order ID</th>
																	<th>Rzp Order ID</th>
																	<th>Payment ID</th>
																	<th>Expected Date</th>
																	<th>Delivery Date</th>
																	<th>Date</th>
																	<th>Time</th>
																</tr>
															</thead>
															
															
															<tbody>
																<?php
																	$sr = 1;
																	foreach ($item->order as $subitem) {
																		
																	?>
																	<tr>
																		<td><?php echo $sr; ?></td>
																		<td>
																			<?php
																				if($subitem->status=='success'){
																					echo '<b class="text-success">Success</b>';
																				}
																				else if($subitem->status=='failed'){
																					echo '<b class="text-danger">Failed</b>';
																				}
																				else if($subitem->status=='Pending'){
																					echo '<b class="text-warning">Pending</b>';
																				}
																			?>
																		</td>
																		<td> <?php echo $subitem->order_status; ?> </td>
																		<td>
																			<?php echo $subitem->refno; ?>
																		</td>
																		<td>
																			<?php echo $subitem->name; ?>
																		</td>
																		<td>
																			<?php echo $subitem->mobile; ?>
																		</td>
																		<td>
																			<?php echo $subitem->alt_mobile; ?>
																		</td>
																		<td>
																			<?php echo $subitem->email; ?>
																		</td>
																		<td>
																			<?php echo $subitem->address; ?>
																		</td>
																		<td>
																			<?php echo $subitem->pincode; ?>
																		</td>
																		<td>
																			<?php echo $subitem->state; ?>
																		</td>
																		<td>
																			<?php echo $subitem->country; ?>
																		</td>
																		<td> <?php echo $subitem->distance; ?> KM </td>
																		<td><i class="fa fa-inr"></i> <?php echo $subitem->certificate_charge; ?> </td>
																		<td><i class="fa fa-inr"></i> <?php echo $subitem->km_charge; ?> </td>
																		<td><i class="fa fa-inr"></i> <?php echo $subitem->amount; ?> </td>
																		<td> <?php echo $subitem->orderid; ?> </td>
																		<td> <?php echo $subitem->rzp_orderid; ?> 
																		</td>
																		<td> <?php echo $subitem->paymentid; ?> </td>
																		
																		
																		<td> <?php echo $subitem->expected_date; ?> </td>
																		<td> <?php echo $subitem->delivery_date; ?> </td>
																		<td> <?php echo $subitem->date; ?> </td>
																		<td> <?php echo $subitem->time; ?> </td>
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
									<?php } } else{ ?>
									<div class="col-sm-12">
										<center>
											<img src="<?php echo base_url('image/NoRecordFound.png');?>" title="img not found" alt="img not found" class="img-fluid"/>
											<br><br>
											<br><br><br><br>
										</center>
									</div>
								<?php } ?> 
							</div>	
							<?php
								break;	
							}
						} 
						else 
						{
							echo 'Action is required.';
						}
					?>
					<div class="overlay toggle-menu"></div>
				</div>
			</div>
			<!--Modal Start-->
            <div class="modal fade" id="AddModal">
                <div class="modal-dialog">
                    <div class="modal-content border-primary">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white">Enter Pincode</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
							</button>
						</div>
                        <form action="<?php echo base_url("Student/CalculateCharge"); ?>" method="post" enctype="multipart/form-data" id="registerForm">
                            <div class="modal-body">
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
								<input type="hidden" name="userid" value="<?= $this->userid; ?>" />
								<input type="hidden" name="itemid" value="<?= $certificateList[0]->itemid; ?>" />
								<input type="hidden" name="itemtype" value="<?= $certificateList[0]->itemtype; ?>" />
								<input type="hidden" name="refno" value="<?= $certificateList[0]->refno; ?>" />
                                <div class="form-group">
                                    <label class="col-form-label">Pincode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="pincode" placeholder="Enter Pincode" required>
                                    <?php echo form_error("pincode", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group CalculateCharge" >
									
								</div>
								
							</div>
                            <div class="modal-footer d-block">
								<button type="submit" id="registerBtn" class="btn btn-primary"><i
								class="icon-lock"></i> Proceed <i class="fa fa-spin fa-spinner" id="registerSpin" style="display:none;"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
            <!--Modal End-->
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
			
			$('#registerForm').on('submit', function(e) {
			e.preventDefault();
			var data = new FormData(this);
			$.ajax({
				type: 'POST',
				url: $('#registerForm').attr('action'),
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$("#registerBtn").attr("disabled", true);
					$('#registerSpin').show();
				},
				success: function(response) {
					
					
					var response = JSON.parse(response);
					$("#registerBtn").removeAttr("disabled");
					$('#registerSpin').hide();
					if (response[0].res == 'success') 
					{
						$('.notifyjs-wrapper').remove();
						$.notify("" + response[0].msg + "", "success");
						$(".CalculateCharge").html('<p>Certificate Charge : <i class="fa fa-inr"></i> '+response[0].data.certificate_charge+'</p><p>Distance : '+response[0].data.distance+'</p><p>KM Charge : <i class="fa fa-inr"></i> '+response[0].data.km_charge+'</p><p>Total Amount : <i class="fa fa-inr"></i> '+response[0].data.amount+'</p> <a href="<?php echo base_url("Student/CertificateOrder/") ?>'+data.get('refno')+'/'+response[0].data.pincode+'" class="btn btn-dark p-2"><i class="fa fa-check-circle"></i> Order Now</a>');
					}
					else if (response[0].res == 'error')
					{
						$('.notifyjs-wrapper').remove();
						$.notify("" + response[0].msg + "", "error");
					}
				},
				error: function() {
					window.location.reload();
				}
			});
		});
		
	</script>
</body>

</html>