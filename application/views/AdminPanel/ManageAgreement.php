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
							<h4 class="page-title"> Manage Agreement</h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="javaScript:void();">Manage Educators</a></li>
								<li class="breadcrumb-item active" aria-current="page">Agreement</li>
							</ol>
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
													<th>Educator</th>
													<th>Signature</th>
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
														<td><?php echo $educatorData->name.' ('.$educatorData->designation.')'; ?><br>
                                                            [<?php echo $educatorData->username;?>]
														</td>
														<td> <a target="_blank" href="<?=base_url('uploads/agreement/'.$item->signature);?>"><img src="<?=base_url('uploads/agreement/'.$item->signature);?>"  style="height:100px;"/></a> </td>
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
					text: "You want to "+status+" this Agreement !",
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
								swal("This Agreement is "+value+" successfully !", {
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