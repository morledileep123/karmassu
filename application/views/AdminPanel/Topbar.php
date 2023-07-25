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
        
            <!--
            <li class="nav-item dropdown-lg">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" href="">
                <i class="fas fa-envelope"></i><span class="badge badge-primary badge-up"><?php if($this->enrollCount>9){ echo '9+'; } else{  echo $this->enrollCount;}?></span></a>
            </li>
            <li class="nav-item dropdown-lg">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
                <i class="fas fa-bell"></i><span class="badge badge-info badge-up">3</span></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            You have 3 Notifications
                            <span class="badge badge-info">3</span>
                        </li>
                        <?php
                            for ($i = 1; $i <= 3; $i++) {
                            ?>
                            <li class="list-group-item">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <i class="zmdi zmdi-accounts fa-2x mr-3 text-info"></i>
                                        <div class="media-body">
                                            <h6 class="mt-0 msg-title">New Registered Users</h6>
                                            <p class="msg-info"></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php
                            }
                        ?>
                        
                        <li class="list-group-item text-center"><a href="javaScript:void();">See All
                        Notifications</a></li>
                    </ul>
                </div>
            </li>
            -->
            
            
            <li class="nav-item">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                    <span class="user-profile"><img src="<?php echo base_url("image/karmasulogonew.png"); ?>" class="img-circle" alt="user avatar"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item user-details">
                        <a href="Profile">
                            <div class="media">
                                <div class="avatar"><img class="align-self-start mr-3" src="<?php echo base_url("uploads/user.png"); ?>" alt="user avatar"></div>
                                <div class="media-body">
                                    <h6 class="mt-2 user-title"><?php echo $this->session->userdata("AdminLoginData")[0]["Name"]; ?></h6>
                                    <p class="user-subtitle"><?php echo $this->session->userdata("AdminLoginData")[0]["Email"]; ?></p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <a href="<?= base_url("AdminPanel/Profile"); ?>"><li class="dropdown-item"><i class="icon-user mr-2"></i> Account</li></a>
                    <li class="dropdown-divider"></li>
                    <a href="<?= base_url("AdminPanel/Settings"); ?>"><li class="dropdown-item"><i class="icon-settings mr-2"></i> Settings</li></a>
                    <li class="dropdown-divider"></li>
                    <a href="<?= base_url("AdminPanel/Logout"); ?>"><li class="dropdown-item"><i class="icon-power mr-2"></i> Logout </li></a>
                </ul>
            </li>
        </ul>
    </nav>
</header>
<!--End topbar header-->