<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>

<header class="topbar-nav">
    <nav id="header-setting" class="navbar navbar-expand fixed-top">
        <ul class="navbar-nav mr-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link toggle-menu" href="javascript:void();">
                    <i class="icon-menu menu-icon"></i>
                </a>
            </li>
            
        </ul>
        <ul class="navbar-nav align-items-center right-nav-link">
            <li class="nav-item app-logo-top-center" >
                <a class="nav-link" href="<?= base_url("Student/Dashboard"); ?>">
                    <img src="<?php echo base_url("image/karmasulogonew.png");?>" class="img-fluid" style="height:55px;"/>
                </a>
            </li>
            <li class="nav-item dropdown-lg">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect"  href="<?= base_url("Student/LiveSessions/List"); ?>">
                <img src="<?php echo base_url("image/live.gif");?>" class="img-fluid" style="height:25px;"/></a>
            </li> 
            <li class="nav-item dropdown-lg">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect"  href="<?= base_url("Student/Notification"); ?>">
                <i class="fas fa-bell"></i><span class="badge badge-info badge-up"><?php if($this->notificationCount>9){ echo '9+'; } else{  echo $this->notificationCount;}?></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                    <span class="user-profile"><img src="<?php if(empty($this->StudentData->profile_photo)){ echo  base_url("image/karmasulogonew.png"); } else{ echo base_url("uploads/profile_photo/".$this->StudentData->profile_photo); } ?>" class="img-circle" alt="user avatar"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item user-details">
                        <a href="Profile">
                            <div class="media">
                                <div class="avatar">
                                    <img src="<?php if(empty($this->StudentData->profile_photo)){ echo base_url("image/karmasulogonew.png"); } else{ echo base_url("uploads/profile_photo/".$this->StudentData->profile_photo); } ?>" class="align-self-start mr-3" alt="user avatar">
                                    
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-2 user-title"><?php echo $this->StudentData->name; ?></h6>
                                    <p class="user-subtitle"><?php echo $this->StudentData->number; ?></p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <a href="<?= base_url("Student/Profile"); ?>"><li class="dropdown-item"><i class="icon-user mr-2"></i> Profile</li></a>
                    <li class="dropdown-divider"></li>
                    <a href="<?= base_url("Student/Logout"); ?>"><li class="dropdown-item"><i class="icon-power mr-2"></i> Logout </li></a>
                </ul>
            </li>
        </ul>
    </nav>
</header>
<!--End topbar header-->