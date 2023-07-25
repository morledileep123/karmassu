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
															<?php if($item->itemtype=='Course') { ?>
															<input type="checkbox"
															onchange="return CertificateStatus(this,'<?php echo $item->enrollid; ?>')" <?php if ($item->status == "true") { echo "checked"; } ?> class="js-switch" data-color="#009999" data-size="small">
															<?php } else { ?>
															<input type="checkbox"
															onchange="return CertificateStatusLive(this,'<?php echo $item->enrollid; ?>')" <?php if ($item->status == "true") { echo "checked"; } ?> class="js-switch" data-color="#009999" data-size="small">
															<?php }?>
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
			<!--Modal Start-->
			<div class="modal fade" id="CertificateModal">
				<div class="modal-dialog modal-lg">
					<div class="modal-content border-primary">
						<div class="modal-header bg-primary">
							<h5 class="modal-title text-white">Certificate</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						
						<form action="<?php echo base_url("AdminPanel/CertificateStatus/Update"); ?>" method="POST" id="registerForm">
							<div class="modal-body">
								
							</div>
							<div class="modal-footer d-block">
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
								value="<?= $this->security->get_csrf_hash(); ?>" />
								<button type="submit" id="registerBtn" class="btn btn-primary"><i
								class="icon-lock"></i> Submit <i class="fa fa-spin fa-spinner" id="registerSpin" style="display:none;"></i></button>
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
			function CertificateStatusLive(e,id) {
				$('#registerForm').attr('action', '<?php echo base_url("AdminPanel/CertificateStatusLive/Update"); ?>');
				var status = 'true';
				var check = $(e).prop("checked");
				if (check) {
					swal({
						title: "Are you sure?",
						text: "Do you want to Issued this Certificate !",
						icon: "warning",
						buttons: true,
						dangerMode: true
						}).then((willDelete) => {
						if (willDelete) {
							$("#CertificateModal").modal("show");
							$("#CertificateModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
							$("#CertificateModal .modal-body").load("<?php echo base_url('AdminPanel/CertificateStatusLive/Edit/');?>"+id+"/"+status);
						}
					});
					} else {
					var status = 'false';
					swal({
						title: "Are you sure?",
						text: "Do you want to Non-Issued this Certificate !",
						icon: "warning",
						buttons: true,
						dangerMode: true
						}).then((willDelete) => {
						if (willDelete) {
							$("#CertificateModal").modal("show");
							$("#CertificateModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
							$("#CertificateModal .modal-body").load("<?php echo base_url('AdminPanel/CertificateStatusLive/Edit/');?>"+id+"/"+status);
						}
					});
				}
				return status;
			}
		</script>
		<script>
			
			function CertificateStatus(e,id) {
				$('#registerForm').attr('action', '<?php echo base_url("AdminPanel/CertificateStatus/Update"); ?>');
				var status = 'true';
				var check = $(e).prop("checked");
				if (check) {
					swal({
						title: "Are you sure?",
						text: "Do you want to Issued this Certificate !",
						icon: "warning",
						buttons: true,
						dangerMode: true
						}).then((willDelete) => {
						if (willDelete) {
							$("#CertificateModal").modal("show");
							$("#CertificateModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
							$("#CertificateModal .modal-body").load("<?php echo base_url('AdminPanel/CertificateStatus/Edit/');?>"+id+"/"+status);
						}
					});
					} else {
					var status = 'false';
					swal({
						title: "Are you sure?",
						text: "Do you want to Non-Issued this Certificate !",
						icon: "warning",
						buttons: true,
						dangerMode: true
						}).then((willDelete) => {
						if (willDelete) {
							$("#CertificateModal").modal("show");
							$("#CertificateModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
							$("#CertificateModal .modal-body").load("<?php echo base_url('AdminPanel/CertificateStatus/Edit/');?>"+id+"/"+status);
						}
					});
				}
				return status;
			}
			
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
						
						console.log(response);
						
						var response = JSON.parse(response);
						$("#registerBtn").removeAttr("disabled");
						$('#registerSpin').hide();
						if (response[0].res == 'success') 
						{
							$('.notifyjs-wrapper').remove();
							$.notify("" + response[0].msg + "", "success");
							window.setTimeout(function() {
								window.location.reload();
							}, 1000);
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