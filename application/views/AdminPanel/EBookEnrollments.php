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
							<h4 class="page-title"> E-Book Enrollments</h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="javaScript:void();">E-Book</a></li>
								<li class="breadcrumb-item active" aria-current="page">E-Book Enrollments</li>
							</ol>
						</div>
						<div class="col-sm-3">
							
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									<a class="btn <?php if($this->uri->segment(3)=='success'){ echo 'btn btn-success'; } else{ echo 'btn btn-outline-success'; }?>" href="<?php echo base_url('AdminPanel/EBookEnrollments/success');?>">Success</a>
									<a class="btn <?php if($this->uri->segment(3)=='failed'){ echo 'btn btn-danger'; } else{ echo 'btn btn-outline-danger'; }?>" href="<?php echo base_url('AdminPanel/EBookEnrollments/failed');?>">Failed</a>
									<a class="btn <?php if($this->uri->segment(3)=='Pending'){ echo 'btn btn-warning'; } else{ echo 'btn btn-outline-warning'; }?>" href="<?php echo base_url('AdminPanel/EBookEnrollments/Pending');?>">Pending</a>
								</div>
								<div class="card-header">
                                    <form action="" method="GET">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label>Select Educator <span class="text-danger">*</span> </label>
                                                    <select class="form-control" name="author">
                                                        <option selected disabled>Select</option>
                                                        <option value="">All Enrollments</option>
                                                        <?php foreach($authorlist as $item){ ?>
                                                            <option value="<?php echo $item->id;?>"><?php echo $item->name.' ('.$item->designation.')'; ?><br>
															[<?php echo $item->username;?>]</option>
														<?php } ?>
													</select>
												</div>
											</div>
                                            <div class="col-sm-4"><br>
                                                <div class="form-group">
                                                    <button class="btn btn-success" type="submit"><i class="bi bi-search"></i>Filter</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										
										<table class="table table-bordered wrap" id="example" style="width:100%;">
											<thead>
												<tr>
													<th>#</th>
													<?php if($this->uri->segment(3)=='success'){ ?>
														<th>Educator Status</th>
													<?php } ?>
													<th>Payment Status</th>
													<th>EBook</th>
													<th>Name</th>
													<th>Mobile</th>
													<th>Email</th>
													<th>Qualification</th>
													<th>Coupon</th>
													<th>Price</th>
													<th>Order ID</th>
													<th>Razorpay Order ID</th>
													<th>Payment ID</th>
													<th>Date</th>
													<th>Time</th>
												</tr>
											</thead>
											
											<tbody>
												<?php
													$sr = 1;
													foreach ($list as $item) {
														$educatorData=$this->Auth_model->getEducator($item->itemtype,$item->itemid);
													?>
													<tr>
														<td><?php echo $sr; ?></td>
														<?php if($this->uri->segment(3)=='success'){ ?>
															<td>
																<?php if(isset($educatorData->name)) echo $educatorData->name.' ('.$educatorData->designation.')'; ?><br>
																[<?php if(isset($educatorData->username)) echo $educatorData->username;?>]
																<input type="checkbox"
																onchange="return EducatorStatus(this,'tbl_enroll','id','<?php echo $item->id; ?>','educator_status')" <?php if ($item->educator_status == 'true') { echo "checked"; } ?> class="js-switch" data-color="#1da1f2" data-size="small">
															</td>
														<?php } ?>
														<td>
															<input type="checkbox"
															onchange="return Status(this,'tbl_enroll','id','<?php echo $item->id; ?>','paymentstatus')"
															<?php if ($item->paymentstatus == "success") {
																echo "checked";
															} ?> class="js-switch"
															data-color="#eb5076" data-size="small">
															<?php
																if($item->paymentstatus=='success'){
																	echo '<b class="text-success">Success</b>';
																}
																else if($item->paymentstatus=='failed'){
																	echo '<b class="text-danger">Failed</b>';
																}
																else if($item->paymentstatus=='Pending'){
																	echo '<b class="text-warning">Pending</b>';
																}
															?>
														</td>
														<td>
															<a href="<?php echo base_url("AdminPanel/ManageEBooks/Details/$item->itemid") ?>"
															class="btn btn-sm btn-info waves-effect waves-light">
															<i class="fa fa-eye"></i> </a>
														</td>
														<td>
															<?php echo $item->firstname.' '.$item->lastname; ?>
															
														</td>
														<td>
															<?php echo $item->mobile; ?>
														</td>
														<td>
															<?php echo $item->email; ?>
														</td>
														<td>
															<?php echo $item->qualification; ?>
														</td>
														<td>
															<?php echo $item->couponcode; ?>
														</td>
														<td>
															<i class="fa fa-inr"></i> <?php echo $item->price; ?>
														</td>
														<td>
															<?php echo $item->orderid; ?>
														</td>
														<td>
															<?php echo $item->rzp_orderid; ?>
															<button class="btn btn-info p-1" onclick="VerifyPayment('<?php echo $item->rzp_orderid; ?>')"><i class="fa fa-check-circle"></i> Verify</button>
														</td>
														<td>
															<?php echo $item->paymentid; ?>
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
				<div class="modal-dialog">
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
			$("#VerifyModal .modal-body").load("<?php echo base_url('AdminPanel/VerifyPayment/') ?>" + id);
		}
	</script>
	<script>
		
		function EducatorStatus(e, table, where_column, where_value, column) {
			var status = true;
			var check = $(e).prop("checked");
			if (check) {
				swal({
					title: "Are you sure?",
					text: "You want to show this enrollment in Educator Panel.",
					icon: "warning",
					buttons: true,
					dangerMode: true
					}).then((willDelete) => {
					if (willDelete) {
						$.ajax({
							url: "<?php echo base_url("AdminPanel/UpdateStatus"); ?>",
							type: "post",
							data: {
								'table': table,
								'column': column,
								'value': 'true',
								'where_column': where_column,
								'where_value': where_value
							},
							success: function(response) {
								swal("Sucsessfully Updated.", {
									icon: "success",
								});
							}
						});
					}
				});
				} else {
				swal({
					title: "Are you sure?",
					text: "You want to hide this enrollment in Educator Panel.",
					icon: "warning",
					buttons: true,
					dangerMode: true
					}).then((willDelete) => {
					if (willDelete) {
						$.ajax({
							url: "<?php echo base_url("AdminPanel/UpdateStatus"); ?>",
							type: "post",
							data: {
								'table': table,
								'column': column,
								'value': 'false',
								'where_column': where_column,
								'where_value': where_value
							},
							success: function(response) {
								swal("Successfully Updated.", {
									icon: "success",
								});
							}
						});
					}
				});
			}
			return status;
		}
		function Status(e, table, where_column, where_value, column) {
			var status = 'success';
			var check = $(e).prop("checked");
			if (check) {
				swal({
					title: "Are you sure?",
					text: "You want to activate this Enrollment !",
					icon: "warning",
					buttons: true,
					dangerMode: true
					}).then((willDelete) => {
					if (willDelete) {
						$.ajax({
							url: "<?php echo base_url("AdminPanel/UpdateStatus"); ?>",
							type: "post",
							data: {
								'table': table,
								'column': column,
								'value': 'success',
								'where_column': where_column,
								'where_value': where_value
							},
							success: function(response) {
								swal("This Enrollment is activated successfully !", {
									icon: "success",
								});
								location.reload();
							}
						});
					}
				});
				} else {
				swal({
					title: "Are you sure?",
					text: "You want to deactivate this Enrollment !",
					icon: "warning",
					buttons: true,
					dangerMode: true
					}).then((willDelete) => {
					if (willDelete) {
						$.ajax({
							url: "<?php echo base_url("AdminPanel/UpdateStatus"); ?>",
							type: "post",
							data: {
								'table': table,
								'column': column,
								'value': 'failed',
								'where_column': where_column,
								'where_value': where_value
							},
							success: function(response) {
								swal("This Enrollment is deactivated successfully !", {
									icon: "success",
								});
								location.reload();
							}
						});
					}
				});
			}
			return status;
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