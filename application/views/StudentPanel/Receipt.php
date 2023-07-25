<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    <head> 
        <title>Karmasu | Student | Receipt</title>
        <?php include("HeaderLinking.php"); ?>
		<style>
			.border-none{
			border:none !important;
			}
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
					<div class="row" id="Invoice-Print">
						<div class="col-sm-12" id="ele2">
							<div class="card">
								<div class="card-header"><h5>Order Details</h5> </div>
								<ul class="list-group list-group-flush">
									<li class="list-group-item">
										<div class="media align-items-center">
											<img src="<?php if($itemtype=='Course'){ echo base_url('uploads/course/'.$item->banner); } else{ echo base_url('uploads/ebook/'.$item->banner); }?>" title="banner" alt="banner" class="img-fluid" style="height:150px;">
											<div class="media-body ml-3 ">
												<h5 class="mb-0"><?php echo $item->name;?> (<?php echo $itemtype;?>) </h5><br>
												<p>Amount : <strong><i class="fa fa-inr"></i> <?php echo $enroll->price;?></strong></p>
												<p>Date : <strong><?php echo $enroll->date;?> <?php echo $enroll->time;?></strong></p>
												<p>Status : 
													<?php
														if($enroll->paymentstatus=='success'){
															echo '<strong class="text-success">Success</strong>';
														}
														else if($enroll->paymentstatus=='Pending'){
															echo '<strong class="text-warning">Pending</strong>';
														}
														else if($enroll->paymentstatus=='failed'){
															echo '<strong class="text-danger">Failed</strong>';
														}
													?>
													
												</p>
											</div>
										</div>
										
									</li>
								</ul>
							</div>
							
							<div class="card" >
								<div class="card-header"><h5>Payment Details</h5> </div>
								<ul class="list-group list-group-flush">
									<li class="list-group-item">
										<div class="media align-items-center">
											<div class="media-body ml-3 table-responsive">
												<table class="table table-borderless">
													<tr>
														<th class="border-none">Coupon Code </th>
														<td class="border-none"> <?php if(empty($enroll->couponcode)){ echo 'Not Applied'; } else{ echo $enroll->couponcode; } ?></td>
													</tr>
													
													<tr>
														<th class="border-none">Order ID </th>
														<td class="border-none"> <?php echo $enroll->rzp_orderid;?></td>
													</tr>
													<tr>
														<th class="border-none">Payment ID </th>
														<td class="border-none">
															<?php 
																$paymentid=explode(',',$enroll->paymentid);
																if(substr($paymentid[0],0,3)=='pay'){
																	echo $paymentid[0].'<br> ('.end($paymentid).') ';
																}
																else{
																	echo end($paymentid);
																}
																
															?>	
														</td>
													</tr>
													
													<tr>
														<th class="border-none">Payment Status </th>
														<td class="border-none"> 
															<?php
																if($enroll->paymentstatus=='success'){
																	echo '<strong class="text-success">Success</strong>';
																}
																else if($enroll->paymentstatus=='Pending'){
																	echo '<strong class="text-warning">Pending</strong>';
																}
																else if($enroll->paymentstatus=='failed'){
																	echo '<strong class="text-danger">Failed</strong>';
																}
															?></td>
													</tr>
												</table>
											</div>
										</div>
									</li>
								</ul>
							</div>
							<div class="card" >
								<div class="card-header"><h5>Student Details</h5> </div>
								<ul class="list-group list-group-flush">
									<li class="list-group-item">
										<div class="media align-items-center">
											<div class="media-body ml-3 table-responsive">
												<table class="table table-borderless">
													<tr>
														<th class="border-none">Name </th>
														<td class="border-none"> <?php echo $enroll->firstname.' '. $enroll->lastname;?></td>
													</tr>
													<tr>
														<th class="border-none">Mobile No </th>
														<td class="border-none"> <?php echo $enroll->mobile;?></td>
													</tr>
													<tr>
														<th class="border-none">Email </th>
														<td class="border-none"><?php echo $enroll->email;?></td>
													</tr>
													<tr>
														<th class="border-none">Qualification </th>
														<td class="border-none"><?php echo $enroll->qualification;?></td>
													</tr>
												</table>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<br>
					<center>
						
						<a class="btn btn-dark " href="<?php echo base_url('Home/Invoice/'.$enroll->id);?>" target="_blank">  Invoice <i class="fa fa-angle-double-right"></i></a>
						<button  class="btn btn-info print-button print-btn" onclick="generatePrint()"> <i class="fa fa-print"></i> Print</button>
						<button class="btn btn-success no-print print-button pdf-btn" onclick="generatePDF()" type="button"><i class="fa fa-file-pdf"></i> Download PDF</button>
						<button class="btn btn-danger no-print print-button image-btn" onclick="generateImage()" type="button"><i class="fa fa-file-image"></i> Download Image</button>
					</center>
					<div class="overlay toggle-menu"></div>
					
				</div>
				
			</div>
			
			
		</div>
		
		<?php  include("FooterLinking.php");  ?>
		
		<script>
			$(function() {
				$(".knob").knob();
			});
		</script>
		<script src="<?php base_url("assets_panel/js/index.js"); ?>"></script>
		<script src="<?php echo base_url("assets/js/jQuery.print.js"); ?>"></script>
		
		<script src="<?php echo base_url("assets/js/html2pdf.bundle.min.js"); ?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js" integrity="sha512-s/XK4vYVXTGeUSv4bRPOuxSDmDlTedEpMEcAQk0t/FMd9V6ft8iXdwSBxV0eD60c6w/tjotSlKu9J2AAW1ckTA==" crossorigin="anonymous"></script>
		<script>
			function generatePDF() {
				const element = document.getElementById("Invoice-Print");
				const opt = { 
					filename:'CodersAdda-Receipt.pdf'
				};
				html2pdf()
				.from(element)
				.set(opt)
				.save();
			}	
			function generatePrint() {
				$.print("#ele2");
			}
			function generateImage() {
				html2canvas($("#Invoice-Print"), {
					onrendered: function(canvas) {
						saveAs(canvas.toDataURL(), 'CodersAdda-Receipt.png');
					}
				});
			}
			
			
			function saveAs(uri, filename) {
				var link = document.createElement('a');
				if (typeof link.download === 'string') {
					link.href = uri;
					link.download = filename;
					document.body.appendChild(link);
					link.click();
					document.body.removeChild(link);
					} else {
					window.open(uri);
				}
			}
		</script>
		
	</body>
	
	
</html>