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
                            <h4 class="page-title"> Manage Video Assignments</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void();">Videos</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Video Assignments</li>
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
									class="fa fa-plus-circle"></i> Add Assignment</button>
								</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        
                                        <table class="table table-bordered" id="example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Status</th>
                                                    <th>Subject</th>
                                                    <th>Video Title</th>
                                                    <th>Video</th>
                                                    <th>Assignment</th>
                                                    <th>Description</th>
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
                                                            onchange="return Status(this,'tbl_video_assignment','id','<?php echo $item->id; ?>','status')"
                                                            <?php if ($item->status == "true") {
                                                                echo "checked";
															} ?> class="js-switch"  data-color="#eb5076" data-size="small" >
															
														</td>
														<td>
															<?php echo $item->subject[0]->name; ?>
														</td>
														<td>
															<?php echo $item->video[0]->title; ?>
														</td>
														<td>
															<?php
																if($item->video[0]->type=='Internal'){
																	$link=base_url('uploads/video/'.$item->video[0]->video);
																}
																else{
																	$link=$item->video[0]->link;
																}
															?>
															<iframe style="width:100%;height:150px;" src="<?php echo $link;?>"  frameborder="0"  allowfullscreen></iframe>
														</td>
														<td> <label data-toggle="tooltip" data-placement="top"
															title="ID: <?php echo $item->id; ?>"><a
																href="<?php echo base_url("uploads/assignment/$item->assignment"); ?>"
															target="_blank"><?php echo base_url("uploads/assignment/$item->assignment"); ?> </a></label>
														</td>
														<td>
															<?php echo $item->description; ?>
														</td>
														<td>
															<?php echo $item->date; ?>
														</td>
														<td>
															<?php echo $item->time; ?>
														</td>
														<td>
															
															<div class="btn-group">
																<a href="javascript:void(0);"
																class="btn btn-sm btn-outline-info waves-effect waves-light"
																onclick="Edit('<?php echo $item->id; ?>')">
																<i class="fa fa fa-edit"></i> </a>
																<a href="javascript:void(0);"
																class="btn btn-sm btn-outline-danger waves-effect waves-light"
																onclick="return Delete(this,'tbl_video_assignment','id','<?php echo $item->id; ?>','assignment','assignment')">
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
							<h5 class="modal-title text-white">Add Assignment</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?php echo base_url("AdminPanel/ManageVideoAssignments/Add"); ?>" method="post"
						enctype="multipart/form-data" id="addform">
							<div class="modal-body">
								
								
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
								value="<?= $this->security->get_csrf_hash(); ?>" />
								
								<div class="form-group">
									<label class="col-form-label">Subject <span class="text-danger">*</span></label>
									<select class="form-control" name="subject" required onchange="getVideos(this.value)">
										<option selected disabled>Select</option>
										<?php foreach ($subjectlist as $item) { ?>
											<option value="<?php echo $item->id;?>" ><?php echo $item->name;?></option>
										<?php } ?>
									</select>
									<?php echo form_error("subject", "<p class='text-danger' >", "</p>"); ?>
								</div>
								
								<div class="form-group">
									<label class="col-form-label">Video <span class="text-danger">*</span></label>
									<select class="form-control videosList" name="video" required>
										<option selected disabled>Select</option>
										<?php foreach ($videolist as $item) { ?>
											<option value="<?php echo $item->id;?>" ><?php echo $item->title;?></option>
										<?php } ?>
									</select>
									<?php echo form_error("video", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Assignment <span class="text-danger">*</span></label>
									<input type="file" class="form-control" name="assignment" Title="Choose Assignment" required>
									<?php echo form_error("assignment", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Description <span class="text-danger">*</span></label>
									<textarea class="form-control summernote" name="description"
									placeholder="Description" required></textarea>
									<?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
								</div>
							</div>
							<div class="modal-footer d-block">
								<button type="submit" id="addaction" name="addaction" class="btn btn-primary"><i
								class="icon-lock"></i> Add Assignment</button>
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
							<h5 class="modal-title text-white">Edit Video</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						
						<form action="<?php echo base_url("AdminPanel/ManageVideoAssignments/Update"); ?>" method="post"
						enctype="multipart/form-data" id="updateform">
							<div class="modal-body">
								
							</div>
							<div class="modal-footer d-block">
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
								value="<?= $this->security->get_csrf_hash(); ?>" />
								<button type="submit" id="updateaction" name="updateaction" class="btn btn-primary"><i
								class="icon-lock"></i> Update Assignment</button>
							</div>
						</form>
						
					</div>
				</div>
			</div>
            <!--Modal End-->
		</div>
        
        <?php include("FooterLinking.php"); ?>
        <script>
            function Edit(id) {
                $("#EditModal").modal("show");
                $("#EditModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
                $("#EditModal .modal-body").load("<?php echo base_url('AdminPanel/ManageVideoAssignments/Edit/') ?>" + id);
			}
		</script>
        
        <script>
			$('.summernote').summernote({
                height: 200,
                tabsize: 2
			});
            function Status(e, table, where_column, where_value, column) {
                var status = true;
                var check = $(e).prop("checked");
                if (check) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to activate this assignment !",
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
                                    swal("This assignment is activated successfully !", {
                                        icon: "success",
									});
								}
							});
						}
					});
                    } else {
                    swal({
                        title: "Are you sure?",
                        text: "You want to deactivate this assignment !",
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
                                    swal("This  assignment is deactivated successfully !", {
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
                    text: "You want to delete this  assignment !",
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
                                swal("This  assignment is deleted successfully !", {
                                    icon: "success",
								});
                                location.reload();
							}
						});
					}
				});
                return status;
			}
			
			function getVideos(id){
				$.ajax({
					url: "<?php echo base_url("AdminPanel/ManageSubjects/VideosList/"); ?>"+id,
					type: "get",
					data: {
					},
					success: function(response) {
						$(".videosList").html(response);
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