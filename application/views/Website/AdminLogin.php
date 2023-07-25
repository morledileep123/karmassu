<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include(APPPATH."views/AdminPanel/HeaderLinking.php"); ?>
	</head>
	
	<body>
		
		<!-- start loader -->
		<div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner"><div class="loader"></div></div></div></div>
		<!-- end loader -->
		
		<!-- Start wrapper-->
		<div id="wrapper">
			
			<div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
			<div class="card card-authentication1 mx-auto my-5"> 
				<div class="card-body">
					<div class="card-content p-2">   
						<div class="text-center"> 
							<img src="<?php echo base_url("image/karmasulogonew.png"); ?>" style="height:100px;" alt="logo icon">
						</div>
						<div class="card-title text-uppercase text-center py-3">Admin Login</div>
						<form method="post" action="<?php echo base_url("Home/ControlPanelLogin"); ?>">
							
							<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />	
							
							<div class="form-group">
								<label for="exampleInputUsername" class="sr-only">Registered Email</label>
								<div class="position-relative has-icon-right">
									<input type="text" name="username" autofocus="true" required autocomplete="off"  id="exampleInputUsername" class="form-control input-shadow" placeholder="Enter Username">
									<?php echo form_error("username","<p class='text-danger' >","</p>"); ?>
									<div class="form-control-position">
										<i class="icon-user"></i>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword" class="sr-only">Password</label>
								<div class="position-relative has-icon-right">
									<input type="password" name="password" required  id="exampleInputPassword" class="form-control input-shadow" placeholder="Enter Password">
									<?php echo form_error("password","<p class='text-danger' >","</p>"); ?>
									<div class="form-control-position">
										<i class="icon-lock"></i>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-6">
									<div class="icheck-material-primary">
										<input type="checkbox" id="user-checkbox" checked="">
										<label for="user-checkbox">Remember me</label>
									</div>
								</div>
								
							</div>
							<button type="submit" name="adminlogin" value="adminlogin" class="btn btn-primary btn-block">Login</button>
							
							
						</form>
					</div>
				</div>
				<div class="card-footer text-center py-3">
					<p class="text-dark mb-0">Back To Home ? <a href="<?php echo base_url();?>"> Click Here </a></p>
				</div>
			</div>
			
			<!--Start Back To Top Button-->
			<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
			<!--End Back To Top Button-->
			
			
			
		</div><!--wrapper-->
		<?php include(APPPATH."views/AdminPanel/FooterLinking.php"); ?>
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
		
		
		
	</body>
</html>
