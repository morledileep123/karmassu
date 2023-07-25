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
                            <h4 class="page-title">Profile</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">Student Profile</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Student Profile</li>
							</ol>
						</div>
                        <div class="col-sm-3">
                            
						</div>
					</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card profile-card-2">
                                <div class="card-img-block">
                                    <img class="img-fluid" src="<?php echo base_url('uploads/logo.png');?>" >
								</div>
                                <div class="card-body pt-5">
                                    <img src="<?php if(empty($profile->profile_photo)){ echo base_url("uploads/user.png"); } else{ echo base_url("uploads/profile_photo/".$profile->profile_photo); } ?>" class="profile" alt="user avatar" style="height:80px;">
                                    <h5 class="card-title"><?=$profile->name;?></h5>
                                    <p class="card-text"><?=$profile->email;?></p>
                                    <p class="card-text"><?=$profile->number;?></p>
								</div>
                                
                                <div class="card-body border-top border-light">
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Education :</h6>
										</div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                                <h6 class="text-primary text-uppercase"><?=$profile->course;?></h6>
											</div>                   
										</div>
									</div>
                                    <hr>
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Address :</h6>
										</div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                                <h6 class="text-primary text-uppercase"><?=$profile->address;?></h6>
											</div>                   
										</div>
									</div>
                                    <hr>
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Live Sessions :</h6>
										</div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                                <h6 class="text-primary text-uppercase"><?=$live_session;?></h6>
											</div>                   
										</div>
									</div>
                                    <hr>
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Courses :</h6>
										</div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                                <h6 class="text-primary text-uppercase"><?=$courses;?></h6>
											</div>                   
										</div>
									</div>
                                    <hr>
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Books :</h6>
										</div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                                <h6 class="text-primary text-uppercase"><?=$books;?></h6>
											</div>                   
										</div>
									</div>
                                    <hr>
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Certificates :</h6>
										</div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
												<h6 class="text-primary text-uppercase"><?=$certificates;?></h6>
											</div>                   
										</div>
									</div>
								</div>
							</div>
                            
						</div>
                        
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#profile" data-toggle="pill" class="nav-link active"><i class="fa fa-user-circle"></i> <span class="hidden-xs">Update Profile</span></a>
										</li>
										<li class="nav-item">
                                            <a href="javascript:void();" data-target="#courses" data-toggle="pill" class="nav-link"><i class="zmdi zmdi-layers"></i> <span class="hidden-xs">Courses</span></a>
										</li>
										<li class="nav-item">
                                            <a href="javascript:void();" data-target="#ebooks" data-toggle="pill" class="nav-link"><i class="zmdi zmdi-book"></i> <span class="hidden-xs">E-Books</span></a>
										</li>
										<li class="nav-item">
                                            <a href="javascript:void();" data-target="#orderlist" data-toggle="pill" class="nav-link"><i class="zmdi zmdi-local-drink"></i> <span class="hidden-xs">Order History</span></a>
										</li>
										<li class="nav-item">
                                            <a href="javascript:void();" data-target="#livesession" data-toggle="pill" class="nav-link"><i class="fa fa-calendar"></i> <span class="hidden-xs">Live Sessions</span></a>
										</li>
									</ul>
                                    <div class="tab-content p-3">
                                        <div class="tab-pane active" id="profile">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <form action="<?php echo base_url("AdminPanel/ManageStudents/Update/".$profile->id); ?>" method="post"
                                                        enctype="multipart/form-data" id="updateform">
															
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                                            <input type="hidden" name="userid" value="<?php echo $profile->id;?>" />
                                                            <div class="form-group">
                                                                <input type="file" class="form-control dropify" name="profile_photo"  accept="image/jpg, image/png, image/jpeg, image/gif" data-height="100"  data-default-file="<?php if(empty($profile->profile_photo)){ echo base_url("uploads/user.png"); } else{ echo base_url("uploads/profile_photo/".$profile->profile_photo); } ?>">
                                                                <?php echo form_error("profile_photo", "<p class='text-danger' >", "</p>"); ?>
															</div>
                                                            <div class="form-group">
                                                                <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="name" placeholder="Name"
                                                                required value="<?php echo $profile->name;?>">
                                                                <?php echo form_error("name", "<p class='text-danger' >", "</p>"); ?>
															</div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="email" placeholder="Email Address"
                                                                required value="<?php echo $profile->email;?>">
                                                                <?php echo form_error("email", "<p class='text-danger' >", "</p>"); ?>
															</div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-form-label">Education <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="education" placeholder="Education"
                                                                required value="<?php echo $profile->course;?>">
                                                                <?php echo form_error("education", "<p class='text-danger' >", "</p>"); ?>
															</div>
                                                            <div class="form-group">
                                                                <label class="col-form-label">Address <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="address" placeholder="Address"
                                                                required value="<?php echo $profile->address;?>">
                                                                <?php echo form_error("address", "<p class='text-danger' >", "</p>"); ?>
															</div>
                                                            <div class="form-group">
                                                                <button type="submit" id="updateaction" name="updateaction" class="btn btn-primary"><i
																class="icon-lock"></i> Update Profile</button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										
										<div class="tab-pane" id="courses">
                                            <div class="row">
												<?php
													if(count($courseList)){
														foreach($courseList as $item){
														?>
														<div class="col-sm-6">
															<div class="card">
																<a href="<?php echo base_url('AdminPanel/ManageCourses/Details/'.$item->item->id);?>"><img src="<?php echo base_url('uploads/course/'.$item->item->banner);?>" class="card-img-top"></a>
																<div class="card-body">
																	<h5 class="card-title"><?php echo $item->item->name;?></h5>
																	
																	<b><?php echo $item->item->nooflecture; ?> </b> Lectures For <b>
																	<?php echo $item->item->daystofinish; ?> </b> Days
																	<?php
																		if ($item->item->certification == 'Yes') {
																			echo '<b class="text-danger">Certification</b>';
																		}
																	?>
																	<p>
																		<?php if($item->rating>0){ for($i=0;$i<$item->rating;$i++){?>
																			<i class="fas fa-star text-warning" aria-hidden="true"></i>
																		<?php }?>
																		(<?php echo $item->totalrating;?>)
																		<?php } else{ ?>
																		<br>
																		<?php } ?>
																	</p>
																	<ul class="list-group list-group-flush list shadow-none p-0">
																		<li class="list-group-item d-flex justify-content-between align-items-center p-1">
																			
																			<a href="<?php echo base_url('AdminPanel/ManageCourses/Details/'.$item->item->id);?>" class="btn btn-dark p-2"><i class="fa fa-folder-open"></i> View Course</a>
																			
																			
																			<?php if($item->item->certification=='Yes'){?>
																				<input title="Certificate Status" type="checkbox"
																				onchange="return CertificateStatus(this,'<?php echo $item->id; ?>')"
																				<?php if ($item->certificate == "true") {
																					echo "checked";
																				} ?> class="js-switch" data-color="#009999" data-size="small">
																				<?php if ($item->certificate == "true") { ?>
																					<a href="<?php echo base_url("Home/Certificate/".$item->refno) ?>" target="_blank" class="text-info">View Certificate</a>	
																				<?php } ?>
																				<?php } else { echo 'No Certification'; ?>
																			<?php }?>
																			
																		</li>
																	</ul>
																</div>
															</div>
														</div>
													<?php } } else{ ?>
													<div class="col-sm-12">
														<center>
															<img src="<?php echo base_url('image/NoRecordFound.png');?>" class="img-fluid"/>
															<br><br>
														</center>
													</div>
												<?php } ?>
											</div>
										</div>
										
										<div class="tab-pane" id="ebooks">
                                            <div class="row">
												<?php
													if(count($ebookList)){
														foreach($ebookList as $item){
														?>
														<div class="col-sm-6">
															<div class="card">
																<a href="<?php echo base_url('AdminPanel/ManageEBooks/Details/'.$item->item->id);?>"><img src="<?php echo base_url('uploads/ebook/'.$item->item->banner);?>" class="card-img-top"></a>
																<div class="card-body">
																	<h5 class="card-title"><?php echo $item->item->name;?></h5>
																	
																	<b><?php echo $item->item->noofpages; ?> </b> Pages For <b>
																	<?php echo $item->item->daystofinish; ?> </b> Days
																	<p>
																		<?php if($item->rating>0){ for($i=0;$i<$item->rating;$i++){?>
																			<i class="fas fa-star text-warning" aria-hidden="true"></i>
																		<?php }?>
																		(<?php echo $item->totalrating;?>)
																		<?php } else{ ?>
																		<br>
																		<?php } ?>
																	</p>
																	<ul class="list-group list-group-flush list shadow-none p-0">
																		<li class="list-group-item d-flex justify-content-between align-items-center p-1">
																			
																			<a href="<?php echo base_url('AdminPanel/ManageEbooks/Details/'.$item->item->id);?>" class="btn btn-dark p-2"><i class="fa fa-folder-open"></i> View E-Book</a>
																			
																		</li>
																	</ul>
																</div>
															</div>
														</div>
														<?php } } else{ 
													?>
													<div class="col-sm-12">
														<center>
															<img src="<?php echo base_url('image/NoRecordFound.png');?>" class="img-fluid"/>
															<br><br>
														</center>
													</div>
													<?php
													} ?>
											</div>
										</div>
										
										<div class="tab-pane" id="orderlist">
											<div class="row">
												
												<?php if (count($orderlist)) : ?>
												<?php foreach ($orderlist as $item) : ?>
												<div class="col-sm-12">
													<div class="card" >
														<ul class="list-group list-group-flush">
															<li class="list-group-item">
																<div class="media align-items-center">
																	<img src="<?php if($item->itemtype=='Course'){ echo base_url('uploads/course/'.$item->item->banner); } else{ echo base_url('uploads/ebook/'.$item->item->banner); }?>"  class="img-fluid" style="height:150px;">
																	<div class="media-body ml-3">
																		<h5 class="mb-0 text-dark"><?php echo $item->item->name;?> (<?php echo $item->itemtype;?>) </h5><br>
																		<p class="text-dark">Amount : <strong><i class="fa fa-inr"></i> <?php echo $item->price;?></strong></p>
																		<p class="text-dark">Date : <strong><?php echo $item->date;?> <?php echo $item->time;?></strong></p>
																		
																		
																	</div>
																	
																</div><br>
																<table class="table table-bordered">
																	<tr>
																		<th class="border-none">Name </th>
																		<td class="border-none"> <?php echo $item->firstname.' '. $item->lastname;?></td>
																	</tr>
																	<tr>
																		<th class="border-none">Mobile No </th>
																		<td class="border-none"> <?php echo $item->mobile;?></td>
																	</tr>
																	<tr>
																		<th class="border-none">Email </th>
																		<td class="border-none"><?php echo $item->email;?></td>
																	</tr>
																	<tr>
																		<th class="border-none">Qualification </th>
																		<td class="border-none"><?php echo $item->qualification;?></td>
																	</tr>
																	<tr>
																		<th class="border-none">Coupon Code </th>
																		<td class="border-none"> <?php if(empty($item->couponcode)){ echo 'Not Applied'; } else{ echo $item->couponcode; } ?></td>
																	</tr>
																	
																	<tr>
																		<th class="border-none">Order ID </th>
																		<td class="border-none"> <?php echo $item->rzp_orderid;?></td>
																	</tr>
																	<tr>
																		<th class="border-none">Payment ID </th>
																		<td class="border-none"> <?php echo $item->paymentid;?></td>
																	</tr>
																	
																	<tr>
																		<th class="border-none">Payment Status </th>
																		<td class="border-none"> 
																			<input type="checkbox"
																			onchange="return Status(this,'tbl_enroll','id','<?php echo $item->id; ?>','paymentstatus')"
																			<?php if ($item->paymentstatus == "success") {
																				echo "checked";
																			} ?> class="js-switch"
																			data-color="#eb5076" data-size="small">
																			<?php
																				if($item->paymentstatus=='success'){
																					echo '<strong class="text-success">Success</strong>';
																				}
																				else if($item->paymentstatus=='Pending'){
																					echo '<strong class="text-warning">Pending</strong>';
																				}
																				else if($item->paymentstatus=='failed'){
																					echo '<strong class="text-danger">Failed</strong>';
																				}
																			?></td>
																	</tr>
																	<tr>
																		<th class="border-none">Verify Payment  </th>
																		<td class="border-none"> 
																			<button class="btn btn-info p-1" onclick="VerifyPayment('<?php echo $item->rzp_orderid; ?>')"><i class="fa fa-check-circle"></i> Verify</button>
																		</td>
																	</tr>
																	<tr>
																		<th class="border-none">Invoice</th>
																		<td class="border-none"> 
																			<a class="btn btn-success p-1" href="<?php echo base_url('Home/Invoice/'.$item->id);?>" target="_blank"> View Invoice <i class="fa fa-angle-double-right"></i></a>
																		</td>
																	</tr>
																</table>
															</li>
														</ul>
														
													</div>
												</div>
												<?php endforeach; ?>
												<?php endif; ?>
												<?php if (!count($orderlist)) : ?>
												<p>No Record Available.</p>
												<?php endif; ?>
												
											</div>
										</div>
										<div class="tab-pane" id="livesession">
											<div class="row">
												<div class="col-sm-12 table-responsive">
													<table class="table table-bordered" id="example">
														<thead>
															<tr>
																<th>#</th>
																<th>Name</th>
																<th>Email</th>
																<th>Mobile</th>
																<th>Thumbnail</th>
																<th>Subject</th>
																<th>Tags</th>
																<th>Timing</th>
																<th>Duration</th>
																<th>User ID</th>
																<th>Password</th>
																<th>Title</th>
																<th>Description</th>
																<th>Link</th>
																<th>Date</th>
																<th>Time</th>
															</tr>
														</thead>
														<tbody>
															<?php
																$sr = 1;
																foreach ($livesessionlist as $item) {
																?>
																<tr>
																	<td><?php echo $sr; ?></td>
																	
																	<td>
																		<?php echo $item->name; ?>
																	</td>
																	<td>
																		<?php echo $item->email; ?>
																	</td>
																	<td>
																		<?php echo $item->mobile; ?>
																	</td>
																	<td> <label data-toggle="tooltip" data-placement="top"
																		title="ID: <?php echo $item->item->id; ?>"><a
																			href="<?php echo base_url("uploads/live_video/".$item->item->thumbnail); ?>"
																			target="_blank"><img
																				data-src="<?php echo base_url("uploads/live_video/".$item->item->thumbnail); ?>"
																				src="<?php echo base_url("images/Preloader2.jpg"); ?>"
																			class="lazy" style="height:50px;" /> </a></label>
																	</td>
																	<td>
																		<?php echo $item->item->subject; ?>
																	</td>
																	<td>
																		<?php echo $item->item->tags; ?>
																	</td>
																	<td>
																		<?php echo $item->item->timing; ?>
																	</td>
																	<td>
																		<?php echo $item->item->duration; ?>
																	</td>
																	<td>
																		<?php echo $item->item->userid; ?>
																	</td>
																	<td>
																		<?php echo $item->item->password; ?>
																	</td>
																	<td>
																		<?php echo $item->item->title; ?>
																	</td>
																	<td>
																		<?php echo $item->item->description; ?>
																	</td>
																	<td>
																		<a href="<?php echo $item->item->link; ?>" target="_blank"><?php echo $item->item->link; ?></a>
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
	<?php  include("CertificateStatus.php");  ?>
	<script>
		function VerifyPayment(id) {
			$("#VerifyModal").modal("show");
			$("#VerifyModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
			$("#VerifyModal .modal-body").load("<?php echo base_url('AdminPanel/VerifyPayment/') ?>" + id);
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