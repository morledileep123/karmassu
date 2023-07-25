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
                                            <a href="javascript:void();" data-target="#profile" data-toggle="pill" class="nav-link active"><i class="fa fa-user"></i> <span class="hidden-xs">Update Profile</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#ChangePassword" data-toggle="pill" class="nav-link "><i class="fa fa-edit"></i> Change Password</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-3">
                                        <div class="tab-pane active" id="profile">
                                            <form action="<?php echo base_url("Educator/Settings/UpdateProfile"); ?>" method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                                        <input type="hidden" name="userid" value="<?php echo $this->author;?>" />
                                                        <div class="row">
                                                            <div class="form-group col-sm-6">
                                                                <label class="col-form-label">Studied At <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="studied_at" placeholder="Studied At" required value="<?=$this->AuthorData->studied_at;?>" />
                                                                <?php echo form_error("studied_at", "<p class='text-danger' >", "</p>"); ?>
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label class="col-form-label">Certifications <span class="text-danger">*</span></label>
                                                                <input  type="text" class="form-control" name="award" placeholder="Certifications" required value="<?=$this->AuthorData->award;?>" value="<?=$this->AuthorData->studied_at;?>"/>
                                                                <?php echo form_error("award", "<p class='text-danger' >", "</p>"); ?>
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label class="col-form-label">Lives In <span class="text-danger">*</span></label>
                                                                <input type="text"  class="form-control" name="lives_in" placeholder="Lives In" required value="<?=$this->AuthorData->lives_in;?>" />
                                                                <?php echo form_error("lives_in", "<p class='text-danger' >", "</p>"); ?>
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label class="col-form-label">Birthday <span class="text-danger">*</span></label>
                                                                <input type="date"  class="form-control" name="birthday" placeholder="Birthday" required value="<?=$this->AuthorData->birthday;?>" />
                                                                <?php echo form_error("birthday", "<p class='text-danger' >", "</p>"); ?>
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label class="col-form-label">Language Known <span class="text-danger">*</span></label>
                                                                <input type="text"  class="form-control" name="language_known" placeholder="Language Known" required value="<?=$this->AuthorData->language_known;?>" />
                                                                <?php echo form_error("language_known", "<p class='text-danger' >", "</p>"); ?>
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label class="col-form-label">Skills <span class="text-danger">*</span></label>
                                                                <input type="text"  class="form-control" name="skills" placeholder="Skills" required value="<?=$this->AuthorData->skills;?>" />
                                                                <?php echo form_error("skills", "<p class='text-danger' >", "</p>"); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Upload Your Profile Pic <span class="text-danger">*</span></label>
                                                            <input type="file" class="form-control dropify" name="photo"  accept="image/jpg, image/png, image/jpeg, image/gif" data-height="100"  data-default-file="<?php if(empty($this->AuthorData->photo)){  } else{ echo base_url("uploads/tutor/".$this->AuthorData->photo); } ?>">
                                                            <?php echo form_error("photo", "<p class='text-danger' >", "</p>"); ?>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-form-label">About {Bio} <span class="text-danger">*</span></label>
                                                            <textarea  class="form-control summernote" name="about" placeholder="About" required ><?=$this->AuthorData->about;?></textarea>
                                                            <?php echo form_error("about", "<p class='text-danger' >", "</p>"); ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn btn-info"  type="submit"><i class="fa fa-check-circle"></i> Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <div class="tab-pane" id="ChangePassword">
                                            <form action="<?php echo base_url("Educator/Settings/ChangePassword"); ?>" method="post" enctype="multipart/form-data" id="addform">
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
        <script>
            $('.summernote').summernote({
                height: 200,
                tabsize: 2
            });
            
        </script>
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