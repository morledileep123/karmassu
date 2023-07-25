<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
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
                                
                                case 'Common';
                            ?>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-scooter">
                                        <a href="<?php echo base_url('Educator/ManageEBooks');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="bi bi-bag-check text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $courseCount;?></h5>
                                                        <p class="mb-0 ml-3 text-white">E-Book Management  </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-quepal">
                                        <a href="<?php echo base_url('Educator/ManageCourses');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="bi bi-bag-check text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $courseCount;?></h5>
                                                        <p class="mb-0 ml-3 text-white">Course Management  </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-blooker">
                                        <a href="<?php echo base_url("Educator/Videos/RecommendedVideos");?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="bi bi-camera-reels text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $videoCount;?></h5>
                                                        <p class="mb-0 ml-3 text-white">Recommended Videos  </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-bloody">
                                        <a href="<?php echo base_url('Educator/Notification');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="bi bi-bell text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $notificationCount;?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Notification </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">Notification
									<div class="card-action">
										<span class="badge badge-pill badge-dark m-1"><?php echo $notificationCount;?></span>
									</div>
								</div>
								
								<ul class="list-group list-group-flush">
									<?php if (count($notificationList)) : ?>
									<?php foreach ($notificationList as $item) : ?>
									<li class="list-group-item">
										<div class="media align-items-center">
											<span class="badge badge-pill badge-danger  m-1 p-3" ><strong ><?php echo substr(strtoupper($item->title),0,1);?></strong></span>
											<div class="media-body ml-3">
												<h6 class="mb-0"><?php echo $item->title;?> </h6>
												<p class="mb-0 small-font"><?php echo $item->message;?></p>
												<?php if(!empty($item->link)){ ?>
												<a href="<?php echo $item->link;?>" target="_blank">Read More <i class="fas fa-angle-double-right"></i> </a>
												<?php } ?>
											</div>
											<div class="star">
											<?php if(!empty($item->image)){ ?>
												<img src="<?=base_url('uploads/notification/'.$item->image);?>" class="img-fluid" style="height:100px;"/>
												<?php } ?>
												<small class="ml-4"><?php echo $item->since;?></small>
												
											</div>
										</div>
									</li>
									
									
									<?php endforeach; ?>
									<?php endif; ?>
									
									<?php if (!count($notificationList)) : ?>
									<li class="list-group-item">
										<div class="media align-items-center">
											No Notification Available.
										</div>
									</li>
									
									<?php endif; ?>
								</ul> 
							</div>
						</div>
					</div>
                            <div class="row">
                                <?php if(count($recommendedList)) : ?>
                                <div class="col-sm-12 p-2"><h5 class="pull-left">Free Videos</h5><a href="<?php echo base_url('Educator/Videos/RecommendedVideos');?>" class="btn btn-dark pull-right ">View All Free Videos <i class="fa fa-angle-double-right"></i> </a></div>
                                
                                
                                <?php foreach($recommendedList as $item) : ?>
                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-header p-0">
                                            <a href="<?php echo base_url('Educator/Videos/RecommendedVideos/'.$item->id);?>"><img src="<?php echo base_url('uploads/thumbnail/'.$item->video->thumbnail);?>"  class="card-img-top" style="height:250px;"></a>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title text-center"><?php echo $item->video->title;?></h5>
                                            <h6 class="text-center"><i class="fa fa-user-circle text-danger"></i> <?php echo $item->author->name;?></h6>
                                            <h6 class="text-center"><i class="fa fa-clock text-danger"></i> <?php echo $item->video->duration;?></h6>
                                            <ul class="list-group list-group-flush list shadow-none p-0 text-center">
                                                <li class="list-group-item d-flex justify-content-center align-items-center p-1">
                                                    
                                                    <a href="<?php echo base_url('Educator/Videos/RecommendedVideos/'.$item->id);?>" class="btn btn-info p-2"> <i class="fa fa-play-circle"></i> Play Now</a>
                                                    
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            
                            <?php
                                break;
                                
                                 case 'Sales';
                            ?>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-scooter">
                                        <a href="javascript:void(0);">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-bar-chart text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountSales->TodaySales; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Today Sales </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-bloody">
                                        <a href="javascript:void(0);">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-bar-chart text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountSales->YesterdaySales; ?></h5>
                                                        <p class="mb-0 ml-3 text-white">Yesterday Sales </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-quepal">
                                        <a href="javascript:void(0);">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-bar-chart text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountSales->WeekSales; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Sales This Week </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-blooker">
                                        <a href="javascript:void(0);">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-bar-chart text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountSales->MonthSales; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Sales This Month </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                            </div>
                            
                            
                            <div class="row mt-3">
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-scooter">
                                        <a href="javascript:void(0);">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-bar-chart text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><i class="fa fa-inr"></i> <?php if($TodaySalesSum->price){ echo $TodaySalesSum->price; } else{ echo 0;}; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Today Sales </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-bloody">
                                        <a href="javascript:void(0);">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-bar-chart text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><i class="fa fa-inr"></i> <?php if($YesterdaySalesSum->price){ echo $YesterdaySalesSum->price; } else{ echo 0;}; ?></h5>
                                                        <p class="mb-0 ml-3 text-white">Yesterday Sales </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-quepal">
                                        <a href="javascript:void(0);">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-bar-chart text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><i class="fa fa-inr"></i><?php if($WeekSalesSum->price){ echo $WeekSalesSum->price; } else{ echo 0;}; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Sales This Week </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-blooker">
                                        <a href="javascript:void(0);">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-bar-chart text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><i class="fa fa-inr"></i> <?php if($MonthSalesSum->price){ echo $MonthSalesSum->price; } else{ echo 0;}; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Sales This Month </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5> Today Sales </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>Item</th>
                                                            <th>Name</th>
                                                            <th>Coupon</th>
                                                            <th>Price</th>
                                                            <th>Order ID</th>
                                                            <th>Payment ID</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($TodaySalesList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <?php
                                                                        if($item->paymentstatus=='success'){
                                                                            echo '<b class="text-success">Success</b>';
                                                                        }
                                                                        else if($item->paymentstatus=='failed'){
                                                                            echo '<b class="text-danger">Failed</b>';
                                                                        }
                                                                        else if($item->paymentstatus=='Pending'){
                                                                            echo '<b class="text-warning">Pending</b>';
                                                                        }
                                                                        else{
                                                                            echo '<b class="text-danger">'.$item->paymentstatus.'</b>';
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->itemtype;?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->firstname.' '.$item->lastname; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->couponcode; ?>
                                                                </td>
                                                                <td>
                                                                    <i class="fa fa-inr"></i> <?php echo $item->price; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->orderid; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->paymentid; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->date; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->time; ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                                $sr++;
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5> Yesterday Sales </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>Item</th>
                                                            <th>Name</th>
                                                            <th>Coupon</th>
                                                            <th>Price</th>
                                                            <th>Order ID</th>
                                                            <th>Payment ID</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($YesterdaySalesList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <?php
                                                                        if($item->paymentstatus=='success'){
                                                                            echo '<b class="text-success">Success</b>';
                                                                        }
                                                                        else if($item->paymentstatus=='failed'){
                                                                            echo '<b class="text-danger">Failed</b>';
                                                                        }
                                                                        else if($item->paymentstatus=='Pending'){
                                                                            echo '<b class="text-warning">Pending</b>';
                                                                        }
                                                                        else{
                                                                            echo '<b class="text-danger">'.$item->paymentstatus.'</b>';
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->itemtype;?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->firstname.' '.$item->lastname; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->couponcode; ?>
                                                                </td>
                                                                <td>
                                                                    <i class="fa fa-inr"></i> <?php echo $item->price; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->orderid; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->paymentid; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->date; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->time; ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                                $sr++;
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5> Sales This Week</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>Item</th>
                                                            <th>Name</th>
                                                            <th>Coupon</th>
                                                            <th>Price</th>
                                                            <th>Order ID</th>
                                                            <th>Payment ID</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($WeekSalesList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <?php
                                                                        if($item->paymentstatus=='success'){
                                                                            echo '<b class="text-success">Success</b>';
                                                                        }
                                                                        else if($item->paymentstatus=='failed'){
                                                                            echo '<b class="text-danger">Failed</b>';
                                                                        }
                                                                        else if($item->paymentstatus=='Pending'){
                                                                            echo '<b class="text-warning">Pending</b>';
                                                                        }
                                                                        else{
                                                                            echo '<b class="text-danger">'.$item->paymentstatus.'</b>';
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->itemtype;?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->firstname.' '.$item->lastname; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->couponcode; ?>
                                                                </td>
                                                                <td>
                                                                    <i class="fa fa-inr"></i> <?php echo $item->price; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->orderid; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->paymentid; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->date; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->time; ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                                $sr++;
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5> Sales This Month</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>Item</th>
                                                            <th>Name</th>
                                                            <th>Coupon</th>
                                                            <th>Price</th>
                                                            <th>Order ID</th>
                                                            <th>Payment ID</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($MonthSalesList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <?php
                                                                        if($item->paymentstatus=='success'){
                                                                            echo '<b class="text-success">Success</b>';
                                                                        }
                                                                        else if($item->paymentstatus=='failed'){
                                                                            echo '<b class="text-danger">Failed</b>';
                                                                        }
                                                                        else if($item->paymentstatus=='Pending'){
                                                                            echo '<b class="text-warning">Pending</b>';
                                                                        }
                                                                        else{
                                                                            echo '<b class="text-danger">'.$item->paymentstatus.'</b>';
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->itemtype;?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->firstname.' '.$item->lastname; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->couponcode; ?>
                                                                </td>
                                                                <td>
                                                                    <i class="fa fa-inr"></i> <?php echo $item->price; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->orderid; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->paymentid; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->date; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->time; ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                                $sr++;
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <?php
                                break;
                            }
                        }
                        
                        
                    ?>
                    
                    
                    
                    
                    <div class="overlay toggle-menu"></div>
                    
                </div>
            </div>
            <?php include("Footer.php"); ?>
            
            
        </div>
        <?php  include("FooterLinking.php");  ?>
        
        <script src="<?php base_url("assets_panel/js/index.js"); ?>"></script>
        <script>
        $(function() {
            $(".knob").knob();
        });
        var table = $('.example').DataTable({
            responsive:true,
            lengthChange: false,
            dom: 'Bfrtip',
            buttons: [ 'excel', 'pdf' ]
        });
        table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
    </script>
        
    </body>
    
</html>                    