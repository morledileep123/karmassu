<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo">
        <a href="<?= base_url("Educator/Dashboard"); ?>" style="font-size:16px;font-weight:bold;color:#f64b1a">
            <img src="<?php echo base_url("uploads/logo.png"); ?>" style="width:60px;height:60px; " /><?=$this->data->appName;?> [<?=$this->data->title;?> ]
        </a>
    </div>  
    <div class="user-details"> 
        <div class="media align-items-center user-pointer collapsed" data-toggle="collapse" data-target="#user-dropdown">
            <div class="avatar"><img class="mr-3 side-user-img" src="<?php echo base_url("uploads/tutor/".$this->AuthorData->photo); ?>" alt="user avatar"></div>
            <div class="media-body">
                <h6 class="side-user-name"> <?php echo $this->AuthorData->name; ?></h6>
            </div>
        </div>
        <div id="user-dropdown" class="collapse">
            <ul class="user-setting-menu">
                <li><a href="<?= base_url("Educator/Profile"); ?>"><i class="icon-user"></i> My Profile</a></li>
                <li><a href="<?= base_url("Educator/Settings"); ?>"><i class="icon-settings"></i> Settings</a></li>
                <li><a href="<?= base_url("Educator/Logout"); ?>"><i class="icon-power"></i> Logout</a></li>
            </ul>
        </div>
    </div>
    <ul class="sidebar-menu">
        
        <li>
            <a href="<?= base_url("Educator/Dashboard/Common"); ?>" class="waves-effect">
            <i class="bi bi-house-door"></i> <span>Dashboard</span></i>
        </a>
    </li>
    <li>
            <a href="<?= base_url("Educator/Dashboard/Sales"); ?>" class="waves-effect">
            <i class="bi bi-bar-chart-line"></i> <span>Sales Dashboard</span></i>
        </a>
    </li>
    <li>
        <a href="javaScript:void();" class="waves-effect">
            <i class="bi bi-bag-check"></i> <span>Manage Courses</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
            <li><a href="<?= base_url("Educator/ManageCourses/Add"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Add Course </a></li>
            <li><a href="<?= base_url("Educator/ManageCourses"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Course </a></li>
            <li><a href="<?= base_url("Educator/CourseEnrollments"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Course Enrollments </a></li>
        </ul>
    </li>
    <li>
        <a href="javaScript:void();" class="waves-effect">
            <i class="bi bi-book"></i> <span>Manage E-Books</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
            <li><a href="<?= base_url("Educator/ManageEBooks/Add"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Add E-Book </a></li>
            <li><a href="<?= base_url("Educator/ManageEBooks"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage E-Book </a></li>
            <li><a href="<?= base_url("Educator/EbookEnrollments"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> E-Book Enrollments </a></li>
        </ul>
    </li>
    <li>
        <a href="javaScript:void();" class="waves-effect">
            <i class="bi bi-file-earmark-music"></i> <span>Manage Audio-Books</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
            <li><a href="<?= base_url("Educator/ManageAudioBooks/Add"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Add A-Book </a></li>
            <li><a href="<?= base_url("Educator/ManageAudioBooks"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage A-Book </a></li>
            <li><a href="<?= base_url("Educator/ABookEnrollments"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> A-Book Enrollments </a></li>
        </ul>
    </li>
    <li>
        <a href="<?= base_url("Educator/ManageLiveVideo") ?>" class="waves-effect">
            <i class="bi bi-caret-up-square"></i> <span> Manage Live Sessions</span>
        </a>
    </li>
    <li>
        <a href="javaScript:void();" class="waves-effect">
            <i class="bi bi-card-checklist"></i> <span>Manage Quiz</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
            <li><a href="<?= base_url("Educator/ManageQuestions"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Questions </a></li>
            <li><a href="<?= base_url("Educator/ManageQuiz"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Quiz </a></li>
            <li><a href="<?= base_url("Educator/ScheduleQuiz"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Schedule Quiz </a></li>
        </ul>
    </li>
    <li>
        <a href="<?= base_url("Educator/Promocode") ?>" class="waves-effect">
            <i class="bi bi-gift"></i> <span>Promo Code</span>
        </a>
    </li>
    <li>
        <a href="<?= base_url("Educator/Revenue") ?>" class="waves-effect">
            <i class="bi bi-calculator"></i> <span>Revenue</span>
        </a>
    </li>
    <li>
        <a href="<?= base_url("Educator/UpdateKYC") ?>" class="waves-effect">
            <i class="bi bi-file-earmark-lock"></i> <span>Update KYC</span>
        </a>
    </li>
    <li>
        <a href="<?= base_url("Educator/Videos/RecommendedVideos") ?>" class="waves-effect">
            <i class="bi bi-camera-reels"></i> <span>Free Videos</span>
        </a>
    </li>
    <li>
        <a href="<?= base_url("Educator/Notification"); ?>" class="waves-effect">
        <i class="bi bi-bell"></i> <span> Notification</span></i>
    </a>
    <li>
        <a href="<?= base_url("Educator/Agreement"); ?>" class="waves-effect">
       <i class="bi bi-file-earmark-medical"></i> <span> Agreement</span></i>
    </a>
</li>
    <li>
        <a href="<?= base_url("Educator/CallAndSupport"); ?>" class="waves-effect">
        <i class="bi bi-info-circle"></i> <span> Call & Support</span></i>
    </a>
</li>

</ul>
</div>