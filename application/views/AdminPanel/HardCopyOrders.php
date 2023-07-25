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
							<h4 class="page-title"> <?php echo $pageTitle;?></h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="javaScript:void();">Manage Certificates</a></li>
								<li class="breadcrumb-item active" aria-current="page"><?php echo $pageTitle;?></li>
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
										
										<table class="table table-bordered wrap" id="example" style="width:100%;">
											<thead>
												<tr>
													<th>#</th>
													<th>Payment Status</th>
													<th>Profile</th>
													<th>Reference No</th>
													<th>Name</th>
													<th>Mobile No</th>
													<th>Alt Mobile No</th>
													<th>Email</th>
													<th>Address</th>
													<th>Pincode</th>
													<th>State</th>
													<th>Country</th>
													<th>Latitude</th>
													<th>Longitude</th>
													<th>Distance</th>
													<th>Certificate Charge</th>
													<th>KM Charge</th>
													<th>Amount</th>
													<th>Order ID</th>
													<th>Rzp Order ID</th>
													<th>Payment ID</th>
													<th>Order Status</th>
													<th>Expected Date</th>
													<th>Delivery Date</th>
													<th>Date</th>
													<th>Time</th>
													<th>Tracking</th>
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
															<input type="checkbox"
															onchange="return Status(this,'tbl_certificate_order','id','<?php echo $item->id; ?>','status')"
															<?php if ($item->status == "success") {
																echo "checked";
															} ?> class="js-switch"
															data-color="#eb5076" data-size="small">
															<?php
																if($item->status=='success'){
																	echo '<b class="text-success">Success</b>';
																}
																else if($item->status=='failed'){
																	echo '<b class="text-danger">Failed</b>';
																}
																else if($item->status=='Pending'){
																	echo '<b class="text-warning">Pending</b>';
																}
															?>
														</td>
														<td>
															<a href="<?php echo base_url('AdminPanel/ManageStudents/Profile/'.$item->userid);?>" class="btn btn-info p-1"> <i class="fa fa-user-circle"></i> Profile</a>
															
														</td>
														<td>
															<?php echo $item->refno; ?>
														</td>
														<td>
															<?php echo $item->name; ?>
														</td>
														<td>
															<?php echo $item->mobile; ?>
														</td>
														<td>
															<?php echo $item->alt_mobile; ?>
														</td>
														<td>
															<?php echo $item->email; ?>
														</td>
														<td>
															<?php echo $item->address; ?>
														</td>
														<td>
															<?php echo $item->pincode; ?>
														</td>
														<td>
															<?php echo $item->state; ?>
														</td>
														<td>
															<?php echo $item->country; ?>
														</td>
														<td> <?php echo $item->latitude; ?> </td>
														<td> <?php echo $item->longitude; ?> </td>
														<td> <?php echo $item->distance; ?> KM </td>
														<td><i class="fa fa-inr"></i> <?php echo $item->certificate_charge; ?> </td>
														<td><i class="fa fa-inr"></i> <?php echo $item->km_charge; ?> </td>
														<td><i class="fa fa-inr"></i> <?php echo $item->amount; ?> </td>
														<td> <?php echo $item->orderid; ?> </td>
														<td> <?php echo $item->rzp_orderid; ?> 
															<button class="btn btn-info p-1" onclick="VerifyPayment('<?php echo $item->rzp_orderid; ?>')"><i class="fa fa-check-circle"></i> Verify</button>
														</td>
														<td> <?php echo $item->paymentid; ?> </td>
														
														<td> <?php echo $item->order_status; ?> </td>
														<td> <?php echo $item->expected_date; ?> </td>
														<td> <?php echo $item->delivery_date; ?> </td>
														<td> <?php echo $item->date; ?> </td>
														<td> <?php echo $item->time; ?> </td>
														
														
														<td><a href="javascript:void(0);"
															class="btn btn-sm btn-outline-info waves-effect waves-light"
															onclick="Edit('<?php echo $item->id; ?>')">
															<i class="fa fa fa-edit"></i> </a>
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
		<!--Modal Start-->
		<div class="modal fade" id="EditModal">
			<div class="modal-dialog">
				<div class="modal-content border-primary">
					<div class="modal-header bg-primary">
						<h5 class="modal-title text-white">Tracking</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					
					<form action="<?php echo base_url("AdminPanel/ManageCertificates/UpdateOrders"); ?>" method="post"
					enctype="multipart/form-data" id="updateform">
						<div class="modal-body">
							
						</div>
						<div class="modal-footer d-block">
							<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
							value="<?= $this->security->get_csrf_hash(); ?>" />
							<button type="submit" id="updateaction" name="updateaction" class="btn btn-primary"><i
							class="icon-lock"></i> Submit</button>
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
			$("#VerifyModal .modal-body").load("<?php echo base_url('AdminPanel/VerifyPayment/') ?>" + id);
		}
		function Edit(id) {
			$("#EditModal").modal("show");
			$("#EditModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
			$("#EditModal .modal-body").load("<?php echo base_url('AdminPanel/ManageCertificates/UpdateOrders/') ?>" + id);
		}
	</script>
	<script>
		function Status(e, table, where_column, where_value, column) 
		{
			var check = $(e).prop("checked");
			if(check){
				var status = 'success';
			}
			else{
				var status = 'failed';
			}
			swal({
				text: 'Enter transaction password to update payment status.',
				content: "input",
				button: {
					text: "Submit",
					closeModal: false,
				},
			})
			.then(name => {
				if (!name) throw null;
				return fetch('<?php echo base_url("AdminPanel/TransactionPassword/")?>'+name);
			})
			.then(results => {
				return results.json();
			})
			.then(json => {
				if(json.res=='success')
				{
					$.ajax({
						url: "<?php echo base_url("AdminPanel/UpdateStatus"); ?>",
						type: "post",
						data: {
							'table': table,
							'column': column,
							'value': status,
							'where_column': where_column,
							'where_value': where_value
						},
						success: function(response) {
							swal("Payment status updated.", { icon: "success", });
							location.reload();
						}
					});
				}
				else{
					swal("Invalid transaction password.", { icon: "error", });
					location.reload();
				}
				
			})
			.catch(err => {
				
				if (err) {
					swal("Enter transaction password.", { icon: "error", });
					location.reload();
					} else {
					swal.stopLoading();
					swal.close();
				}
			});
		}
		
		
	</script>
	<?php
		if ($this->session->flashdata("res") == "error") {
		?>
		<script>
			$(document).ready(function() {
				Lobibox.notify('warning', {
					pauseDelayOnHover: true,
					size: 'mini',
					rounded: true,
					delayIndicator: false,
					icon: 'fa fa-exclamation-circle',
					continueDelayOnInactiveTab: false,
					position: 'top right',
					msg: '<?php echo $this->session->flashdata("msg");?>'
				});
			})
		</script>
		<?php
			} else if ($this->session->flashdata("res") == "success") {
		?>
		<script>
			$(document).ready(function() {
				Lobibox.notify('success', {
					pauseDelayOnHover: true,
					size: 'mini',
					rounded: true,
					icon: 'fa fa-check-circle',
					delayIndicator: false,
					continueDelayOnInactiveTab: false,
					position: 'top right',
					msg: '<?php echo $this->session->flashdata("msg");?>'
				});
			});
		</script>
		<?php
			} else if ($this->session->flashdata("res") == "upload_error") {
		?>
		<script>
			$(document).ready(function() {
				Lobibox.notify('error', {
					pauseDelayOnHover: true,
					size: 'mini',
					rounded: true,
					delayIndicator: false,
					icon: 'fa fa-times-circle',
					continueDelayOnInactiveTab: false,
					position: 'top right',
					msg: '<?php echo $this->session->flashdata("msg");?>'
				});
			});
		</script>
		<?php
		}
	?>
	
	
</body>

</html>