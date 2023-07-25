<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Karmasu | Student | Checkout</title>
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
					<form action="<?php echo base_url("Student/EnrollStudent/".$itemtype.'/'.$itemid); ?>" method="post"
					enctype="multipart/form-data" id="registerForm">
						<div class="row">
							<div class="col-sm-12">
								<div class="card">
									<div class="card-header"><h5>Fill the following details for  certification</h5> </div>
									<?php $name=explode(' ',$this->StudentData->name); ?>
									<ul class="list-group list-group-flush">
										<li class="list-group-item">
											<div class="media align-items-center">
												<div class="media-body ml-3">
													<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
													value="<?= $this->security->get_csrf_hash(); ?>" />
													<input type="hidden" name="userid" value="<?php echo $this->StudentData->id;?>" />
													<input type="hidden" name="mobile" value="<?php echo $this->StudentData->number;?>" />
													<input type="hidden" name="courseid" value="<?php echo $itemid;?>" />
													<input type="hidden" name="itemid" value="<?php echo $itemid;?>" />
													<input type="hidden" name="itemtype" value="<?php echo $itemtype;?>" />
													<div class="form-group">
														<label class="col-form-label">First Name <span class="text-danger">*</span></label>
														<input type="text" class="form-control" name="firstname" placeholder="First Name"
														required value="<?php echo $name[0];?>">
														<?php echo form_error("firstname", "<p class='text-danger' >", "</p>"); ?>
													</div>
													<div class="form-group">
														<label class="col-form-label">Last Name <span class="text-danger">*</span></label>
														<input type="text" class="form-control" name="lastname" placeholder="First Name"
														required value="<?php echo end($name);?>">
														<?php echo form_error("lastname", "<p class='text-danger' >", "</p>"); ?>
													</div>
													<div class="form-group">
														<label class="col-form-label">Email <span class="text-danger">*</span></label>
														<input type="text" class="form-control" name="emailid" placeholder="Email Address"
														required value="<?php echo $this->StudentData->email;?>">
														<?php echo form_error("email", "<p class='text-danger' >", "</p>"); ?>
													</div>
													<div class="form-group">
														<label class="col-form-label">Highest Qualification <span class="text-danger">*</span></label>
														<input list="qualifications" name="qualification" class="form-control" placeholder="Highest Qualification" required>
														<datalist id="qualifications">
															<option value="High School">
																<option value="Intermediate">
																	<option value="Diploma">
																		<option value="Graduation">
																			<option value="Post Graduation">
																			</datalist>
																			<?php echo form_error("qualification", "<p class='text-danger' >", "</p>"); ?>
																		</div>
																	</div>
																</div>
															</li>
														</ul>
													</div>
													
													<div class="card">
														<div class="card-header"><h5>Order Details</h5> </div>
														<ul class="list-group list-group-flush">
															<li class="list-group-item">
																<div class="media align-items-center">
																	<img src="<?php if($itemtype=='Course'){ echo base_url('uploads/course/'.$list->banner); } else{ echo base_url('uploads/ebook/'.$list->banner); }?>"  class="img-fluid" style="height:100px;" >
																	<div class="media-body ml-3">
																		<h6 class="mb-0"><?php echo $list->name;?>(<?php echo $itemtype;?>) </h6>
																		<p><strong>
																			<?php
																				if ($list->type == "Paid") {
																				?>
																				<?php
																					if (empty($list->offerprice)) {
																					?>
																					<i class="fa fa-rupee"></i> <?php echo $list->price; ?>
																					<?php
																						} else {
																					?>
																					<s><i class="fa fa-rupee"></i> <?php echo $list->price; ?></s>
																					<i class="fa fa-rupee"></i> <?php echo $list->offerprice; ?>
																					<span class="text-danger p-1 "><?php echo str_replace('Off','',$list->discountpercent); ?>OFF</span>
																					<?php
																					}
																					} else {
																				?>
																				<span class="p-2 text-success">Free</span>
																				<?php
																				}
																			?>
																		</strong></p>
																		<p><?php echo $list->shortdesc;?></p>
																		
																	</div>
																	
																</div>
																<?php if ($list->type == "Free") {  ?>
																	<center><button type="submit" id="registerBtn"  class="btn btn-dark"><i
																		class="icon-lock"></i> Checkout <i class="fa fa-spinner fa-spin" id="registerSpin" style="display:none;"></i></button></center>
																<?php } ?>
																
															</li>
														</ul>
													</div>
													
													<div class="card <?php if ($list->type == "Free") { echo 'd-none';}?>" >
														<div class="card-header"><h5>Price Details</h5> </div>
														<ul class="list-group list-group-flush">
															<li class="list-group-item">
																<div class="media align-items-center">
																	<div class="media-body ml-3">
																		<table class="table table-borderless">
																			<tr>
																				<th class="border-none">MRP</th>
																				<td class="border-none"><i class="fa fa-rupee"></i> <?php echo $list->price;?></td>
																			</tr>
																			<tr>
																				<th class="border-none">Offer Price</th>
																				<td class="border-none"><i class="fa fa-rupee"></i> <?php echo $list->offerprice;?></td>
																			</tr>
																			<tr>
																				<th class="border-none">Discount</th>
																				<td class="border-none"><i class="fa fa-rupee"></i> <?php echo ($list->price-$list->offerprice);?></td>
																			</tr>
																			<?php
																				if(!empty($this->session->get_userdata()['CouponData']) and ($this->session->get_userdata()['CouponData'])->itemtype==$itemtype and ($this->session->get_userdata()['CouponData'])->itemid==$itemid){
																					
																					$CouponData=$this->session->get_userdata()['CouponData'];
																					if($CouponData->discount_type=='Amount'){
																						$coupondiscount=($list->offerprice)-($CouponData->discount);
																						if($coupondiscount>$CouponData->upto){
																							$coupondiscount=$CouponData->upto;
																						}
																						
																						$totalprice=($list->offerprice)-($coupondiscount);
																					}
																					else{
																						
																						$coupondiscount=(($list->offerprice)*$CouponData->discount)/100;
																						if($coupondiscount>$CouponData->upto){
																							$coupondiscount=$CouponData->upto;
																						}
																						
																						$totalprice=($list->offerprice)-($coupondiscount);
																					}
																				?>
																				<tr>
																					<th class="border-none">Coupon Discount (<?php echo $CouponData->coupon;?>)</th>
																					<td class="border-none">
																						<i class="fa fa-rupee"></i> <?php echo $coupondiscount;?>
																					</td>
																				</tr>
																				<tr>
																					<th class="border-none">Total Price</th>
																					<td class="border-none">
																						<i class="fa fa-rupee"></i> <?php echo $totalprice;?>
																						<input type="hidden" name="price" value="<?php echo $totalprice;?>"/>
																						<input type="hidden" name="coupon" value="<?php echo $CouponData->coupon;?>"/>
																					</td>
																				</tr>
																				<?php
																					} else{
																				?>
																				<tr>
																					<th class="border-none">Total Price</th>
																					<td class="border-none">
																						<i class="fa fa-rupee"></i> <?php echo $list->offerprice;?>
																						<input type="hidden" name="price" value="<?php echo $list->offerprice;?>"/>
																						<input type="hidden" name="coupon" value=""/>
																					</td>
																				</tr>
																				<?php
																				}
																			?>
																			
																			<tr>
																				<th colspan="2">
																					
																					<h6 class="text-primary">Have a coupon code ? <a href="javascript:void(0);" data-toggle="modal" data-target="#CouponModal">Click Here</a></h6>
																					
																					<?php
																						if($this->session->flashdata("response")){
																							$output=$this->session->flashdata("response");
																							if($output['res']=='success'){
																								echo '<p class="text-success">'.str_ireplace('<p>','',$output['msg']).'</p>';
																							}
																							else{
																								echo '<p class="text-danger">'.str_ireplace('<p>','',$output['msg']).'</p>';
																							}
																						}
																					?>
																				</th>
																				
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
										
										<div class="modal fade" id="CouponModal">
											<div class="modal-dialog">
												<div class="modal-content border-primary">
													<div class="modal-header bg-primary">
														<h5 class="modal-title text-white">Apply Coupon</h5>
														<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<form action="<?php echo base_url("Student/CouponValidation/".$itemtype.'/'.$itemid); ?>" method="post"
													enctype="multipart/form-data" id="addform">
														<div class="modal-body">
															
															
															<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
															value="<?= $this->security->get_csrf_hash(); ?>" />
															
															<div class="form-group">
																<label class="col-form-label">Coupon <span class="text-danger">*</span></label>
																<input type="text" class="form-control text-uppercase" name="couponcode" placeholder="Coupon Code"
																required>
																<input type="hidden" class="form-control" name="userid" value="<?php echo $this->userid; ?>" required>
																<?php echo form_error("couponcode", "<p class='text-danger' >", "</p>"); ?>
															</div>
														</div>
														<div class="modal-footer d-block">
															<button type="submit" id="addaction" name="addaction" class="btn btn-primary"><i
															class="icon-lock"></i> Apply Coupon</button>
														</div>
													</form>
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
							<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
							<script>
								$("#registerForm").on('submit', function(e) {
									e.preventDefault();
									var data = new FormData(this);
									$.ajax({
										type: 'POST',
										url: "<?php echo base_url('Student/EnrollStudent')?>",
										data: data,
										cache: false,
										contentType: false,
										processData: false,
										beforeSend: function() {
											$("#registerBtn").attr("disabled", true);
											$('#registerSpin').show();
										},
										success: function(response) {
											// console.log(response);
											var response = JSON.parse(response);
											$("#registerBtn").removeAttr("disabled");
											$('#registerSpin').hide();
											if (response[0].res == 'free') {
												window.location.href=response[0].data.baseUrl+'Student/FreePaymentStatusUpdate/'+response[0].data.rzpOrderId;
											}
											else if (response[0].res == 'pay') {
												var options = {
													"key": response[0].data.rzp_api_key, 
													"amount": response[0].data.rzpAmount, 
													"currency": "INR",
													"name": response[0].data.product, 
													"description": response[0].data.description, 
													"image": response[0].data.logo, 
													"order_id": response[0].data.rzpOrderId, 
													"handler": function (rzpResponse){
														window.location.href=response[0].data.baseUrl+'Student/PaymentStatusUpdate/'+rzpResponse.razorpay_order_id+'/'+rzpResponse.razorpay_payment_id;
													},
													"prefill": {
														"name": response[0].data.enrollData.firstname+' '+response[0].data.enrollData.lastname,
														"email": response[0].data.enrollData.email,
														"contact": response[0].data.enrollData.mobile
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
											window.location.reload();
										}
									});
								});	
							</script>
							
						</body>
					</html>					