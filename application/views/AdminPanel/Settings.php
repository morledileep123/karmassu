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
                            <h4 class="page-title">Settings</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">Settings</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Settings</li>
                            </ol>
                        </div>
                        <div class="col-sm-3">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card profile-card-2">
                                <div class="card-img-block">
                                    <img class="img-fluid" src="<?php echo base_url('uploads/logo.png');?>" >
                                </div>
                                <div class="card-body pt-5">
                                    <img src="<?php echo base_url('uploads/user.png');?>" alt="profile-image" class="profile">
                                    <h5 class="card-title"><?=$profile->Name;?></h5>
                                    <p class="card-text"><?=$profile->Email;?></p>
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
                                    
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#NeedHelp" data-toggle="pill" class="nav-link active"><i class="fa  fa-question-circle"></i> Need Help Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#ChangePassword" data-toggle="pill" class="nav-link"><i class="fa fa-edit"></i> Change Password</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#TransactionPassword" data-toggle="pill" class="nav-link"><i class="fa fa-check-circle"></i> Transaction Password</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-3">
                                         <div class="tab-pane active" id="NeedHelp">
                                            <form action="<?php echo base_url("AdminPanel/Settings/NeedHelp"); ?>" method="post" enctype="multipart/form-data"">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Mobile No <span class="text-danger">*</span></label>
                                                            <input type="number" name="help_mobile" class="form-control" placeholder="Enter Need Help Mobile No" data-parsley-minlength="10" data-parsley-maxlength="10" required value="<?=$profile->help_mobile;?>">
                                                            <?php echo form_error("help_mobile","<p class='text-danger' >","</p>"); ?>
                                                        </div>   
                                                       <div class="form-group">
                                                            <label>Email Address <span class="text-danger">*</span></label>
                                                            <input type="email" name="help_email" class="form-control" placeholder="Enter Need Help Email Address" required value="<?=$profile->help_email;?>">
                                                            <?php echo form_error("help_email","<p class='text-danger' >","</p>"); ?>
                                                        </div>  
                                                        <div class="form-group">
                                                            <button class="btn btn-info"  name="addaction" type="submit"><i class="fa fa-check-circle"></i> Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="ChangePassword">
                                            <form action="<?php echo base_url("AdminPanel/Settings/ChangePassword"); ?>" method="post" enctype="multipart/form-data" id="addform">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Current Password <span class="text-danger">*</span></label>
                                                            <input type="password" name="opass" class="form-control" placeholder="Current Password" data-parsley-minlength="6" data-parsley-minlength-message="Password must be at least 6 characters long." required>
                                                            <?php echo form_error("opass","<p class='text-danger' >","</p>"); ?>
                                                        </div>   
                                                        <div class="form-group">
                                                            <label>New Password <span class="text-danger">*</span></label>
                                                            <input type="password" id="npass" name="npass" class="form-control" placeholder="New Password" data-parsley-minlength="6" data-parsley-minlength-message="Password must be at least 6 characters long." required>
                                                            <?php echo form_error("npass","<p class='text-danger' >","</p>"); ?>
                                                        </div> 
                                                        <div class="form-group">
                                                            <label>Confirm Password <span class="text-danger">*</span></label>
                                                            <input type="password" name="cpass" class="form-control" placeholder="Confirm Password" data-parsley-minlength="6" data-parsley-minlength-message="Password must be at least 6 characters long." data-parsley-equalTo="#npass" data-parsley-equalTo-message="New and Confirm Password are not match." required>
                                                            <?php echo form_error("cpass","<p class='text-danger' >","</p>"); ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn btn-info"  id="addaction" name="addaction" type="submit"><i class="fa fa-check-circle"></i> Change</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <div class="tab-pane" id="TransactionPassword">
                                            <form action="<?php echo base_url("AdminPanel/Settings/TransactionPassword"); ?>" method="post" enctype="multipart/form-data" >
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Current Password <span class="text-danger">*</span></label>
                                                            <input type="password" name="opass" class="form-control" placeholder="Current Password" data-parsley-minlength="6" data-parsley-minlength-message="Password must be at least 6 characters long." required>
                                                            <?php echo form_error("opass","<p class='text-danger' >","</p>"); ?>
                                                        </div>   
                                                        <div class="form-group">
                                                            <label>New Password <span class="text-danger">*</span></label>
                                                            <input type="password" id="tnpass" name="npass" class="form-control" placeholder="New Password" data-parsley-minlength="6" data-parsley-minlength-message="Password must be at least 6 characters long." required>
                                                            <?php echo form_error("npass","<p class='text-danger' >","</p>"); ?>
                                                        </div> 
                                                        <div class="form-group">
                                                            <label>Confirm Password <span class="text-danger">*</span></label>
                                                            <input type="password" name="cpass" class="form-control" placeholder="Confirm Password" data-parsley-minlength="6" data-parsley-minlength-message="Password must be at least 6 characters long." data-parsley-equalTo="#tnpass" data-parsley-equalTo-message="New and Confirm Password are not match." required>
                                                            <?php echo form_error("cpass","<p class='text-danger' >","</p>"); ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn btn-info"   name="addaction" type="submit"><i class="fa fa-check-circle"></i> Change</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
        <?php
            if ($this->session->flashdata("res") == "error") {
            ?>
            <script>
                $(document).ready(function() {
                    Lobibox.notify('warning', {
                        pauseDelayOnHover: true,
                        size: 'mini',
                        rounded: true,
                        delayIndicator: false,
                        icon: 'fa fa-exclamation-circle',
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        msg: '<?php echo $this->session->flashdata("msg");?>'
                    });
                })
            </script>
            <?php
                } else if ($this->session->flashdata("res") == "success") {
            ?>
            <script>
                $(document).ready(function() {
                    Lobibox.notify('success', {
                        pauseDelayOnHover: true,
                        size: 'mini',
                        rounded: true,
                        icon: 'fa fa-check-circle',
                        delayIndicator: false,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        msg: '<?php echo $this->session->flashdata("msg");?>'
                    });
                });
            </script>
            <?php
                } else if ($this->session->flashdata("res") == "upload_error") {
            ?>
            <script>
                $(document).ready(function() {
                    Lobibox.notify('error', {
                        pauseDelayOnHover: true,
                        size: 'mini',
                        rounded: true,
                        delayIndicator: false,
                        icon: 'fa fa-times-circle',
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        msg: '<?php echo $this->session->flashdata("msg");?>'
                    });
                });
            </script>
            <?php
            }
        ?>
    </body>
    
</html>    