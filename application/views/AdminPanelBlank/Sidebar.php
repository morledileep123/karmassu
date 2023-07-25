<?php
defined("BASEPATH") or exit("No direct scripts allowed here");
?>

<!--Start sidebar-wrapper-->
        <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
            <div class="brand-logo">
                <a href="<?= base_url("AdminPanel/Dashboard"); ?>">
                    <img src="<?php echo base_url("image/Transparent-LogoCodersAdda.png"); ?>" style="width:70%; " />
                </a>
            </div>
            <div class="user-details">
                <div class="media align-items-center user-pointer collapsed" data-toggle="collapse"
                    data-target="#user-dropdown">
                    <div class="avatar"><img class="mr-3 side-user-img" src="<?php echo base_url("image/LogoCodersAdda1.png"); ?>"
                            alt="user avatar"></div>
                    <div class="media-body">
                        <h6 class="side-user-name">CodersAdda Student</h6>
                    </div>
                </div>
                <div id="user-dropdown" class="collapse">
                    <ul class="user-setting-menu">
                        <li><a href="javaScript:void();"><i class="icon-user"></i> My Profile</a></li>
                        <li><a href="javaScript:void();"><i class="icon-settings"></i> Setting</a></li>
                        <li><a href="javaScript:void();"><i class="icon-power"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
            <ul class="sidebar-menu">
                <!-- <li class="sidebar-header">MAIN NAVIGATION</li> -->
                
                <li>
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span><i
                            class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="<?= base_url("AdminPanel/Dashboard") ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Main Dashboard </a></li>
                        <li><a href="#"><i class="zmdi zmdi-dot-circle-alt"></i> Course Dashboard </a></li>
                        <li><a href="#"><i class="zmdi zmdi-dot-circle-alt"></i> Sales Dashboard </a></li>
                        <li><a href="#"><i class="zmdi zmdi-dot-circle-alt"></i> Student Dashboard </a></li>
                    </ul>
                </li>

                <li>
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="zmdi zmdi-view-dashboard"></i> <span>Courses</span><i
                            class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="#"><i class="zmdi zmdi-dot-circle-alt"></i> Add Course </a></li>
                        <li><a href="#"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Course </a></li>
                        <li><a href="#"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Offers </a></li>
                        <li><a href="#"><i class="zmdi zmdi-dot-circle-alt"></i> Course Contents </a></li>
                        <li><a href="#"><i class="zmdi zmdi-dot-circle-alt"></i> Course Enrollments </a></li>
                    </ul>
                </li>

                <li>
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="zmdi zmdi-view-dashboard"></i> <span>Videos</span><i
                            class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="#"><i class="zmdi zmdi-dot-circle-alt"></i> Add Video </a></li>
                        <li><a href="#"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Videos </a></li>
                        <li><a href="#"><i class="zmdi zmdi-dot-circle-alt"></i> Video Performance </a></li>
                        <li><a href="#"><i class="zmdi zmdi-dot-circle-alt"></i> Video Assignments </a></li>
                    </ul>
                </li>


                <!--
                <li>
                    <a href="calendar.html" class="waves-effect">
                        <i class="zmdi zmdi-calendar-check"></i> <span>Calendar</span>
                        <small class="badge float-right badge-light">New</small>
                    </a>
                </li>
                <li>
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="zmdi zmdi-invert-colors"></i> <span>UI Icons</span>
                        <i class="fa fa-angle-left float-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="icons-font-awesome.html"><i class="zmdi zmdi-dot-circle-alt"></i> Font Awesome</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="zmdi zmdi-email"></i>
                        <span>Mailbox</span>
                        <small class="badge float-right badge-warning">12</small>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="mail-inbox.html"><i class="zmdi zmdi-dot-circle-alt"></i> Inbox</a></li>
                    </ul>
                </li>

                <li class="sidebar-header">LABELS</li>
                <li>
                    <a href="javaScript:void();" class="waves-effect"><i class="zmdi zmdi-coffee text-danger"></i>
                        <span>Important</span></a>
                </li>
                -->

            </ul>

        </div>
        <!--End sidebar-wrapper-->