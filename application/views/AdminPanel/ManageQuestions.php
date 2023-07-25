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
        
        <!-- Start wrapper-->
        <div id="wrapper">
            
            <?php include("Sidebar.php"); ?>
            
            <?php include("Topbar.php"); ?>
            
            <div class="clearfix"></div>
            
            <div class="content-wrapper">
                <div class="container-fluid">
                    
                    <!-- Breadcrumb-->
                    <div class="row pt-2 pb-2">
                        <div class="col-sm-9">
                            <h4 class="page-title"> Manage Questions</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">Questions</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Questions</li>
							</ol>
						</div>
                        <div class="col-sm-3">
                            
						</div>
					</div>
                    <!-- End Breadcrumb-->
                    
                    <div class="row">
                        <div class="col-sm-12">
                            
                            <!-- Manage Courses Card Start -->
                            <div class="card">
                                <div class="card-header">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#AddModal"><i class="fa fa-plus-circle"></i> Add Question</button>
									<button class="btn btn-dark" type="button" data-toggle="modal" data-target="#UploadQuestionModal"> <i class="fa fa-upload" aria-hidden="true"></i> Upload CSV File</button>
									<a href="<?=base_url('uploads/excel/Sample-CSV-File-Upload-Question.csv');?>" class="btn btn-danger"> <i class="fa fa-download" aria-hidden="true"></i> Download Sample File</a>
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
													<th>Week Bucket</th>
													<th>Question</th>
													<th>Option A</th>
													<th>Option B</th>
													<th>Option C</th>
													<th>Option D</th>
													<th>Right Answer</th>
													<th>Date</th>
													<th>Time</th>
													<th>Action</th>
												</tr>
											</thead>
                                            <tbody>
                                                <?php
                                                    $sr = 1;
                                                    foreach ($list as $item) {
                                                        $educatorData=$this->Auth_model->getData('tbl_tutor',$item->teacher_id);
													?>
                                                    <tr>
                                                        <td><?php echo $sr; ?></td>
                                                        <td>
															<input type="checkbox" onchange="return Status(this,'tbl_questions','id','<?php echo $item->id; ?>','status')" <?php if ($item->status == "true") {
																echo "checked";
															} ?> class="js-switch" data-color="#eb5076" data-size="small">
														</td>
														<td>
														 	<?php 
																if($educatorData)
																{
															 		echo $educatorData->name.' ('.$educatorData->designation.') <br>['.$educatorData->username.']'; 
																}
																else{
																	echo 'Admin';	
																}
																
															?>
														</td>
														<td><?= $item->subject->name; ?></td>
														<td><?= $item->week; ?></td>
														<td><?= $item->question; ?></td>
														<td><?php if($item->answer_type=='Photo'){ echo '<img src="'.base_url('uploads/question/'.$item->a).'" style="height:50px"/>'; } else{ echo $item->a; }?></td>
														<td><?php if($item->answer_type=='Photo'){ echo '<img src="'.base_url('uploads/question/'.$item->b).'" style="height:50px"/>'; } else{ echo $item->b; }?></td>
														<td><?php if($item->answer_type=='Photo'){ echo '<img src="'.base_url('uploads/question/'.$item->c).'" style="height:50px"/>'; } else{ echo $item->c; }?></td>
														<td><?php if($item->answer_type=='Photo'){ echo '<img src="'.base_url('uploads/question/'.$item->d).'" style="height:50px"/>'; } else{ echo $item->d; }?></td>
														<td><?= $this->ansList[$item->answer]; ?></td>
														<td><?= $item->date; ?></td>
															<td><?= $item->time; ?></td>
															<td>
																<div class="btn-group">
																	<a href="javascript:void(0);" class="btn btn-sm btn-outline-info waves-effect waves-light" onclick="Edit('<?php echo $item->id; ?>')">
																	<i class="fa fa fa-edit"></i> </a>
																	<a href="javascript:void(0);" class="btn btn-sm btn-outline-danger waves-effect waves-light" onclick="return Delete(this,'tbl_questions','id','<?php echo $item->id; ?>','','')">
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
							<!-- Manage Courses Card End -->
							
						</div>
					</div>
					
					
					<!--End Dashboard Content-->
					
					<!--start overlay-->
					<div class="overlay toggle-menu"></div>
					<!--end overlay-->
					
				</div>
				<!-- End container-fluid-->
				
			</div>
			<!--End content-wrapper-->
			
			<?php include("Footer.php"); ?>
			
			
			<div class="modal fade" id="AddModal">
				<div class="modal-dialog">
					<div class="modal-content border-primary">
						<div class="modal-header bg-primary">
							<h5 class="modal-title text-white">Add Question</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?php echo base_url("AdminPanel/ManageQuestions/Add"); ?>" method="post" enctype="multipart/form-data" id="addform">
							<div class="modal-body">
								
								
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
								
								<div class="form-group">
									<label class="col-form-label">Subject <span class="text-danger">*</span></label>
									<select class="form-control" name="subject_id" required>
										<option selected disabled>Select</option>
										<?php foreach ($subjectList as $item) { ?>
											<option value="<?php echo $item->id;?>" ><?php echo $item->name;?></option>
										<?php } ?>
									</select>
									<?php echo form_error("subject_id", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Week Bucket <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="week" placeholder="Week Bucket" required>
									<?php echo form_error("week", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Question <span class="text-danger">*</span></label>
									<textarea class="form-control" name="question" placeholder="Question" required></textarea>
									<?php echo form_error("question", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Answer Type <span class="text-danger">*</span></label>
									<select class="form-control" name="answer_type" required onchange="AnswerType(this.value)">
										<option selected value="Text">Text</option>
										<option value="Photo">Photo</option>
									</select>
									<?php echo form_error("subject_id", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Option A <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="a" placeholder="Option A" required>
									<?php echo form_error("a", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Option B <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="b" placeholder="Option B" required>
									<?php echo form_error("b", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Option C <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="c" placeholder="Option C" required>
									<?php echo form_error("c", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Option D <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="d" placeholder="Option D" required>
									<?php echo form_error("d", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Right Answer<span class="text-danger">*</span></label>
									<select class="form-control" name="answer" required>
										<option selected disabled>Select</option>
										<?php foreach($this->ansList as $key=>$value): ?>
										<option value="<?=$key;?>"><?=$value;?></option>
										<?php endforeach; ?>
									</select>
								</div> 
							</div>
							<div class="modal-footer d-block">
								<button type="submit" id="addaction" name="addaction" class="btn btn-primary"><i class="icon-lock"></i> Add Question</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!--End Modal -->
			<!--Modal Start-->
			<div class="modal fade" id="EditModal">
				<div class="modal-dialog">
					<div class="modal-content border-primary">
						<div class="modal-header bg-primary">
							<h5 class="modal-title text-white">Edit Question</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						
						<form action="<?php echo base_url("AdminPanel/ManageQuestions/Update"); ?>" method="post" enctype="multipart/form-data" id="updateform">
							<div class="modal-body">
								
							</div>
							<div class="modal-footer d-block">
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
								<button type="submit" id="updateaction" name="updateaction" class="btn btn-primary"><i class="icon-lock"></i> Update Question</button>
							</div>
						</form>
						
					</div>
				</div>
			</div>
			<!--Modal End-->
			
			<!--Modal Start-->
			<div class="modal fade" id="UploadQuestionModal">
				<div class="modal-dialog">
					<div class="modal-content border-primary">
						<div class="modal-header bg-primary">
							<h5 class="modal-title text-white">Upload Question</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?php echo base_url("AdminPanel/ManageQuestions/Import"); ?>" method="post" enctype="multipart/form-data" id="uploadForm">
							<div class="modal-body">
								<div class="row">
									<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
									<div class="form-group col-sm-12">
										<label class="col-form-label">Choose CSV File <span class="text-danger">*</span></label>
										<input type="file" class="form-control dropify" data-height="150" name="excelfile" Title="Choose CSV File"  accept= ".csv"  required>
										<?php echo form_error("excelfile", "<p class='text-danger' >", "</p>"); ?>
									</div>
								</div>
							</div>
							<div class="modal-footer d-block p-1">
								<button type="submit" class="btn btn-primary" id="uploadBtn"> <i class="fa fa-check-circle"></i>  Submit <i class="fa fa-spin fa-spinner" id="uploadSpin" style="display:none;"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!--Modal End-->
			
		</div>
		<!--End wrapper-->
		
		<?php include("FooterLinking.php"); ?>
		<script>
			function Edit(id) {
				$("#EditModal").modal("show");
				$("#EditModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
				$("#EditModal .modal-body").load("<?php echo base_url('AdminPanel/ManageQuestions/Edit/') ?>" + id);
			}
		</script>
		
		<script>
			function AnswerType(type) {
				if(type=='Photo')
				{
					$("input[name=a]").attr('type','file');
					$("input[name=b]").attr('type','file');
					$("input[name=c]").attr('type','file');
					$("input[name=d]").attr('type','file');
				}
				else{
					$("input[name=a]").attr('type','text');
					$("input[name=b]").attr('type','text');
					$("input[name=c]").attr('type','text');
					$("input[name=d]").attr('type','text');
				}
				
			}
		</script>
		
		<script>
			function Status(e, table, where_column, where_value, column) {
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
			
			function Delete(e, table, where_column, where_value, unlink_folder, unlink_column) {
				var status = true;
				swal({
					title: "Are you sure?",
					text: "You want to delete this Question !",
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
								swal("This Question is deleted successfully !", {
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
						msg: '<?php echo $this->session->flashdata("msg"); ?>'
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
						msg: '<?php echo $this->session->flashdata("msg"); ?>'
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
						msg: '<?php echo $this->session->flashdata("msg"); ?>'
					});
				});
			</script>
			<?php
			}
		?>
		
	</body>
	
</html>	