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
                            <h4 class="page-title">Add E-Book</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">E-Books</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add E-Book</li>
							</ol>
						</div>
                        <div class="col-sm-3">
						</div>
					</div>
                    <!-- End Breadcrumb-->
                    
                    <div class="row">
                        <div class="col-sm-12">
                            
                            <!-- Form Card Start -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">Add New E-Book</div>
                                    <hr>
                                    <form action="<?php echo base_url("Educator/ManageEBooks/Add"); ?>" method="post" enctype="multipart/form-data" id="addform" >
                                        
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                        <input type="hidden" name="author" value="<?=$this->author;?>" required>
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Category <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="category" required>
                                                    <option selected disabled>Select</option>
                                                    <?php
                                                        foreach ($categorylist as $item){
														?>
                                                        <option value="<?php echo $item->id;?>"><?php echo $item->title;?></option>
                                                        <?php
														}
													?>
												</select>
                                                <?php echo form_error("category","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">E-Book Name <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="ebookname" placeholder="Enter E-Book Name" required >
                                                <?php echo form_error("ebookname","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">E-Book Type <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <div class="icheck-material-danger">
                                                    <input type="radio" id="paidradio" value="Paid" name="ebooktype" required />
                                                    <label for="paidradio">Paid</label>
												</div>
                                                <div class="icheck-material-success">
                                                    <input type="radio" id="freeradio" value="Free" name="ebooktype" required />
                                                    <label for="freeradio">Free</label>
												</div>
                                                <?php echo form_error("ebooktype","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        <div class="form-group row" id="pricediv">
                                            <label  class="col-sm-2 col-form-label">E-Book Price <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" id="ebookprice" value="0" class="form-control" name="ebookprice" placeholder="Enter E-Book Price" >
                                                <?php echo form_error("ebookprice","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        <div class="form-group row" id="checkofferdiv">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-10">
                                                <div class="icheck-material-success">
                                                    <input type="checkbox" id="offercheck" />
                                                    <label for="offercheck">Add Offer Price</label>
												</div>
											</div>
										</div>
                                        
                                        <div class="form-group row" id="offerpricediv">
                                            <label  class="col-sm-2 col-form-label">E-Book Offer Price</label>
                                            <div class="col-sm-10">
                                                <input type="number" id="offerprice" class="form-control" name="ebookofferprice" placeholder="Enter E-Book Offer Price">
                                                <br/>
                                                <input type="text" id="discountpercentage" name="discountpercentage" readonly class="form-control form-control-rounded" />
											</div>
										</div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">E-Book Short Description <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="ebookshortdescription" placeholder="Enter E-Book Short Description" required></textarea>
                                                <?php echo form_error("ebookshortdescription","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">No of Pages <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="noofpages" placeholder="Enter No of Pages" required >
                                                <?php echo form_error("noofpages","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Days to Finish <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="daystofinish" placeholder="Enter Days to Finish" required>
                                                <?php echo form_error("daystofinish","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
										
										<div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Offer Text <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="offer_text" placeholder="Enter Offer Text" required>
                                                <?php echo form_error("offer_text","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Description <span class="text-danger"></span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control summernote" id="description" name="description" ></textarea>
                                                <?php echo form_error("description","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        <div class="form-group row d-none">
                                            <label  class="col-sm-2 col-form-label">Requirements <span class="text-danger"></span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control summernote" id="" name="requirement" ></textarea>
                                                <?php echo form_error("requirement","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">What this E-Book include ? <span class="text-danger"></span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control summernote" name="ebook_include" ></textarea>
                                                <?php echo form_error("ebook_include","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">What you will learn ? <span class="text-danger"></span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control summernote"  name="will_learn" ></textarea>
                                                <?php echo form_error("will_learn","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">E-Book Logo <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" name="ebooklogo" title="Upload E-Book Logo" required accept="image/jpg, image/png, image/jpeg, image/gif">
                                                <?php echo form_error("ebooklogo","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">E-Book Cover Page <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" name="ebookbanner" title="Upload E-Book Cover Page" required accept="image/jpg, image/png, image/jpeg, image/gif">
                                                <?php echo form_error("ebookbanner","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">E-Book Sample Page<span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" name="ebooksample" title="Upload E-Book Sample Page" required accept="application/pdf">
                                                <?php echo form_error("ebooksample","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        <div class="form-group row d-none">
                                            <label  class="col-sm-2 col-form-label">E-Book PDF File<span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" name="ebook" title="E-Book PDF File"  accept="application/pdf">
                                                <?php echo form_error("ebook","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-10">
                                                <div class="icheck-material-danger">
                                                    <input type="checkbox" id="comfirmsubmit" required />
                                                    <label for="comfirmsubmit">Confirm Submission</label>
												</div>
											</div>
										</div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-10">
                                                <button type="submit" id="addaction" name="addaction" class="btn btn-primary px-5"><i class="icon-lock"></i> Add E-Book</button>
											</div>
										</div>
                                        
									</form>
								</div>
							</div>
                            
                            <!-- Form Card End -->
                            
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
            
            
		</div>
        <!--End wrapper-->
        
        <?php
            include("FooterLinking.php");
		?>
        
        <script>
            $(function() {
                $(".knob").knob();
			});
		</script>
        <!-- Index js -->
        <script src="<?php base_url("assets_panel/js/index.js"); ?>"></script>
        <script>
            $(document).ready(function(){
				
				// Apply Summer Note on About E-Book
				$('.summernote').summernote({
					height: 200,
					tabsize: 2
				});
				
				$("#addaction").attr("disabled",true);
				
				$("#pricediv").hide();
				$("#checkofferdiv").hide();
				$("#offerpricediv").hide();
				
				$("#paidradio").change(function(){
					var check=$(this).prop("checked");
					if(check)
					{
						$("#pricediv").show();
						$("#checkofferdiv").show();
					}
				});
				$("#freeradio").change(function(){
					var check=$(this).prop("checked");
					if(check)
					{
						$("#pricediv").hide();
						$("#E-Bookprice").val("0");
						$("#checkofferdiv").hide();
					}
				});
				
				$("#offercheck").change(function(){
					var check=$(this).prop("checked");
					if(check)
					{
						$("#offerpricediv").show();
					}
					else
					{
						$("#offerpricediv").hide();
					}
					
				});
				
				$("#offerprice").keyup(function(){
					var ebookprice=($("#ebookprice").val()=="")?0:$("#ebookprice").val();
					var offerprice=$(this).val();
					var dicountedprice=ebookprice-offerprice;
					var percentage=(dicountedprice*100)/ebookprice;
					var percentage=percentage.toFixed(2);
					$("#discountpercentage").val(percentage+"% Off");
				});
				
				$("#comfirmsubmit").change(function(){
					
					var check =$(this).prop("checked");
					if(check)
					{
						$("#addaction").attr("disabled",false);
					}
					else{
						$("#addaction").attr("disabled",true);
					}
					
				});
				
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