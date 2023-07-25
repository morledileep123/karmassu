<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">  
    <head>
        <title>Karmasu | Student | Courses</title>
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
                        <div class="col-sm-12 p-2"><h5 class="pull-left">Courses</h5></div>
                        <?php
							if(count($courseList)){
                                foreach($courseList as $item){
                                ?>
                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-header p-0">
                                            <a href="<?php echo base_url('Student/CourseDescription/'.$item->id);?>"><img src="<?php echo base_url('uploads/course/'.$item->banner);?>" title="<?php echo $item->name;?>"  class="card-img-top"></a>
                                            
                                            <?php if($item->discountpercent!='0% Off'){ ?>
                                                <span class="badge badge-warning badge-up p-2" style="border-radius:0%;"><?php echo $item->discountpercent;?></span>
                                            <?php } ?>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $item->name;?></h5>
                                            <h6><i class="fa fa-user-circle"></i> <?php echo $item->author->name;?></h6>
                                            <b><?php echo $item->nooflecture; ?> </b> Lectures For <b>
                                            <?php echo $item->daystofinish; ?> </b> Days
                                            <?php
                                                if ($item->certification == 'Yes') {
                                                    echo '<p><b class="text-success">Certification</b></p>';
                                                }
                                                else{
                                                    echo '<p><b class="text-danger">No Certification</b></p>';
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
                                                    <?php if($item->offerprice>0){?>
                                                        <span><i class="fa fa-inr"></i><?php echo $item->offerprice;?></span>
                                                        <?php if($item->price!=$item->offerprice){?>
                                                            <del><i class="fa fa-inr"></i><?php echo $item->price;?></del>
                                                        <?php } ?>
                                                        <?php } else{?>
                                                        <strong><span class="p-2 text-success">Free</span></strong>
                                                    <?php } ?>
                                                    <a href="<?php echo base_url('Student/Checkout/Course/'.$item->id);?>" class="btn btn-primary p-2">Enroll Now</a>
                                                    
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php } } else{ ?>
                            <div class="col-sm-12">
								<center>
									<img src="<?php echo base_url('image/NoRecordFound.png');?>" title="not found" alt="not found" class="img-fluid"/>
									<br><br>
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