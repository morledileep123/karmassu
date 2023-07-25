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
						<div class="col-sm-12">
							<h4 class="page-title"> Manage KYC</h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="javaScript:void();">Manage Educators</a></li>
								<li class="breadcrumb-item active" aria-current="page">KYC Management</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									<a class="btn <?php if($this->uri->segment(3)=='Approved'){ echo 'btn btn-success'; } else{ echo 'btn btn-outline-success'; }?>" href="<?php echo base_url('AdminPanel/ManageKYC/Approved');?>">Approved</a>
									<a class="btn <?php if($this->uri->segment(3)=='Rejected'){ echo 'btn btn-danger'; } else{ echo 'btn btn-outline-danger'; }?>" href="<?php echo base_url('AdminPanel/ManageKYC/Rejected');?>">Rejected</a>
									<a class="btn <?php if($this->uri->segment(3)=='Pending'){ echo 'btn btn-warning'; } else{ echo 'btn btn-outline-warning'; }?>" href="<?php echo base_url('AdminPanel/ManageKYC/Pending');?>">Pending</a>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										
										<table class="table table-bordered wrap" id="example" style="width:100%;">
											<thead>
												<tr>
													<th>#</th>
													<th>Status</th>
													<th>Educator</th>
													<th>Bank Name</th>
													<th>Branch Name</th>
													<th>IFSC Code</th>
													<th>Account No</th>
													<th>Account Holder Name</th>
													<th>Account Holder Mobile No</th>
													<th>UPI ID</th>
													<th>Document Type</th>
													<th>Document No</th>
													<th>Document Proof</th>
													<th>Date</th>
													<th>Time</th>
												</tr>
											</thead>
											
											
											<tbody>
												<?php
													$sr = 1;
													foreach ($list as $item) {
														$educatorData=$this->Auth_model->getData('tbl_tutor',$item->userid);
													?>
													<tr>
														<td><?php echo $sr; ?></td>
														<td>
															<?php
																if($item->status=='Pending'){
																?>
																<button class="btn btn-sm btn-success" onclick="Status('tbl_kyc','id','<?php echo $item->id; ?>','status','Approve','Approved')"><i class="fa fa-check-circle"></i> Approve</button>
																<button class="btn btn-sm btn-danger" onclick="Status('tbl_kyc','id','<?php echo $item->id; ?>','status','Reject','Rejected')"><i class="fa fa-times-circle"></i> Reject</button>
																<?php
																}
																else if($item->status=='Approved'){
																	echo '<p class="text-success">'.$item->status.'</p>';
																}
																else{
																	echo '<p class="text-danger">'.$item->status.'</p>';
																}
															?>
														</td>
														<td><?php echo $educatorData->name.' ('.$educatorData->designation.')'; ?><br>
                                                            [<?php echo $educatorData->username;?>]
														</td>
														<td> <?php echo $item->bank; ?> </td>
														<td> <?php echo $item->branch; ?> </td>
														<td> <?php echo $item->ifsc; ?> </td>
														<td> <?php echo $item->account_no; ?> </td>
														<td> <?php echo $item->name; ?> </td>
														<td> <?php echo $item->mobile; ?> </td>
														<td> <?php echo $item->upi; ?> </td>
														<td> <?php echo $item->document_type; ?> </td>
														<td> <?php echo $item->document_no; ?> </td>
														<td> <a target="_blank" href="<?=base_url('uploads/kyc/'.$item->document_proof);?>"><img src="<?=base_url('uploads/kyc/'.$item->document_proof);?>"  style="height:200px;"/></a> </td>
														<td> <?php echo $item->date; ?> </td>
														<td> <?php echo $item->time; ?> </td>
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
			function Status(table,where_column,where_value,column,status,value) 
			{
				swal({
					title: "Are you sure?",
					text: "You want to "+status+" this kyc !",
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
								'value': value,
								'where_column': where_column,
								'where_value': where_value
							},
							success: function(response) 
							{
								swal("This kyc is "+value+" successfully !", {
									icon: "success",
								});
								window.location.reload();
							}
						});
					}
				});
			}
			
		</script>
		
	</body>
	
</html>