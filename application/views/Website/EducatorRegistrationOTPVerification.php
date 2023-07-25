<!DOCTYPE html>
<html lang="en">  
	<head> 
		<?php include(APPPATH."views/Educator/HeaderLinking.php"); ?>
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
						<div class="card-title text-uppercase text-center py-3">Educator OTP Verification</div>
						<form method="post" action="<?php echo base_url("Home/EducatorRegistration"); ?>">
							
							<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />	 
							
							<div class="form-group">
								<label for="otp" class="sr-only">OTP</label>
								<div class="position-relative has-icon-right">
									<input type="text" name="otp" autofocus="true" required autocomplete="off"  id="otp" class="form-control input-shadow" data-parsley-type="number" data-parsley-minlength="4" data-parsley-maxlength="4" data-parsley-required-message="Enter OTP" data-parsley-type-message="Enter valid OTP" data-parsley-maxlength-message="Enter valid OTP" data-parsley-minlength-message="Enter valid OTP" placeholder="Enter OTP">
									<?php echo form_error("otp","<p class='text-danger' >","</p>"); ?>
									<div class="form-control-position">
										<i class="icon-user"></i>
									</div>
								</div>
							</div>
							<div class="form-group">
								<h6>OTP Sent On Your Registered Mobile No.</h6>
								<span class="resend-otp"><a class="text-success"><span id="resend-otp"></span> </a></span>
							</div>
							<button type="submit" name="OTPVerification" value="OTPVerification" class="btn btn-primary btn-block">Verify</button>
							
							
						</form>
					</div>
				</div>
				<div class="card-footer text-center py-3">
					<p class="text-dark mb-0">Back To Login ? <a href="<?php echo base_url('EducatorLogin');?>"> Click Here </a></p>
				</div>
			</div>
			
			<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
			
		</div>
		<?php include(APPPATH."views/Educator/FooterLinking.php"); ?>
		
		<script>
			function startTimer(duration, display) {
				var start = Date.now(),
				diff,
				minutes,
				seconds;
				function timer() 
				{
					diff = duration - (((Date.now() - start) / 1000) | 0);
					minutes = (diff / 60) | 0;
					seconds = (diff % 60) | 0;
					minutes = minutes < 10 ? "0" + minutes : minutes;
					seconds = seconds < 10 ? "0" + seconds : seconds;
					
					if (diff == 0) {
						$('.resend-otp').html('<a href="javascript:void(0);" onclick="ResendOTP()" class="text-success">Resend OTP</a>'); 
						
					}
					else{
						display.textContent = minutes + ":" + seconds; 
					}
				};
				timer();
				setInterval(timer, 1000);
			}
			
			window.onload = function () {
				var fiveMinutes = 30,
				display = document.querySelector('#resend-otp');
				startTimer(fiveMinutes, display);
			};
			
			function ResendOTP(){
				window.location.reload();
			}
		</script>
		
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
