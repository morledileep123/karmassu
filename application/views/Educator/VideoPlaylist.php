<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("HeaderLinking.php"); ?>
	</head>
      
    <body>
        <?php include("Loader.php"); ?>
        <div id="wrapper">
            <?php include("Sidebar.php"); ?>
            
            <?php include("Topbar.php"); ?>
            
            <div class="clearfix"></div>
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
							<?php
								if($list[0]->video->type=='Internal'){
									$link=base_url('uploads/video/'.$list[0]->video->video);
								}
								else{
									$link=$list[0]->video->link;
								}
							?>
							<div class="card">
								<div class="card-header"><h5><?php echo $list[0]->video->title;?></h5> </div>
								<ul class="list-group list-group-flush">
									<li class="list-group-item">
										<div class="media align-items-center">
											<iframe style="width:100%;height:460px;" src="<?php echo $link;?>"  frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
										</div>
										<div class="media-body ml-3"><br>
											<p><a class="text-info"><?php echo $list[0]->video->subjectdetails->name;?></a></p>
											<h6><i class="fa fa-user-circle text-danger"></i> <?php echo $list[0]->course->author->name;?></h6>
											
											<h6><i class="fa fa-clock text-danger"></i> <?php echo$list[0]->video->duration;?></h6>
											<h4 class="mb-0 text-dark"><?php echo $list[0]->video->title;?> </h4>
											
											<br>
											
											<div class="" >
												<div id="accordion-description">
													
													<button class="btn btn-link text-primary shadow-none collapsed p-0" data-toggle="collapse" data-target="#collapse-description" aria-expanded="false" aria-controls="collapse-description">
														Click to read description - Lecture Description & Notes
													</button>
													<div id="collapse-description" class="collapse" data-parent="#accordion-description"><br>
														<?php if($list[0]->video->notes){ ?>
															<a class="text-info" href="<?php echo base_url('uploads/notes/'.$list[0]->video->notes);?>" download><i class="fa fa-download"></i> Download Notes</a><br>
														<?php } ?>
														
														<p><?php echo $list[0]->video->description;?></p>
														
													</div>
												</div>
											</div><br>
										</div>
									</li>
								</ul>
							</div>
							
							
							<div class="card" style="max-height:530px;overflow-y:scroll;">
								<div class="card-header"><h5>Playlist</h5> </div>
								<ul class="list-group list-group-flush">
									<?php if(count($lecture)) : ?>
									<?php foreach($lecture as $item) : ?>
									<li class="list-group-item">
										<div class="media align-items-center">
											<img src="<?php echo base_url('uploads/thumbnail/'.$item->video[0]->thumbnail);?>"  class="img-fluid" style="width:80px;height:80px;">
											<div class="media-body ml-3">
												<h6 class="mb-0"><?php echo $item->video[0]->title;?> </h6>
												<p class="mb-0 small-font"><?php echo $item->video[0]->description;?></p>
											</div>
											<div class="star">
												<a href="<?php echo base_url('Educator/VideoPlaylist/'.$list[0]->course->id.'/'.$item->video[0]->id); ?>" class="btn btn-info p-2"> <i class="fa fa-play-circle"></i> Play</a>
											</div>
										</div>
									</li>
									<?php endforeach; ?>
									<?php endif; ?>
									<?php if(!count($lecture)) : ?>
									<li class="list-group-item">
										<div class="media align-items-center">
											<div class="media-body ml-3">
												No Playlist Found.
											</div>
										</div>
									</li>
									<?php endif; ?>
								</ul>
							</div>
							
							<div class="" >
								<div class="card card-header"><h5>Assignment</h5> </div>
								<div id="accordion1">
									
									<?php if(count($list[0]->assignment)) : $i=1;?>
									<?php foreach($list[0]->assignment as $item) : ?>
									<div class="card mb-2">
										<div class="card-header">
											<button class="btn btn-link text-primary shadow-none collapsed" data-toggle="collapse" data-target="#collapse-<?php echo $item->id;?>" aria-expanded="false" aria-controls="collapse-<?php echo $item->id;?>">
												Assignment #<?php echo $i;?>
											</button>
										</div>
										
										<div id="collapse-<?php echo $item->id;?>" class="collapse" data-parent="#accordion1" style="">
											<div class="card-body">
												<h6 class="mb-0"><?php echo $item->description;?> </h6>
												<a style="float:right;" href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="return Delete(this,'tbl_video_assignment','id','<?php echo $item->id; ?>','assignment','assignment')"> <i class="fa fa-trash"></i> Delete </a>
												<a class="text-danger" href="<?php echo base_url('uploads/assignment/'.$item->assignment);?>" download><i class="fa fa-file-pdf-o"></i> Download Assignment</a>
												<hr>
												<ul class="list-group list-group-flush">
													<?php if(count($item->answer)) : $i=1;?>
													<?php foreach($item->answer as $item_child) : ?>
													<li class="list-group-item">
														<div class="media align-items-center">
															<img src="<?php if(empty($item_child->user->profile_photo)){ echo base_url("uploads/logo.png"); } else{ echo base_url("uploads/profile_photo/".$item_child->user->profile_photo); } ?>" class="customer-img rounded-circle" style="height:80px;width:80px;">
															<div class="media-body ml-3">
																<h6 class="mb-0"><?php echo $item_child->user->name;?> (<?php echo $item_child->user->number;?>) </h6>
																<p class="mb-0 small-font"><a class="text-danger" href="<?php echo base_url('uploads/answer/'.$item_child->answer);?>" download><i class="fa fa-file-pdf-o"></i> Download Answer</a></p>
															</div>
														</div>
													</li>
													
													<?php endforeach; ?>
													<?php endif; ?>
												</ul>
											</div>
										</div>
									</div>
									<?php $i++; endforeach; ?>
									<?php endif; ?>
									<?php if(!count($list[0]->assignment)) : ?>
									<div class="card mb-2">
										<div class="card-header">
											No Assignment Found.
										</div>
									</div>
									<?php endif; ?>
								</div>
							</div>
							
							<div class="card">
								<div class="card-header">Post Question and Answer </div>
								
								<ul class="list-group list-group-flush">
									<?php if(count($list[0]->question)) : $i=1;?>
									<?php foreach($list[0]->question as $item) : ?>
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
													<img src="<?php if(empty($reply->user->profile_photo)){ echo base_url("uploads/logo.png"); } else{ echo base_url("uploads/profile_photo/".$reply->user->profile_photo); } ?>" class="customer-img rounded-circle" style="height:60px;width:60px;">
													<div class="media-body ml-3">
														<h6 class="mb-0"><?php echo $reply->user->name;?> </h6>
														<p class="mb-0 small-font"><?php echo $reply->message;?></p>
														<p class="mb-0 small-font">Date: <?php echo $reply->date;?> <?php echo $reply->time;?></p>
														<input type="checkbox"
														onchange="return replystatus(this,'tbl_video_reply','id','<?php echo $reply->id;?>','status')" <?php if ($reply->status == "true") {
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
																<button class="btn btn-dark" onclick="ReplyPost('<?php echo $list[0]->course->id;?>','<?php echo $list[0]->video->id;?>','<?php echo 1;?>','Educator','<?php echo $item->id;?>')"> <i class="fa fa-reply"></i> </button>
																
															</div>
														</div>
													</div>
												</div>
											</li>
										</ul>
									</li>
									
									<?php endforeach; ?>
									<?php endif; ?>
								</ul>
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
			function UploadAssignment(U_course,U_video,U_assignment) {
				
				$("#U_course").val(U_course);
				$("#U_video").val(U_video);
				$("#U_assignment").val(U_assignment);
				$("#AddModal").modal("show");
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
		
		<script>
			function ReplyPost(courseid,videoid,userid,usertype,questionid){
				
				var message=$("#message"+questionid).val();
				
				$.ajax({
					url: "<?php echo base_url("Educator/VideoReply/Add"); ?>",
					type: "post",
					data: {'message':message,'courseid':courseid,'videoid':videoid,'userid':userid,'usertype':usertype,'questionid':questionid},
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
								url: "<?php echo base_url("Educator/UpdateStatus");?>",
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
								url: "<?php echo base_url("Educator/UpdateStatus");?>",
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
								url: "<?php echo base_url("Educator/UpdateStatus");?>",
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
								url: "<?php echo base_url("Educator/UpdateStatus");?>",
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
                            url: "<?php echo base_url("Educator/Delete"); ?>",
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
