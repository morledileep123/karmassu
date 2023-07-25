<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo">
        <a href="<?= base_url("Student/Dashboard"); ?>">
            <!---<img src="<?php echo base_url("image/Transparent-LogoCodersAdda.png"); ?>" style="width:70%; " />---->
			<h4 class="text-warning mt-3">Karmasu</h4>
        </a> 
    </div>
    <div class="user-details"> 
        <div class="media align-items-center user-pointer collapsed" data-toggle="collapse" data-target="#user-dropdown">
            
            <div class="avatar"> 
                <img src="<?php if(empty($this->StudentData->profile_photo)){ echo base_url("image/karmasulogonew.png"); } else{ echo base_url("uploads/profile_photo/".$this->StudentData->profile_photo); } ?>" class="mr-3 side-user-img" title="user" alt="user avatar">
                
            </div>
            <div class="media-body">
                <h6 class="side-user-name"> <?php echo $this->StudentData->name; ?></h6>
            </div>
        </div>
        <div id="user-dropdown" class="collapse">
            <ul class="user-setting-menu">  
                <li><a href="<?= base_url("Student/Profile"); ?>"><i class="icon-user"></i> My Profile</a></li>
                <li><a href="<?= base_url("Student/Logout"); ?>"><i class="icon-power"></i> Logout</a></li>
            </ul>
        </div>
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?= base_url("Student/Dashboard") ?>" class="waves-effect">
                <i class="zmdi zmdi-home"></i> <span>Home</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url("Student/MyCourses") ?>" class="waves-effect">
                <i class="fa fa-tag"></i> <span>My Courses</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url("Student/MyEBooks") ?>" class="waves-effect">
                <i class="fa fa-book"></i> <span>My E-Books</span>
            </a>
        </li>
        
        <li>
            <a href="<?= base_url("Student/LiveSessions") ?>" class="waves-effect">
                <i class="fas fa-stream"></i> <span>Live Sessions</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url("Student/Search") ?>" class="waves-effect">
                <i class="fa fa-search"></i> <span>Search</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url("Student/Courses") ?>" class="waves-effect">
                <i class="fa fa-file-video-o"></i> <span>Courses</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url("Student/EBooks") ?>" class="waves-effect">
                <i class="fa fa-file-pdf-o"></i> <span>E-Books</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url("Student/Videos/RecommendedVideos") ?>" class="waves-effect">
                <i class="fas fa-video"></i> <span>Recommended Videos</span>
            </a>
        </li>
        
        <!---
        <li>
            <a href="<?= base_url("Student/Videos/FreeVideos") ?>" class="waves-effect">
                <i class="zmdi zmdi-invert-colors"></i> <span>Free Videos</span>
            </a>
        </li>
        -->
        
        <!---
        <li>
            <a href="<?= base_url("Student/Videos/ShortTricks") ?>" class="waves-effect">
                <i class="fas fa-lightbulb"></i> <span>Short Tricks/Tips</span>
            </a>
        </li>
        -->
        
        
        <li>
            <a href="<?= base_url("Student/Offers") ?>" class="waves-effect">
                <i class="fa fa-gift"></i> <span>Offers/Coupon</span>
            </a>
        </li>
        
        <li>
            <a href="<?= base_url("Student/OrderHistory") ?>" class="waves-effect">
                <i class="fa fa-history"></i> <span>Order History</span>
            </a>
        </li>
        <!--
        <li>
            <a href="<?= base_url("Student/MyCertificates") ?>" class="waves-effect">
                <i class="fa fa-certificate"></i> <span>My Certificates</span>
            </a>
        </li>
        -->
        <li>
            <a href="<?= base_url("Student/Profile") ?>" class="waves-effect">
                <i class="fa fa-user-circle"></i> <span>My Account</span>
            </a>
        </li>
    </ul>
</div>