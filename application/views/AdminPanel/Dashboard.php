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
                            <!--
                            <div class="row mt-3">
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-scooter">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Sales');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-bar-chart text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Sales Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-bloody">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Student');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-user-circle text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Student Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-quepal">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Course');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-certificate text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Course Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-blooker">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Ebook');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-book text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">E-Book Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                            </div>
                            -->
                            
                            <div class="row mt-3">
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-scooter">
                                        <a href="<?php echo base_url('AdminPanel/ManageStudents');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="bi bi-people text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $studentCount;?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Manage Students </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-bloody">
                                        <a href="<?php echo base_url('AdminPanel/ManageTutors');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="bi bi-file-person text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $tutorCount;?></h5>
                                                        <p class="mb-0 ml-3 text-white">Manage Educators </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-quepal">
                                        <a href="<?php echo base_url('AdminPanel/ManageCourses');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="bi bi-bag-check text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $courseCount;?></h5>
                                                        <p class="mb-0 ml-3 text-white">Manage Courses  </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-blooker">
                                        <a href="<?php echo base_url('AdminPanel/ManageEBooks');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="bi bi-book text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $ebookCount;?></h5>
                                                        <p class="mb-0 ml-3 text-white">Manage E-Books  </p>
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
                                        <a href="<?php echo base_url('AdminPanel/ManageCategories');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="bi bi-collection text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $categoryCount;?></h5>
                                                        <p class="mb-0 ml-3 text-white">Manage Categories </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-quepal">
                                        <a href="<?php echo base_url('AdminPanel/ManageLiveVideo');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="bi bi-caret-up-square text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $liveCount;?></h5>
                                                        <p class="mb-0 ml-3 text-white">Live Sessions  </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-blooker">
                                        <a href="<?php echo base_url('AdminPanel/RecommendedVideos');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="bi bi-camera-reels text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $recommendedCount;?></h5>
                                                        <p class="mb-0 ml-3 text-white">Free Videos  </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-bloody">
                                        <a href="<?php echo base_url('AdminPanel/ManageNotification');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="bi bi-bell text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $notificationCount;?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Manage Notification </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="row mt-3">
                                
                                
                                
                                <!--
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-blooker">
                                        <a href="<?php echo base_url('AdminPanel/ManageTeam');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-user-md text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $teamCount;?></h5>
                                                        <p class="mb-0 ml-3 text-white">Team Management  </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                -->
                                
                                
                            </div>
                            
                            <?php
                                break;
                                
                                case 'Sales';
                            ?>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-scooter">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Common');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="zmdi zmdi-view-dashboard text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Common Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-bloody">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Student');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-user-circle text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Student Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-quepal">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Course');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-certificate text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Course Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-blooker">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Ebook');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-book text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">E-Book Dashboard</h5>
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
                                                            <th>Invoice</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            <th>Qualification</th>
                                                            <th>Coupon</th>
                                                            <th>Price</th>
                                                            <th>Order ID</th>
                                                            <th>Razorpay Order ID</th>
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
                                                                    <input type="checkbox"
                                                                    onchange="return Status(this,'tbl_enroll','id','<?php echo $item->id; ?>','paymentstatus')"
                                                                    <?php if ($item->paymentstatus == "success") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch"
                                                                    data-color="#eb5076" data-size="small">
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
                                                                    <a href="<?php if($item->itemtype=='Course'){ echo base_url("AdminPanel/ManageCourses/Details/$item->itemid");  } else{ echo base_url("AdminPanel/ManageEBooks/Details/$item->itemid");} ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light">
                                                                    <i class="fa fa-eye"></i> </a>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-success p-1" href="<?php echo base_url('Home/Invoice/'.$item->id);?>" target="_blank">  Invoice <i class="fa fa-angle-double-right"></i></a>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->firstname.' '.$item->lastname; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->mobile; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->email; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->qualification; ?>
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
                                                                    <?php echo $item->rzp_orderid; ?>
                                                                    <button class="btn btn-info p-1" onclick="VerifyPayment('<?php echo $item->rzp_orderid; ?>')"><i class="fa fa-check-circle"></i> Verify</button>
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
                                                            <th>Invoice</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            <th>Qualification</th>
                                                            <th>Coupon</th>
                                                            <th>Price</th>
                                                            <th>Order ID</th>
                                                            <th>Razorpay Order ID</th>
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
                                                                    <input type="checkbox"
                                                                    onchange="return Status(this,'tbl_enroll','id','<?php echo $item->id; ?>','paymentstatus')"
                                                                    <?php if ($item->paymentstatus == "success") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch"
                                                                    data-color="#eb5076" data-size="small">
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
                                                                    <a href="<?php if($item->itemtype=='Course'){ echo base_url("AdminPanel/ManageCourses/Details/$item->itemid");  } else{ echo base_url("AdminPanel/ManageEBooks/Details/$item->itemid");} ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light">
                                                                    <i class="fa fa-eye"></i> </a>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-success p-1" href="<?php echo base_url('Home/Invoice/'.$item->id);?>" target="_blank">  Invoice <i class="fa fa-angle-double-right"></i></a>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->firstname.' '.$item->lastname; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->mobile; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->email; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->qualification; ?>
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
                                                                    <?php echo $item->rzp_orderid; ?>
                                                                    <button class="btn btn-info p-1" onclick="VerifyPayment('<?php echo $item->rzp_orderid; ?>')"><i class="fa fa-check-circle"></i> Verify</button>
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
                                                            <th>Invoice</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            <th>Qualification</th>
                                                            <th>Coupon</th>
                                                            <th>Price</th>
                                                            <th>Order ID</th>
                                                            <th>Razorpay Order ID</th>
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
                                                                    <input type="checkbox"
                                                                    onchange="return Status(this,'tbl_enroll','id','<?php echo $item->id; ?>','paymentstatus')"
                                                                    <?php if ($item->paymentstatus == "success") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch"
                                                                    data-color="#eb5076" data-size="small">
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
                                                                    <a href="<?php if($item->itemtype=='Course'){ echo base_url("AdminPanel/ManageCourses/Details/$item->itemid");  } else{ echo base_url("AdminPanel/ManageEBooks/Details/$item->itemid");} ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light">
                                                                    <i class="fa fa-eye"></i> </a>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-success p-1" href="<?php echo base_url('Home/Invoice/'.$item->id);?>" target="_blank">  Invoice <i class="fa fa-angle-double-right"></i></a>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->firstname.' '.$item->lastname; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->mobile; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->email; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->qualification; ?>
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
                                                                    <?php echo $item->rzp_orderid; ?>
                                                                    <button class="btn btn-info p-1" onclick="VerifyPayment('<?php echo $item->rzp_orderid; ?>')"><i class="fa fa-check-circle"></i> Verify</button>
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
                                                            <th>Invoice</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            <th>Qualification</th>
                                                            <th>Coupon</th>
                                                            <th>Price</th>
                                                            <th>Order ID</th>
                                                            <th>Razorpay Order ID</th>
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
                                                                    <input type="checkbox"
                                                                    onchange="return Status(this,'tbl_enroll','id','<?php echo $item->id; ?>','paymentstatus')"
                                                                    <?php if ($item->paymentstatus == "success") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch"
                                                                    data-color="#eb5076" data-size="small">
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
                                                                    <a href="<?php if($item->itemtype=='Course'){ echo base_url("AdminPanel/ManageCourses/Details/$item->itemid");  } else{ echo base_url("AdminPanel/ManageEBooks/Details/$item->itemid");} ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light">
                                                                    <i class="fa fa-eye"></i> </a>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-success p-1" href="<?php echo base_url('Home/Invoice/'.$item->id);?>" target="_blank">  Invoice <i class="fa fa-angle-double-right"></i></a>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->firstname.' '.$item->lastname; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->mobile; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->email; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->qualification; ?>
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
                                                                    <?php echo $item->rzp_orderid; ?>
                                                                    <button class="btn btn-info p-1" onclick="VerifyPayment('<?php echo $item->rzp_orderid; ?>')"><i class="fa fa-check-circle"></i> Verify</button>
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
                                
                                case 'Student';
                            ?>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-scooter">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Common');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="zmdi zmdi-view-dashboard text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Common Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-bloody">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Sales');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-bar-chart text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Sales Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-quepal">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Course');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-certificate text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Course Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-blooker">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Ebook');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-book text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">E-Book Dashboard</h5>
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
                                                    <div class="w-icon"><i class="fa fa-user-circle text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountStudent->TodayStudent; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Today Student Registration </p>
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
                                                    <div class="w-icon"><i class="fa fa-user-circle text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountStudent->YesterdayStudent; ?></h5>
                                                        <p class="mb-0 ml-3 text-white">Yesterday Student Registration </p>
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
                                                    <div class="w-icon"><i class="fa fa-user-circle text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountStudent->WeekStudent; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> This Week Student Registration </p>
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
                                                    <div class="w-icon"><i class="fa fa-user-circle text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountStudent->MonthStudent; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> This Month Student Registration </p>
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
                                            <h5> Active Student  </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>Profile</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            <th>Education</th>
                                                            <th>Address</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($ActiveStudentList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <input type="checkbox"
                                                                    onchange="return StudentStatus(this,'tbl_registration','id','<?php echo $item->id; ?>','status')"
                                                                    <?php if ($item->status == "true") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch" data-color="#eb5076" data-size="small">
                                                                    
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo base_url('AdminPanel/ManageStudents/Profile/'.$item->id);?>" class="btn btn-info p-1"> <i class="fa fa-user-circle"></i> Profile</a>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->name; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->number; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->email; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->course; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->address; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->date; ?>
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
                                            <h5> Today Student Registration</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>Profile</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            <th>Education</th>
                                                            <th>Address</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($TodayStudentList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <input type="checkbox"
                                                                    onchange="return StudentStatus(this,'tbl_registration','id','<?php echo $item->id; ?>','status')"
                                                                    <?php if ($item->status == "true") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch" data-color="#eb5076" data-size="small">
                                                                    
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo base_url('AdminPanel/ManageStudents/Profile/'.$item->id);?>" class="btn btn-info p-1"> <i class="fa fa-user-circle"></i> Profile</a>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->name; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->number; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->email; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->course; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->address; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->date; ?>
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
                                            <h5> Yesterday Student Registration </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>Profile</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            <th>Education</th>
                                                            <th>Address</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($YesterdayStudentList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <input type="checkbox"
                                                                    onchange="return StudentStatus(this,'tbl_registration','id','<?php echo $item->id; ?>','status')"
                                                                    <?php if ($item->status == "true") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch" data-color="#eb5076" data-size="small">
                                                                    
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo base_url('AdminPanel/ManageStudents/Profile/'.$item->id);?>" class="btn btn-info p-1"> <i class="fa fa-user-circle"></i> Profile</a>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->name; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->number; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->email; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->course; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->address; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->date; ?>
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
                                            <h5> This Week Student Registration </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>Profile</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            <th>Education</th>
                                                            <th>Address</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($WeekStudentList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <input type="checkbox"
                                                                    onchange="return StudentStatus(this,'tbl_registration','id','<?php echo $item->id; ?>','status')"
                                                                    <?php if ($item->status == "true") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch" data-color="#eb5076" data-size="small">
                                                                    
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo base_url('AdminPanel/ManageStudents/Profile/'.$item->id);?>" class="btn btn-info p-1"> <i class="fa fa-user-circle"></i> Profile</a>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->name; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->number; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->email; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->course; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->address; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->date; ?>
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
                                            <h5> This Month Student Registration </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>Profile</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            <th>Education</th>
                                                            <th>Address</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($MonthStudentList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <input type="checkbox"
                                                                    onchange="return StudentStatus(this,'tbl_registration','id','<?php echo $item->id; ?>','status')"
                                                                    <?php if ($item->status == "true") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch" data-color="#eb5076" data-size="small">
                                                                    
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo base_url('AdminPanel/ManageStudents/Profile/'.$item->id);?>" class="btn btn-info p-1"> <i class="fa fa-user-circle"></i> Profile</a>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->name; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->number; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->email; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->course; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->address; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->date; ?>
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
                                
                                case 'Course';
                            ?>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-scooter">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Common');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="zmdi zmdi-view-dashboard text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Common Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-bloody">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Sales');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-bar-chart text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Sales Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-quepal">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Student');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-user-circle text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Student Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-blooker">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Ebook');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-book text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">E-Book Dashboard</h5>
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
                                                    <div class="w-icon"><i class="fa fa-certificate text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountCourse->PurchasedCourse; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Purchased Course </p>
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
                                                    <div class="w-icon"><i class="fa fa-certificate text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountCourse->TrendingCourse; ?></h5>
                                                        <p class="mb-0 ml-3 text-white">Trending Course </p>
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
                                                    <div class="w-icon"><i class="fa fa-certificate text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountCourse->ActiveReview; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Active Review </p>
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
                                                    <div class="w-icon"><i class="fa fa-certificate text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountCourse->InactiveReview; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Inactive Review </p>
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
                                            <h5> Purchased Course </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>Certificate</th>
                                                            <th>Invoice</th>
                                                            <th>Course</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            <th>Qualification</th>
                                                            <th>Coupon</th>
                                                            <th>Price</th>
                                                            <th>Order ID</th>
                                                            <th>Razorpay Order ID</th>
                                                            <th>Payment ID</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($PurchasedCourseList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <input type="checkbox"
                                                                    onchange="return Status(this,'tbl_enroll','id','<?php echo $item->id; ?>','paymentstatus')"
                                                                    <?php if ($item->paymentstatus == "success") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch"
                                                                    data-color="#eb5076" data-size="small">
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
                                                                    <?php if($item->item->certification=='Yes'){?>
                                                                        <input type="checkbox"
                                                                        onchange="return CertificateStatus(this,'<?php echo $item->id; ?>')"
                                                                        <?php if ($item->certificate == "true") {
                                                                            echo "checked";
                                                                        } ?> class="js-switch" data-color="#009999" data-size="small">
                                                                        <?php if ($item->certificate == "true") { ?>
                                                                            <a href="<?php echo base_url("Home/Certificate/".$item->refno) ?>" target="_blank" class="text-info">View Certificate</a>	
                                                                        <?php } ?>
                                                                        <?php } else { echo 'No Certification'; ?>
                                                                    <?php }?>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-success p-1" href="<?php echo base_url('Home/Invoice/'.$item->id);?>" target="_blank">  Invoice <i class="fa fa-angle-double-right"></i></a>
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo base_url("AdminPanel/ManageCourses/Details/$item->itemid") ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light p-2">
                                                                    <i class="fa fa-eye"></i> </a>
                                                                    <?php echo $item->item->name; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->firstname.' '.$item->lastname; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->mobile; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->email; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->qualification; ?>
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
                                                                    <?php echo $item->rzp_orderid; ?>
                                                                    <button class="btn btn-info p-1" onclick="VerifyPayment('<?php echo $item->rzp_orderid; ?>')"><i class="fa fa-check-circle"></i> Verify</button>
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
                                            <h5> Trending Course </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="example">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Indexing</th>
                                                            <th>Logo</th>
                                                            <th>Name</th>
                                                            <th>Price</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($TrendingCourseList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td><?php echo $item->trending; ?></td>
                                                                <td> <img
                                                                    data-src="<?php echo base_url("uploads/course/$item->logo"); ?>"
                                                                    src="<?php echo base_url("images/Preloader2.jpg"); ?>"
                                                                class="lazy" style="height:50px;" /> </td>
                                                                <td>
                                                                    <label data-toggle="tooltip" data-placement="top"
                                                                    title="Course ID: <?php echo $item->id; ?>"><?php echo $item->name; ?>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        if ($item->type == "Paid") {
                                                                        ?>
                                                                        <span class="p-2 text-danger">Paid</span> <br />
                                                                        <?php
                                                                            if (empty($item->offerprice)) {
                                                                            ?>
                                                                            <i class="fa fa-rupee"></i> <?php echo $item->price; ?>
                                                                            <?php
                                                                                } else {
                                                                            ?>
                                                                            <s><i class="fa fa-rupee"></i> <?php echo $item->price; ?></s>
                                                                            <i class="fa fa-rupee"></i> <?php echo $item->offerprice; ?>
                                                                            <?php
                                                                            }
                                                                            } else {
                                                                        ?>
                                                                        <span class="p-2 text-success">Free</span>
                                                                        <?php
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    
                                                                    <div class="btn-group">
                                                                        <a href="<?php echo base_url("AdminPanel/ManageCourses/Details/$item->id") ?>"
                                                                        class="btn btn-sm btn-outline-success waves-effect waves-light">
                                                                        <i class="fa fa-eye"></i> </a>
                                                                        <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                                        onclick="return Status(this,'tbl_course','id','<?php echo $item->id;?>','trending')">
                                                                        <i class="fa fa-times-circle"></i> </a>
                                                                    </div>
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
                                            <h5> Active Review </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>User</th>
                                                            <th>Course</th>
                                                            <th>Rating</th>
                                                            <th>Review</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($ActiveReviewList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <input type="checkbox"
                                                                    onchange="return reviewstatus(this,'tbl_review','id','<?php echo $item->id;?>','status')" <?php if ($item->status == "true") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch"  data-color="#eb5076" data-size="small">
                                                                    
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo base_url("AdminPanel/ManageStudents/Profile/".$item->user->id) ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light p-2">
                                                                    <i class="fa fa-user-circle"></i> </a>
                                                                    <?php echo $item->user->name; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    
                                                                    <a href="<?php echo base_url("AdminPanel/ManageCourses/Details/$item->itemid") ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light p-2">
                                                                    <i class="fa fa-eye"></i> </a>
                                                                    <?php echo $item->item->name; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->rating; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->review; ?>
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
                                            <h5> Inactive Review </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>User</th>
                                                            <th>Course</th>
                                                            <th>Rating</th>
                                                            <th>Review</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($InactiveReviewList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <input type="checkbox"
                                                                    onchange="return reviewstatus(this,'tbl_review','id','<?php echo $item->id;?>','status')" <?php if ($item->status == "true") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch"  data-color="#eb5076" data-size="small">
                                                                    
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo base_url("AdminPanel/ManageStudents/Profile/".$item->user->id) ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light p-2">
                                                                    <i class="fa fa-user-circle"></i> </a>
                                                                    <?php echo $item->user->name; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    
                                                                    <a href="<?php echo base_url("AdminPanel/ManageCourses/Details/$item->itemid") ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light p-2">
                                                                    <i class="fa fa-eye"></i> </a>
                                                                    <?php echo $item->item->name; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->rating; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->review; ?>
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
                                
                                case 'Ebook';
                            ?>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-scooter">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Common');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="zmdi zmdi-view-dashboard text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Common Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-bloody">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Sales');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-bar-chart text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Sales Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-quepal">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Student');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-user-circle text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Student Dashboard</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="card gradient-blooker">
                                        <a href="<?php echo base_url('AdminPanel/Dashboard/Course');?>">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <div class="w-icon"><i class="fa fa-certificate text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white">Course Dashboard</h5>
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
                                                    <div class="w-icon"><i class="fa fa-book text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountEbook->PurchasedEbook; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Purchased E-Book </p>
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
                                                    <div class="w-icon"><i class="fa fa-book text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountEbook->TotalEbook; ?></h5>
                                                        <p class="mb-0 ml-3 text-white">Total E-Book </p>
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
                                                    <div class="w-icon"><i class="fa fa-book text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountEbook->ActiveReview; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Active Review </p>
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
                                                    <div class="w-icon"><i class="fa fa-book text-white"></i></div>
                                                    <div class="media-body ml-3 border-left-xs border-white-2">
                                                        <h5 class="mb-0 ml-3 text-white"><?php echo $CountEbook->InactiveReview; ?></h5>
                                                        <p class="mb-0 ml-3 text-white"> Inactive Review </p>
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
                                            <h5> Purchased E-Book </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>Invoice</th>
                                                            <th>E-Book</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            <th>Qualification</th>
                                                            <th>Coupon</th>
                                                            <th>Price</th>
                                                            <th>Order ID</th>
                                                            <th>Razorpay Order ID</th>
                                                            <th>Payment ID</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($PurchasedEbookList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <input type="checkbox"
                                                                    onchange="return Status(this,'tbl_enroll','id','<?php echo $item->id; ?>','paymentstatus')"
                                                                    <?php if ($item->paymentstatus == "success") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch"
                                                                    data-color="#eb5076" data-size="small">
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
                                                                    <a class="btn btn-success p-1" href="<?php echo base_url('Home/Invoice/'.$item->id);?>" target="_blank">  Invoice <i class="fa fa-angle-double-right"></i></a>
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo base_url("AdminPanel/ManageEBooks/Details/$item->itemid") ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light p-2">
                                                                    <i class="fa fa-eye"></i> </a>
                                                                    <?php echo $item->item->name; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->firstname.' '.$item->lastname; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->mobile; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->email; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->qualification; ?>
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
                                                                    <?php echo $item->rzp_orderid; ?>
                                                                    <button class="btn btn-info p-1" onclick="VerifyPayment('<?php echo $item->rzp_orderid; ?>')"><i class="fa fa-check-circle"></i> Verify</button>
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
                                            <h5> Active Review </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>User</th>
                                                            <th>E-Book</th>
                                                            <th>Rating</th>
                                                            <th>Review</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($ActiveReviewList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <input type="checkbox"
                                                                    onchange="return reviewstatus(this,'tbl_review','id','<?php echo $item->id;?>','status')" <?php if ($item->status == "true") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch"  data-color="#eb5076" data-size="small">
                                                                    
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo base_url("AdminPanel/ManageStudents/Profile/".$item->user->id) ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light p-2">
                                                                    <i class="fa fa-user-circle"></i> </a>
                                                                    <?php echo $item->user->name; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    
                                                                    <a href="<?php echo base_url("AdminPanel/ManageEBooks/Details/$item->itemid") ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light p-2">
                                                                    <i class="fa fa-eye"></i> </a>
                                                                    <?php echo $item->item->name; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->rating; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->review; ?>
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
                                            <h5> Inactive Review </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered wrap example"  style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>User</th>
                                                            <th>E-Book</th>
                                                            <th>Rating</th>
                                                            <th>Review</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            foreach ($InactiveReviewList as $item) {
                                                                
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sr; ?></td>
                                                                <td>
                                                                    <input type="checkbox"
                                                                    onchange="return reviewstatus(this,'tbl_review','id','<?php echo $item->id;?>','status')" <?php if ($item->status == "true") {
                                                                        echo "checked";
                                                                    } ?> class="js-switch"  data-color="#eb5076" data-size="small">
                                                                    
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo base_url("AdminPanel/ManageStudents/Profile/".$item->user->id) ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light p-2">
                                                                    <i class="fa fa-user-circle"></i> </a>
                                                                    <?php echo $item->user->name; ?>
                                                                    
                                                                </td>
                                                                <td>
                                                                    
                                                                    <a href="<?php echo base_url("AdminPanel/ManageEBooks/Details/$item->itemid") ?>"
                                                                    class="btn btn-sm btn-info waves-effect waves-light p-2">
                                                                    <i class="fa fa-eye"></i> </a>
                                                                    <?php echo $item->item->name; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->rating; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item->review; ?>
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
                                
                                default:
                                break;
                            }
                        }
                        
                        
                    ?>
                    
                    
                    
                    
                    <div class="overlay toggle-menu"></div>
                    
                </div>
            </div>
            <!--Modal Start-->
            <div class="modal fade" id="VerifyModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-primary">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white">Verify Payment</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Modal End-->
        <?php include("Footer.php"); ?>
        
        
    </div>
    <?php  include("FooterLinking.php");  ?>
    <?php  include("CertificateStatus.php");  ?>
    
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
    <script src="<?php base_url("assets_panel/js/index.js"); ?>"></script>
    <script>
        function VerifyPayment(id) {
        $("#VerifyModal").modal("show");
        $("#VerifyModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
        $("#VerifyModal .modal-body").load("<?php echo base_url('AdminPanel/VerifyPayment/') ?>" + id);
        }
    </script>
    <script>
        function Status(e, table, where_column, where_value, column) 
		{
			var check = $(e).prop("checked");
			if(check){
				var status = 'success';
            }
			else{
				var status = 'failed';
            }
			swal({
				text: 'Enter transaction password to update payment status.',
				content: "input",
				button: {
					text: "Submit",
					closeModal: false,
                },
            })
			.then(name => {
				if (!name) throw null;
				return fetch('<?php echo base_url("AdminPanel/TransactionPassword/")?>'+name);
            })
			.then(results => {
				return results.json();
            })
			.then(json => {
				if(json.res=='success')
				{
					$.ajax({
						url: "<?php echo base_url("AdminPanel/UpdateStatus"); ?>",
						type: "post",
						data: {
							'table': table,
							'column': column,
							'value': status,
							'where_column': where_column,
							'where_value': where_value
                        },
						success: function(response) {
							swal("Payment status updated.", { icon: "success", });
							location.reload();
                        }
                    });
                }
				else{
					swal("Invalid transaction password.", { icon: "error", });
					location.reload();
                }
				
            })
			.catch(err => {
				
				if (err) {
					swal("Enter transaction password.", { icon: "error", });
					location.reload();
					} else {
					swal.stopLoading();
					swal.close();
                }
            });
        }
        
    </script>
    
    <script>
        function StudentStatus(e, table, where_column, where_value, column) {
            var status = 'true';
            var check = $(e).prop("checked");
            if (check) {
                swal({
                    title: "Are you sure?",
                    text: "You want to activate this Student!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                    }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "<?php echo base_url("AdminPanel/UpdateStatus"); ?>",
                            type: "post",
                            data: {
                                'table': table,
                                'column': column,
                                'value': 'true',
                                'where_column': where_column,
                                'where_value': where_value
                            },
                            success: function(response) {
                                swal("This Student is activated successfully !", {
                                    icon: "success",
                                });
                                location.reload();
                            }
                        });
                    }
                });
                } else {
                swal({
                    title: "Are you sure?",
                    text: "You want to deactivate this Student!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                    }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "<?php echo base_url("AdminPanel/UpdateStatus"); ?>",
                            type: "post",
                            data: {
                                'table': table,
                                'column': column,
                                'value': 'false',
                                'where_column': where_column,
                                'where_value': where_value
                            },
                            success: function(response) {
                                swal("This Student is deactivated successfully !", {
                                    icon: "success",
                                });
                                location.reload();
                            }
                        });
                    }
                });
            }
            return status;
        }
        
        function reviewstatus(e, table, where_column, where_value, column) {
            var status = true;
            var check = $(e).prop("checked");
            if (check) {
                swal({
                    title: "Are you sure?",
                    text: "You want to activate this review !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                    }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "<?php echo base_url("AdminPanel/UpdateStatus");?>",
                            type: "post",
                            data: {
                                'table': table,
                                'column': column,
                                'value': 'true',
                                'where_column': where_column,
                                'where_value': where_value
                            },
                            success: function(response) {
                                swal("This review is activated successfully !", {
                                    icon: "success",
                                });
                            }
                        });
                    }
                });
                } else {
                swal({
                    title: "Are you sure?",
                    text: "You want to deactivate this review !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                    }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "<?php echo base_url("AdminPanel/UpdateStatus");?>",
                            type: "post",
                            data: {
                                'table': table,
                                'column': column,
                                'value': 'false',
                                'where_column': where_column,
                                'where_value': where_value
                            },
                            success: function(response) {
                                swal("This review is deactivated successfully !", {
                                    icon: "success",
                                });
                            }
                        });
                    }
                });
            }
            return status;
        }
    </script>
    
</body>

</html>                    