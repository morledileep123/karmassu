<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <?php include("HeaderLinking.php"); ?>
		<style>
			@media print {
			.print-button {
			display :  none !important;
			}
			}
		</style>
	</head>
    
    <body  style="background-color:white !important;">
        <div id="wrapper">
            <div class="container" style="margin-top:10px;">
				<div class="card">
					<div class="card-body">
						<section class="content-header">
							<h5>
								Invoice
								<small>#00<?php echo $enroll->id;?></small>
							</h5>
						</section>
						<section class="invoice">
							<div class="row mt-3">
								<div class="col-lg-6">
									<img src="<?php echo base_url('uploads/logo.png');?>" style="height:50px;">
								</div>
								<div class="col-lg-6">
									<h5 class="float-sm-right">Date: <?php echo $enroll->date;?></h5>
								</div>
							</div> 
							<div class="row invoice-info"> 
								<div class="col-12 table-responsive">
									<table class="table table-bordered wrap">
										<tr> 
											<td>From
												<address> 
													<strong><?=$this->data->appName;?></strong><br>
													<?=$this->data->appAddress;?><br>
													Phone: +91 <?=$this->data->appMobileNo;?><br>
													Email: <?=$this->data->appEmail;?>
												</address>
											</td>
											<td>To
												<address>
													<strong><?php echo $enroll->firstname.' '.$enroll->lastname;?></strong><br>
													<?php echo $enroll->qualification;?><br>
													Phone: <?php echo $enroll->mobile;?><br>
													Email: <?php echo $enroll->email;?><br>
													Address: <?php echo $user->address;?>
												</address>
											</td>
											<td>
												<b>Invoice #00<?php echo $enroll->id;?></b><br>
												<br>
												<b>Order ID:</b> <?php echo $enroll->orderid;?><br>
												<b>Razorpay Order ID:</b> <?php echo $enroll->rzp_orderid;?><br>
												<b>Razorpay Payment ID:</b> 
												<?php 
													$paymentid=explode(',',$enroll->paymentid);
													if(substr($paymentid[0],0,3)=='pay'){
														echo $paymentid[0].'<br> ('.end($paymentid).') ';
													}
													else{
														echo end($paymentid);
													}
													
												?>
												<br>
												<b>Order Date:</b> <?php echo $enroll->date;?><br>
												<b>Order Status:</b> <?php
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
											</td>
										</tr>
									</table>
								</div>
							</div><br>
							<?php if($item->type=='Paid') { ?>
								<div class="row">
									<div class="col-12 table-responsive">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Image</th>
													<th>Item</th>
													<th>Item Type</th>
													<th>MRP</th>
													<th>Discount</th>
													<th>Price</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><img src="<?php echo $item_image;?>" style="height:70px;"></td>
													<td><?php echo $item->name;?> <br>(<?php echo $itemtype;?>)</td>
													<td><?php if($item->type=='Paid'){ echo '<strong class="text-danger">Paid</strong>'; } else{ echo '<strong class="text-success">Free</strong>'; }?></td>
													<td><i class="fa fa-inr"></i> <?php echo $item->price;?></td>
													<td><?php echo $item->discountpercent;?></td>
													<td><i class="fa fa-inr"></i> <?php echo $item->offerprice;?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<br>
								
								<div class="row">
									<div class="col-12 table-responsive">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th  rowspan="6">Authorized Signature</th>
													<th  rowspan="6">QR CODE</th>
													<th colspan="6">Price Details</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td rowspan="6"><img src="<?php echo base_url('images/seal.png');?>" style="height:100px;"></td>
													<td  rowspan="6">
														<img src="https://chart.googleapis.com/chart?cht=qr&chs=100x100&chl=<?=base_url('Home/Invoice/');?><?php echo $enroll->id;?>">
													</td>
													<td>
														<strong>Subtotal</strong>
													</td>
													<td>
														<i class="fa fa-inr"></i> <?php echo $item->price;?>
													</td>
												</tr>
												<tr>
													<td>
														<strong>Discount</strong>
													</td>
													<td>
														<i class="fa fa-inr"></i> <?php echo ($item->price)-($item->offerprice);?>
													</td>
												</tr>
												
												<tr>
													<td>
														<strong>Price</strong>
													</td>
													<td>
														<i class="fa fa-inr"></i> <?php echo ($item->offerprice);?>
													</td>
												</tr>
												<tr>
													<td>
														<strong>Coupon Code </strong>
													</td>
													<td>
														<?php if($enroll->couponcode){ echo $enroll->couponcode; } else { echo 'No Coupon Applied.'; } ?>
													</td>
												</tr>
												
												<tr>
													<td>
														<strong>Coupon Discount</strong>
													</td>
													<td>
														<i class="fa fa-inr"></i> <?php echo ($item->offerprice)-($enroll->price);?>
													</td>
												</tr>
												<tr>
													<td>
														<strong>Grand Total</strong>
													</td>
													<td>
														<i class="fa fa-inr"></i> <?php echo ($enroll->price);?>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<?php } else { ?>
								<div class="row">
									<div class="col-12 table-responsive">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Image</th>
													<th>Item</th>
													<th>Item Type</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><img src="<?php echo $item_image;?>" style="height:70px;"></td>
													<td><?php echo $item->name;?> <br>(<?php echo $itemtype;?>)</td>
													<td><?php if($item->type=='Paid'){ echo '<strong class="text-danger">Paid</strong>'; } else{ echo '<strong class="text-success">Free</strong>'; }?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-12 table-responsive">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Signature</th>
													<th>QR CODE</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><img src="<?php echo base_url('uploads/logo.png');?>" style="height:100px;"></td>
													<td>
													<img src="https://chart.googleapis.com/chart?cht=qr&chs=100x100&chl=<?=base_url('Home/Invoice/');?><?php echo $enroll->id;?>"></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							<?php } ?>
							<br>
							
						</section>
					</div>
				</div>
				<div class="overlay toggle-menu"></div>
			</div>
		</div>
		<br>
		<center>
			<button  class="btn btn-info print-button print-btn" onclick="generatePrint()"> <i class="fa fa-print"></i> Print</button>
			<button class="btn btn-success no-print print-button pdf-btn" onclick="generatePDF()" type="button"><i class="fa fa-file-pdf"></i> Download PDF</button>
			<button class="btn btn-danger no-print print-button image-btn" onclick="generateImage()" type="button"><i class="fa fa-file-image"></i> Download Image</button>
		</center>
		<br>
        <?php include("FooterLinking.php"); ?>
		<script src="<?php echo base_url("assets/js/html2pdf.bundle.min.js"); ?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js" integrity="sha512-s/XK4vYVXTGeUSv4bRPOuxSDmDlTedEpMEcAQk0t/FMd9V6ft8iXdwSBxV0eD60c6w/tjotSlKu9J2AAW1ckTA==" crossorigin="anonymous"></script>
		<script>
			function generatePDF() {
				const element = document.getElementById("wrapper");
				const opt = { 
					filename:'Karmasu-Invoice.pdf'
				};
				html2pdf()
				.from(element)
				.set(opt)
				.save();
			}	
			function generatePrint() {
				window.print();
			}
			function generateImage() {
				html2canvas($("#wrapper"), {
					onrendered: function(canvas) {
						saveAs(canvas.toDataURL(), 'Karmasu-Invoice.png');
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
