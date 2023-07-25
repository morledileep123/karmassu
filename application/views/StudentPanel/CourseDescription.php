<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    <head> 
        <title>Karmasu | Student | Course Description</title>
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
                                            <img src="../../../uploads/course/<?php echo $list[0]->banner; ?>" class="img-fluid" title="course-img" alt="course-img" />
                                            
										</div>
                                        <div class="col-sm-12 p-2">
                                            <img src="../../../uploads/course/<?php echo $list[0]->logo; ?>" class="img-fluid mr-3 img-thumbnail" title="logo" alt="logo" style="width:80px;" />
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
                                            <p><strong><i class="fa fa-book text-primary"></i> <?php echo $list[0]->nooflecture; ?> Lectures</strong></p>
										</div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-universal-access text-primary"></i> Full Lifetime Access</strong></p>
										</div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-certificate text-primary"></i> 
                                                <?php 
                                                    if($list[0]->certification == "Yes"){
                                                        echo 'Certification';
													}
                                                    else{
                                                        echo 'No Certification';
													}
                                                    
												?>
											</p></strong>
											<p>
												<?php for($i=0;$i<5;$i++){ ?>
													<i class="<?php if($rating >= $i){ echo 'fas fa-star text-warning'; } else{ echo 'far fa-star text-warning'; } ?>"  aria-hidden="true" ></i>
												<?php } ?>
												(<?php echo $ratingcount;?>)
											</p>
											<?php
												if($enrollcount){
												?>
												<?php if($enroll->certificatestatus=='true') { ?>
													<a href="<?php echo base_url("Student/MyCertificates/".$enroll->certificatedata->refno) ?>" class="btn btn-dark p-2"><i class="fa fa-certificate"></i> View Certificate </a>
												<?php } ?>
												<?php if($enroll->certificatestatus=='request') { ?>
													<a href="javascript:void(0);" onclick="RequestCertificate('<?php echo $this->userid;?>','<?php echo $enroll->id;?>')" class="btn btn-dark p-2"><i class="fa fa-certificate"></i> Request Certificate <i class="fa fa-spin fa-spinner" id="registerSpin" style="display:none;"></i></a>
												<?php } ?>
												<?php if($enroll->certificatestatus=='requested') { ?>
													<a href="javascript:void(0);"  class="btn btn-danger p-1"><i class="fa fa-certificate"></i> Certificate Requested <i class="fa fa-spin fa-spinner"></i></a>
												<?php } ?>
												<?php
												}
												else{
												?>
												<a href="<?php echo base_url('Student/Checkout/Course/'.$list[0]->id);?>" class="btn btn-danger p-2"><i class="fa fa-registered"></i> Enroll Now</a>
												<?php	
												}
											?>
										</div>
										
									</div>
                                    
                                    
								</div>
							</div>
                            
						</div>
                        <div class="col-sm-8">
							
							<?php if(!$enrollcount){ ?>
								<div class="card">
									<div class="card-header"><h5> Demo Lecture</h5> </div>
									<ul class="list-group list-group-flush">
										<li class="list-group-item">
											<div class="media align-items-center">
												<iframe style="width:100%;height:460px;" src="<?php echo $list[0]->demovedio;?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
											</div>
										</li>
									</ul>
								</div>
								<?php } else {?>
								<div class="card" style="height:530px;overflow-y:scroll;">
									<div class="card-header"><h5>Playlist</h5> </div>
									<ul class="list-group list-group-flush">
										<?php if(count($lecture)) : ?>
										<?php foreach($lecture as $item) : ?>
										<li class="list-group-item">
											<div class="media align-items-center">
												<img src="<?php echo base_url('uploads/thumbnail/'.$item->video[0]->thumbnail);?>" title="thumbnail" alt="thumbnail"  class="img-fluid" style="width:80px;height:80px;">
												<div class="media-body ml-3">
													<h6 class="mb-0"><?php echo $item->video[0]->title;?> </h6>
													<p class="mb-0 small-font"><?php echo $item->video[0]->description;?></p>
												</div>
												<div class="star">
													<a href="<?php if($enrollcount){ echo base_url('Student/VideoPlaylist/'.$list[0]->id.'/'.$item->video[0]->id); } else{ echo 'javascript:void(0);';} ?>" class="btn btn-info p-2" <?php if($enrollcount){ }else{ echo 'data-toggle="tooltip" data-placement="top" title="First enroll this course."';} ?> > <i class="fa fa-play-circle"></i> Play</a>
												</div>
											</div>
										</li>
										<?php endforeach; ?>
										<?php endif; ?>
										<?php if(!count($lecture)) : ?>
										<li class="list-group-item">
											<div class="media align-items-center">
												<div class="media-body ml-3">
													No Playlist Found.
												</div>
											</div>
										</li>
										<?php endif; ?>
									</ul>
								</div>
							<?php }?>
							
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<?php if($enrollcount){ ?>
								<div class="card">
									<div class="card-header"><h5>Demo Lecture</h5> </div>
									<ul class="list-group list-group-flush">
										<li class="list-group-item">
											<div class="media align-items-center">
												<iframe style="width:100%;height:460px;" src="<?php echo $list[0]->demovedio;?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
											</div>
										</li>
									</ul>
								</div>
								<?php } else {?>
								<div class="card" style="height:530px;overflow-y:scroll;">
									<div class="card-header"><h5>Playlist</h5> </div>
									<ul class="list-group list-group-flush">
										<?php if(count($lecture)) : ?>
										<?php foreach($lecture as $item) : ?>
										<li class="list-group-item">
											<div class="media align-items-center">
												<img src="<?php echo base_url('uploads/thumbnail/'.$item->video[0]->thumbnail);?>"  class="img-fluid" style="width:80px;height:80px;"">
												<div class="media-body ml-3">
												<h6 class="mb-0"><?php echo $item->video[0]->title;?> </h6>
												<p class="mb-0 small-font"><?php echo $item->video[0]->description;?></p>
											</div>
											<div class="star">
												<a href="<?php if($enrollcount){ echo base_url('Student/VideoPlaylist/'.$list[0]->id.'/'.$item->video[0]->id); } else{ echo 'javascript:void(0);';} ?>" class="btn btn-info p-2" <?php if($enrollcount){ }else{ echo 'data-toggle="tooltip" data-placement="top" title="First enroll this course."';} ?> > <i class="fa fa-play-circle"></i> Play</a>
											</div>
										</div>
									</li>
									<?php endforeach; ?>
									<?php endif; ?>
									<?php if(!count($lecture)) : ?>
									<li class="list-group-item">
										<div class="media align-items-center">
											<div class="media-body ml-3">
												No Playlist Found.
											</div>
										</div>
									</li>
									<?php endif; ?>
								</ul>
							</div>
						<?php }?>
						
						<div class="card">
							<div class="card-header"><h5>What does this course include?</h5> </div>
							<ul class="list-group list-group-flush">
								<li class="list-group-item">
									<div class="media align-items-center">
										<p><?php echo $list[0]->course_include; ?></p>
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
							<div class="card-header"><h5>Course Description</h5> </div>
							<ul class="list-group list-group-flush">
								<li class="list-group-item">
									<div class="media align-items-center">
										<p><?php echo $list[0]->description; ?></p>
									</div>
								</li>
							</ul>
						</div>
						<div class="card">
							<div class="card-header"><h5>What do you need?</h5> </div>
							<ul class="list-group list-group-flush">
								<li class="list-group-item">
									<div class="media align-items-center">
										<p><?php echo $list[0]->requirement; ?></p>
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
										<img src="<?php if(empty($item->photo)){ echo base_url("image/LogoCodersAdda1.png"); } else{ echo base_url("uploads/tutor/".$item->photo); } ?>"  class="customer-img rounded-circle" >
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
										<button data-toggle="modal" data-target="#AddModal" class="btn btn-primary"> <i class="fa fa-check-circle"></i> Give Review </button>
									<?php }?>
								</div>	
							</div>
							<ul class="list-group list-group-flush">
								<?php if(count($review)) : ?>
								<?php foreach($review as $item) : ?>
								<li class="list-group-item">
									<div class="media align-items-center">
										<img src="<?php if(empty($item['profile_photo'])){ echo base_url("image/LogoCodersAdda1.png"); } else{ echo base_url("uploads/profile_photo/".$item['profile_photo']); } ?>"  class="customer-img rounded-circle" >
										<div class="media-body ml-3">
											<h6 class="mb-0"><?php echo $item['name'];?> </h6>
											<p><?php echo $item['review'];?></p>
											<p>Date : <?php echo $item['date'];?> <?php echo $item['time'];?></p>
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
									<input type="hidden" name="itemtype" value="<?php echo 'Course';?>"/>
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
	
	<script>
		
		function RequestCertificate(userid,enrollid) 
		{
			
			$.ajax({
				url: "<?php echo base_url('Student/RequestCertificate'); ?>",
				type: "POST",
				data: {'userid':userid,'enrollid':enrollid},
				beforeSend: function() {
					$("#registerBtn").attr("disabled", true);
					$('#registerSpin').show();
				},
				success: function(response) {
					$("#registerBtn").removeAttr("disabled");
					$('#registerSpin').hide();
					var response = JSON.parse(response);
					if (response[0].res == 'success') {
						$('.notifyjs-wrapper').remove();
						$.notify("" + response[0].msg + "", "success");
						window.setTimeout(function() {
							window.location.reload();
						}, 1000);
					}
					else if (response[0].res == 'error') {
						$('.notifyjs-wrapper').remove();
						$.notify("" + response[0].msg + "", "error");
					}
				}
			});
		}
		
	</script>
	
</body>
</html>
