<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    <head> 
        <title>Karmasu | Student | Profile</title>
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
                            <h4 class="page-title">Profile</h4>
                        </div>
                        <div class="col-sm-3">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card profile-card-2">
                                <div class="card-img-block">
                                    <img class="img-fluid" src="<?php echo base_url('image/karmasulogonew.png');?>" title="codersadda-logo" alt="codersadda-logo"/>
                                </div>
                                <div class="card-body pt-5">
                                    <img src="<?php if(empty($this->StudentData->profile_photo)){ echo base_url("image/karmasulogonew.png"); } else{ echo base_url("uploads/profile_photo/".$this->StudentData->profile_photo); } ?>" class="profile" title="codersadda" alt="codersadda">
                                    <h5 class="card-title"><?=$profile->name;?></h5>
                                    <p class="card-text"><?=$profile->email;?></p>
                                    <p class="card-text"><?=$profile->number;?></p>
                                </div>
                                
                                <div class="card-body border-top border-light">
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Education :</h6>
                                        </div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                                <h6 class="text-primary text-uppercase"><?=$profile->course;?></h6>
                                            </div>                   
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Address :</h6>
                                        </div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                                <h6 class="text-primary text-uppercase"><?=$profile->address;?></h6>
                                            </div>                   
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Live Sessions :</h6>
                                        </div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                                <h6 class="text-primary text-uppercase"><?=$live_session;?></h6>
                                            </div>                   
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Courses :</h6>
                                        </div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                                <h6 class="text-primary text-uppercase"><?=$courses;?></h6>
                                            </div>                   
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Books :</h6>
                                        </div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                                <h6 class="text-primary text-uppercase"><?=$books;?></h6>
                                            </div>                   
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="media align-items-center">
                                        <div>
                                            <h6>Certificates :</h6>
                                        </div>
                                        <div class="media-body text-left ml-3">
                                            <div class="progress-wrapper">
                                               <h6 class="text-primary text-uppercase"><?=$certificates;?></h6>
                                            </div>                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                         
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#profile" data-toggle="pill" class="nav-link active"><i class="fa fa-edit"></i> <span class="hidden-xs">Update Profile</span></a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-3">
                                        <div class="tab-pane active" id="profile">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <form action="<?php echo base_url("Student/Profile/Update"); ?>" method="post"
                                                        enctype="multipart/form-data" id="updateform">
                                                        
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                                            <input type="hidden" name="userid" value="<?php echo $this->StudentData->id;?>" />
                                                            <div class="form-group">
                                                                <input type="file" class="form-control dropify" name="profile_photo"  accept="image/jpg, image/png, image/jpeg, image/gif" data-height="100"  data-default-file="<?php if(empty($this->StudentData->profile_photo)){ echo base_url("image/karmasulogonew.png"); } else{ echo base_url("uploads/profile_photo/".$this->StudentData->profile_photo); } ?>">
                                                                <?php echo form_error("profile_photo", "<p class='text-danger' >", "</p>"); ?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="name" placeholder="Name"
                                                                required value="<?php echo $this->StudentData->name;?>">
                                                                <?php echo form_error("name", "<p class='text-danger' >", "</p>"); ?>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="email" placeholder="Email Address"
                                                                required value="<?php echo $this->StudentData->email;?>">
                                                                <?php echo form_error("email", "<p class='text-danger' >", "</p>"); ?>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-form-label">Education <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="education" placeholder="Education"
                                                                required value="<?php echo $this->StudentData->course;?>">
                                                                <?php echo form_error("education", "<p class='text-danger' >", "</p>"); ?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-form-label">Address <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="address" placeholder="Address"
                                                                required value="<?php echo $this->StudentData->address;?>">
                                                                <?php echo form_error("address", "<p class='text-danger' >", "</p>"); ?>
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit" id="updateaction" name="updateaction" class="btn btn-primary"><i
                                                                class="icon-lock"></i> Update Profile</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/row-->
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