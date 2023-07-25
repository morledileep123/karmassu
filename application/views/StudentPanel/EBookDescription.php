<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en"> 
    <head> 
        <title>Karmasu | Student | E-Book Description</title>
        <?php include("HeaderLinking.php"); ?>
		<style>
			.rating{
			display: flex;
			color: #9e9e9e;
			font-size: 25px;
			}
			.rating [type=radio]{
			display: none;
			}
			.rating label{
			margin:0 5px;
			}
			.rating label:hover{
			color: orange;
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
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <img src="../../../uploads/ebook/<?php echo $list[0]->banner; ?>" class="img-fluid" title="ebook-img" alt="ebook-img"  style="max-height:200px;"/>
                                            
										</div>
                                        <div class="col-sm-12 p-2">
                                            <img src="../../../uploads/ebook/<?php echo $list[0]->logo; ?>" class="img-fluid mr-3 img-thumbnail" style="width:80px;" />
                                            <h5 style="display:inline-block;" class="mt-3"> <?php echo $list[0]->name; ?> </h5>
										</div>
                                        <div class="col-sm-12">
											<?php
												if($enrollcount){
												?>
												
												<?php
												}
												else{
												?>
												<p><strong><i class="fa fa-money text-primary"></i> 
													<?php
														if ($list[0]->type == "Paid") {
														?>
														<span class="p-2 text-danger">Paid</span>
														<?php
															if (empty($list[0]->offerprice)) {
															?>
															<i class="fa fa-rupee"></i> <?php echo $list[0]->price; ?>
															<?php
																} else {
															?>
															<s><i class="fa fa-rupee"></i> <?php echo $list[0]->price; ?></s>
															<i class="fa fa-rupee"></i> <?php echo $list[0]->offerprice; ?>
															<button class="btn btn-sm p-1 btn-primary"><?php echo str_replace('Off','',$list[0]->discountpercent); ?>OFF</button>
															<?php
															}
															} else {
														?>
														<span class="p-2 text-success">Free</span>
														<?php
														}
													?>
												</strong></p>
											<?php }?>
										</div>
                                        
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-user-circle text-primary"></i> <?php echo $author[0]->name; ?> </strong></p>
										</div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-list-alt text-primary"></i> <?php echo $category[0]->title; ?> </strong></p>
										</div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-clock-o text-primary"></i> <?php echo $list[0]->daystofinish; ?> Days To Finish</strong></p>
										</div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-book text-primary"></i> <?php echo $list[0]->noofpages; ?> Pages </strong></p>
										</div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-universal-access text-primary"></i> Full Lifetime Access</strong></p>
										</div>
										
                                        <div class="col-sm-12">
											<p>
												<?php for($i=0;$i<5;$i++){ ?>
													<i class="<?php if($rating >= $i){ echo 'fas fa-star text-warning'; } else{ echo 'far fa-star text-warning'; } ?>"  aria-hidden="true" ></i>
												<?php } ?>
												(<?php echo $ratingcount;?>)
											</p>
											<?php
												if($enrollcount){
												?>
												<!--
												<a href="" class="btn btn-dark p-2"><i class="fa fa-certificate"></i> Generate Certificate</a>-->
												<?php
												}
												else{
												?>
												<a href="<?php echo base_url('Student/Checkout/Ebook/'.$list[0]->id);?>" class="btn btn-danger p-2"><i class="fa fa-registered"></i> Enroll Now</a>
												<?php	
												}
											?>
										</div>
                                        
                                        
									</div>
								</div> 
                                
							</div>
						</div>
						
						<div class="col-sm-8">
							<?php if($enrollcount){ ?>
								<div class="card">
									<div class="card-header"><h5>E-Book </h5> </div>
									<ul class="list-group list-group-flush">
										<li class="list-group-item">
											<div class="media align-items-center">
												<iframe class="ebook-size" src="https://docs.google.com/viewerng/viewer?url=<?php echo base_url("uploads/ebook/".$list[0]->ebook);?>&hl=bn&embedded=true"></iframe>
											</div>
										</li>
									</ul>
								</div>
								<?php } else { ?>
								<div class="card">
									<div class="card-header"><h5>Sample E-Book Pages</h5> </div>
									<ul class="list-group list-group-flush">
										<li class="list-group-item">
											<div class="media align-items-center">
												<iframe class="ebook-size" src="https://docs.google.com/viewerng/viewer?url=<?php echo base_url("uploads/ebook/".$list[0]->sample);?>&hl=bn&embedded=true"></iframe>
											</div>
										</li>
									</ul>
								</div>
							<?php } ?>
							
							
							
							
						</div>
						
					</div>  
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header"><h5>What does this  Ebook include?</h5> </div>
								<ul class="list-group list-group-flush">
									<li class="list-group-item">
										<div class="media align-items-center">
											<p><?php echo $list[0]->ebook_include; ?></p>
										</div>
									</li>
								</ul>
							</div>
							<div class="card">
								<div class="card-header"><h5>What will you learn?</h5> </div>
								<ul class="list-group list-group-flush">
									<li class="list-group-item">
										<div class="media align-items-center">
											<p><?php echo $list[0]->will_learn; ?></p>
										</div>
									</li>
								</ul>
							</div>
							<div class="card">
								<div class="card-header"><h5> Ebook Description</h5> </div>
								<ul class="list-group list-group-flush">
									<li class="list-group-item">
										<div class="media align-items-center">
											<p><?php echo $list[0]->description; ?></p>
										</div>
									</li>
								</ul>
							</div>
							<div class="card">
								<div class="card-header"><h5>Author</h5> </div>
								<ul class="list-group list-group-flush">
									<?php if(count($author)) : ?>
									<?php foreach($author as $item) : ?>
									<li class="list-group-item">
										<div class="media align-items-center">
											<img src="<?php if(empty($item->photo)){ echo base_url("image/LogoCodersAdda1.png"); } else{ echo base_url("uploads/tutor/".$item->photo); } ?>" title="rounded-img" alt="rounded-img" class="customer-img rounded-circle" >
											<div class="media-body ml-3">
												<h6 class="mb-0"><?php echo $item->name;?> </h6>
												<p><?php echo strip_tags($item->designation);?></p>
												<p><?php echo $item->about;?></p>
												<a class="btn btn-info" target="_blank" href="<?php echo $item->social_link;?>"><i class="fa fa-share-square"></i> Follow on Linkedin</a>
											</div>
										</div>
									</li>
									<?php endforeach; ?>
									<?php endif; ?>
								</ul>
							</div>
							<div class="card">
								<div class="card-header">Review 
									<div class="card-action">
										<?php if($enrollcount){ ?>
											<button data-toggle="modal" aria-label="read more about review" data-target="#AddModal" class="btn btn-primary"> <i class="fa fa-check-circle"></i> Give Review </button>
										<?php }?>
									</div>	
								</div>
								<ul class="list-group list-group-flush">
									<?php if(count($review)) : ?>
									<?php foreach($review as $item) : ?>
									<li class="list-group-item">
										<div class="media align-items-center">
											<img src="<?php if(empty($item['profile_photo'])){ echo base_url("image/LogoCodersAdda1.png"); } else{ echo base_url("uploads/profile_photo/".$item['profile_photo']); } ?>" title="customer-img" alt="customer-img"  class="customer-img rounded-circle" >
											<div class="media-body ml-3">
												<h6 class="mb-0"><?php echo $item['name'];?> </h6>
												<p><?php echo $item['review'];?></p>
												<p>Date: <?php echo $item['date'];?> <?php echo $item['time'];?></p>
											</div>
											<p>
											<?php for($i=0;$i<5;$i++){?>
												<i class="<?php if($item['rating'] >= $i){ echo 'fas fa-star text-warning'; } else{ echo 'far fa-star text-warning'; } ?>"" aria-hidden="true"></i>
											<?php }?>
										</p>
										</div>
									</li>
									<?php endforeach; ?>
									<?php endif; ?>
									<?php if(!count($review)) : ?>
									<li class="list-group-item">
										<div class="media align-items-center">
											<div class="media-body ml-3">
												No Review Found.
											</div>
										</div>
									</li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
					</div>
					<div class="modal fade" id="AddModal">
						<div class="modal-dialog">
							<div class="modal-content border-primary">
								<div class="modal-header bg-primary">
									<h5 class="modal-title text-white">Give Review</h5>
									<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<form action="#" method="post"
								enctype="multipart/form-data" id="registerForm">
									<div class="modal-body">
										
										
										<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
										value="<?= $this->security->get_csrf_hash(); ?>" />
										
										<input type="hidden" name="userid" value="<?php echo $this->userid;?>"/>
										<input type="hidden" name="itemid" value="<?php echo $list[0]->id;?>"/>
										<input type="hidden" name="itemtype" value="<?php echo 'Ebook';?>"/>
										<div class="form-group rating ">
											<input type="radio" id="rating1" name="rating" value="1">
											<label id="1" title="Poor" class="fa fa-star" for="rating1"></label>
											
											<input type="radio" id="rating2" name="rating" value="2">
											<label id="2" title="Average" class="fa fa-star" for="rating2"></label>
											
											
											<input type="radio" id="rating3" name="rating" value="3">
											<label id="3" title="Average" class="fa fa-star" for="rating3"></label>
											
											
											<input type="radio" id="rating4" name="rating" value="4">
											<label id="4" title="Good" class="fa fa-star" for="rating4"></label>
											
											
											<input type="radio" id="rating5" name="rating" value="5">
											<label id="5" title="Awesome" class="fa fa-star" for="rating5"></label>
										</div>
										<div class="form-group">
											<label class="col-form-label">Review <span class="text-danger">*</span></label>
											<textarea class="form-control" name="review" placeholder="Review"
											required></textarea>
											<?php echo form_error("review", "<p class='text-danger' >", "</p>"); ?>
										</div>
									</div>
									<div class="modal-footer d-block">
										<button type="submit" id="registerBtn"  class="btn btn-dark"><i
										class="icon-lock"></i> Submit <i class="fa fa-spinner fa-spin" id="registerSpin" style="display:none;"></i></button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="overlay toggle-menu"></div>
				</div>
			</div>
			<?php include("Footer.php"); ?>
		</div>
		<?php include("FooterLinking.php"); ?>
		<script>
			$("#registerForm").on('submit', function(e) {
				e.preventDefault();
				var data = new FormData(this);
				$.ajax({
					type: 'POST',
					url: "<?php echo base_url('Student/Review/Add')?>",
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function() {
						$("#registerBtn").attr("disabled", true);
						$('#registerSpin').show();
					},
					success: function(response) {
						console.log(response);
						var response = JSON.parse(response);
						$("#registerBtn").removeAttr("disabled");
						$('#registerSpin').hide();
						if (response[0].res == 'success') {
							Lobibox.notify('success', {
								pauseDelayOnHover: true,
								size: 'mini',
								rounded: true,
								delayIndicator: false,
								icon: 'fa fa-exclamation-circle',
								continueDelayOnInactiveTab: false,
								position: 'top right',
								msg: response[0].msg
							});
							window.location.reload();
						}
						else if (response[0].res == 'error') {
							Lobibox.notify('error', {
								pauseDelayOnHover: true,
								size: 'mini',
								rounded: true,
								delayIndicator: false,
								icon: 'fa fa-exclamation-circle',
								continueDelayOnInactiveTab: false,
								position: 'top right',
								msg: response[0].msg
							});
						}
					},
					error: function() {
						window.location.reload();
					}
				});
			});	
		</script>
		
		<script>
			
			function rate5(){ 
				document.getElementById("5").style.color = "orange"; 
				document.getElementById("4").style.color = "orange";
				document.getElementById("3").style.color = "orange";
				document.getElementById("2").style.color = "orange"; 
				document.getElementById("1").style.color = "orange";
			}
			
			function rate4(){
				document.getElementById("5").style.color = "#9e9e9e"; 
				document.getElementById("4").style.color = "orange";
				document.getElementById("3").style.color = "orange";
				document.getElementById("2").style.color = "orange"; 
				document.getElementById("1").style.color = "orange";
			}
			
			function rate3(){
				document.getElementById("5").style.color = "#9e9e9e"; 
				document.getElementById("4").style.color = "#9e9e9e";
				document.getElementById("3").style.color = "orange";
				document.getElementById("2").style.color = "orange"; 
				document.getElementById("1").style.color = "orange";
			}
			
			function rate2(){
				document.getElementById("5").style.color = "#9e9e9e"; 
				document.getElementById("4").style.color = "#9e9e9e";
				document.getElementById("3").style.color = "#9e9e9e";
				document.getElementById("2").style.color = "orange"; 
				document.getElementById("1").style.color = "orange";
			}
			
			function rate1(){
				document.getElementById("5").style.color = "#9e9e9e"; 
				document.getElementById("4").style.color = "#9e9e9e";
				document.getElementById("3").style.color = "#9e9e9e";
				document.getElementById("2").style.color = "#9e9e9e";
				document.getElementById("1").style.color = "orange";
			}
			
			document.getElementById("5").onclick = function(){
				rate5();
			}
			document.getElementById("4").onclick = function(){
				rate4();
			}
			document.getElementById("3").onclick = function(){
				rate3();
			}
			document.getElementById("2").onclick = function(){
				rate2();
			}
			document.getElementById("1").onclick = function(){
				rate1();
			}
		</script>
	</body>
</html>    