<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<?php
    if (isset($action)) 
    {
        switch ($action) 
        {
			
            case 'Joined';
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
									<h4 class="page-title"> Joined Live Sessions</h4>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="javascript:void();">Live Sessions</a></li>
										<li class="breadcrumb-item active" aria-current="page">Manage Live Sessions</li>
									</ol>
								</div>
								<div class="col-sm-3">
									
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="card">
										<div class="card-header">
											<a class="btn btn-success" href="<?php echo base_url('AdminPanel/ManageLiveVideo');?>"><i
											class="fa fa-arrow-left"></i>  Back To Live Sessions</a>
											<button class="btn btn-dark" style="float:right;" onclick="window.location.reload();"><i class="fa fa-refresh" aria-hidden="true"></i>  Refresh</button>
										</div>
										<div class="card-body">
											<div class="table-responsive">
												
												<table class="table table-bordered" id="example">
													<thead>
														<tr>
															<th>#</th>
															<?php if($list[0]->certification=='Yes'){ ?>
																<th>Certificate</th>
															<?php } ?>
															<th>Name</th>
															<th>Email</th>
															<th>Mobile</th>
															<th>Date</th>
															<th>Time</th>
														</tr>
													</thead>
													<tbody>
														<?php 
															$sr = 1;
															foreach ($liveJoined as $item) {
																$userData=$this->Auth_model->getData('tbl_registration',$item->id);
															?>
															<tr>
																<td><?php echo $sr; ?></td>
																
																<?php if($list[0]->certification=='Yes'){ ?>
																	<td>
																		<input type="checkbox"
																		onchange="return CertificateStatusLive(this,'<?php echo $item->id; ?>')"
																		<?php if ($item->certificate == "true") {
																			echo "checked";
																		} ?> class="js-switch" data-color="#009999" data-size="small">
																		<?php if ($item->certificate == "true") { ?>
																			<a href="<?php echo base_url("Home/Certificate/".$item->refno) ?>" target="_blank" class="text-info">View Certificate</a>	
																		<?php } ?>
																	</td>
																<?php } ?>
																
																<td>
																	<?php echo $userData->name; ?>
																</td>
																<td>
																	<?php echo $userData->email; ?>
																</td>
																<td>
																	<?php echo $userData->number; ?>
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
								
								<form action="<?php echo base_url("AdminPanel/CertificateStatusLive/Update"); ?>" method="POST" id="registerForm">
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
			</body>
			
		</html>
		<?php
			break;
			
			case 'Questions';
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
									<h4 class="page-title"> Questions</h4>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="javascript:void();">Live Sessions</a></li>
										<li class="breadcrumb-item active" aria-current="page">Questions</li>
									</ol>
								</div>
								<div class="col-sm-3">
									
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="card">
										<div class="card-header">
											<a class="btn btn-success" href="<?php echo base_url('AdminPanel/ManageLiveVideo');?>"><i
											class="fa fa-arrow-left"></i>  Back To Live Sessions</a>
											<button class="btn btn-dark" style="float:right;" onclick="window.location.reload();"><i class="fa fa-refresh" aria-hidden="true"></i>  Refresh</button>
										</div>
										<div class="card-body">
										    <ul class="list-group list-group-flush">
            									<?php if(count($questions)) : $i=1;?>
            									<?php foreach($questions as $item) : ?>
            									<li class="list-group-item">
            										<div class="media align-items-center">
            											<img src="<?php if(empty($item->user->profile_photo)){ echo base_url("image/user-icon.png"); } else{ echo base_url("uploads/profile_photo/".$item->user->profile_photo); } ?>" class="customer-img rounded-circle" style="height:60px;width:60px;">
            											<div class="media-body ml-3">
            												<h6 class="mb-0"><?php echo $item->user->name;?> </h6>
            												<p class="mb-0 small-font"><?php echo $item->message;?></p>
            												<p class="mb-0 small-font">Date: <?php echo $item->date;?> <?php echo $item->time;?></p>
            												<input type="checkbox"
                                                            onchange="return questionstatus(this,'tbl_video_question','id','<?php echo $item->id;?>','status')" <?php if ($item->status == "true") {
                                                                echo "checked";
            												} ?> class="js-switch"  data-color="#eb5076" data-size="small">
            											</div>
            										</div>
            										<ul class="list-group list-group-flush">
            											<?php if(count($item->reply)) : ?>
            											<?php foreach($item->reply as $reply) : ?>
            											<li class="list-group-item">
            												<div class="media align-items-center">
            													<img src="<?php if(empty($reply->user->profile_photo)){ echo base_url("uploads/logo.png"); } else{ echo base_url("uploads/".$reply->user->profile_photo); } ?>" class="customer-img rounded-circle" style="height:60px;width:60px;">
            													<div class="media-body ml-3">
            														<h6 class="mb-0"><?php echo $reply->user->name;?> </h6>
            														<p class="mb-0 small-font"><?php echo $reply->message;?></p>
            														<p class="mb-0 small-font">Date: <?php echo $reply->date;?> <?php echo $reply->time;?></p>
            														<input type="checkbox"
            														onchange="return replystatus(this,'tbl_live_reply','id','<?php echo $reply->id;?>','status')" <?php if ($reply->status == "true") {
            															echo "checked";
            														} ?> class="js-switch"  data-color="#eb5076" data-size="small">
            													</div>
            												</div>
            											</li>
            											<?php endforeach; ?>
            											<?php endif; ?>
            											<li class="list-group-item">
            												<div class="media align-items-center">
            													<div class="media-body ml-3">
            														<div class="row">
            															<div class="col-sm-6">
            																<input type="text" class="form-control" id="message<?php echo $item->id;?>" name="message" placeholder="Enter Message" style="height:40px;" >
            															</div>
            															<div class="col-sm-6">
            																<button class="btn btn-dark" onclick="ReplyPost('<?php echo $item->liveid;?>','<?php echo 1;?>','Admin','<?php echo $item->id;?>')"> <i class="fa fa-reply"></i> </button>
            																
            															</div>
            														</div>
            													</div>
            												</div>
            											</li>
            										</ul>
            									</li>
            									
            									<?php endforeach; ?>
            									<?php endif; ?>
            									<?php if(!count($questions)) : ?>
									<div class="card mb-2">
										<div class="card-header">
											No Questions Found.
										</div>
									</div>
									<?php endif; ?>
            								</ul>
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
        			function ReplyPost(liveid,userid,usertype,questionid){
        				
        				var message=$("#message"+questionid).val();
        				
        				$.ajax({
        					url: "<?php echo base_url("AdminPanel/LiveReply/Add"); ?>",
        					type: "post",
        					data: {'message':message,'liveid':liveid,'userid':userid,'usertype':usertype,'questionid':questionid},
        					success: function(response) {
        						var response = JSON.parse(response);
        						if (response[0].res == 'success') {
        							Lobibox.notify('success', {
        								pauseDelayOnHover: true,
        								size: 'mini',
        								rounded: true,
        								delayIndicator: false,
        								icon: 'fa fa-exclamation-circle',
        								continueDelayOnInactiveTab: false,
        								position: 'top right',
        								msg: response[0].msg
        							});
        							location.reload();
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
        					}
        				});
        			}
        			
        			function questionstatus(e, table, where_column, where_value, column) {
        				var status = true;
        				var check = $(e).prop("checked");
        				if (check) {
        					swal({
        						title: "Are you sure?",
        						text: "You want to activate this Question !",
        						icon: "warning",
        						buttons: true,
        						dangerMode: true
        						}).then((willDelete) => {
        						if (willDelete) {
        							$.ajax({
        								url: "<?php echo base_url("AdminPanel/UpdateStatus");?>",
        								type: "post",
        								data: {
        									'table': table,
        									'column': column,
        									'value': 'true',
        									'where_column': where_column,
        									'where_value': where_value
        								},
        								success: function(response) {
        									swal("This Question is activated successfully !", {
        										icon: "success",
        									});
        								}
        							});
        						}
        					});
        					} else {
        					swal({
        						title: "Are you sure?",
        						text: "You want to deactivate this Question !",
        						icon: "warning",
        						buttons: true,
        						dangerMode: true
        						}).then((willDelete) => {
        						if (willDelete) {
        							$.ajax({
        								url: "<?php echo base_url("AdminPanel/UpdateStatus");?>",
        								type: "post",
        								data: {
        									'table': table,
        									'column': column,
        									'value': 'false',
        									'where_column': where_column,
        									'where_value': where_value
        								},
        								success: function(response) {
        									swal("This Question is deactivated successfully !", {
        										icon: "success",
        									});
        								}
        							});
        						}
        					});
        				}
        				return status;
        			}
        			
        			function replystatus(e, table, where_column, where_value, column) {
        				var status = true;
        				var check = $(e).prop("checked");
        				if (check) {
        					swal({
        						title: "Are you sure?",
        						text: "You want to activate this Reply !",
        						icon: "warning",
        						buttons: true,
        						dangerMode: true
        						}).then((willDelete) => {
        						if (willDelete) {
        							$.ajax({
        								url: "<?php echo base_url("AdminPanel/UpdateStatus");?>",
        								type: "post",
        								data: {
        									'table': table,
        									'column': column,
        									'value': 'true',
        									'where_column': where_column,
        									'where_value': where_value
        								},
        								success: function(response) {
        									swal("This Reply is activated successfully !", {
        										icon: "success",
        									});
        								}
        							});
        						}
        					});
        					} else {
        					swal({
        						title: "Are you sure?",
        						text: "You want to deactivate this Reply !",
        						icon: "warning",
        						buttons: true,
        						dangerMode: true
        						}).then((willDelete) => {
        						if (willDelete) {
        							$.ajax({
        								url: "<?php echo base_url("AdminPanel/UpdateStatus");?>",
        								type: "post",
        								data: {
        									'table': table,
        									'column': column,
        									'value': 'false',
        									'where_column': where_column,
        									'where_value': where_value
        								},
        								success: function(response) {
        									swal("This Reply is deactivated successfully !", {
        										icon: "success",
        									});
        								}
        							});
        						}
        					});
        				}
        				return status;
        			}
        			
        			function Delete(e, table, where_column, where_value, unlink_folder, unlink_column) {
                        var status = true;
                        swal({
                            title: "Are you sure?",
                            text: "You want to delete this !",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true
                            }).then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: "<?php echo base_url("AdminPanel/Delete"); ?>",
                                    type: "post",
                                    data: {
                                        'table': table,
                                        'where_column': where_column,
                                        'where_value': where_value,
                                        'unlink_folder': unlink_folder,
                                        'unlink_column': unlink_column
                                    },
                                    success: function(response) {
                                        swal("This is deleted successfully !", {
                                            icon: "success",
                                        });
                                        location.reload();
                                    }
                                });
                            }
                        });
                        return status;
                    }
        		</script>
				
			</body>
			
		</html>
		<?php
			break;
		}
	}
	else{
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
								<h4 class="page-title"> Manage Live Sessions</h4>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="javascript:void();">Videos</a></li>
									<li class="breadcrumb-item active" aria-current="page">Manage Live Sessions</li>
								</ol>
							</div>
							<div class="col-sm-3">
								
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="card">
									<div class="card-header">
										<button class="btn btn-primary" data-toggle="modal" data-target="#AddModal"><i
										class="fa fa-plus-circle"></i> Add Live Session</button>
									</div>
									<div class="card-header">
										<form action="" method="GET">
											<div class="row">
												<div class="col-sm-8">
													<div class="form-group">
														<label>Select Educator <span class="text-danger">*</span> </label>
														<select class="form-control" name="author">
															<option selected disabled>Select</option>
															<option value="">All Sessions</option>
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
											
											<table class="table table-bordered" id="example">
												<thead>
													<tr>
														<th>#</th>
														<th>Status</th>
														<th>Session Status</th>
														<th>Thumbnail</th>
														<th>Educator</th>
														<th>Title</th>
														<th>Subject</th>
														<th>Tags</th>
														<th>Timing</th>
														<th>Duration</th>
														<th>Certification</th>
														<th>Description</th>
														<th>Link</th>
														<th>Date</th>
														<th>Time</th>
														<th>Action</th>
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
																onchange="return Status(this,'tbl_live_video','id','<?php echo $item->id; ?>','status')"
																<?php if ($item->status == "true") {
																	echo "checked";
																} ?> class="js-switch"
																data-color="#eb5076" data-size="small">
															</td>
															<td>
																<?php if($item->session_status=='Scheduled'){ ?>
																	<a href="javascript:void(0);"
																	class="btn btn-sm btn-info"
																	onclick="StartLiveSession('<?php echo $item->id; ?>')">
																	<i class="fa fa-check-circle"></i> Start</a>	
																	<?php }  elseif($item->session_status=='Started') {?>
																	<a href="javascript:void(0);"
																	class="btn btn-sm btn-danger"
																	onclick="EndLiveSession('<?php echo $item->id; ?>')">
																	<i class="fa fa-times-circle"></i> End</a>
																	<?php } else { ?>
																	<b class="text-danger"><?=$item->session_status;?></b>
																<?php }?>
																
															</td>
															<td> <label data-toggle="tooltip" data-placement="top"
																title="ID: <?php echo $item->id; ?>"><a
																	href="<?php echo base_url("uploads/live_video/$item->thumbnail"); ?>"
																	target="_blank"><img
																		data-src="<?php echo base_url("uploads/live_video/$item->thumbnail"); ?>"
																		src="<?php echo base_url("images/Preloader2.jpg"); ?>"
																	class="lazy" style="height:50px;" /> </a></label>
															</td>
															<td><?php echo $item->author[0]->name.' ('.$item->author[0]->designation.')'; ?><br>
																[<?php echo $item->author[0]->username;?>]
															</td>
															<td>
																<?php echo $item->title; ?>
															</td>
															<td>
																<?php echo $item->subject; ?>
															</td>
															<td>
																<?php echo $item->tags; ?>
															</td>
															<td>
																<?php echo $item->timing; ?>
															</td>
															<td>
																<?php echo $item->duration; ?>
															</td>
															<td>
																<?php echo $item->certification;?>
																<?php if($item->certification=='Yes') {?>
																	<p> <a href="<?php echo base_url("AdminPanel/ManageLiveVideo/Certificate/$item->id") ?>" target="_blank" class="text-info">View Certificate</a></p>
																	<p>Certificate Hardcopy Charge: <i class="fa fa-inr"></i> <?php echo $item->certificate_charge; ?></p>
																	<p>Per KM Delivery Charge: <i class="fa fa-inr"></i> <?php echo $item->km_charge; ?></p>
																<?php }?>
															</td>
															<td>
																<?php echo $item->description; ?>
															</td>
															<td>
																<a href="<?php echo $item->link; ?>" target="_blank"><?php echo $item->link; ?></a>
															</td>
															<td>
																<?php echo $item->date; ?>
															</td>
															<td>
																<?php echo $item->time; ?>
															</td>
															<td>
																
																<div class="btn-group">
																    <a href="<?php echo base_url('AdminPanel/ManageLiveVideo/Joined/'.$item->id);?>"  class="btn btn-sm btn-success"><i class="fa fa-eye"></i> Joined</a>
																	 <a href="<?php echo base_url('AdminPanel/ManageLiveVideo/Questions/'.$item->id);?>"  class="btn btn-sm btn-primary"><i class="fa fa-info"></i> Questions</a>
																	<a href="javascript:void(0);"
																	class="btn btn-sm btn-outline-info waves-effect waves-light"
																	onclick="Edit('<?php echo $item->id; ?>')">
																	<i class="fa fa fa-edit"></i> </a>
																	<a href="javascript:void(0);"
																	class="btn btn-sm btn-outline-danger waves-effect waves-light"
																	onclick="return Delete(this,'tbl_live_video','id','<?php echo $item->id; ?>','live_video','thumbnail')">
																	<i class="fa fa-trash"></i> </a>
																</div>
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
				<!--Modal Start-->
				<div class="modal fade" id="AddModal">
					<div class="modal-dialog">
						<div class="modal-content border-primary">
							<div class="modal-header bg-primary">
								<h5 class="modal-title text-white">Add Live Session</h5>
								<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="<?php echo base_url("AdminPanel/ManageLiveVideo/Add"); ?>" method="post"
							enctype="multipart/form-data" id="addform">
								<div class="modal-body">
									
									
									<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
									value="<?= $this->security->get_csrf_hash(); ?>" />
									
									<div class="form-group">
										<label class="col-form-label">Educator <span class="text-danger">*</span></label>
										<select class="form-control" name="author" required>
											<option selected disabled>Select</option>
											<?php foreach ($authorlist as $item) { ?>
												<option value="<?php echo $item->id;?>" ><?php echo $item->name;?></option>
											<?php } ?>
										</select>
										<?php echo form_error("author", "<p class='text-danger' >", "</p>"); ?>
									</div>
									<div class="form-group">
										<label class="col-form-label">Course <span class="text-danger">*</span></label>
										<select class="form-control" name="course" id="course" type="dropdown">
											<option selected disabled>Select</option>
											<?php foreach ($courselist as $item) { ?>
												<option value="<?php echo $item->id;?>" ><?php echo $item->name;?></option>
											<?php } ?>
										</select>
										<?php echo form_error("course", "<p class='text-danger' >", "</p>"); ?>
									</div>
									<div class="form-group">
										<label  class="col-form-label">Session Type <span class="text-danger">*</span></label>
										<select class="form-control" id="session_type" name="session_type" type="dropdown">
										
										</select>
										<?php echo form_error("session_type","<p class='text-danger' >","</p>"); ?>
                                    </div>
									<!-- <div class="form-group">
										<label  class="col-form-label">For User <span class="text-danger">*</span></label>
										<select class="form-control" name="for_user" required onchange="getUsers(this.value)">
											<option selected disabled>Select</option>
											<option value="AllEducator">All Educators</option>
											<option value="Educator">Select Educators</option>
											<option value="AllStudent">All Students</option>
											<option value="Student">Select Students</option>
										</select>
										<?php //echo form_error("for_user","<p class='text-danger' >","</p>"); ?>
                                    </div> -->
									<div class="form-group">
										<label class="col-form-label">Subject <span class="text-danger">*</span></label>
										<input type="text" class="form-control text-capitalize" name="subject" placeholder="Subject"
										required>
										<?php echo form_error("subject", "<p class='text-danger' >", "</p>"); ?>
									</div>
									<div class="form-group">
										<label class="col-form-label">Tags <span class="text-danger">*</span></label>
										<input type="text" class="form-control text-uppercase" name="tags" placeholder="Tags"
										required>
										<?php echo form_error("tags", "<p class='text-danger' >", "</p>"); ?>
									</div>
									<div class="form-group">
										<label class="col-form-label">Title <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="title" placeholder="Title" required>
										<?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
									</div>
									<div class="form-group">
										<label class="col-form-label">Timing <span class="text-danger">*</span></label>
										<input type="datetime-local" class="form-control" name="timing" required>
										<?php echo form_error("timing", "<p class='text-danger' >", "</p>"); ?>
									</div>
									<div class="form-group">
										<label class="col-form-label">Duration <span class="text-danger">*</span></label>
										<input type="text" class="form-control text-uppercase" name="duration" placeholder="Duration" required>
										<?php echo form_error("duration", "<p class='text-danger' >", "</p>"); ?>
									</div>
									<!-- <div class="form-group d-none">
										<label class="col-form-label">Link <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="link" placeholder="Link"
										>
										<?php //echo form_error("link", "<p class='text-danger' >", "</p>"); ?>
									</div> -->
									<!-- <div class="form-group">
                                    <label class="col-form-label">Parameter <span class="text-danger">*</span></label>
                                    <select  class="form-control" name="parameter" required onchange="getParameterData(this.value)">
                                        <option value="None" selected>None</option>
                                        <option value="Category">Category</option>
                                        <option value="Course">Course</option>
                                        <option value="Ebook">E-Book</option>
                                        <option value="Abook">Audio Book</option>
                                        <option value="Quiz">Quiz</option>
                                        <option value="LiveSession">Live Session</option>
                                        <option value="FreeVideo">Free Video</option>
                                        <option value="Offer">Offer</option>
                                        <option value="External">External</option>
                                        
                                    </select>
                                    <?php // echo form_error("parameter", "<p class='text-danger' >", "</p>"); ?>
                                   </div> -->
									<!-- <div class="form-group d-none">
										<label class="col-form-label">User ID of Live Session<span class="text-danger"></span></label>
										<input type="text" class="form-control" name="userid" placeholder="User ID"  >
										<?php //echo form_error("userid", "<p class='text-danger' >", "</p>"); ?>
									</div>
									<div class="form-group d-none">
										<label class="col-form-label">Password of Live Session<span class="text-danger"></span></label>
										<input type="text" class="form-control" name="password" placeholder="Password" >
										<?php //echo form_error("password", "<p class='text-danger' >", "</p>"); ?>
									</div> -->
									<div class="form-group">
										<label  class="col-form-label">Is this Live Session includes certification ? <span class="text-danger">*</span></label>
										<div class="icheck-material-success">
											<input type="radio" id="yesradio" class="certificationcheck" value="Yes" name="certificationcheck"/>
											<label for="yesradio">Yes</label>
										</div>
										<div class="icheck-material-danger">
											<input type="radio" id="noradio" class="certificationcheck" checked value="No" name="certificationcheck" />
											<label for="noradio">No</label>
										</div>
										<?php echo form_error("certificationcheck","<p class='text-danger' >","</p>"); ?>
										
									</div>
									
									<div  id="certificatediv">
										<div class="form-group">
											<label  class="col-form-label">Certificate Theme  <span class="text-danger">*</span></label>
											<select class="form-control" name="certificate" id="certificateTheme" onchange="certificateThemePreview(this.value)">
												<option selected disabled>Select</option>
												<?php
													foreach ($this->certificateTheme as $item => $value){
													?>
													<option value="<?php echo $value;?>"><?php echo $item;?></option>
													<?php
													}
												?>
											</select>
											<?php echo form_error("certificate","<p class='text-danger' >","</p>"); ?>
											
											<p id="certificateThemePreview"></p>
											
										</div>
										<div class="form-group">
											<label  class="col-form-label">Certificate Hardcopy Charge<span class="text-danger">*</span></label>
											<input type="number" class="form-control" name="certificate_charge"  id="certificate_charge" placeholder="Certificate Charge" >
											<?php echo form_error("certificate_charge","<p class='text-danger' >","</p>"); ?>
											
										</div>
										
										<div class="form-group">
											<label  class="col-form-label">Per KM Delivery Charge<span class="text-danger">*</span></label>
											<input type="number" class="form-control" name="km_charge"  id="km_charge" placeholder="Per KM Charge" >
											<?php echo form_error("km_charge","<p class='text-danger' >","</p>"); ?>
											
										</div>
									</div>
									<div class="form-group">
										<label class="col-form-label">Description <span class="text-danger">*</span></label>
										<textarea class="form-control" name="description"
										placeholder="Description" required></textarea>
										<?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
									</div>
									<div class="form-group">
										<label class="col-form-label">Thumbnail <span class="text-danger">*</span></label>
										<input type="file" class="form-control" name="thumbnail" Title="Choose Thumbnail" required>
										<?php echo form_error("thumbnail", "<p class='text-danger' >", "</p>"); ?>
									</div>
								</div>
								<div class="modal-footer d-block">
									<button type="submit" id="addaction" name="addaction" class="btn btn-primary"><i
									class="icon-lock"></i> Submit</button>
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
								<h5 class="modal-title text-white">Edit Live Session</h5>
								<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							
							<form action="<?php echo base_url("AdminPanel/ManageLiveVideo/Update"); ?>" method="post"
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
				
				<!--Modal Start-->
				<div class="modal fade" id="StartModal">
					<div class="modal-dialog">
						<div class="modal-content border-primary">
							<div class="modal-header bg-primary">
								<h5 class="modal-title text-white">Start Live Session</h5>
								<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							
							<form action="<?php echo base_url("AdminPanel/ManageLiveVideo/StartLiveSession"); ?>" method="post"
							enctype="multipart/form-data" id="updateform1">
								<div class="modal-body">
									
								</div>
								<div class="modal-footer d-block">
									<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
									value="<?= $this->security->get_csrf_hash(); ?>" />
									<button type="submit" id="updateaction1" name="updateaction1" class="btn btn-primary"><i
									class="icon-lock"></i> Submit</button>
								</div>
							</form>
							
						</div>
					</div>
				</div>
				<!--Modal End-->
				
				<!--Modal Start-->
				<div class="modal fade" id="EndModal">
					<div class="modal-dialog">
						<div class="modal-content border-primary">
							<div class="modal-header bg-primary">
								<h5 class="modal-title text-white">End Live Session</h5>
								<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							
							<form action="<?php echo base_url("AdminPanel/ManageLiveVideo/EndLiveSession"); ?>" method="post"
							enctype="multipart/form-data" id="updateform1">
								<div class="modal-body">
									
								</div>
								<div class="modal-footer d-block">
									<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
									value="<?= $this->security->get_csrf_hash(); ?>" />
									<button type="submit" id="updateaction2" name="updateaction2" class="btn btn-primary"><i
									class="icon-lock"></i> Submit</button>
								</div>
							</form>
							
						</div>
					</div>
				</div>
				<!--Modal End-->
				
			</div>
			
			<?php include("FooterLinking.php"); ?>
			
			<script>

				function getParameterData(parameter)
				{
					// alert(parameter);
					if(parameter=='External'){
						$(".parameter-data").html('<label class="col-form-label">External Link <span class="text-danger">*</span></label><input type="text" class="form-control" name="link" placeholder="Enter Link " required >');
						$('.parameter-data').show();
					}
					else if(parameter=='None'){
						$(".parameter-data").html('');
						$('.parameter-data').hide();
					}
					else{
						
						$.ajax({
							url: "<?php echo base_url("AdminPanel/Parameters/"); ?>"+parameter,
							type: "get",
							data: { },
							success: function(response) 
							{
								// alert(response);
								$(".parameter-data").html(response);
								$('.parameter-data').show(); 
							}
						});
					}
					
				}
				
				function getUsers(type)
				{
					$.ajax({
						url: "<?php echo base_url("AdminPanel/GetUsers/"); ?>"+type,
						type: "get",
						data: { },
						success: function(response) 
						{
							// alert(response);
							$(".user-data").html(response);
							$('.user-data').show(); 
						}
					});
					
				}
				
				function CertificateStatusLive(e,id) {
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
			<script>
				$(document).ready(function() {
					$('#course').change(function() {
						var selectedOption = $(this).val(); // Get the selected option value from the first selector
						
						// Send AJAX request to fetch data
						$.ajax({
						url: '<?php echo site_url('AdminPanel/getDataByType'); ?>', // Replace 'controller_name' with your actual controller name
						type: 'POST',
						data: {option: selectedOption},
						dataType: 'json',
						success: function(response) {
							var options = '';

							// Generate HTML options for the second selector
							$.each(response, function(ManageLiveVideo, value) {
							options += '<option value="' + value.id + '">' + value.type + '</option>';
							});

							// Populate the second selector with options
							$('#session_type').html(options);
						},
						error: function(xhr, status, error) {
							// Handle AJAX error if needed
							console.log(error);
						}
						});
					});
				});
			</script>
			<script>
				$(document).ready(function(){
					
					
					$("#certificatediv").hide();
					$('#certificateTheme').prop('required',false);
					
					$('#certificate_charge').prop('required',false);
					$('#km_charge').prop('required',false);
					
					$("#yesradio").change(function(){
						var check=$(this).prop("checked");
						if(check)
						{
							$("#certificatediv").show();
							$('#certificateTheme').prop('required',true);
							$('#certificate_charge').prop('required',true);
							$('#km_charge').prop('required',true);
						}
					});
					$("#noradio").change(function(){
						var check=$(this).prop("checked");
						if(check)
						{
							$("#certificatediv").hide();
							$('#certificateTheme').prop('required',false);
							$('#certificate_charge').prop('required',false);
							$('#km_charge').prop('required',false);
						}
					});
					
				});
				
				function certificateThemePreview(certificateTheme){
					$("#certificateThemePreview").html('<br><a href="<?php echo base_url("AdminPanel/Certificates/Preview/")?>'+certificateTheme+'" target="_blank">View Certificate</a>');
				}
			</script>
			<script>
				function Edit(id) {
					$("#EditModal").modal("show");
					$("#EditModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
					$("#EditModal .modal-body").load("<?php echo base_url('AdminPanel/ManageLiveVideo/Edit/') ?>" + id);
				}
				function StartLiveSession(id) {
					$("#StartModal").modal("show");
					$("#StartModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
					$("#StartModal .modal-body").load("<?php echo base_url('AdminPanel/ManageLiveVideo/StartLiveSession/') ?>" + id);
				}
				function EndLiveSession(id) {
					$("#EndModal").modal("show");
					$("#EndModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
					$("#EndModal .modal-body").load("<?php echo base_url('AdminPanel/ManageLiveVideo/EndLiveSession/') ?>" + id);
				}
			</script>
			
			<script>
				function Status(e, table, where_column, where_value, column) {
					var status = true;
					var check = $(e).prop("checked");
					if (check) {
						swal({
							title: "Are you sure?",
							text: "You want to activate this live session !",
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
										swal("This live session is activated successfully !", {
											icon: "success",
										});
									}
								});
							}
						});
						} else {
						swal({
							title: "Are you sure?",
							text: "You want to deactivate this live session !",
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
										swal("This live session is deactivated successfully !", {
											icon: "success",
										});
									}
								});
							}
						});
					}
					return status;
				}
				
				function Delete(e, table, where_column, where_value, unlink_folder, unlink_column) {
					var status = true;
					swal({
						title: "Are you sure?",
						text: "You want to delete this live session !",
						icon: "warning",
						buttons: true,
						dangerMode: true
						}).then((willDelete) => {
						if (willDelete) {
							$.ajax({
								url: "<?php echo base_url("AdminPanel/Delete"); ?>",
								type: "post",
								data: {
									'table': table,
									'where_column': where_column,
									'where_value': where_value,
									'unlink_folder': unlink_folder,
									'unlink_column': unlink_column
								},
								success: function(response) {
									swal("This live session is deleted successfully !", {
										icon: "success",
									});
									location.reload();
								}
							});
						}
					});
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
	<?php
	}	
	?>												