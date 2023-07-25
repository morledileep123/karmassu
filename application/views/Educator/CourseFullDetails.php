<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
    // var_dump($author[0]);
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
        
        <!-- Start wrapper-->
        <div id="wrapper">
            
            <?php include("Sidebar.php"); ?>
            
            <?php include("Topbar.php"); ?>
            
            <div class="clearfix"></div>
            
            <div class="content-wrapper">
                <div class="container-fluid">
                    
                    <!-- Breadcrumb-->
                    <div class="row pt-2 pb-2">
                        <div class="col-sm-9">
                            <h4 class="page-title"> Full Details of Course</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">Courses</a></li>
                                <li class="breadcrumb-item"><a href="javaScript:void();">Manage Courses</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Detail</li>
                            </ol>
                        </div>
                        <div class="col-sm-3">
                            
                        </div>
                    </div>
                    <!-- End Breadcrumb-->
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <img src="../../../uploads/course/<?php echo $list[0]->banner; ?>" class="img-fluid" />
                                            
                                        </div>
                                        <div class="col-sm-12 p-2">
                                            <img src="../../../uploads/course/<?php echo $list[0]->logo; ?>" class="img-fluid mr-3 img-thumbnail" style="width:80px;" />
                                            <h5 style="display:inline-block;" class="mt-3"> <?php echo $list[0]->name; ?> </h5>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-money text-primary"></i> 
                                                <?php
                                                    if ($list[0]->type == "Paid") {
                                                    ?>
                                                    <span class="p-2 text-danger">Paid</span>
                                                    <?php
                                                        if (empty($list[0]->offerprice)) {
                                                        ?>
                                                        <i class="fa fa-rupee"></i> <?php echo $list[0]->price; ?>
                                                        <?php
                                                            } else {
                                                        ?>
                                                        <s><i class="fa fa-rupee"></i> <?php echo $list[0]->price; ?></s>
                                                        <i class="fa fa-rupee"></i> <?php echo $list[0]->offerprice; ?>
                                                        <button class="btn btn-sm p-1 btn-primary"><?php echo str_replace('Off','',$list[0]->discountpercent); ?>OFF</button>
                                                        <?php
                                                        }
                                                        } else {
                                                    ?>
                                                    <span class="p-2 text-success">Free</span>
                                                    <?php
                                                    }
                                                ?>
                                            </strong></p>
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-user-circle text-primary"></i> <?php echo $author[0]->name; ?> </strong></p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-list-alt text-primary"></i> <?php echo $category[0]->title; ?> </strong></p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-clock-o text-primary"></i> <?php echo $list[0]->daystofinish; ?> Days To Finish</strong></p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-book text-primary"></i> <?php echo $list[0]->nooflecture; ?> Lectures</p></strong>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-universal-access text-primary"></i> Full Lifetime Access</p></strong>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-certificate text-primary"></i> 
                                                <?php 
                                                    if($list[0]->certification == "Yes"){
                                                        echo 'Certification';
                                                    ?>
                                                    <p> <a href="<?php echo base_url("Educator/ManageCourses/Certificate/".$list[0]->id) ?>" target="_blank" class="text-info">View Certificate</a></p>
                                                    <p>Certificate Hardcopy Charge: <i class="fa fa-inr"></i> <?php echo $list[0]->certificate_charge; ?></p>
                                                    <p>Per KM Delivery Charge: <i class="fa fa-inr"></i> <?php echo $list[0]->km_charge; ?>  </p>
                                                    <?php
                                                    }
                                                    else{
                                                        echo 'No Certification';
                                                    }
                                                    
                                                ?>
                                            </p></strong>
                                        </div>
                                        <div class="col-sm-12">
                                            
                                            <input type="checkbox"
                                            onchange="return coursestatus(this,'tbl_course','id','<?php echo $list[0]->id;?>','apprstatus')" <?php if ($list[0]->apprstatus == "true") {
                                                echo "checked";
                                            } ?> class="js-switch"  data-color="#eb5076" data-size="small">
                                            <a href="<?php echo base_url("Educator/ManageCourses/Edit/".$list[0]->id) ?>"
                                            class="btn btn-sm btn-primary waves-effect waves-light">
                                            <i class="fa fa fa-edit"></i>  </a>
                                            <a href="javascript:void(0);"
                                            class="btn btn-sm btn-danger waves-effect waves-light"
                                            onclick="return coursedelete(this,'tbl_course','id','<?php echo $list[0]->id;?>','course','logo,banner')">
                                            <i class="fa fa-trash"></i> </a>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <!-- Manage Courses Card End -->
                            
                        </div>
                        <div class="col-sm-8">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                                        <li class="nav-item ">
                                            <a href="javascript:void();" data-target="#lecture" data-toggle="pill" class="nav-link active">Lectures</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a href="javascript:void();" data-target="#description" data-toggle="pill" class="nav-link">Description</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#requirement" data-toggle="pill" class="nav-link">Requirement</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#include" data-toggle="pill" class="nav-link">Include</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#will_learn" data-toggle="pill" class="nav-link">Will Learn</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-3">
                                        <div class="tab-pane active" id="lecture">
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#AddModal"><i
                                            class="fa fa-plus-circle"></i> Add Lecture</button><br><br>
                                            <div class="table-responsive">
                                                
                                                <table class="table table-bordered wrap" id="example">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Lecture No</th>
                                                            <th>Subject</th>
                                                            <th>Title</th>
                                                            <th>Duration</th>
                                                            <th>Thumbnail</th>
                                                            <th>Video</th>
                                                            <th>Description</th>
                                                            <th>Notes</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            if(count($lecture)){
                                                                foreach ($lecture as $item) {
                                                                ?>
                                                                <tr>
                                                                    
                                                                    <td>
                                                                        <a href="<?php echo base_url('Educator/VideoPlaylist/'.$list[0]->id.'/'.$item->video[0]->id); ?>" class="btn btn-info btn-sm"> <i class="fa fa-play-circle"></i> Play</a>
                                                                        <input type="checkbox"
                                                                        onchange="return Status(this,'tbl_lecture','id','<?php echo $item->id; ?>','status')"
                                                                        <?php if ($item->status == "true") {
                                                                            echo "checked";
                                                                        }  ?> class="js-switch"
                                                                        data-color="#eb5076" data-size="small">
                                                                        
                                                                        <br>
                                                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#AddAssignmentModal" onclick="AddAssignment('<?=$item->video[0]->id;?>')"><i
                                                                        class="fa fa-plus-circle"></i> Assignment</button>
                                                                        
                                                                        <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger p-1"
                                                                        onclick="return Delete(this,'tbl_lecture','id','<?php echo $item->id; ?>','','')">
                                                                        <i class="bi bi-trash"></i> Delete</a>
                                                                        
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item->lecture_no; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item->subject[0]->name; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item->video[0]->title; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item->video[0]->duration; ?>
                                                                    </td>
                                                                    
                                                                    
                                                                    <td>
                                                                        <label data-toggle="tooltip" data-placement="top"
                                                                        title="ID: <?php echo $item->video[0]->id; ?>"><a
                                                                            href="<?php echo base_url("uploads/thumbnail/".$this->session->userdata("EducatorLoginData")[0]["username"]."/".$item->video[0]->thumbnail); ?>"
                                                                            target="_blank"><img
                                                                                data-src="<?php echo base_url("uploads/thumbnail/".$this->session->userdata("EducatorLoginData")[0]["username"]."/".$item->video[0]->thumbnail); ?>"
                                                                                src="<?php echo base_url("images/Preloader2.jpg"); ?>"
                                                                            class="lazy" style="height:50px;" /> </a></label>
                                                                    </td>
                                                                    <td> 
                                                                        <?php
                                                                            if($item->video[0]->type=='Internal'){
                                                                            ?>
                                                                            <a
                                                                            href="<?php echo base_url("uploads/video/".$this->session->userdata("EducatorLoginData")[0]["username"].'/'.$item->video[0]->video); ?>"
                                                                            target="_blank">
                                                                                <video controls src="<?php echo base_url("uploads/video/".$this->session->userdata("EducatorLoginData")[0]["username"]."/".$item->video[0]->video); ?>" style="height:100px;" ></video> 
                                                                            </a>
                                                                            
                                                                            <?php } else{?>
                                                                            <a
                                                                            href="<?php echo $item->video[0]->link; ?>"
                                                                            target="_blank">
                                                                                <iframe src="<?php echo $item->video[0]->link; ?>" style="height:150px;" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> 
                                                                            </a>
                                                                        <?php }?>
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        <?php echo $item->video[0]->description; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                            if($item->video[0]->notes==''){ }
                                                                            else{
                                                                            ?>
                                                                            <a href="<?php echo base_url("uploads/notes/".$item->video[0]->notes);?>" target="_blank"><?php echo $item->video[0]->notes;?></a>
                                                                            <?php
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        <?php echo $item->date; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item->time; ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                    $sr++;
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="description">
                                            <?php echo $list[0]->shortdesc;?><br>
                                            <?php echo $list[0]->description;?>
                                        </div>
                                        <div class="tab-pane" id="requirement">
                                            <?php echo $list[0]->requirement;?>
                                        </div>
                                        <div class="tab-pane" id="include">
                                            <?php echo $list[0]->course_include;?>
                                        </div>
                                        <div class="tab-pane" id="will_learn">
                                            <?php echo $list[0]->will_learn;?>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header"><h5>Author</h5> </div>
                                <ul class="list-group list-group-flush">
                                    <?php if(count($author)) : ?>
                                    <?php foreach($author as $item) : ?>
                                    <li class="list-group-item">
                                        <div class="media align-items-center">
                                            <img src="<?php if(empty($item->photo)){ echo base_url("uploads/logo.png"); } else{ echo base_url("uploads/tutor/".$item->photo); } ?>"  class="customer-img rounded-circle" >
                                            <div class="media-body ml-3">
                                                <h6 class="mb-0"><?php echo $item->name;?> </h6>
                                                <p><?php echo strip_tags($item->designation);?></p>
                                                <p><?php echo $item->about;?></p>
                                                <a class="btn btn-info" target="_blank" href="<?php echo $item->social_link;?>"><i class="fa fa-share-square"></i> Follow on Linkedin</a>
                                            </div>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            
                            <div class="card">
                                <div class="card-header">Review 
                                </div>
                                <ul class="list-group list-group-flush">
                                    <?php if(count($review)) : ?>
                                    <?php foreach($review as $item) : ?>
                                    <li class="list-group-item">
                                        <div class="media align-items-center">
                                            <img src="<?php if(empty($item['profile_photo'])){ echo base_url("uploads/logo.png"); } else{ echo base_url("uploads/profile_photo/".$item['profile_photo']); } ?>"  class="customer-img rounded-circle" >
                                            <div class="media-body ml-3">
                                                <h6 class="mb-0"><?php echo $item['name'];?> </h6>
                                                <p><?php echo $item['review'];?></p>
                                                <input type="checkbox"
                                                onchange="return reviewstatus(this,'tbl_review','id','<?php echo $item['id'];?>','status')" <?php if ($item['status'] == "true") {
                                                    echo "checked";
                                                } ?> class="js-switch"  data-color="#eb5076" data-size="small">
                                            </div>
                                            <p>
                                                <?php if($item['rating']>0){ for($i=0;$i<$item['rating'];$i++){?>
                                                    <i class="fas fa-star text-warning" aria-hidden="true"></i>
                                                <?php }?>
                                                
                                                <?php } else{ ?>
                                                <br>
                                                <?php } ?>
                                            </p>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if(!count($review)) : ?>
                                    <li class="list-group-item">
                                        <div class="media align-items-center">
                                            <div class="media-body ml-3">
                                                No Review Found.
                                            </div>
                                        </div>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    
                    <!--End Dashboard Content-->
                    
                    <!--start overlay-->
                    <div class="overlay toggle-menu"></div>
                    <!--end overlay-->
                    
                </div>
                <!-- End container-fluid-->
                
            </div>
            <!--End content-wrapper-->
            <!--Modal Start-->
            <div class="modal fade" id="AddModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-primary">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white">Add Lecture</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?php echo base_url("Educator/ManageCourses/AddLecture/".$list[0]->id); ?>" method="post"
                        enctype="multipart/form-data" id="addform">
                            <div class="modal-body row">
                                
                                
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <input type="hidden" name="author" value="<?php echo $author[0]->id;?>" />
                                <div class="form-group col-sm-6">
                                    <label class="col-form-label">Subject <span class="text-danger">*</span></label>
                                    <select class="form-control" name="subject" required>
                                        <option selected disabled>Select</option>
                                        <?php foreach ($subjectlist as $item) { ?>
                                            <option value="<?php echo $item->id;?>" ><?php echo $item->name;?></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error("subject", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-form-label">Video Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="type" required onchange="videoType(this.value)">
                                        <option selected disabled>Select</option>
                                        <option value="External">External</option>
                                        <option value="Internal" selected>Internal</option>
                                    </select>
                                    <?php echo form_error("type", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                                <div class="form-group col-sm-6" id="thumbnailInternal" >
                                    <label class="col-form-label">Thumbnail<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="thumbnail" placeholder="Thumbnail" accept="image/jpg, image/png, image/jpeg, image/gif">
                                    <?php echo form_error("thumbnail", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                                <!--
                                    <div class="form-group col-sm-12" style="max-height:200px;overflow:scroll;" id="thumbnailInternal">
                                    <label class="col-form-label">Thumbnail <span class="text-danger">*</span></label>
                                    <?php
                                        $count1=0;
                                        $newpath='uploads/thumbnail/'.$author[0]->username;
                                        if (is_dir($newpath))
                                        {
                                            if ($dh = opendir($newpath))
                                            {
                                                while (($file = readdir($dh)) !== false)
                                                {
                                                    if($file=="." || $file=="..")
                                                    {
                                                        continue;
                                                    }
                                                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                                                    $ext=strtolower($ext);
                                                    if($ext=="jpg" || $ext=="png")
                                                    {
                                                        $count1++;
                                                    ?>
                                                    <div class="row">
                                                    <div class="col-sm-10">
                                                    <input type="radio" id="thumb<?php echo $count1; ?>" name="thumbnail" value="<?php echo $file; ?>"  required />
                                                    <?php echo $file; ?>
                                                    </div>
                                                    <div class="col-sm-2">
                                                    <a href="<?php echo base_url($newpath.$file); ?>" target="_blank" ><i class="fas fa-image fa-lg"></i></a>
                                                    </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    
                                                }
                                            }
                                            
                                        }
                                        if($count1==0)
                                        {
                                            echo "No Thumbnail Found in Folder, Please Upload using FTP.";
                                        }
                                    ?>
                                    <?php echo form_error("thumbnail", "<p class='text-danger' >", "</p>"); ?>
                                    </div>
                                -->
                                <!--
                                    <div class="form-group col-sm-12" style="max-height:200px;overflow:scroll;" id="videoInternal">
                                    <label class="col-form-label">Video <span class="text-danger">*</span></label>
                                    <?php
                                        $count1=0;
                                        $newpath='uploads/video/'.$author[0]->username;
                                        if (is_dir($newpath))
                                        {
                                            if ($dh = opendir($newpath))
                                            {
                                                while (($file = readdir($dh)) !== false)
                                                {
                                                    if($file=="." || $file=="..")
                                                    {
                                                        continue;
                                                    }
                                                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                                                    $ext=strtolower($ext);
                                                    if($ext=="mp4" || $ext=="mov")
                                                    {
                                                        $count1++;
                                                    ?>
                                                    <div class="row">
                                                    <div class="col-sm-10">
                                                    <input type="radio" id="video<?php echo $count1; ?>" name="video" value="<?php echo $file; ?>"  required />
                                                    <?php echo $file; ?>
                                                    </div>
                                                    <div class="col-sm-2">
                                                    <a href="<?php echo base_url($newpath.$file); ?>" target="_blank" ><i class="fas fa-video fa-lg"></i></a>
                                                    </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    
                                                }
                                            }
                                            
                                        }
                                        if($count1==0)
                                        {
                                            echo "No Video Found in Folder, Please Upload using FTP.";
                                        }
                                    ?>
                                    <?php echo form_error("video", "<p class='text-danger' >", "</p>"); ?>
                                    </div>
                                -->
                                <div class="form-group col-sm-6" id="videoInternal">
                                    <label class="col-form-label">Video<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="video" placeholder="Video" accept="video/*">
                                    <?php echo form_error("video", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                                <div class="form-group col-sm-6" id="videoExternal" style="display:none;">
                                    <label class="col-form-label">Video Link <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="link" placeholder="Link" >
                                    <?php echo form_error("link", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-form-label">Notes<span class="text-danger"></span></label>
                                    <input type="file" class="form-control" name="notes"  accept="application/pdf">
                                    <?php echo form_error("notes","<p class='text-danger' >","</p>"); ?>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-form-label">Duration <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-uppercase" name="duration" placeholder="Duration" required>
                                    <?php echo form_error("duration", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="col-form-label">Lecture No <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="lecture_no" placeholder="Lecture No" required>
                                    <?php echo form_error("lecture_no", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " name="title" placeholder="Title" required>
                                    <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label class="col-form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="description"
                                    placeholder="Description" required></textarea>
                                    <?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                                
                            </div>
                            <div class="modal-footer d-block">
                                <button type="submit" id="addaction" name="addaction" class="btn btn-primary"><i
                                class="icon-lock"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
            <!--Modal End-->
            
            
            <!--Modal Start-->
			<div class="modal fade" id="AddAssignmentModal">
				<div class="modal-dialog">
					<div class="modal-content border-primary">
						<div class="modal-header bg-primary">
							<h5 class="modal-title text-white">Add Assignment</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						<form action="<?php echo base_url("Educator/ManageCourses/AddAssignment/".$list[0]->id); ?>" method="post"
						enctype="multipart/form-data" id="addform1">
							<div class="modal-body">
								
								
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
								<!--
                                    <div class="form-group">
									<label class="col-form-label">Subject <span class="text-danger">*</span></label>
									<select class="form-control" name="subject" required onchange="getVideos(this.value)">
                                    <option selected disabled>Select</option>
                                    <?php foreach ($subjectlist as $item) { ?>
                                        <option value="<?php echo $item->id;?>" ><?php echo $item->name;?></option>
                                    <?php } ?>
                                    </select>
									<?php echo form_error("subject", "<p class='text-danger' >", "</p>"); ?>
                                    </div>
                                    
                                    <div class="form-group">
									<label class="col-form-label">Video <span class="text-danger">*</span></label>
									<select class="form-control videosList" name="video" required>
                                    <option selected disabled>Select</option>
                                    <?php foreach ($videolist as $item) { ?>
                                        <option value="<?php echo $item->id;?>" ><?php echo $item->title;?></option>
                                    <?php } ?>
                                    </select>
									<?php echo form_error("video", "<p class='text-danger' >", "</p>"); ?>
                                </div>-->
                                <input type="hidden" name="video" id="assignment_video_id"  />
								<div class="form-group">
									<label class="col-form-label">Assignment <span class="text-danger">*</span></label>
									<input type="file" class="form-control" name="assignment" Title="Choose Assignment" required>
									<?php echo form_error("assignment", "<p class='text-danger' >", "</p>"); ?>
                                </div>
								<div class="form-group">
									<label class="col-form-label">Description <span class="text-danger">*</span></label>
									<textarea class="form-control summernote" name="description"
									placeholder="Description" required></textarea>
									<?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                            </div>
							<div class="modal-footer d-block">
								<button type="submit" id="addaction1" name="addaction1" class="btn btn-primary"><i
                                class="icon-lock"></i>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
            <!--Modal End-->
            <?php include("Footer.php"); ?>
            
            
        </div>
        <!--End wrapper-->
        
        <?php include("FooterLinking.php"); ?>
        <script>
            function Edit(id) {
                $("#EditModal").modal("show");
                $("#EditModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
                $("#EditModal .modal-body").load("<?php echo base_url('Educator/ManageVideos/Edit/') ?>" + id);
            }
            function videoType(type){
                if(type=='External'){
                    
                    $("#videoInternal").hide();
                    // $("#thumbnailInternal").hide();
                    $("#videoExternal").show();
                    $("input[name='video']").removeAttr('required');
                    // $("input[name='thumbnail']").removeAttr('required');
                    $("input[name='link']").attr('required');
                }
                else{
                    $("#videoInternal").show();
                    // $("#thumbnailInternal").show();
                    $("#videoExternal").hide();
                    $("input[name='video']").attr('required');
                    // $("input[name='thumbnail']").attr('required');
                    $("input[name='link']").removeAttr('required');
                }
            }
            
            function AddAssignment(id)
            {
                $("#assignment_video_id").val(id);
            }
        </script>
        <script>
            
            function coursestatus(e, table, where_column, where_value, column) {
                var status = true;
                var check = $(e).prop("checked");
                if (check) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to activate this course !",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true
                        }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "<?php echo base_url("Educator/UpdateStatus");?>",
                                type: "post",
                                data: {
                                    'table': table,
                                    'column': column,
                                    'value': 'true',
                                    'where_column': where_column,
                                    'where_value': where_value
                                },
                                success: function(response) {
                                    swal("This course is activated successfully !", {
                                        icon: "success",
                                    });
                                }
                            });
                        }
                    });
                    } else {
                    swal({
                        title: "Are you sure?",
                        text: "You want to deactivate this course !",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true
                        }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "<?php echo base_url("Educator/UpdateStatus");?>",
                                type: "post",
                                data: {
                                    'table': table,
                                    'column': column,
                                    'value': 'false',
                                    'where_column': where_column,
                                    'where_value': where_value
                                },
                                success: function(response) {
                                    swal("This course is deactivated successfully !", {
                                        icon: "success",
                                    });
                                }
                            });
                        }
                    });
                }
                return status;
            }
            
            function reviewstatus(e, table, where_column, where_value, column) {
                var status = true;
                var check = $(e).prop("checked");
                if (check) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to activate this review !",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true
                        }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "<?php echo base_url("Educator/UpdateStatus");?>",
                                type: "post",
                                data: {
                                    'table': table,
                                    'column': column,
                                    'value': 'true',
                                    'where_column': where_column,
                                    'where_value': where_value
                                },
                                success: function(response) {
                                    swal("This review is activated successfully !", {
                                        icon: "success",
                                    });
                                }
                            });
                        }
                    });
                    } else {
                    swal({
                        title: "Are you sure?",
                        text: "You want to deactivate this review !",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true
                        }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "<?php echo base_url("Educator/UpdateStatus");?>",
                                type: "post",
                                data: {
                                    'table': table,
                                    'column': column,
                                    'value': 'false',
                                    'where_column': where_column,
                                    'where_value': where_value
                                },
                                success: function(response) {
                                    swal("This review is deactivated successfully !", {
                                        icon: "success",
                                    });
                                }
                            });
                        }
                    });
                }
                return status;
            }
            
            
            function coursedelete(e, table, where_column, where_value, unlink_folder, unlink_column) {
                var status = true;
                swal({
                    title: "Are you sure?",
                    text: "You want to removed this course !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                    }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "<?php echo base_url("Educator/Delete");?>",
                            type: "post",
                            data: {
                                'table': table,
                                'where_column': where_column,
                                'where_value': where_value,
                                'unlink_folder': unlink_folder,
                                'unlink_column': unlink_column
                            },
                            success: function(response) {
                                swal("This course is removed successfully !", {
                                    icon: "success",
                                });
                                location.reload();
                            }
                        });
                    }
                });
                return status;
            }
        </script>
        <script>
            function Status(e, table, where_column, where_value, column) {
                var status = true;
                var check = $(e).prop("checked");
                if (check) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to activate this lecture !",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true
                        }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "<?php echo base_url("Educator/UpdateStatus"); ?>",
                                type: "post",
                                data: {
                                    'table': table,
                                    'column': column,
                                    'value': 'true',
                                    'where_column': where_column,
                                    'where_value': where_value
                                },
                                success: function(response) {
                                    swal("This lecture is activated successfully !", {
                                        icon: "success",
                                    });
                                }
                            });
                        }
                    });
                    } else {
                    swal({
                        title: "Are you sure?",
                        text: "You want to deactivate this lecture !",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true
                        }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "<?php echo base_url("Educator/UpdateStatus"); ?>",
                                type: "post",
                                data: {
                                    'table': table,
                                    'column': column,
                                    'value': 'false',
                                    'where_column': where_column,
                                    'where_value': where_value
                                },
                                success: function(response) {
                                    swal("This lecture is deactivated successfully !", {
                                        icon: "success",
                                    });
                                }
                            });
                        }
                    });
                }
                return status;
            }
            
            function Delete(e, table, where_column, where_value, unlink_folder, unlink_column) {
                var status = true;
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this lecture !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                    }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "<?php echo base_url("Educator/Delete"); ?>",
                            type: "post",
                            data: {
                                'table': table,
                                'where_column': where_column,
                                'where_value': where_value,
                                'unlink_folder': unlink_folder,
                                'unlink_column': unlink_column
                            },
                            success: function(response) {
                                swal("This lecture is deleted successfully !", {
                                    icon: "success",
                                });
                                location.reload();
                            }
                        });
                    }
                });
                return status;
            }
            
            function getVideos(id){
                $.ajax({
                    url: "<?php echo base_url("Educator/ManageSubjects/VideosList/"); ?>"+id,
                    type: "get",
                    data: {
                    },
                    success: function(response) {
                        $(".videosList").html(response);
                    }
                });
            }
        </script>
    </body>
    
</html>        