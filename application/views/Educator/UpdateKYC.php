<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
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
                    <div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">Update KYC - 
									<?php 
										if($kycCount)
										{
											if($kycData->status=='Pending'){
												$readonly=true;	
												echo '<p class="text-danger">KYC Pending.</p>';
											}
											else if($kycData->status=='Rejected'){
												$readonly=false;	
												echo '<p class="text-danger">KYC Rejected.</p>';
											}
											else if($kycData->status=='Approved'){
												$readonly=true;	
												echo '<p class="text-success">KYC Approved.</p>';
											}
										}
										else{
											$readonly=false;	
										}
									?>	
								</div>
								<div class="card-body">
									<form action="<?php echo base_url("Educator/UpdateKYC/Update"); ?>" method="post" enctype="multipart/form-data" id="updateform">
										
										<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
										<input type="hidden" name="userid" value="<?php echo $this->AuthorData->id;?>" />
										<div class="row">
											<div class="form-group col-sm-3">
												<label class="col-form-label">Bank Name <span class="text-danger">*</span></label>
												<input type="text" class="form-control" name="bank" placeholder="Enter Bank Name"
												required value="<?php if($kycCount){ echo  $kycData->bank; } ?>" <?php if($readonly==true){ echo 'disabled';} ?>>
												<?php echo form_error("bank", "<p class='text-danger' >", "</p>"); ?>
											</div>
											<div class="form-group col-sm-3">
												<label class="col-form-label">Branch Name <span class="text-danger">*</span></label>
												<input type="text" class="form-control" name="branch" placeholder="Enter Branch Name"
												required value="<?php if($kycCount){ echo  $kycData->branch; } ?>" <?php if($readonly==true){ echo 'disabled';} ?>>
												<?php echo form_error("branch", "<p class='text-danger' >", "</p>"); ?>
											</div> 
											<div class="form-group col-sm-3">
												<label class="col-form-label">IFSC Code <span class="text-danger">*</span></label>
												<input type="text" class="form-control text-uppercase" name="ifsc" placeholder="Enter IFSC Code"
												required value="<?php if($kycCount){ echo  $kycData->bank; } ?>" <?php if($readonly==true){ echo 'disabled';} ?>>
												<?php echo form_error("ifsc", "<p class='text-danger' >", "</p>"); ?>
											</div>
											<div class="form-group col-sm-3">
												<label class="col-form-label">Account No <span class="text-danger">*</span></label>
												<input type="number" class="form-control" name="account_no" placeholder="Enter Account No"
												required value="<?php if($kycCount){ echo  $kycData->account_no; } ?>" <?php if($readonly==true){ echo 'disabled';} ?>>
												<?php echo form_error("account_no", "<p class='text-danger' >", "</p>"); ?>
											</div>
											<div class="form-group col-sm-3">
												<label class="col-form-label">Account Holder Name <span class="text-danger">*</span></label>
												<input type="text" class="form-control" name="name" placeholder="Enter Account Holder Name"
												required value="<?php if($kycCount){ echo  $kycData->name; } ?>" <?php if($readonly==true){ echo 'disabled';} ?>>
												<?php echo form_error("name", "<p class='text-danger' >", "</p>"); ?>
											</div>
											<div class="form-group col-sm-3">
												<label class="col-form-label">Account Holder Mobile No <span class="text-danger">*</span></label>
												<input type="number" class="form-control" name="mobile" placeholder="Enter Account Holder Mobile No"
												required maxlength="10" minlength="10" value="<?php if($kycCount){ echo  $kycData->mobile; } ?>" <?php if($readonly==true){ echo 'disabled';} ?>>
												<?php echo form_error("mobile", "<p class='text-danger' >", "</p>"); ?>
											</div>
											<div class="form-group col-sm-3">
												<label class="col-form-label">UPI ID <span class="text-danger"></span></label>
												<input type="text" class="form-control" name="upi" placeholder="Enter UPI ID"
												  value="<?php if($kycCount){ echo  $kycData->upi; } ?>" <?php if($readonly==true){ echo 'disabled';} ?>>
												<?php echo form_error("upi", "<p class='text-danger' >", "</p>"); ?>
											</div>
											<div class="form-group col-sm-3">
												<label class="col-form-label">Document Type <span class="text-danger">*</span></label>
												<select  class="form-control" name="document_type"  required <?php if($readonly==true){ echo 'disabled';} ?>>
													<option selected disabled>Select</option>
													<option value="Aadhar Card" <?php if($kycCount){ if($kycData->document_type=='Aadhar Card'){ echo 'selected'; } } ?>>Aadhar Card</option>
													<option value="Pan Card" <?php if($kycCount){ if($kycData->document_type=='Pan Card'){ echo 'selected'; } } ?>>Pan Card</option>
													<option value="Cancelled Cheque" <?php if($kycCount){ if($kycData->document_type=='Cancelled Cheque'){ echo 'selected'; } } ?>>Cancelled Cheque</option>
												</select>
												<?php echo form_error("document_type", "<p class='text-danger' >", "</p>"); ?>
											</div>
											<div class="form-group col-sm-3">
												<label class="col-form-label">Document No <span class="text-danger">*</span></label>
												<input type="text" class="form-control" name="document_no" placeholder="Enter Document No" required value="<?php if($kycCount){ echo  $kycData->document_no; } ?>" <?php if($readonly==true){ echo 'disabled';} ?>>
												<?php echo form_error("document_no", "<p class='text-danger' >", "</p>"); ?>
											</div>
											<div class="form-group col-sm-4">
												<label class="col-form-label">Document Proof <span class="text-danger">* {jpg,png,jpeg}</span></label>
												<input type="file" class="form-control dropify" name="document_proof" required  accept="image/jpg, image/png, image/jpeg, image/gif" data-height="100" <?php if($kycCount){ echo 'data-default-file="'.base_url('uploads/kyc/'.$kycData->document_proof).'"'; } ?> <?php if($readonly==true){ echo 'disabled';} ?>>
												<?php echo form_error("document_proof", "<p class='text-danger' >", "</p>"); ?>
											</div>
											<div class="form-group col-sm-12">
												<?php if($readonly==false){?>
													<button type="submit" id="updateaction" name="updateaction" class="btn btn-primary"><i
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