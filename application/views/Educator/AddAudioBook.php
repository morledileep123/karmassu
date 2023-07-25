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
                            <h4 class="page-title">Add Audio-Book</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">Audio-Books</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Audio-Book</li>
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
                                    <div class="card-title">Add New Audio-Book</div>
                                    <hr>
                                    <form action="<?php echo base_url("Educator/ManageAudioBooks/Add"); ?>" method="post" enctype="multipart/form-data" id="addform" >
                                        
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
                                            <label  class="col-sm-2 col-form-label">Audio-Book Name <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="abookname" placeholder="Enter Audio-Book Name" required >
                                                <?php echo form_error("abookname","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Audio-Book Type <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <div class="icheck-material-danger">
                                                    <input type="radio" id="paidradio" value="Paid" name="abooktype" required />
                                                    <label for="paidradio">Paid</label>
												</div>
                                                <div class="icheck-material-success">
                                                    <input type="radio" id="freeradio" value="Free" name="abooktype" required />
                                                    <label for="freeradio">Free</label>
												</div>
                                                <?php echo form_error("abooktype","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
                                        <div class="form-group row" id="pricediv">
                                            <label  class="col-sm-2 col-form-label">Audio-Book Price <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" id="abookprice" value="0" class="form-control" name="abookprice" placeholder="Enter Audio-Book Price" >
                                                <?php echo form_error("abookprice","<p class='text-danger' >","</p>"); ?>
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
                                            <label  class="col-sm-2 col-form-label">Audio-Book Offer Price</label>
                                            <div class="col-sm-10">
                                                <input type="number" id="offerprice" class="form-control" name="abookofferprice" placeholder="Enter Audio-Book Offer Price">
                                                <br/>
                                                <input type="text" id="discountpercentage" name="discountpercentage" readonly class="form-control form-control-rounded" />
											</div>
										</div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Audio-Book Short Description <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="abookshortdescription" placeholder="Enter Audio-Book Short Description" required></textarea>
                                                <?php echo form_error("abookshortdescription","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        <!--
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
										-->
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
										<!--
											<div class="form-group row d-none">
                                            <label  class="col-sm-2 col-form-label">Requirements <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
											<textarea class="form-control summernote" id="" name="requirement" ></textarea>
											<?php echo form_error("requirement","<p class='text-danger' >","</p>"); ?>
											</div>
											</div>
											
											<div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">What this Audio-Book include ? <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
											<textarea class="form-control summernote" name="abook_include" required></textarea>
											<?php echo form_error("abook_include","<p class='text-danger' >","</p>"); ?>
											</div>
											</div>
											
											<div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">What you will learn ? <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
											<textarea class="form-control summernote"  name="will_learn" required></textarea>
											<?php echo form_error("will_learn","<p class='text-danger' >","</p>"); ?>
											</div>
											</div>
										-->
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Audio-Book Logo <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" name="abooklogo" title="Upload Audio-Book Logo" required accept="image/jpg, image/png, image/jpeg, image/gif">
                                                <?php echo form_error("abooklogo","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
                                        
										<div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Audio-Book Banner <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
												<input type="file" class="form-control" name="abookbanner" title="Upload Audio-Book Cover Page" required accept="image/jpg, image/png, image/jpeg, image/gif">
												<?php echo form_error("abookbanner","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>
										<!--
											<div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Audio-Book Sample Page<span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
											<input type="file" class="form-control" name="abooksample" title="Upload Audio-Book Sample Page" required accept="application/pdf">
											<?php echo form_error("abooksample","<p class='text-danger' >","</p>"); ?>
											</div>
										</div>-->
                                        <div class="form-group row d-none">
                                            <label  class="col-sm-2 col-form-label">Audio-Book Audio File<span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" name="abook" title="Audio-Book File"  accept="audio/mp3">
                                                <?php echo form_error("abook","<p class='text-danger' >","</p>"); ?>
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
                                                <button type="submit" id="addaction" name="addaction" class="btn btn-primary px-5"><i class="icon-lock"></i> Submit</button>
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
			
			// Apply Summer Note on About Audio-Book
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
			$("#abookprice").val("0");
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
			var abookprice=($("#abookprice").val()=="")?0:$("#abookprice").val();
			var offerprice=$(this).val();
			var dicountedprice=abookprice-offerprice;
			var percentage=(dicountedprice*100)/abookprice;
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