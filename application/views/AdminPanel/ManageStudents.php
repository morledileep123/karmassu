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
							<h4 class="page-title"> Manage Students</h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="javaScript:void();">Students</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Students</li>
							</ol>
						</div>
						<div class="col-sm-3">
							
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									
								</div>
								<div class="card-body">
									<div class="table-responsive">
										
										<table class="table table-bordered wrap" id="example" style="width:100%;">
											<thead>
												<tr>
													<th>#</th>
													<th>Status</th>
													<th>Profile</th>
													<th>Name</th>
													<th>Mobile</th>
													<th>Email</th>
													<th>Password</th>
													<th>Education</th>
													<th>Address</th>
													<th>OTP</th>
													<th>Date</th>
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
															onchange="return Status(this,'tbl_registration','id','<?php echo $item->id; ?>','status')"
															<?php if ($item->status == "true") {
																echo "checked";
															} ?> class="js-switch" data-color="#eb5076" data-size="small">
															
														</td>
														<td>
															<a href="<?php echo base_url('AdminPanel/ManageStudents/Profile/'.$item->id);?>" class="btn btn-info p-1"> <i class="fa fa-user-circle"></i> Profile</a>
															
														</td>
														<td>
															<?php echo $item->name; ?>
														</td>
														<td>
															<?php echo $item->number; ?>
														</td>
														<td>
															<?php echo $item->email; ?>
														</td>
														<td>
															<?php echo $item->password; ?>
														</td>
														<td>
															<?php echo $item->course; ?>
														</td>
														<td>
															<?php echo $item->address; ?>
														</td>
														<td>
															<?php echo $item->otp; ?>
														</td>
														<td>
															<?php echo $item->date; ?>
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
		</div>
		
		<?php include("FooterLinking.php"); ?>
		
		
		<script>
			function Status(e, table, where_column, where_value, column) {
				var status = 'true';
				var check = $(e).prop("checked");
				if (check) {
					swal({
						title: "Are you sure?",
						text: "You want to activate this Student!",
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
									swal("This Student is activated successfully !", {
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
						text: "You want to deactivate this Student!",
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
									swal("This Student is deactivated successfully !", {
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
		
		
	</body>
	
</html>