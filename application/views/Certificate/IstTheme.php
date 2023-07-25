<!DOCTYPE html>
<html>
	<head>
		<title>Certificate</title>
		<link rel="icon" type="image/x-icon" href="<?=base_url('uploads/logo.png');?>" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
		
		<style type="text/css">
			@import url('https://fonts.googleapis.com/css?family=Saira+Condensed:700');
			span
			{
			font-family: 'Roboto', sans-serif;
			}
			p
			{
			font-family: 'Roboto', sans-serif;
			}
			hr {
			background-color: #be2d24;
			height: 3px;
			margin: 5px;
			}
			
			div#cert-footer {
			position: absolute;
			width: 60%;
			/*top: 50px;*/
			text-align: center;
			}
			
			#cert-stamp, #cert-ceo-sign {
			width: 60%;
			display: inline-block;
			}
			
			div#cert-issued-by, div#cert-ceo-design {
			width: 25%;
			display: inline-block;
			float: center;
			}
			
			div#cert-ceo-design {
			margin-left: 10%;
			}
			
			h1 {
			font-family: 'Saira Condensed', sans-serif;
			margin: 5px 0px;
			}
			
			body {
			width: 730px;
			/*height: 690px;*/
			position: absolute;
			left: 30px;
			top: 30px;
			border: 3px solid red;
			}
			
			p {
			font-family: 'Arial', sans-serif;
			font-size: 19px;
			/*margin: 5px 0px;*/
			}
			
			html {
			display: inline-block;
			width: 793px;
			height: 835px;
			border: 2px solid red;
			background: #eee url("<?=base_url();?>images/CertificateBackground.jpg") no-repeat; background-size: 100% 100%;
			}
			
			h1#cert-holder {
			font-size: 50px;
			}
			
			p.smaller {
			font-size: 19px !important;
			}
			
			div#cert-desc {
			width: 70%;
			}
			
			p#cert-from {
			color: #be2d24;
			font-family: 'Saira Condensed', sans-serif;
			}
			
			div#cert-verify {
			opacity: 1;
			position: absolute;
			top: 680px;
			left: 60%;
			font-size: 12px;
			color: grey;
			}
			.fa {
			border-radius:50%;
			padding: 8px;
			font-size: 14px;
			width: 28px;
			text-decoration: none;
			}
			.icon {
			background: #be2d24;
			color: white;
			}
			
			@media print {
			.print-button {
			display :  none !important;
			}
			}
			.watermark {
			opacity: 0.1;
			color: BLACK;
			position: absolute;
			left: 20%;
			top: 7%;
			}
			.watermark img{
			height:500px;
			}
			
			
			.print-btn {
			position: fixed;
			top: 2%;
			right:2%;
			}
			.pdf-btn {
			position: fixed;
			top: 10%;
			right:2%;
			}
			.image-btn {
			position: fixed;
			top: 18%;
			right:2%;
			}
			
		</style>
	</head>
	<body>
		<button  class="btn btn-info print-button print-btn" onclick="generatePrint()"> <i class="fa fa-print"></i> Print</button>
		<button class="btn btn-success no-print print-button pdf-btn" onclick="generatePDF()" type="button"><i class="fa fa-file-pdf"></i> Download PDF</button>
		<button class="btn btn-danger no-print print-button image-btn" onclick="generateImage()" type="button"><i class="fa fa-file-image"></i> Download Image</button>
		<div class="container-fluid">
			<div class="watermark">
				<img src="<?=base_url('uploads/logo.png');?>"/>
			</div>
			<div class="row p-2">
				<div class="col-sm-4">
					<img src="<?=base_url();?>images/iso-9001.jpg" style="height: 100px;">
					<img src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=<?=base_url();?>Home/Certificate/<?php echo $refno; ?>" style="height: 100px;">
					
					
				</div>
				<div class="col-sm-4 text-center">
					<h1 id='cert-holder'>
						<span style="color:#be2d24"><b>C</b></span>ertificate
					</h1>
					<p>of completion</p>
				</div>
				<div class="col-sm-4 text-right">
					<img src="<?=base_url('uploads/logo.png');?>" style="height: 100px;">
				</div>
			</div>
			<div class="row">
				<!-- <div class="col-sm-1"></div> -->
				<div class="col-sm-12 text-center">
					<p class="smaller text-uppercase" id="cert-declaration">
						<b> This certificate is presented to</b>
					</p>
					<p>Mr/Ms/Mrs &ensp;<strong style="border-bottom:3px dotted;"><?php echo $name;?></strong> &ensp;</p>
					<?php if($certificateList[0]->itemtype=='Course') { ?>
					<p>To certify that he/she has successfully completed </p>
					<p>online course at Karmasu</p>
					<p>on &nbsp;<strong style="border-bottom:3px dotted;"><?php echo $technology;?></strong> &nbsp; with grade &nbsp;<strong style="border-bottom:3px dotted;"><?php echo $grade;?></strong> &nbsp; </p>
					<p>duration &nbsp;<strong style="border-bottom:3px dotted;"><?php echo $duration;?></strong> &nbsp; from &nbsp;<strong style="border-bottom:3px dotted;"><?php echo $from;?></strong> &nbsp; to &nbsp;<strong style="border-bottom:3px dotted;"><?php echo $to;?></strong> &nbsp;.</p>
					<?php } else{  ?>
					<p>To certify that he/she has successfully attended </p>
					<p>live session at Karmasu</p>
					<p>on &nbsp;<strong style="border-bottom:3px dotted;"><?php echo $technology;?></strong> &nbsp; by author &nbsp;<strong style="border-bottom:3px dotted;"><?php echo $author->name;?></strong> &nbsp; </p>
					<p>duration &nbsp;<strong style="border-bottom:3px dotted;"><?php echo $duration;?></strong> &nbsp; from &nbsp;<strong style="border-bottom:3px dotted;"><?php echo $from;?></strong> &nbsp; to &nbsp;<strong style="border-bottom:3px dotted;"><?php echo $to;?></strong> &nbsp;.</p>
					<?php } ?>
					<br/>
					<span class="smaller" id='cert-from'>
						<b>Ref. No. : </b> <?php echo $refno;?>
					</span><br/>
					<span class="smaller" id='cert-from'>
						<b>Issued on : </b> <?php echo $issuedon;?>
					</span>
					
					<br/>
					<div id="cert-footer text-center">
						<div id="cert-issued-by">
							<img src="<?=base_url('uploads/logo.png');?>" style="height: 100px;">
							<hr>
							<p class="text-uppercase">Training Head</p>
						</div>
						<div id="cert-ceo-design">
							<img src="<?=base_url('uploads/logo.png');?>" style="height: 100px;">
							<hr>
							<p class="text-uppercase">Director</p>
						</div>
					</div>
				</div>
			</div><br/>
			<!-----------footer------------->
			
			<div class="row bg-dark text-white">
				<div class="col-sm-4 p-2">
					<span><i class="fa fa-mobile icon"></i> 0000000000</span><br/>
					<span><i class="fa fa-envelope icon mt-2"></i> info@karmasu.com</span>
				</div>
				<div class="col-sm-4 p-2">
					<span><i class="fa fa-globe icon"></i> www.digicoders.in</span>	<br/>
					<span><i class="fa fa-globe icon mt-2"></i>www.karmasu.Karmasu.in</span>
				</div>
				<div class="col-sm-4 p-2">
					<span><i class="fa fa-map-marker icon"></i> 22-23, Behind State Bank of India Babuganj Branch, Near IT Chauraha, Lucknow, UP, India, 226007</span>
					
				</div>
			</div>
			<!-------------//footer------------->
		</div>
		
		<script src="<?php echo base_url("assets/js/html2pdf.bundle.min.js"); ?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js" integrity="sha512-s/XK4vYVXTGeUSv4bRPOuxSDmDlTedEpMEcAQk0t/FMd9V6ft8iXdwSBxV0eD60c6w/tjotSlKu9J2AAW1ckTA==" crossorigin="anonymous"></script>
		<script>
			function generatePDF() {
			const element = document.getElementsByTagName("HTML")[0];
			const opt = { 
			filename:'Karmasu-Certificate.pdf'
			};
			html2pdf()
			.from(element)
			.set(opt)
			.save();
			}	
			function generatePrint() {
			$("html").css("width","100%");
			window.print();
			$("html").css("width","793px");
			}
			function generateImage() {
			html2canvas($("html"), {
			onrendered: function(canvas) {
			saveAs(canvas.toDataURL(), 'Karmasu-Certificate.png');
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

