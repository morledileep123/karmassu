<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <title>Karmasu | Student | Certificate Order</title>
        <?php include("HeaderLinking.php"); ?>
		<style>
			.border-none{
			border:none !important; 
			}
		</style>
	</head>
    
    <body>
        <?php include("Loader.php"); ?>
        <div id="wrapper">
            
            <?php include("Sidebar.php"); ?>
            
            <?php include("Topbar.php"); ?>
            
            <div class="clearfix"></div>
            <div class="content-wrapper">
                <div class="container-fluid">
					<form action="<?php echo base_url("Student/CertificateOrder/Create"); ?>" method="post"
					enctype="multipart/form-data" id="registerForm">
						<div class="row">
							<div class="col-sm-12">
								<div class="card">
									<div class="card-header"><h5>Fill the following details to order</h5> </div>
									<ul class="list-group list-group-flush">
										<li class="list-group-item">
											<div class="media align-items-center">
												<div class="media-body ml-3">
													<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
													value="<?= $this->security->get_csrf_hash(); ?>" />
													<input type="hidden" name="userid" value="<?php echo $this->userid;?>" />
													<input type="hidden" name="refno" value="<?php echo $certificateData->refno;?>" />
													<input type="hidden" name="latitude" value="<?php echo $calculateCharge->latitude;?>" />
													<input type="hidden" name="longitude" value="<?php echo $calculateCharge->longitude;?>" />
													<input type="hidden" name="distance" value="<?php echo $calculateCharge->distance;?>" />
													<input type="hidden" name="certificate_charge" value="<?php echo $calculateCharge->certificate_charge;?>" />
													<input type="hidden" name="km_charge" value="<?php echo $calculateCharge->km_charge;?>" />
													<input type="hidden" name="amount" value="<?php echo $calculateCharge->amount;?>" />
													<input type="hidden" name="pincode" value="<?php echo $calculateCharge->pincode;?>" />
													<input type="hidden" name="country" value="India" />
													<div class="form-group">
														<label class="col-form-label">Name <span class="text-danger">*</span></label>
														<input type="text" class="form-control" name="name" placeholder="Name"
														required value="<?php echo $certificateData->name;?>">
														<?php echo form_error("name", "<p class='text-danger' >", "</p>"); ?>
													</div>
													<div class="form-group">
														<label class="col-form-label">Email <span class="text-danger">*</span></label>
														<input type="text" class="form-control" name="email" placeholder="Email Address"
														required value="<?php echo $certificateData->email;?>">
														<?php echo form_error("email", "<p class='text-danger' >", "</p>"); ?>
													</div>
													<div class="form-group">
														<label class="col-form-label">Mobile No <span class="text-danger">*</span></label>
														<input type="text" class="form-control" name="mobile" placeholder="Mobile No"
														required value="<?php echo $certificateData->mobile;?>">
														<?php echo form_error("mobile", "<p class='text-danger' >", "</p>"); ?>
													</div>
													<div class="form-group">
														<label class="col-form-label">Alternate Mobile No <span class="text-danger">*</span></label>
														<input type="text" class="form-control" name="alt_mobile" placeholder="Alternate Mobile No"
														required value="<?php echo $certificateData->mobile;?>">
														<?php echo form_error("alt_mobile", "<p class='text-danger' >", "</p>"); ?>
													</div>
													<div class="form-group">
														<label class="col-form-label">Address <span class="text-danger">*</span></label>
														<input type="text" class="form-control" name="address" placeholder="Address"
														required value="<?php echo $calculateCharge->address;?>">
														<?php echo form_error("address", "<p class='text-danger' >", "</p>"); ?>
													</div>
													<div class="form-group">
														<label class="col-form-label">State <span class="text-danger">*</span></label>
														<input type="text" class="form-control" name="state" placeholder="State"
														required value="<?php  $state=explode(',',$calculateCharge->address); $statecount=count($state)-2; echo $state[$statecount];?>">
														<?php echo form_error("address", "<p class='text-danger' >", "</p>"); ?>
													</div>
													<div class="form-group">
														<label class="col-form-label">Country <span class="text-danger">*</span></label>
														<input type="text" class="form-control" name="countryname" 
														required value="India" disabled>
														<?php echo form_error("address", "<p class='text-danger' >", "</p>"); ?>
													</div>
													
												</div>
											</div>
										</li>
									</ul>
								</div>
								
								<div class="card">
									<div class="card-header"><h5>Certificate Details</h5> </div>
									<ul class="list-group list-group-flush">
										<li class="list-group-item">
											<div class="media align-items-center">
												<?php if($certificateData->itemtype=='Course') { ?>
													<img src="<?php echo base_url('uploads/course/'.$itemData->banner);?>" class="img-fluid" style="height:100px;"/>
													<?php } else { ?>
													<img src="<?php echo base_url('uploads/live_video/'.$itemData->thumbnail);?>"  class="img-fluid" style="height:100px;">
												<?php }?>
												<div class="media-body ml-3">
													<?php if($certificateData->itemtype=='Course') { ?>
														<h5 class="mb-0"><?php echo $itemData->name;?></h5>
														<?php } else { ?>
														<h5 class="mb-0"><?php echo $itemData->name;?></h5>
													<?php }?>
													<p>Type: <?php echo $certificateData->itemtype;?></p>
													<p>Reference No: <?php echo $certificateData->refno;?></p>
													<p>Issued On: <?php echo $certificateData->issuedon;?></p>
												</div>
												
											</div>
											
										</li>
									</ul>
								</div>
								
								<div class="card" >
									<div class="card-header"><h5>Price Details</h5> </div>
									<ul class="list-group list-group-flush">
										<li class="list-group-item">
											<div class="media align-items-center">
												<div class="media-body ml-3">
													<table class="table table-borderless">
														<tr>
															<th class="border-none">Certificate Charge</th>
															<td class="border-none"><i class="fa fa-rupee"></i> <?php echo $calculateCharge->certificate_charge;?></td>
														</tr>
														<tr>
															<th class="border-none">Per KM Charge</th>
															<td class="border-none"><i class="fa fa-rupee"></i> <?php echo $calculateCharge->km_charge;?></td>
														</tr>
														<tr>
															<th class="border-none">Distance</th>
															<td class="border-none"><?php echo $calculateCharge->distance;?></td>
														</tr>
														
														<tr>
															<th class="border-none">Total Distance Charge</th>
															<td class="border-none"><i class="fa fa-rupee"></i> <?php echo ($calculateCharge->distance)*($calculateCharge->km_charge);?></td>
														</tr>
														<tr>
															<th class="border-none">Payable Amount</th>
															<td class="border-none"><i class="fa fa-rupee"></i> <?php echo $calculateCharge->amount;?></td>
														</tr>
													</table>
													
													<center><button type="submit" id="registerBtn"  class="btn btn-dark"><i
													class="icon-lock"></i> Checkout <i class="fa fa-spinner fa-spin" id="registerSpin" style="display:none;"></i></button></center>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</form>
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
		<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
		<script>
			$("#registerForm").on('submit', function(e) {
				e.preventDefault();
				var data = new FormData(this);
				$.ajax({
					type: 'POST',
					url: "<?php echo base_url('Student/CertificateOrder/Create')?>",
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function() {
						$("#registerBtn").attr("disabled", true);
						$('#registerSpin').show();
					},
					success: function(response) {
						console.log(response);
						var response = JSON.parse(response);
						$("#registerBtn").removeAttr("disabled");
						$('#registerSpin').hide();
						if (response[0].res == 'success') {
							var options = {
								"key": response[0].data.rzp_api_key, 
								"amount": response[0].data.rzpAmount, 
								"currency": "INR",
								"name": response[0].data.product, 
								"description": response[0].data.description, 
								"image": response[0].data.logo, 
								"order_id": response[0].data.rzpOrderId, 
								"handler": function (rzpResponse){
								console.log(rzpResponse);
									window.location.href=response[0].data.baseUrl+'Student/CertificateOrder/UpdateStatus/'+rzpResponse.razorpay_order_id+'/'+rzpResponse.razorpay_payment_id;
								},
								"prefill": {
									"name": response[0].data.orderData.name,
									"email": response[0].data.orderData.email,
									"contact": response[0].data.orderData.mobile
								},
								"notes": {
									"address": "CodersAdda"
								},
								"theme": {
									"color": "#004bfe"
								}
							};
							var rzp1 = new Razorpay(options);
							rzp1.on('payment.failed', function (response){
								// alert(response.error.code);
								// alert(response.error.description);
								// alert(response.error.source);
								// alert(response.error.step);
								// alert(response.error.reason);
								// alert(response.error.metadata.order_id);
								// alert(response.error.metadata.payment_id);
							});
							rzp1.open();
						}
						else if (response[0].res == 'error') {
							Lobibox.notify('error', {
								pauseDelayOnHover: true,
								size: 'mini',
								rounded: true,
								delayIndicator: false,
								icon: 'fa fa-exclamation-circle',
								continueDelayOnInactiveTab: false,
								position: 'top right',
								msg: response[0].msg
							});
						}
					},
					error: function() {
						// window.location.reload();
					}
				});
			});	
		</script>
		
	</body>
</html>																														