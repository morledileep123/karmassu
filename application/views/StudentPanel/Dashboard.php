<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Karmasu | Student | Dashboard</title>
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
                    <section class="top-category section-padding">
						<div class="container">
							<div class="owl-carousel owl-carousel-featured">
                                
                                <?php if(count($sliderList)) : ?>
                                <?php foreach($sliderList as $item) : ?>
                                
                                <div class="item">
                                    <div class="owl-slider-item">
                                        <a href="<?php if($item->parameter=='None'){ echo 'javascript:void(0);';} else if($item->parameter=='External'){ echo $item->link; } else if($item->parameter=='Category') { echo base_url('Student/Courses/Category/'.$item->link); } else if($item->parameter=='Course') { echo base_url('Student/CourseDescription/'.$item->link); }?>" <?php if($item->parameter=='External'){ echo 'target="_blank"';}?>><img class="img-fluid" src="<?php echo base_url('uploads/slider/'.$item->image);?>"></a>
                                    </div>
                                </div>
                                
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                    <div class="row">
                        <?php if(count($trendingCourseList)) : ?>
                        <div class="col-sm-12 p-2"><h5 class="pull-left">Trending Courses</h5><a href="<?php echo base_url('Student/Courses');?>" class="btn btn-dark pull-right ">View All Courses <i class="fa fa-angle-double-right"></i> </a></div>
                        
                        
                        <?php foreach($trendingCourseList as $item) : ?>
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
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <section class="top-category section-padding">
                        <div class="container">
                            <div class="section-header">
                                <h5 class="heading-design-h5">Course By Category 
                                    <a href="<?php echo base_url('Student/Courses');?>" class="text-dark float-right ">View All <i class="fa fa-angle-double-right"></i> </a>
                                </h5>
                            </div>
                            <div class="owl-carousel owl-carousel-category">
                                
                                <?php if(count($categoryList)) : ?>
                                <?php foreach($categoryList as $item) : ?>
                                
                                <div class="item">
                                    <div class="category-item">
                                        <a href="<?php echo base_url('Student/Courses/Category/'.$item->id);?>">
                                            <img class="img-fluid" src="<?php echo base_url('uploads/category/'.$item->icon);?>" title="<?php echo $item->title;?>" >
                                            <h6><?php echo $item->title;?></h6>
                                        </a>
                                    </div>
                                </div>
                                
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                    
                    
                    <div class="row">
                        <?php if(count($topCourseList)) : ?>
                        <div class="col-sm-12 p-2"><h5 class="pull-left">Top Courses</h5><a href="<?php echo base_url('Student/Courses');?>" class="btn btn-dark pull-right ">View All Courses <i class="fa fa-angle-double-right"></i> </a></div>
                        
                        
                        <?php foreach($topCourseList as $item) : ?>
                        
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
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="row">
                        <?php if(count($latestCourseList)) : ?>
                        <div class="col-sm-12 p-2"><h5 class="pull-left">Latest Courses</h5><a href="<?php echo base_url('Student/Courses');?>" class="btn btn-dark pull-right ">View All Courses <i class="fa fa-angle-double-right"></i> </a></div>
                        
                        
                        <?php foreach($latestCourseList as $item) : ?>
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
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    
                    <section class="top-category section-padding">
                        <div class="container">
                            <div class="section-header">
                                <h5 class="heading-design-h5">E-Book By Category 
                                    <a href="<?php echo base_url('Student/EBooks');?>" class="text-dark float-right ">View All <i class="fa fa-angle-double-right"></i> </a>
                                </h5>
                            </div>
                            <div class="owl-carousel owl-carousel-category">
                                
                                <?php if(count($categoryList)) : ?>
                                <?php foreach($categoryList as $item) : ?>
                                
                                <div class="item">
                                    <div class="category-item">
                                        <a href="<?php echo base_url('Student/EBooks/Category/'.$item->id);?>">
                                            <img class="img-fluid" src="<?php echo base_url('uploads/category/'.$item->icon);?>" title="<?php echo $item->title;?>" >
                                            <h6><?php echo $item->title;?></h6>
                                        </a>
                                    </div>
                                </div>
                                
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                    
                    <div class="row">
                        <?php if(count($latestEbookList)) : ?>
                        <div class="col-sm-12 p-2"><h5 class="pull-left">Latest E-Books</h5><a href="<?php echo base_url('Student/EBooks');?>" class="btn btn-dark pull-right ">View All E-Books <i class="fa fa-angle-double-right"></i> </a></div>
                        
                        
                        <?php foreach($latestEbookList as $item) : ?>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-header p-0">
                                    <a href="<?php echo base_url('Student/EBookDescription/'.$item->id);?>"><img src="<?php echo base_url('uploads/ebook/'.$item->banner);?>" title="<?php echo $item->name;?>"  class="card-img-top"></a>
                                    
                                    <?php if($item->discountpercent!='0% Off'){ ?>
                                        <span class="badge badge-warning badge-up p-2" style="border-radius:0%;"><?php echo $item->discountpercent;?></span>
                                    <?php } ?>
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $item->name;?></h5>
                                    <h6><i class="fa fa-user-circle"></i> <?php echo $item->author->name;?></h6>
                                    <b><?php echo $item->noofpages; ?> </b> Pages For <b>
                                    <?php echo $item->daystofinish; ?> </b> Days
                                    
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
                                            <a href="<?php echo base_url('Student/Checkout/Ebook/'.$item->id);?>" class="btn btn-primary p-2">Enroll Now</a>
                                            
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="row">
                        <?php if(count($recommendedList)) : ?>
                        <div class="col-sm-12 p-2"><h5 class="pull-left">Recommended Videos</h5><a href="<?php echo base_url('Student/Videos/RecommendedVideos');?>" class="btn btn-dark pull-right ">View All Recommended Videos <i class="fa fa-angle-double-right"></i> </a></div>
                        
                        
                        <?php foreach($recommendedList as $item) : ?>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-header p-0">
                                    <a href="<?php echo base_url('Student/Videos/RecommendedVideos/'.$item->id);?>"><img src="<?php echo base_url('uploads/thumbnail/'.$item->video->thumbnail);?>"  class="card-img-top" ></a>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-center"><?php echo $item->video->title;?></h5>
                                    <h6 class="text-center"><i class="fa fa-user-circle text-danger"></i> <?php echo $item->author->name;?></h6>
                                    <h6 class="text-center"><i class="fa fa-clock text-danger"></i> <?php echo $item->video->duration;?></h6>
                                    <ul class="list-group list-group-flush list shadow-none p-0 text-center">
                                        <li class="list-group-item d-flex justify-content-center align-items-center p-1">
                                            
                                            <a href="<?php echo base_url('Student/Videos/RecommendedVideos/'.$item->id);?>" class="btn btn-info p-2"> <i class="fa fa-play-circle"></i> Play Now</a>
                                            
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
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