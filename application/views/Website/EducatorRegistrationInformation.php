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
						<br>
						<p class="text-success">
							You are successfully registered.
						</p>
						<p class="text-danger">
							Fill out the form given below. You will be contacted soon after the form is filled.
						</p>
						<p class="text-success">
							<a href="https://docs.google.com/forms/d/e/1FAIpQLSd2Y1cahDMrZsD2mkMZvN_Ggp0xgw5IFgaUGvNo3OYV2APfvw/viewform?usp=sf_link">Click Here To Open Form</a>
						</p>
					</div>
				</div>
				<div class="card-footer text-center py-3">
					<p class="text-dark mb-0">Back To Login? <a href="<?php echo base_url('Home/EducatorLogin');?>"> Login Now </a></p>
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
