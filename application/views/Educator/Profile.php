<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en"> 
    <head>
        <?php include("HeaderLinking.php"); ?>
    </head>
    <body>
        <!-- start loader --> 
        <?php include("Loader.php"); ?>
        <!-- end loader -->
        <div id="wrapper"> 
                
            <?php include("Sidebar.php"); ?>
            
            <?php include("Topbar.php"); ?>
             
            <div class="clearfix"></div>
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row pt-2 pb-2">
                        <div class="col-sm-9">
                            <h4 class="page-title">Profile</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">Profile</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </div>
                        <div class="col-sm-3">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card profile-card-2">
                                <br>
                                <div class="card-body pt-5">
                                    <img src="<?php echo base_url("uploads/tutor/".$this->AuthorData->photo); ?>" alt="profile-image" class="profile">
                                    <h5 class="card-title"><?=$profile->name;?> [<?=$profile->username;?>]</h5>
                                    <h5 class="card-title"><?=$profile->designation;?>[<?=$profile->position;?>]</h5>
                                    <p class="card-text"><?=$profile->email;?></p>
                                    <p class="card-text"><?=$profile->mobile;?></p>
                                    <h6>About:</h6>
                                    <p class="card-text"><?=$profile->about;?></p>
                                </div>
                                
                                <div class="card-body border-top border-light">
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Last Login Date :</h6>
                                        </div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                                <h6 class="text-primary text-uppercase"><?=$profile->LastLoginDate;?> <?=$profile->LastLoginTime;?></h6>
                                            </div>                   
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Last Logout Date :</h6>
                                        </div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                                <h6 class="text-primary text-uppercase"><?=$profile->LastLogoutDate;?> <?=$profile->LastLogoutTime;?></h6>
                                            </div>                   
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Show All Login Activity :</h6>
                                        </div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                                <a href="<?php echo base_url('Educator/Profile/LoginActivities');?>" class=" btn btn-primary p-2"> View </a>
                                            </div>                   
                                        </div>
                                    </div>
                                    <hr>
                                    
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#profile" data-toggle="pill" class="nav-link active"><i class="icon-user"></i> <span class="hidden-xs">This Week Login Activity</span></a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-3">
                                        <div class="tab-pane active" id="profile">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="example" class="table table-bordered table-hover table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th> 
                                                                    <th>Login Details ID</th> 
                                                                    <th>IP</th> 
                                                                    <!--
                                                                        <th>MAC</th> 
                                                                    -->
                                                                    <th>USER NAME</th> 
                                                                    <th>BROWSER NAME</th> 
                                                                    <th>OS NAME</th> 
                                                                    <th>DATE</th> 
                                                                    <th>TIME</th> 
                                                                </tr>
                                                            </thead>
                                                            <tbody>  
                                                                <?php
                                                                    $srno=1;
                                                                    foreach($login_details as $item){
                                                                    ?>
                                                                    <tr>
                                                                        <td><?=$srno++;?></td>
                                                                        <td><?=$item->LoginDetailsID;?></td>
                                                                        <td><?=$item->IP;?></td>
                                                                        <!--
                                                                                        <td><?=$item->MAC;?></td>
                                                                                    -->
                                                                        <td><?=$item->UserName;?></td>
                                                                        <td><?=$item->BrowserName;?></td>
                                                                        <td><?=$item->OSName;?></td>
                                                                        <td><?=$item->Date;?></td>
                                                                        <td><?=$item->Time;?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/row-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overlay toggle-menu"></div>
                </div>
            </div>
            <?php include("Footer.php"); ?>
                                </div>
                                <?php include("FooterLinking.php"); ?>
    </body>
    
</html>    