<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo">
        <a href="<?= base_url("AdminPanel/Dashboard"); ?>" style="font-size:16px;font-weight:bold;color:#f64b1a">
            <img src="<?php echo base_url("uploads/logo.png"); ?>" style="width:60px;height:60px; " /><?=$this->data->appName;?> [<?=$this->data->title;?> ]
        </a>
    </div>  
    <div class="user-details"> 
        <div class="media align-items-center user-pointer collapsed" data-toggle="collapse" data-target="#user-dropdown">
            <div class="avatar"><img class="mr-3 side-user-img" src="<?php echo base_url("uploads/user.png"); ?>" alt="user avatar"></div>
            <div class="media-body">
                <h6 class="side-user-name"> <?php echo $this->session->userdata("AdminLoginData")[0]["Name"]; ?></h6>
            </div>
        </div>
        <div id="user-dropdown" class="collapse">
            <ul class="user-setting-menu">
                <li><a href="<?= base_url("AdminPanel/Profile"); ?>"><i class="icon-user"></i> My Profile</a></li>
                <li><a href="<?= base_url("AdminPanel/Settings"); ?>"><i class="icon-settings"></i> Settings</a></li>
                <li><a href="<?= base_url("AdminPanel/Logout"); ?>"><i class="icon-power"></i> Logout</a></li>
            </ul>
        </div>
    </div>
    <ul class="sidebar-menu">
        
        <li>
            <a href="<?= base_url("AdminPanel/Dashboard/Common"); ?>" class="waves-effect">
            <i class="bi bi-house-door"></i> <span>Dashboard</span></i>
        </a>
        <!--
            <ul class="sidebar-submenu">
            <li><a href="<?= base_url("AdminPanel/Dashboard/Common"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Common  Dashboard </a></li>
            <li><a href="<?= base_url("AdminPanel/Dashboard/Sales"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Sales Dashboard </a></li>
            <li><a href="<?= base_url("AdminPanel/Dashboard/Student"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Student Dashboard </a></li>
            <li><a href="<?= base_url("AdminPanel/Dashboard/Course"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Course Dashboard </a></li>
            <li><a href="<?= base_url("AdminPanel/Dashboard/Ebook"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> E-Book Dashboard </a></li>
            </ul>
        -->
    </li>
    <li>
        <a href="javaScript:void();" class="waves-effect">
            <i class="bi bi-file-person"></i> <span>Manage Educators</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
            <li><a href="<?= base_url("AdminPanel/ManageTutors"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Educators </a></li>
            <li><a href="<?= base_url("AdminPanel/ManageKYC"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage KYC </a></li>
            <li><a href="<?= base_url("AdminPanel/ManageAgreement"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Agreement </a></li>
        </ul>
    </li>
    <li>
        <a href="<?= base_url("AdminPanel/ManageStudents") ?>" class="waves-effect">
            <i class="bi bi-people"></i> <span>Manage Students</span>
        </a>
    </li>
    
    <li>
        <a href="javaScript:void();" class="waves-effect">
            <i class="bi bi-bag-check"></i> <span>Manage Courses</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
            <li><a href="<?= base_url("AdminPanel/ManageCourses/Add"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Add Course </a></li>
            <li><a href="<?= base_url("AdminPanel/ManageCourses"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Course </a></li>
            <li><a href="<?= base_url("AdminPanel/CourseEnrollments"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Course Enrollments </a></li>
            <li><a href="<?= base_url("AdminPanel/TrendingAppCourses") ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Trending Courses</a></li>
            <li><a href="<?= base_url("AdminPanel/TopAppCourses") ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Top Courses</a></li>
        </ul>
    </li>
    <li>
        <a href="javaScript:void();" class="waves-effect">
            <i class="bi bi-book"></i> <span>Manage E-Books</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
            <li><a href="<?= base_url("AdminPanel/ManageEBooks/Add"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Add E-Book </a></li>
            <li><a href="<?= base_url("AdminPanel/ManageEBooks"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage E-Book </a></li>
            <li><a href="<?= base_url("AdminPanel/EbookEnrollments"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> E-Book Enrollments </a></li>
        </ul>
    </li>
    <li>
        <a href="javaScript:void();" class="waves-effect">
            <i class="bi bi-file-earmark-music"></i> <span>Manage Audio-Books</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
            <li><a href="<?= base_url("AdminPanel/ManageAudioBooks/Add"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Add A-Book </a></li>
            <li><a href="<?= base_url("AdminPanel/ManageAudioBooks"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage A-Book </a></li>
            <li><a href="<?= base_url("AdminPanel/ABookEnrollments"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> A-Book Enrollments </a></li>
        </ul>
    </li>
    <li>
        <a href="javaScript:void();" class="waves-effect">
            <i class="bi bi-card-checklist"></i> <span>Manage Quiz</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
            <li><a href="<?= base_url("AdminPanel/ManageQuestions"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Questions </a></li>
            <li><a href="<?= base_url("AdminPanel/ManageQuiz"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Quiz </a></li>
            <li><a href="<?= base_url("AdminPanel/ScheduleQuiz"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Schedule Quiz </a></li>
        </ul>
    </li>
    <li>
        <a href="<?= base_url("AdminPanel/ManageLiveVideo") ?>" class="waves-effect">
            <i class="bi bi-caret-up-square"></i> <span>Manage Live Sessions</span>
        </a>
    </li>
    <!--
        <li>
        <a href="javaScript:void();" class="waves-effect">
        <i class="bi bi-camera-video"></i> <span>Manage Videos</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
        <li><a href="<?= base_url("AdminPanel/ManageVideos"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Videos </a></li>
        <!-- <li><a href="<?= base_url("AdminPanel/VideoPerformance"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Video Performance </a></li> --><!--
        <li><a href="<?= base_url("AdminPanel/ManageVideoAssignments"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Video Assignments </a></li>
        <li><a href="<?= base_url("AdminPanel/ManageSubjects"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Subjects </a></li>
        </ul>
        </li>
    -->
    <li>
        <a href="<?= base_url("AdminPanel/ManageCategories"); ?>" class="waves-effect ">
            <i class="bi bi-collection"></i> <span>Manage Categories</span>
        </a>
    </li>

    <li>
        <a href="<?= base_url("AdminPanel/ShopCategories"); ?>" class="waves-effect ">
            <i class="bi bi-collection"></i> <span>Manage Shop Categories</span>
        </a>
    </li>
    
    <li>
        <a href="<?= base_url("AdminPanel/ManageSpirituality"); ?>" class="waves-effect ">
            <i class="bi bi-collection"></i> <span>Manage Spiritualities</span>
        </a>
    </li>

    <li>
        <a href="<?= base_url("AdminPanel/ManageSubjects"); ?>" class="waves-effect ">
            <i class="bi bi-card-checklist"></i><span>Manage Subjects</span>
        </a>
    </li>
    
    
    
    <!--
        <li>
        <a href="javaScript:void();" class="waves-effect">
        <i class="fa fa-certificate"></i> <span>Manage Certificates</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
        <li><a href="<?= base_url("AdminPanel/ManageCertificates/Requested"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Requested Certificates </a></li>
        <li><a href="<?= base_url("AdminPanel/ManageCertificates/Issued"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Issued Certificates </a></li>
        <li><a href="<?= base_url("AdminPanel/ManageCertificates/NonIssued"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Non-Issued Certificates </a></li>
        <li><a href="<?= base_url("AdminPanel/ManageCertificates/NewOrders"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i>New Orders</a></li>
        <li><a href="<?= base_url("AdminPanel/ManageCertificates/RunningOrders"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i>Running Orders</a></li>
        <li><a href="<?= base_url("AdminPanel/ManageCertificates/DeliveredOrders"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i>Delivered Orders</a></li>
        <li><a href="<?= base_url("AdminPanel/ManageCertificates/PendingOrders"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i>Pending Orders</a></li>
        <li><a href="<?= base_url("AdminPanel/ManageCertificates/SuccessOrders"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i>Success Orders</a></li>
        <li><a href="<?= base_url("AdminPanel/ManageCertificates/FailedOrders"); ?>"><i class="zmdi zmdi-dot-circle-alt"></i>Failed Orders</a></li>
        </ul>
        </li>
    -->
    
    
    
    
    
    <li>
        <a href="<?= base_url("AdminPanel/RecommendedVideos") ?>" class="waves-effect">
            <i class="bi bi-camera-reels"></i> <span>Free Videos</span>
        </a>
    </li>
    <!--
        <li>
        <a href="<?= base_url("AdminPanel/FreeAndShortVideos") ?>" class="waves-effect">
        <i class="fas fa-lightbulb"></i> <span>Free & Short Tricks</span>
        </a>
        </li> 
    -->
    <li>
        <a href="<?= base_url("AdminPanel/ManageOffers") ?>" class="waves-effect">
            <i class="bi bi-gift"></i> <span>Manage Offers/Coupons</span>
        </a>
    </li>
    <li>
        <a href="<?= base_url("AdminPanel/ManageNotification") ?>" class="waves-effect">
            <i class="bi bi-bell"></i> <span>Manage Notification</span>
        </a>
    </li>
    <li>
        <a href="<?= base_url("AdminPanel/AppSplashScreen") ?>" class="waves-effect">
            <i class="bi bi-file-earmark-image-fill"></i> <span>App Splash Screen</span>
        </a>
    </li>
    <li>
        <a href="<?= base_url("AdminPanel/ManageAppSliders") ?>" class="waves-effect">
            <i class="bi bi-file-image"></i> <span>Manage Sliders</span>
        </a>
    </li>
    <li>
        <a href="javaScript:void();" class="waves-effect">
            <i class="bi bi-globe"></i>
            <span>Content Management</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
            <!--<li><a href="<?= base_url("AdminPanel/ManageSliders") ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Sliders</a></li>-->
            <li><a href="<?= base_url("AdminPanel/ManageTestimonials") ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Testimonials</a></li>
            <!-- <li><a href="<?= base_url("AdminPanel/ManageTeam") ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Team</a></li> -->
            <li><a href="<?= base_url("AdminPanel/ManageBlog") ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Blogs</a></li>
            <li><a href="<?= base_url("AdminPanel/ManageFAQ") ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage FAQ</a></li>
            <li><a href="<?= base_url("AdminPanel/ManageContacts") ?>"><i class="zmdi zmdi-dot-circle-alt"></i> Manage Contacts</a></li>
        </ul>
    </li>
    
    
</ul>
</div>