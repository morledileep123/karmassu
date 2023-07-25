<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">  
    <head>
        <?php include("HeaderLinking.php"); ?>
		<style>
			.pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
		</style>
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
							<div class="card">
								<div class="card-header"><h5>Agreement </h5></div>
								<div class="card-body">
									<div id="pdfRenderer"></div>
									<br><br>
									<form action="<?php echo base_url("Educator/Agreement"); ?>" method="post" enctype="multipart/form-data" id="addform">
										<div class="row">
											<div class="form-group form-check col-sm-12">
												&emsp;
												<input type="checkbox" name="agree" class="form-check-input" id="accept" value="accept" required <?php if($agreement){ echo 'checked disabled';}?>>
												<label class="form-check-label" for="accept">I agree to the agreement.</label>
											</div>
												<div class="form-group col-sm-4">
												<label>Upload Photo <span class="text-danger">*</span></label>
												<input type="file" name="photo" class="form-control dropify" data-height="150" required data-default-file="<?php if($agreement){ echo base_url('uploads/agreement/'.$agreement->photo); }?>" <?php if($agreement){ echo 'disabled';}?> />
											</div>
											<div class="form-group col-sm-4">
												<label>Upload ID Proof <span class="text-danger">*</span></label>
												<input type="file" name="proof" class="form-control dropify" data-height="150" required data-default-file="<?php if($agreement){ echo base_url('uploads/agreement/'.$agreement->proof); }?>" <?php if($agreement){ echo 'disabled';}?> />
											</div>
											<div class="form-group col-sm-4">
												<label>Upload Signature <span class="text-danger">*</span></label>
												<input type="file" name="signature" class="form-control dropify" data-height="150" required data-default-file="<?php if($agreement){ echo base_url('uploads/agreement/'.$agreement->signature); }?>" <?php if($agreement){ echo 'disabled';}?> />
											</div>
											<div class="form-group col-sm-12">
											<?php if(!$agreement){?>
												<button type="submit" id="addaction" name="addaction" class="btn btn-primary"><i
												class="icon-lock"></i> Submit</button>
											<?php } ?>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
                    
                    <div class="overlay toggle-menu"></div>
				</div>
			</div>
            <?php include("Footer.php"); ?>
            
		</div>
        
        <?php  include("FooterLinking.php");  ?>
        
        <script>
            $(function() {
                $(".knob").knob();
			});
		</script>
        <script src="<?php base_url("assets_panel/js/index.js"); ?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.6/pdfobject.min.js" integrity="sha512-B+t1szGNm59mEke9jCc5nSYZTsNXIadszIDSLj79fEV87QtNGFNrD6L+kjMSmYGBLzapoiR9Okz3JJNNyS2TSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
// 			PDFObject.embed("https://pdfobject.com/pdf/sample-3pp.pdf", "#pdfRenderer");
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