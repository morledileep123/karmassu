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
                            <h4 class="page-title"> Manage Quiz</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">Quiz</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Quiz</li>
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
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#AddModal"><i class="fa fa-plus-circle"></i> Add Quiz</button>
								</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        
                                        <table class="table table-bordered" id="example">
                                            <thead>
                                                <tr>
													<th>#</th>
													<th>Status</th>
													<th>Educator</th>
													<th>Quiz Name</th>
													<th>No of Questions</th>
													<th>Per Question Marks</th>
													<th>Quiz Timing</th>
													<th>Description</th>
													<th>Solutions</th>
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
															<input type="checkbox" onchange="return Status(this,'tbl_quiz','id','<?php echo $item->id; ?>','status')" <?php if ($item->status == "true") {
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
														<td><?= $item->name; ?></td>
														<td><?= $item->no_of_questions; ?> <a href="<?=base_url('AdminPanel/ManageQuiz/Questions/'.$item->id);?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a></td>
														<td><?= $item->per_question_no; ?> </td>
														<td><?= $item->timing; ?> Minutes</td>
														<td><?= $item->description; ?></td>
														<td><?= $item->solutions; ?></td>
														<td><?= $item->date; ?></td>
														<td><?= $item->time; ?></td>
														<td>
															<div class="btn-group">
																<a href="javascript:void(0);" class="btn btn-sm btn-outline-info waves-effect waves-light" onclick="Edit('<?php echo $item->id; ?>')">
																<i class="fa fa fa-edit"></i> </a>
																<a href="javascript:void(0);" class="btn btn-sm btn-outline-danger waves-effect waves-light" onclick="return Delete(this,'tbl_quiz','id','<?php echo $item->id; ?>','','')">
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
							<h5 class="modal-title text-white">Add Quiz</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?php echo base_url("AdminPanel/ManageQuiz/Add"); ?>" method="post" enctype="multipart/form-data" id="addform">
							<div class="modal-body">
								
								
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
								<div class="form-group">
									<label class="col-form-label">Quiz Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="name" placeholder="Quiz Name" required>
									<?php echo form_error("name", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Course <span class="text-danger">*</span></label>
									<select class="form-control" name="course_id" required >
										<option selected disabled>Select</option>
										<?php foreach ($courselist as $item) { ?>
											<option value="<?php echo $item->id;?>" ><?php echo $item->name;?></option>
										<?php } ?>
									</select>
									<?php echo form_error("course_id", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Questions Filter By Subject <span class="text-danger">*</span></label>
									<div class="row skin skin-line" >
										<?php foreach ($subjectList as $item){ ?>
											<fieldset class="col-sm-6">
												<input type="checkbox" name="subject_id" id="subject-<?=$item->id;?>" value="<?=$item->id;?>" required >
												<label for="subject-<?=$item->id;?>"><?=$item->name;?></label>
											</fieldset>
										<?php }  ?>
										<?php echo form_error("subject_id","<p class='text-danger' >","</p>"); ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-form-label">Questions Filter By Week Bucket <span class="text-danger">*</span></label>
									<div class="row skin skin-line" >
										<?php foreach ($weekList as $item){ ?>
											<fieldset class="col-sm-6">
												<input type="checkbox" name="week" id="week-<?=$item->week;?>" value="<?=$item->week;?>" required >
												<label for="week-<?=$item->week;?>"><?=$item->week;?></label>
											</fieldset>
										<?php }  ?>
										<?php echo form_error("week","<p class='text-danger' >","</p>"); ?>
									</div>
									<button type="button" class="btn btn-dark btn-sm filterBtn"  style="padding:10px;" onclick="getQuestions(this.value)"> <i class="fa fa-check-circle"></i>  Click Here To Filter <i class="fa fa-spin fa-spinner filterSpin"  style="display:none;"></i></button>
								</div>
								
								<div class="form-group">
									<label class="col-form-label">Questions <span class="text-danger">*</span></label>
									<div class="questionsList">
									</div>
									<?php echo form_error("questions","<p class='text-danger' >","</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Per Question Marks <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="per_question_no" placeholder="Per Question Marks" required>
									<?php echo form_error("per_question_no", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Quiz Timing (In Minutes) <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="timing" placeholder="Quiz Timing (In Minutes)" required>
									<?php echo form_error("timing", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Solutions Link <span class="text-danger"></span></label>
									<input type="text" class="form-control" name="solutions" placeholder="Solutions">
									<?php echo form_error("solutions", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Description <span class="text-danger">*</span></label>
									<textarea class="form-control" name="description" placeholder="Description" required></textarea>
									<?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
								</div>
								
							</div>
							<div class="modal-footer d-block">
								<button type="submit" id="addaction" name="addaction" class="btn btn-primary"><i class="icon-lock"></i> Add Quiz</button>
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
							<h5 class="modal-title text-white">Edit Quiz</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						
						<form action="<?php echo base_url("AdminPanel/ManageQuiz/Update"); ?>" method="post" enctype="multipart/form-data" id="updateform">
							<div class="modal-body">
								
							</div>
							<div class="modal-footer d-block">
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
								<button type="submit" id="updateaction" name="updateaction" class="btn btn-primary"><i class="icon-lock"></i> Update Quiz</button>
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
			function getQuestions(id){
				$(".filterBtn").attr("disabled", true);
				$(".filterSpin").show();
				var ids = [];
				$.each($("input[name='subject_id']:checked"), function(){            
					ids.push($(this).val());
				});
				var weeks = [];
				$.each($("input[name='week']:checked"), function(){            
					weeks.push($(this).val());
				});
				$.ajax({
					url: "<?=base_url('AdminPanel/ManageSubjects/QuestionsList');?>",
					type: "POST",
					data: {'ids':ids,'weeks':weeks},
					success: function(response) {
						$(".filterBtn").removeAttr("disabled");
						$(".filterSpin").hide();
						var response = JSON.parse(response);
						if (response[0].res == 'success') 
						{
							var htmlData='<div class="row">';
							for (var i = 0; i < response[0].data.length; i++) {
								htmlData+='<fieldset class="col-sm-12"> <input type="checkbox" name="questions[]" id="questions-'+i+'" value="'+response[0].data[i].id+'" required > <label for="questions-'+i+'">'+response[0].data[i].question+'</label></fieldset>';
							}
							htmlData+='</div>';
							$('.questionsList').html(htmlData);
						}
						else if (response[0].res == 'error') 
						{
							$('.notifyjs-wrapper').remove();
							$.notify("" + response[0].msg + "", "error");
							var htmlData='<div class="row">';
							htmlData+='</div>';
							$('.studentsList').html(htmlData);
						}
					}
				});
			}
		</script>
		<script>
			function Edit(id) {
				$("#EditModal").modal("show");
				$("#EditModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
				$("#EditModal .modal-body").load("<?php echo base_url('AdminPanel/ManageQuiz/Edit/') ?>" + id);
			}
		</script>
		
		<script>
			function Status(e, table, where_column, where_value, column) {
				var status = true;
				var check = $(e).prop("checked");
				if (check) {
					swal({
						title: "Are you sure?",
						text: "You want to activate this Quiz !",
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
									swal("This Quiz is activated successfully !", {
										icon: "success",
									});
								}
							});
						}
					});
					} else {
					swal({
						title: "Are you sure?",
						text: "You want to deactivate this Quiz !",
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
									swal("This Quiz is deactivated successfully !", {
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
					text: "You want to delete this Quiz !",
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
								swal("This Quiz is deleted successfully !", {
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