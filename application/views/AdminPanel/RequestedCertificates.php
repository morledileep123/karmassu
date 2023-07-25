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
							<h4 class="page-title"> Requested Certificates</h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="javaScript:void();">Manage Certificates</a></li>
								<li class="breadcrumb-item active" aria-current="page">Requested Certificates</li>
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
													<th>Certificate</th>
													<th>Profile</th>
													<th>Reference No</th>
													<th>Name</th>
													<th>Mobile</th>
													<th>Email</th>
													<th>Issued On</th>
													<th>Grade</th>
													<th>Duration</th>
													<th>From Date</th>
													<th>To Date</th>
													<th>Date</th>
													<th>Time</th>
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
															onchange="return CertificateStatus(this,'<?php echo $item->enrollid; ?>')"
															<?php if ($item->status == "true") {
																echo "checked";
															} ?> class="js-switch" data-color="#009999" data-size="small">
															<?php if ($item->status == "true") { ?>
																<a href="<?php echo base_url("Home/Certificate/".$item->refno) ?>" target="_blank" class="text-info">View Certificate</a>	
															<?php } ?>
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
															<?php echo $item->email; ?>
														</td>
														<td>
															<?php echo $item->issuedon; ?>
														</td>
														<td>
															<?php echo $item->grade; ?>
														</td>
														<td>
															<?php echo $item->duration; ?>
														</td>
														<td>
															<?php echo $item->from_date; ?>
														</td>
														<td>
															<?php echo $item->to_date; ?>
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
			<?php include("Footer.php"); ?>
		</div>
		
		<?php include("FooterLinking.php"); ?>
		<?php  include("CertificateStatus.php");  ?>
		
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