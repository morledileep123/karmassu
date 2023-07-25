<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("HeaderLinking.php"); ?>
		<style>
			.chosen-container {
			width:100% !important;
			}
		</style> 
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
                            <h4 class="page-title"> Top App Courses</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">App Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Top App Courses</li>
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
									class="fa fa-plus-circle"></i> Set Top Courses</button>
								</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        
                                        <table class="table table-bordered" id="example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Indexing</th>
                                                    <th>Logo</th>
                                                    <th>Name</th>
                                                    <th>Price</th>
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
                                                        <td><?php echo $item->top; ?></td>
                                                        <td> <img
                                                            data-src="<?php echo base_url("uploads/course/$item->logo"); ?>"
                                                            src="<?php echo base_url("images/Preloader2.jpg"); ?>"
														class="lazy" style="height:50px;" /> </td>
                                                        <td>
                                                            <label data-toggle="tooltip" data-placement="top"
                                                            title="Course ID: <?php echo $item->id; ?>"><?php echo $item->name; ?>
															</label>
														</td>
                                                        <td>
                                                            <?php
                                                                if ($item->type == "Paid") {
																?>
                                                                <span class="p-2 text-danger">Paid</span> <br />
                                                                <?php
                                                                    if (empty($item->offerprice)) {
																	?>
                                                                    <i class="fa fa-rupee"></i> <?php echo $item->price; ?>
                                                                    <?php
                                                                        } else {
																	?>
                                                                    <s><i class="fa fa-rupee"></i> <?php echo $item->price; ?></s>
                                                                    <i class="fa fa-rupee"></i> <?php echo $item->offerprice; ?>
                                                                    <?php
																	}
                                                                    } else {
																?>
                                                                <span class="p-2 text-success">Free</span>
                                                                <?php
																}
															?>
														</td>
                                                        <td>
                                                            
                                                            <div class="btn-group">
                                                                <a href="<?php echo base_url("AdminPanel/ManageCourses/Details/$item->id") ?>"
                                                                class="btn btn-sm btn-outline-success waves-effect waves-light">
																<i class="fa fa-eye"></i> </a>
                                                                <a href="javascript:void(0);"
                                                                class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                                onclick="return Status(this,'tbl_course','id','<?php echo $item->id;?>','top')">
																<i class="fa fa-times-circle"></i> </a>
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
                            <h5 class="modal-title text-white">Top Course</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
							</button>
						</div>
                        <form action="<?php echo base_url("AdminPanel/TopAppCourses/Add"); ?>" method="post"
                        enctype="multipart/form-data" id="addform">
                            <div class="modal-body">
                                
                                
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>" />
								
                                <div class="form-group">
										<label>Top Courses <span class="text-danger">*</span></label>
										<!--
										<div class="icheck-primary">
											<input type="radio" id="select_all" class="select_type" name="type" value="Select All" >
											<label for="select_all">Select All</label>
										</div>
										<div class="icheck-primary">
											<input type="radio" id="select_any_more" class="select_type"  name="type" value="Select Any More" checked>
											<label for="select_any_more" >Select Any More</label>
										</div> -->
										<div class="user_box d-block" >
											<select class="form-control" data-placeholder="Choose" multiple  name="course_id[]" id="course_id" required >
												<?php
													foreach ($courselist as $item) {
														?>
														<option value="<?php echo $item->id;?>"><?php echo $item->name;?></option>
														<?php
													}
												?>
												
											</select>	
										</div>
									</div>
                                
                                
							</div>
                            <div class="modal-footer d-block">
                                <button type="submit" id="addaction" name="addaction" class="btn btn-primary">
								<i class="icon-lock"></i> Submit</button>
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
                $("#EditModal .modal-body").load("<?php echo base_url('AdminPanel/ManageSliders/Edit/') ?>" + id);
			}
		</script>
        <script>
            function Status(e, table, where_column, where_value, column) {
                swal({
					title: "Are you sure?",
					text: "You want to remove this course from Top !",
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
								'value': 'Top',
								'where_column': where_column,
								'where_value': where_value
							},
							success: function(response) {
								swal("This course is removed from Top.", {
									icon: "success",
								});
								location.reload();
							}
						});
					}
				});
			}
			
			$('#course_id').chosen();
			
			$('.select_type').change(function() {
				if ($("#select_all").is(':checked')) {
					$('#course_id option').prop('selected', true);
					$('#course_id').trigger('liszt:updated');
					$("#course_id").trigger("chosen:updated");
				}
				if ($("#select_any_more").is(':checked')) {
					$('#course_id option').prop('selected', false);
					$('#course_id').trigger('liszt:updated');
					$("#course_id").trigger("chosen:updated");
					
				}
			});
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