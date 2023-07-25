<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Karmasu | Student | Recommended Videos</title>
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
					<?php
						if (isset($action)) 
						{
							switch ($action) 
							{
								
								case 'RecommendedVideos';
							?>
							
							<div class="row">
								<div class="col-sm-12 p-2"><h5 class="pull-left"><?php echo $type;?></h5></div>
								<?php
									if(count($list)){
										foreach($list as $item){
										?>
										<div class="col-sm-3">
											<div class="card">
											<div class="card-header p-0">
												<a href="<?php echo base_url('Student/Videos/'.$type.'/'.$item->id);?>"><img src="<?php echo base_url('uploads/thumbnail/'.$item->video->thumbnail);?>"  class="card-img-top" ></a>
												</div>
												<div class="card-body">
													<h5 class="card-title text-center"><?php echo $item->video->title;?></h5>
													<h6 class="text-center"><i class="fa fa-user-circle text-danger"></i> <?php echo $item->author->name;?></h6>
													<h6 class="text-center"><i class="fa fa-clock text-danger"></i> <?php echo $item->video->duration;?></h6>
													<ul class="list-group list-group-flush list shadow-none p-0 text-center">
														<li class="list-group-item d-flex justify-content-center align-items-center p-1">
															
															<a href="<?php echo base_url('Student/Videos/'.$type.'/'.$item->id);?>" class="btn btn-info p-2"> <i class="fa fa-play-circle"></i> Play Now</a>
															
														</li>
													</ul>
												</div>
											</div>
										</div>
									<?php } } else{ ?>
									<div class="col-sm-12">
										<center>
											<img src="<?php echo base_url('image/NoRecordFound.png');?>" title="img not found" alt="img not found" class="img-fluid"/>
											<br><br>
											<br><br><br><br>
										</center>
									</div>
								<?php } ?>
							</div>	
							<?php
								break;
								
								case 'RecommendedVideosDescription';
							?>
							
							<div class="row">
								<div class="col-sm-12 p-2"><h5 class="pull-left"><?php echo $list[0]->video->title;?></h5></div>
								<?php
									if(count($list)){
										foreach($list as $item){
											if($item->video->type=='Internal'){
												$link=base_url('uploads/video/'.$item->video->video);
											}
											else{
												$link=$item->video->link;
											}
										?>
										<div class="col-sm-12">
											<div class="card">
												<ul class="list-group list-group-flush">
													<li class="list-group-item">
														<div class="media align-items-center">
															<iframe style="width:100%;height:480px;" src="<?php echo $link;?>"  frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
														</div>
														<div class="media-body ml-3"><br>
														
															<p><a class="text-info"><?php echo $item->video->duration;?></a></p>
															<h6><i class="fa fa-user-circle text-danger"></i> <?php echo $item->author->name;?></h6>
															<h4 class="mb-0 text-dark"><?php echo $item->video->title;?> </h4>
															
															<p><?php echo $item->description;?></p>
														</div>
													</li>
												</ul>
											</div>
										</div>
									<?php } } else{ ?>
									<div class="col-sm-12">
										<center>
											<img src="<?php echo base_url('image/NoRecordFound.png');?>" title="img not found" alt="img not found" class="img-fluid"/>
											<br><br>
											<br><br><br><br>
										</center>
									</div>
								<?php } ?> 
							</div>	
							<?php
								break;	
							}
						} 
						else 
						{
							echo 'Action is required.';
						}
					?>
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
        
	</body>
    
</html>