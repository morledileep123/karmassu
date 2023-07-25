<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<?php
    if (isset($action)) 
    {
        switch ($action) 
        {
			
            case 'Attend';
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
									<h4 class="page-title"> Attend Quiz</h4>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="javascript:void();">Attend Quiz</a></li>
										<li class="breadcrumb-item active" aria-current="page">Schedule Quiz</li>
									</ol>
								</div>
								<div class="col-sm-3">
									
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="card">
										<div class="card-header">
											<a class="btn btn-success" href="<?php echo base_url('AdminPanel/ScheduleQuiz');?>"><i
											class="fa fa-arrow-left"></i>  Back To Schedule Quiz</a>
										</div>
										<div class="card-body">
											<div class="table-responsive">
												
												<table class="table table-bordered" id="example">
													<thead>
														<tr>
															<th>#</th>
															<th>Student</th>
															<th>Quiz</th>
															<th>Right Answer</th>
															<th>Wrong Answer</th>
															<th>Score</th>
															<th>Date</th>
															<th>Time</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$sr = 1;
															foreach ($resultList as $item) {
																$QuizData=$this->Auth_model->getData('tbl_quiz',$item->quiz_id);
																$studentData=$this->Auth_model->getData('tbl_registration',$item->student_id);
															?>
															<tr>
																<td><?php echo $sr; ?></td>
																<td> <?php echo $studentData->name; ?> (<?php echo $studentData->number; ?>)</td>
																<td> <?php echo $QuizData->name; ?> <a href="<?php echo base_url("AdminPanel/ScheduleQuiz/Questions/".$item->schedule_id); ?>" class="btn btn-sm btn-info waves-effect waves-light"> <i class="fa fa-eye"></i> </a></td>
																<td> <?php echo $item->right; ?> </td>
																<td> <?php echo $item->wrong; ?> </td>
																<td> <?php echo $item->score; ?> </td>
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
				<?php include("Loader.php"); ?>
				<div id="wrapper">
					
					<?php include("Sidebar.php"); ?>
					
					<?php include("Topbar.php"); ?>
					
					<div class="clearfix"></div>
					
					<div class="content-wrapper">
						<div class="container-fluid">
							<div class="row pt-2 pb-2">
								<div class="col-sm-9">
									<h4 class="page-title"> Quiz Questions</h4>
									<ol class="breadcrumb">
										<li class="breadcrumb-item active" aria-current="page"><?=$quizData[0]->name;?></li>
									</ol>
								</div>
								<div class="col-sm-3">
									
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12">
									
									<div class="card">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12 text-center">
													<h4><strong><?= $quizData[0]->name; ?></strong></h4>
													<h6><strong>Per Question Marks: <?= $quizData[0]->per_question_no; ?></strong></h6>
													<h6><strong>No of Question: <?= $quizData[0]->no_of_questions; ?></strong></h6>
													<h6><strong>Quiz Timing: <?= $quizData[0]->timing; ?> Minutes</strong></h6>
													<p><?= $quizData[0]->description; ?></p>
													<hr>
												</div>
											</div>
											<?php $srno=1; foreach ($questionslist as $item){ ?>
												<div class="row">
													<div class="col-sm-12">
														<h6><strong>(<?= $srno; ?>). <?= $item->question; ?></strong></h6><br>
														<p>a). <?php if($item->answer_type=='Photo'){ echo '<img src="'.base_url('uploads/question/'.$item->a).'" style="height:50px"/>'; } else{ echo $item->a; }?></p>
														<p>b). <?php if($item->answer_type=='Photo'){ echo '<img src="'.base_url('uploads/question/'.$item->b).'" style="height:50px"/>'; } else{ echo $item->b; }?></p>
														<p>c). <?php if($item->answer_type=='Photo'){ echo '<img src="'.base_url('uploads/question/'.$item->c).'" style="height:50px"/>'; } else{ echo $item->c; }?></p>
														<p>d). <?php if($item->answer_type=='Photo'){ echo '<img src="'.base_url('uploads/question/'.$item->d).'" style="height:50px"/>'; } else{ echo $item->d; }?></p>
														<p><strong>Right Answer: <?= $this->ansList[$item->answer]; ?></strong></p>
													</div>
													<hr>
												</div>
												<br>
											<?php $srno++; } ?>
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
								<h4 class="page-title">Schedule Quiz</h4>
							</div>
							<div class="col-sm-3">
								
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="card">
									<div class="card-header">
										<button class="btn btn-primary" data-toggle="modal" data-target="#AddModal"><i
										class="fa fa-plus-circle"></i> Schedule</button>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											
											<table class="table table-bordered" id="example">
												<thead>
													<tr>
														<th>#</th>
														<th>Status</th><!--
														<th>Is Done</th>-->
														<th>Educator</th>
														<th>Attend Students</th>
														<th>Course</th>
														<th>Quiz</th>
														<th>Quiz Date</th>
														<th>Date</th>
														<th>Time</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$sr = 1;
														foreach ($list as $item) {
															$quizData=$this->Auth_model->getData('tbl_quiz',$item->quiz_id);
															$courseData=$this->Auth_model->getData('tbl_course',$item->course_id);
															$educatorData=$this->Auth_model->getData('tbl_tutor',$item->teacher_id);
														?>
														<tr>
															<td><?php echo $sr; ?></td>
															<td>
																<input type="checkbox"
																onchange="return Status(this,'tbl_quiz_scheduled','id','<?php echo $item->id; ?>','status')"
																<?php if ($item->status == "true") {
																	echo "checked";
																} ?> class="js-switch"
																data-color="#eb5076" data-size="small">
																</td><!--
																<td>
																<input type="checkbox"
																onchange="return Status(this,'tbl_quiz_scheduled','id','<?php echo $item->id; ?>','is_done')"
																<?php if ($item->is_done == "true") {
																	echo "checked";
																} ?> class="js-switch"
																data-color="#eb5076" data-size="small">
															</td>-->
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
															<td> <a href="<?php echo base_url("AdminPanel/ScheduleQuiz/Attend/".$item->id); ?>" class="btn btn-sm btn-success waves-effect waves-light"> Attend Students </a></td>
															<td> <?php echo $courseData->name; ?> <a href="<?php echo base_url("AdminPanel/ManageCourses/Details/".$item->course_id); ?>" class="btn btn-sm btn-info waves-effect waves-light"> <i class="fa fa-eye"></i> </a></td>
															<td> <?php echo $quizData->name; ?> <a href="<?php echo base_url("AdminPanel/ScheduleQuiz/Questions/".$item->id); ?>" class="btn btn-sm btn-info waves-effect waves-light"> <i class="fa fa-eye"></i> </a></td>
															<td> <?php echo $item->timing; ?> </td>
															<td> <?php echo $item->date; ?> </td>
															<td> <?php echo $item->time; ?> </td>
															<td>
																
																<div class="btn-group">
																	<a href="javascript:void(0);"
																	class="btn btn-sm btn-outline-info waves-effect waves-light"
																	onclick="Edit('<?php echo $item->id; ?>')">
																	<i class="fa fa fa-edit"></i> </a>
																	<a href="javascript:void(0);"
																	class="btn btn-sm btn-outline-danger waves-effect waves-light"
																	onclick="return Delete(this,'tbl_quiz_scheduled','id','<?php echo $item->id; ?>','live_video','thumbnail')">
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
								<h5 class="modal-title text-white">Schedule Quiz</h5>
								<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="<?php echo base_url("AdminPanel/ScheduleQuiz/Add"); ?>" method="post"
							enctype="multipart/form-data" id="addform">
								<div class="modal-body">
									
									
									<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
									value="<?= $this->security->get_csrf_hash(); ?>" />
									
									<div class="form-group">
										<label class="col-form-label">Quiz <span class="text-danger">*</span></label>
										<select class="form-control" name="quiz_id" required>
											<option selected disabled>Select</option>
											<?php foreach ($quizlist as $item) { ?>
												<option value="<?php echo $item->id;?>" ><?php echo $item->name;?></option>
											<?php } ?>
										</select>
										<?php echo form_error("quiz_id", "<p class='text-danger' >", "</p>"); ?>
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
										<label class="col-form-label">Quiz Date <span class="text-danger">*</span></label>
										<input type="datetime-local" class="form-control" name="timing" required>
										<?php echo form_error("timing", "<p class='text-danger' >", "</p>"); ?>
									</div>
								</div>
								<div class="modal-footer d-block">
									<button type="submit" id="addaction" name="addaction" class="btn btn-primary"><i
									class="icon-lock"></i> Schedule</button>
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
								<h5 class="modal-title text-white">Edit Schedule Quiz</h5>
								<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							
							<form action="<?php echo base_url("AdminPanel/ScheduleQuiz/Update"); ?>" method="post"
							enctype="multipart/form-data" id="updateform">
								<div class="modal-body">
									
								</div>
								<div class="modal-footer d-block">
									<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
									value="<?= $this->security->get_csrf_hash(); ?>" />
									<button type="submit" id="updateaction" name="updateaction" class="btn btn-primary"><i
									class="icon-lock"></i> Schedule</button>
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
					$("#EditModal .modal-body").load("<?php echo base_url('AdminPanel/ScheduleQuiz/Edit/') ?>" + id);
				}
			</script>
			<script>
				function Status(e, table, where_column, where_value, column) {
					var status = true;
					var check = $(e).prop("checked");
					if (check) {
						swal({
							title: "Are you sure?",
							text: "You want to activate this  !",
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
										swal("This  is activated successfully !", {
											icon: "success",
										});
									}
								});
							}
						});
						} else {
						swal({
							title: "Are you sure?",
							text: "You want to deactivate this  !",
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
										swal("This  is deactivated successfully !", {
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
						text: "You want to delete this  !",
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
									swal("This  is deleted successfully !", {
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