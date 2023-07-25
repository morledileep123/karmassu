<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>

<!--Start topbar header-->
<header class="topbar-nav">
    <nav id="header-setting" class="navbar navbar-expand fixed-top">
        <ul class="navbar-nav mr-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link toggle-menu" href="javascript:void();">
                    <i class="icon-menu menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                 
                
                <!--
                    <form class="search-bar">
                    <input type="text" class="form-control" placeholder="Enter keywords">
                    <a href="javascript:void();"><i class="icon-magnifier"></i></a>
                    </form>
                -->
                
            </li>
        </ul>
        
        
        <ul class="navbar-nav align-items-center right-nav-link">
            <li class="nav-item dropdown-lg">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect"  href="<?= base_url("Educator/Notification"); ?>">
                <i class="bi bi-bell"></i><span class="badge badge-info badge-up"><?php if($this->notificationCount>9){ echo '9+'; } else{  echo $this->notificationCount;}?></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                    <span class="user-profile"><img src="<?php echo base_url("image/karmasulogonew.png"); ?>" class="img-circle" alt="user avatar"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item user-details">
                        <a href="Profile">
                            <div class="media">
                                <div class="avatar"><img class="align-self-start mr-3" src="<?php echo base_url("uploads/tutor/".$this->AuthorData->photo); ?>" alt="user avatar"></div>
                                <div class="media-body">
                                    <h6 class="mt-2 user-title"><?php echo $this->AuthorData->name; ?></h6>
                                    <p class="user-subtitle"><?php echo $this->AuthorData->email; ?></p>
                                    <p class="user-subtitle"><?php echo $this->AuthorData->mobile; ?></p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <a href="<?= base_url("Educator/Profile"); ?>"><li class="dropdown-item"><i class="icon-user mr-2"></i> Account</li></a>
                    <li class="dropdown-divider"></li>
                    <a href="<?= base_url("Educator/Settings"); ?>"><li class="dropdown-item"><i class="icon-settings mr-2"></i> Settings</li></a>
                    <li class="dropdown-divider"></li>
                    <a href="<?= base_url("Educator/Logout"); ?>"><li class="dropdown-item"><i class="icon-power mr-2"></i> Logout </li></a>
                </ul>
            </li>
        </ul>
    </nav>
</header>
<!--End topbar header-->