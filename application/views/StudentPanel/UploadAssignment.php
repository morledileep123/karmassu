<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
     
    <head>
        <title>Karmasu | Student | Upload Assignment</title>
        <?php include("HeaderLinking.php"); ?>
	</head>
          
    <body>
        <div id="wrapper">
            
            <div class="container" style="margin-top:10px;">
                    <div class="row">
                        <div class="col-sm-12">
							
							<div class="" >
								<div class="card card-header"><h5>Assignment</h5> </div>
								<div id="accordion1">
									
									<?php if(count($list[0]->assignment)) : $i=1;?>
									<?php foreach($list[0]->assignment as $item) : ?>
									<div class="card mb-2">
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
							<form action="<?php echo base_url("Home/Assignment/Upload/".$list[0]->course->id."/".$list[0]->video->id); ?>" method="post"
							enctype="multipart/form-data" id="addform">
								<div class="modal-body">
									
									
									<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
									value="<?= $this->security->get_csrf_hash(); ?>" />
									<input  hidden name="userid" value="<?php echo $userid;?>"/>
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
									class="fa fa-lock"></i> Upload</button>
								</div>
							</form>
						</div>
					</div>
				</div>
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
	</body>
</html>
