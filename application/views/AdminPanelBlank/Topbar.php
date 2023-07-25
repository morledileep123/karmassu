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
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown"
                            href="javascript:void();">
                            <i class="fa fa-envelope-open-o"></i><span
                                class="badge badge-primary badge-up">12</span></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    You have 12 new messages
                                    <span class="badge badge-primary">12</span>
                                </li>

                                <?php 
                                for($i=1;$i<=5;$i++)
                                {
                                ?>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <div class="avatar"><img class="align-self-start mr-3"
                                                    src="<?= base_url("assets_panel/images/avatars/avatar-8.png"); ?>" alt="user avatar"></div>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">Katrina Mccoy</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet.</p>
                                                <small>1/11/2018, 2:50 PM</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <?php
                                }
                                ?>

                                <li class="list-group-item text-center"><a href="javaScript:void();">See All
                                        Messages</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown-lg">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown"
                            href="javascript:void();">
                            <i class="fa fa-bell-o"></i><span class="badge badge-info badge-up">14</span></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    You have 14 Notifications
                                    <span class="badge badge-info">14</span>
                                </li>
                                <?php
                                for($i=1;$i<=3;$i++)
                                {
                                ?>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <i class="zmdi zmdi-accounts fa-2x mr-3 text-info"></i>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">New Registered Users</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet...</p>
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
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                            <span class="user-profile"><img src="<?php echo base_url("image/LogoCodersAdda1.png"); ?>" class="img-circle"
                                    alt="user avatar"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item user-details">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <div class="avatar"><img class="align-self-start mr-3"
                                                src="<?php echo base_url("image/LogoCodersAdda1.png"); ?>" alt="user avatar"></div>
                                        <div class="media-body">
                                            <h6 class="mt-2 user-title">Student</h6>
                                            <p class="user-subtitle">student@gmail.com</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-user mr-2"></i> Account</li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-power mr-2"></i> Logout</li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        <!--End topbar header-->