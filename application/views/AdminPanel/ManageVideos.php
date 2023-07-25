<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
	
    <head>
        <title>Manage Video - Karmasu Admin</title>
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
                            <h4 class="page-title"> Manage Videos</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void();">Videos</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage  Videos</li>
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
									class="fa fa-plus-circle"></i> Add Video</button>
								</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        
                                        <table class="table table-bordered" id="example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Status</th>
													<th>Educator</th>
                                                    <th>Subject</th>
                                                    <th>Video Type</th>
                                                    <th>Thumbnail</th>
                                                    <th>Video</th>
                                                    <th>Notes</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Duration</th>
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
                                                            onchange="return Status(this,'tbl_video','id','<?php echo $item->id; ?>','status')"
                                                            <?php if ($item->status == "true") {
                                                                echo "checked";
															} ?> class="js-switch" data-color="#eb5076" data-size="small">
														</td>
														 <td><?php echo $item->author->name.' ('.$item->author->designation.')'; ?></td>
														<td>
															<?php echo $item->subject[0]->name; ?>
														</td>
														<td>
															<?php echo $item->type; ?>
														</td>
														<td>
															<label data-toggle="tooltip" data-placement="top"
															title="ID: <?php echo $item->id; ?>"><a
																href="<?php echo base_url("uploads/thumbnail/$item->thumbnail"); ?>"
																target="_blank"><img
																	data-src="<?php echo base_url("uploads/thumbnail/$item->thumbnail"); ?>"
																	src="<?php echo base_url("images/Preloader2.jpg"); ?>"
																class="lazy" style="height:50px;" /> </a></label>
														</td>
														<td>
															<?php
																if($item->type=='Internal'){
																	$link=base_url('uploads/video/'.$item->video);
																}
																else{
																	$link=$item->link;
																}
															?>
															<iframe style="width:100%;height:150px;" src="<?php echo $link;?>"  frameborder="0"  allowfullscreen></iframe>
														</td>
														
														
														<td>
															<?php
																if($item->notes==''){ }
																else{
																?>
																<a href="<?php echo base_url("uploads/notes/".$item->notes);?>" target="_blank"><?php echo $item->notes;?></a>
																<?php
																}
															?>
														</td>
														<td>
															<?php echo $item->title; ?>
														</td>
														<td>
															<?php echo $item->description; ?>
														</td>
														<td>
															<?php echo $item->duration; ?>
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
																onclick="return Delete(this,'tbl_video','id','<?php echo $item->id; ?>','','')">
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
							<h5 class="modal-title text-white">Add Video</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?php echo base_url("AdminPanel/ManageVideos/Add"); ?>" method="post"
						enctype="multipart/form-data" id="addform">
							<div class="modal-body">
								
								
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
								value="<?= $this->security->get_csrf_hash(); ?>" />
								<div class="form-group">
									<label class="col-form-label">Educator <span class="text-danger">*</span></label>
									<select class="form-control" name="author" required>
										<option selected disabled>Select</option>
										<?php foreach ($authorlist as $item) { ?>
											<option value="<?php echo $item->id;?>"><?php echo $item->name;?></option>
										<?php } ?>
									</select>
									<?php echo form_error("author", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Subject <span class="text-danger">*</span></label>
									<select class="form-control" name="subject" required>
										<option selected disabled>Select</option>
										<?php foreach ($subjectlist as $item) { ?>
											<option value="<?php echo $item->id;?>" ><?php echo $item->name;?></option>
										<?php } ?>
									</select>
									<?php echo form_error("subject", "<p class='text-danger' >", "</p>"); ?>
								</div>
								
								<div class="form-group">
									<label class="col-form-label">Video Type <span class="text-danger">*</span></label>
									<select class="form-control" name="type" required onchange="videoType(this.value)">
										<option selected disabled>Select</option>
										<option value="External">External</option>
										<option value="Internal" selected>Internal</option>
									</select>
									<?php echo form_error("type", "<p class='text-danger' >", "</p>"); ?>
								</div>
								
								
								<div class="form-group" style="max-height:300px;overflow:scroll;" id="thumbnailInternal">
									<label class="col-form-label">Thumbnail <span class="text-danger">*</span></label>
									<?php
										$count1=0;
										$newpath='uploads/thumbnail/';
										if (is_dir($newpath))
										{
											if ($dh = opendir($newpath))
											{
												while (($file = readdir($dh)) !== false)
												{
													if($file=="." || $file=="..")
													{
														continue;
													}
													$ext = pathinfo($file, PATHINFO_EXTENSION);
													$ext=strtolower($ext);
													if($ext=="jpg" || $ext=="png")
													{
														$count1++;
													?>
													<div class="row">
														<div class="col-sm-10">
															<input type="radio" id="thumb<?php echo $count1; ?>" name="thumbnail" value="<?php echo $file; ?>"  required />
															<?php echo $file; ?>
														</div>
														<div class="col-sm-2">
															<a href="<?php echo base_url($newpath.$file); ?>" target="_blank" ><i class="fas fa-image fa-lg"></i></a>
														</div>
													</div>
													<?php
													}
													
												}
											}
											
										}
										if($count1==0)
										{
											echo "No Thumbnail Found in Folder, Please Upload using FTP.";
										}
									?>
									<?php echo form_error("thumbnail", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group" style="max-height:300px;overflow:scroll;" id="videoInternal">
									<label class="col-form-label">Video <span class="text-danger">*</span></label>
									<?php
										$count1=0;
										$newpath='uploads/video/';
										if (is_dir($newpath))
										{
											if ($dh = opendir($newpath))
											{
												while (($file = readdir($dh)) !== false)
												{
													if($file=="." || $file=="..")
													{
														continue;
													}
													$ext = pathinfo($file, PATHINFO_EXTENSION);
													$ext=strtolower($ext);
													if($ext=="mp4" || $ext=="mov")
													{
														$count1++;
													?>
													<div class="row">
														<div class="col-sm-10">
															<input type="radio" id="video<?php echo $count1; ?>" name="video" value="<?php echo $file; ?>"  required />
															<?php echo $file; ?>
														</div>
														<div class="col-sm-2">
															<a href="<?php echo base_url($newpath.$file); ?>" target="_blank" ><i class="fas fa-video fa-lg"></i></a>
														</div>
													</div>
													<?php
													}
													
												}
											}
											
										}
										if($count1==0)
										{
											echo "No Video Found in Folder, Please Upload using FTP.";
										}
									?>
									<?php echo form_error("video", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group" id="videoExternal" style="display:none;">
									<label class="col-form-label">Video Link <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="link" placeholder="Link">
									<?php echo form_error("link", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Notes<span class="text-danger"></span></label>
									<input type="file" class="form-control" name="notes"  accept="application/pdf">
									<?php echo form_error("notes","<p class='text-danger' >","</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Duration <span class="text-danger">*</span></label>
									<input type="text" class="form-control text-uppercase" name="duration" placeholder="Duration" required>
									<?php echo form_error("duration", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Title <span class="text-danger">*</span></label>
									<input type="text" class="form-control " name="title" placeholder="Title" required>
									<?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Description <span class="text-danger">*</span></label>
									<textarea class="form-control" name="description"
									placeholder="Description" required></textarea>
									<?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
								</div>
							</div>
							<div class="modal-footer d-block">
								<button type="submit" id="addaction" name="addaction" class="btn btn-primary"><i
								class="icon-lock"></i> Add Video</button>
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
						
						<form action="<?php echo base_url("AdminPanel/ManageVideos/Update"); ?>" method="post"
						enctype="multipart/form-data" id="updateform">
							<div class="modal-body">
								
							</div>
							<div class="modal-footer d-block">
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
								value="<?= $this->security->get_csrf_hash(); ?>" />
								<button type="submit" id="updateaction" name="updateaction" class="btn btn-primary"><i
								class="icon-lock"></i> Update Video</button>
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
                $("#EditModal .modal-body").load("<?php echo base_url('AdminPanel/ManageVideos/Edit/') ?>" + id);
			}
		</script>
        
        <script>
            function Status(e, table, where_column, where_value, column) {
                var status = true;
                var check = $(e).prop("checked");
                if (check) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to activate this video !",
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
                                    swal("This video is activated successfully !", {
                                        icon: "success",
									});
								}
							});
						}
					});
                    } else {
                    swal({
                        title: "Are you sure?",
                        text: "You want to deactivate this video !",
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
                                    swal("This  video is deactivated successfully !", {
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
                    text: "You want to delete this video !",
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
                                swal("This  video is deleted successfully !", {
                                    icon: "success",
								});
                                location.reload();
							}
						});
					}
				});
                return status;
			}
			
			function videoType(type){
				if(type=='External'){
					
					$("#videoInternal").hide();
					// $("#thumbnailInternal").hide();
					$("#videoExternal").show();
					$("input[name='video']").removeAttr('required');
					// $("input[name='thumbnail']").removeAttr('required');
					$("input[name='link']").attr('required');
				}
				else{
					$("#videoInternal").show();
					// $("#thumbnailInternal").show();
					$("#videoExternal").hide();
					$("input[name='video']").attr('required');
					// $("input[name='thumbnail']").attr('required');
					$("input[name='link']").removeAttr('required');
				}
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