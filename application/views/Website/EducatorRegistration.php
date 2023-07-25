<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include(APPPATH."views/Educator/HeaderLinking.php"); ?>
		<style>
			.card-authentication1 {
			max-width: 50rem;
			}
		</style>
	</head>
	<body>
		<div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner"><div class="loader"></div></div></div></div>
		<div id="wrapper">
			
			<div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
			<div class="card card-authentication1 mx-auto my-5"> 
				<div class="card-body">
					<div class="card-content p-2">   
						<div class="text-center"> 
							<a href="<?=base_url();?>"><img src="<?php echo base_url("image/karmasulogonew.png"); ?>" style="height:100px;" alt="logo icon"></a>
						</div>
						<div class="card-title text-uppercase text-center py-3">Educator Registration</div>
						<form method="post" action="<?php echo base_url("Home/EducatorRegistration"); ?>" class="row">
							
							<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />	
							
							<div class="form-group col-sm-6">
								<label>Name <span class="text-danger">*</span></label>
								<input type="text" name="name" class="form-control" placeholder="Enter Name" required>
								<?php echo form_error("name","<p class='text-danger' >","</p>"); ?>
							</div>
							<div class="form-group col-sm-6">
								<label>Mobile No <span class="text-danger">*</span></label>
								<input type="number" name="mobile" class="form-control" placeholder="Enter Mobile No" required maxlength="10" minlength="10">
								<?php echo form_error("mobile","<p class='text-danger' >","</p>"); ?>
							</div>
							<div class="form-group col-sm-6">
								<label>Email Address <span class="text-danger">*</span></label>
								<input type="email" name="email" class="form-control" placeholder="Enter Email Address" required >
								<?php echo form_error("email","<p class='text-danger' >","</p>"); ?>
							</div>
							<div class="form-group col-sm-6">
								<label>Password <span class="text-danger">*</span></label>
								<input type="text" name="password" class="form-control" placeholder="Enter Password" required minlength="6" maxlength="20">
								<?php echo form_error("password","<p class='text-danger' >","</p>"); ?>
							</div>
							<div class="form-group col-sm-12">
								<label>About <span class="text-danger">*</span></label>
								<textarea  name="about" class="form-control" placeholder="About" required ></textarea>
								<?php echo form_error("about","<p class='text-danger' >","</p>"); ?>
							</div>
							<div class="form-group col-sm-12">
								<button type="submit" name="EducatorRegistration" value="EducatorRegistration" class="btn btn-primary">Submit</button>
							</div>
							
							
						</form>
					</div>
				</div>
				<div class="card-footer text-center py-3">
					<p class="text-dark mb-0">Already have an account? <a href="<?php echo base_url('Home/EducatorLogin');?>"> Login Now </a></p>
				</div>
			</div>
			
			<!--Start Back To Top Button-->
			<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
			<!--End Back To Top Button-->
			
			
			
		</div><!--wrapper-->
		<?php include(APPPATH."views/Educator/FooterLinking.php"); ?>
		<?php
			if($this->session->flashdata("status")=="blocked")
			{
			?>
			
			<script>
				$(document).ready(function() {
					Lobibox.notify('error', {
						pauseDelayOnHover: true,
						size: 'mini',
						rounded: true,
						delayIndicator: false,
						icon: 'fa fa-exclamation-circle',
						continueDelayOnInactiveTab: false,
						position: 'top right',
						msg: 'Your Login ID is Blocked by Karmasu Admin, Please Contact to Admin.'
					});
				})
			</script>
			<?php
			}
			else if($this->session->flashdata("status")=="invalidemailorpassword")
			{
			?>
			<script>
				$(document).ready(function() {
					Lobibox.notify('error', {
						pauseDelayOnHover: true,
						size: 'mini',
						rounded: true,
						delayIndicator: false,
						icon: 'fa fa-exclamation-circle',
						continueDelayOnInactiveTab: false,
						position: 'top right',
						msg: 'Your Email ID or Password is Incorrect.'
					});
				})
			</script>
			<?php
			}
			else if($this->session->flashdata("status")=="error")
			{
			?>
			<script>
				$(document).ready(function() {
					Lobibox.notify('error', {
						pauseDelayOnHover: true,
						size: 'mini',
						rounded: true,
						delayIndicator: false,
						icon: 'fa fa-exclamation-circle',
						continueDelayOnInactiveTab: false,
						position: 'top right',
						msg: 'Something went wrong, Please try again later.'
					});
				})
			</script>
			<?php
			}
		?>
		<?php
			if($this->session->flashdata("response")){
				$output=$this->session->flashdata("response");
				if($output['res']=='success'){
				?>
				
				<script> 
					Lobibox.notify('success', {
						pauseDelayOnHover: true,
						size: 'mini',
						rounded: true,
						delayIndicator: false,
						icon: 'fa fa-exclamation-circle',
						continueDelayOnInactiveTab: false,
						position: 'top right',
						msg: '<?php echo $output['msg'];?>'
					});
				</script> 
				<?php
				}
				else{
				?>
				
				<script> 
					Lobibox.notify('error', {
						pauseDelayOnHover: true,
						size: 'mini',
						rounded: true,
						delayIndicator: false,
						icon: 'fa fa-exclamation-circle',
						continueDelayOnInactiveTab: false,
						position: 'top right',
						msg: '<?php echo $output['msg'];?>'
					});
				</script> 
				<?php
				}
			}
		?>
		
	</body>
</html>
