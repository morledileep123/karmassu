<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en"> 
    <head> 
        <title>Karmasu | Student | Video PlayList</title>
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
											<div class="p-2 float-right">
												<?php if($list[0]->video->completed=='true') {?>
												<button class="btn btn-info" disabled><i class="fa fa-check-circle"></i> DONE </button>
												<?php } else {?>
												<button class="btn btn-danger" onclick="MarkAsCompleted('<?php echo $list[0]->enroll->id;?>','<?php echo $list[0]->video->id;?>','<?php echo $this->userid;?>')"><i class="fa fa-check-circle"></i> MARK AS COMPLETED </button>
												<?php } ?>
												
											</div>
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
											<img src="<?php echo base_url('uploads/thumbnail/'.$item->video[0]->thumbnail);?>" title="img not found" alt="img not found"  class="img-fluid" style="width:80px;height:80px;">
											<div class="media-body ml-3">
												<h6 class="mb-0"><?php echo $item->video[0]->title;?> </h6>
												<p class="mb-0 small-font"><?php echo $item->video[0]->description;?></p>
											</div>
											<div class="star">
												<a href="<?php echo base_url('Student/VideoPlaylist/'.$list[0]->course->id.'/'.$item->video[0]->id); ?>" class="btn btn-info p-2"> <i class="fa fa-play-circle"></i> Play</a>
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
												<a class="text-danger" href="<?php echo base_url('uploads/assignment/'.$item->assignment);?>" download><i class="fa fa-file-pdf-o"></i> Download Assignment</a>
												<?php if($item->upload_status=='true'){ ?>
													| <a class="text-info" href="<?php echo base_url('uploads/answer/'.$item->answer->answer);?>" download><i class="fa fa-download"></i> Download Answer</a>
													<?php } else {?>
													<button onclick="UploadAssignment('<?php echo $list[0]->course->id;?>','<?php echo $item->video;?>','<?php echo $item->id;?>')" class="btn btn-info p-2"><i class="fa fa-upload"></i> Upload Assignment</button>
												<?php } ?>
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
											</div>
										</div>
										<ul class="list-group list-group-flush">
											<?php if(count($item->reply)) : ?>
											<?php foreach($item->reply as $reply) : ?>
											<li class="list-group-item">
												<div class="media align-items-center">
													<img src="<?php if(empty($reply->user->profile_photo)){ echo base_url("image/LogoCodersAdda1.png"); } else{ echo base_url("uploads/profile_photo/".$reply->user->profile_photo); } ?>" class="customer-img rounded-circle" style="height:60px;width:60px;">
													<div class="media-body ml-3">
														<h6 class="mb-0"><?php echo $reply->user->name;?> </h6>
														<p class="mb-0 small-font"><?php echo $reply->message;?></p>
														<p class="mb-0 small-font">Date: <?php echo $reply->date;?> <?php echo $reply->time;?></p>
													</div>
												</div>
											</li>
											<?php endforeach; ?>
											<?php endif; ?>
										</ul>
									</li>
									
									<?php endforeach; ?>
									<?php endif; ?>
									<li class="list-group-item">
										<div class="media align-items-center">
											<div class="media-body ml-3">
												<div class="row">
													<div class="col-sm-6">
														<input type="text" class="form-control" id="message0" name="message" placeholder="Enter Question" style="height:40px;" >
													</div>
													<div class="col-sm-6">
														<button class="btn btn-dark" onclick="QuestionPost('<?php echo $list[0]->course->id;?>','<?php echo $list[0]->video->id;?>','<?php echo $this->userid;?>','','0')"> <i class="fa fa-question-circle"></i> Post</button>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					
                    <div class="overlay toggle-menu"></div>
				</div>
				<div class="modal fade" id="AddModal">
					<div class="modal-dialog">
						<div class="modal-content border-primary">
							<div class="modal-header bg-primary">
								<h5 class="modal-title text-white">Upload Assignment</h5>
								<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="<?php echo base_url("Student/Assignment/Upload/".$list[0]->course->id."/".$list[0]->video->id); ?>" method="post"
							enctype="multipart/form-data" id="addform">
								<div class="modal-body">
									
									
									<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
									value="<?= $this->security->get_csrf_hash(); ?>" />
									<input  hidden name="userid" value="<?php echo $this->userid;?>"/>
									<input hidden  name="courseid" id="U_course"/>
									<input hidden name="videoid" id="U_video"/>
									<input hidden name="assignmentid" id="U_assignment"/>
									
									<div class="form-group">
										<label class="col-form-label">Assignment Answer<span class="text-danger">*</span></label>
										<input type="file" class="form-control dropify" name="answer"  accept="application/pdf" data-height="100" required />
										<?php echo form_error("answer", "<p class='text-danger' >", "</p>"); ?>
									</div>
								</div>
								<div class="modal-footer d-block">
									<button type="submit" id="addaction" name="addaction" class="btn btn-primary"><i
									class="icon-lock"></i> Upload</button>
								</div>
							</form>
						</div>
					</div>
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
			function QuestionPost(courseid,videoid,userid,questionid,srno){
				
				var message=$("#message"+srno).val();
				
				$.ajax({
					url: "<?php echo base_url("Student/VideoQuestion/Add"); ?>",
					type: "post",
					data: {'message':message,'courseid':courseid,'videoid':videoid,'userid':userid,'questionid':questionid},
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
		</script>
		
		<script>
			function MarkAsCompleted(enrollid,videoid,userid){
				$.ajax({
					url: "<?php echo base_url("Student/MarkAsCompleted"); ?>",
					type: "post",
					data: {'enrollid':enrollid,'videoid':videoid,'userid':userid},
					success: function(response) {
					console.log(response);
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
		</script>
	</body>
</html>
