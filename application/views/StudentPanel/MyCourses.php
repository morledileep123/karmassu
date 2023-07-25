<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en"> 
    <head> 
        <title>Karmasu | Student | My Courses</title>
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
                    <div class="row">
                        <div class="col-sm-12 p-2"><h5 class="pull-left">My Courses</h5></div>
                        <?php
							if(count($courseList)){
								foreach($courseList as $item){
								?>
								<div class="col-sm-3">
									<div class="card">
										<div class="card-header p-0">
											<a href="<?php echo base_url('Student/CourseDescription/'.$item->item->id);?>"><img src="<?php echo base_url('uploads/course/'.$item->item->banner);?>" title="<?php echo $item->item->name;?>" alt="<?php echo $item->item->name;?>" class="card-img-top"></a>
										</div>
										<div class="card-body">
											<h5 class="card-title"><?php echo $item->item->name;?></h5>
											<h6><i class="fa fa-user-circle"></i> <?php echo $item->item->author->name;?></h6>
											
											<b><?php echo $item->item->nooflecture; ?> </b> Lectures For <b>
											<?php echo $item->item->daystofinish; ?> </b> Days
											<?php
												if ($item->item->certification == 'Yes') {
													echo '<b class="text-danger">Certification</b>';
												}
											?> 
											<p>
												<?php for($i=0;$i<5;$i++){ ?>
													<i class="<?php if($item->rating >= $i){ echo 'fas fa-star text-warning'; } else{ echo 'far fa-star text-warning'; } ?>"  aria-hidden="true" ></i>
												<?php } ?>
												(<?php echo $item->totalrating;?>)
											</p>
											<ul class="list-group list-group-flush list shadow-none p-0">
												<li class="list-group-item d-flex justify-content-between align-items-center p-1">
													
													<a href="<?php echo base_url('Student/CourseDescription/'.$item->item->id);?>" class="btn btn-dark p-2"><i class="fa fa-folder-open"></i> Read Course</a>
													
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
									<a href="<?php echo base_url('Student/Courses');?>" class="btn btn-dark btn-lg">Purchase Now <i class="fa fa-angle-double-right"></i> </a>
									<br><br><br><br>
								</center>
							</div>
						<?php } ?>
					</div>	
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