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
                            <h4 class="page-title"> Manage Offers/Coupons</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="Dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Offers/Coupons</li>
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
									class="fa fa-plus-circle"></i> Add Offer/Coupon</button>
								</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        
                                        <table class="table table-bordered" id="example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Status</th>
                                                    <th>Coupon Type</th>
                                                    <th>Banner</th>
                                                    <th>Coupon</th>
                                                    <th>Discount</th>
                                                    <th>Discount Type</th>
                                                    <th>UPTO</th>
                                                    <th>Expiry Date</th>
                                                    <th>No Of Coupon</th>
                                                    <th>Used Coupon</th>
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
                                                            onchange="return Status(this,'tbl_offer','id','<?php echo $item->id; ?>','status')"
                                                            <?php if ($item->status == "true") {
                                                                echo "checked";
															} ?> class="js-switch"
                                                            data-color="#eb5076" data-size="small">
														</td>
														<td> <?php echo $item->type; ?> 
															<?php
																if($item->type=='Educator'){
																	$educatorData=$this->Auth_model->getData('tbl_tutor',$item->educator_id);
																?>
																[<?php echo $educatorData->name.' ('.$educatorData->designation.')'; ?>]<br>
																[<?php echo $educatorData->username;?>]
																<?php
																}
															?>
														</td>
														<td> <label data-toggle="tooltip" data-placement="top"
															title="Offer ID: <?php echo $item->id; ?>"><a
																href="<?php echo base_url("uploads/offer/$item->banner"); ?>"
																target="_blank"><img
																	data-src="<?php echo base_url("uploads/offer/$item->banner"); ?>"
																	src="<?php echo base_url("images/Preloader2.jpg"); ?>"
																class="lazy" style="height:50px;" /> </a></label>
														</td>
														<td> <?php echo $item->coupon; ?> </td>
														<td>
															<?php if($item->discount_type=='Amount') {  echo '<i class="fa fa-rupee"></i>'.$item->discount; } else{ echo $item->discount.'%'; }?>
														</td>
														<td>
															<?php echo $item->discount_type; ?>
														</td>
														<td>
															<i class="fa fa-rupee"></i><?php echo $item->upto; ?>
														</td>
														<td>
															<?php echo $item->expiry_date; ?>
															<?php
																if(strtotime($item->expiry_date)>=strtotime(date('Y-m-d'))){
																	echo '<p class="text-primary">Valid</p>';
																}
																else{
																	echo '<p class="text-danger">Expired</p>';
																}
															?>
														</td>
														<td>
															<?php echo $item->no_of_coupon; ?>
														</td>	
														<td>
															<?php echo $item->used_coupon; ?>
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
																<a href="<?php echo base_url('AdminPanel/ManageOffers/UsedCouponHistory/'.$item->id);?>" class="btn btn-sm btn-primary" >
																<i class="fa fa fa-eye"></i> Used History</a>
																<a href="javascript:void(0);"
																class="btn btn-sm btn-outline-info waves-effect waves-light"
																onclick="Edit('<?php echo $item->id; ?>')">
																<i class="fa fa fa-edit"></i> </a>
																<a href="javascript:void(0);"
																class="btn btn-sm btn-outline-danger waves-effect waves-light"
																onclick="return Delete(this,'tbl_offer','id','<?php echo $item->id; ?>','offer','banner')">
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
							<h5 class="modal-title text-white">Add Offer/Coupon</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?php echo base_url("AdminPanel/ManageOffers/Add"); ?>" method="post"
						enctype="multipart/form-data" id="addform">
							<div class="modal-body">
								
								
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
								value="<?= $this->security->get_csrf_hash(); ?>" />
								<div class="form-group">
									<label class="col-form-label">Coupon Type <span class="text-danger">*</span></label>
									<select class="form-control" name="type"  required onchange="CouponType(this.value)">
										<option value="Student">Student</option>
										<option value="Educator">Educator</option>
									</select>
									<?php echo form_error("type", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group Educators" style="display:none;">
									<label class="col-form-label">Educator <span class="text-danger">*</span></label>
									<select class="form-control" name="educator_id">
										<?php foreach ($authorlist as $item) { ?>
											<option value="<?php echo $item->id;?>" ><?php echo $item->name;?></option>
										<?php } ?>
									</select>
									<?php echo form_error("educator_id", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Coupon <span class="text-danger">*</span></label>
									<input type="text" class="form-control text-uppercase" name="coupon" placeholder="Coupon Code"
									required>
									<?php echo form_error("coupon", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Discount <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="discount" placeholder="Discount"
									required pattern="/^-?\d+\.?\d*$/">
									<?php echo form_error("discount", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Discount Type<span class="text-danger">*</span></label>
									<select class="form-control" name="discount_type"  required>
										<option value="Percentage">Percentage</option>
										<option value="Amount">Amount</option>
									</select>
									<?php echo form_error("discount_type", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">UPTO <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="upto" placeholder="UPTO"
									required pattern="/^-?\d+\.?\d*$/">
									<?php echo form_error("upto", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Expiry Date <span class="text-danger">*</span></label>
									<input type="date" class="form-control" name="expiry_date" required>
									<?php echo form_error("expiry_date", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">No Of Coupon <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="no_of_coupon" placeholder="No Of Coupon"
									required pattern="/^-?\d+\.?\d*$/">
									<?php echo form_error("no_of_coupon", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Description <span class="text-danger">*</span></label>
									<textarea class="form-control" name="description"
									placeholder="Enter offer Description" required></textarea>
									<?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
								</div>
								<div class="form-group">
									<label class="col-form-label">Banner <span class="text-danger">*</span></label>
									<input type="file" class="form-control" name="banner" Title="Choose Banner" required>
									<?php echo form_error("banner", "<p class='text-danger' >", "</p>"); ?>
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit" id="addaction" name="addaction" class="btn btn-primary"><i
								class="icon-lock"></i> Add Offer</button>
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
							<h5 class="modal-title text-white">Edit Offer/Coupon</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						
						<form action="<?php echo base_url("AdminPanel/ManageOffers/Update"); ?>" method="post"
						enctype="multipart/form-data" id="updateform">
							<div class="modal-body">
								
							</div>
							<div class="modal-footer d-block">
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
								value="<?= $this->security->get_csrf_hash(); ?>" />
								<button type="submit" id="updateaction" name="updateaction" class="btn btn-primary"><i
								class="icon-lock"></i> Update Offer</button>
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
                $("#EditModal .modal-body").load("<?php echo base_url('AdminPanel/ManageOffers/Edit/') ?>" + id);
			}
		</script>
        
        <script>
            function Status(e, table, where_column, where_value, column) {
                var status = true;
                var check = $(e).prop("checked");
                if (check) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to activate this offer !",
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
                                    swal("This offer is activated successfully !", {
                                        icon: "success",
									});
								}
							});
						}
					});
                    } else {
                    swal({
                        title: "Are you sure?",
                        text: "You want to deactivate this offer !",
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
                                    swal("This offer is deactivated successfully !", {
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
                    text: "You want to delete this offer !",
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
                                swal("This offer is deleted successfully !", {
                                    icon: "success",
								});
                                location.reload();
							}
						});
					}
				});
                return status;
			}
			
			function CouponType(type)
			{
				if(type=='Educator')
				{
					$('.Educators').show();
				}
				else{
					$('.Educators').hide();
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