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
							<h4 class="page-title"> Course Enrollments</h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="javaScript:void();">Course</a></li>
								<li class="breadcrumb-item active" aria-current="page">Course Enrollments</li>
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
													<th>Status</th>
													<th>Course</th>
													
													<th>Price</th>
													<th>Order ID</th>
													<th>Date</th>
													<th>Time</th>
												</tr>
											</thead>
											
											
											<tbody>
												<?php
													$sr = 1;
													foreach ($list as $item) {
														$itemData=$this->Auth_model->getData('tbl_course',$item->itemid);
													?>
													<tr>
														<td><?php echo $sr; ?></td>
														<td>
														<!--
															<input type="checkbox"
															onchange="return Status(this,'tbl_enroll','id','<?php echo $item->id; ?>','paymentstatus')"
															<?php if ($item->paymentstatus == "success") {
																echo "checked";
															} ?> class="js-switch"
															data-color="#eb5076" data-size="small">-->
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
														<?php echo $itemData->name;?>
															<a href="<?php echo base_url("Educator/ManageCourses/Details/$item->itemid") ?>"
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
				return fetch('<?php echo base_url("Educator/TransactionPassword/")?>'+name);
			})
			.then(results => {
				return results.json();
			})
			.then(json => {
				if(json.res=='success')
				{
					$.ajax({
						url: "<?php echo base_url("Educator/UpdateStatus"); ?>",
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