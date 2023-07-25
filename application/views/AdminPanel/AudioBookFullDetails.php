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
                            <h4 class="page-title"> Full Details of Audio-Book</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">Audio-Books</a></li>
                                <li class="breadcrumb-item"><a href="javaScript:void();">Manage Audio-Books</a></li>
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
                                            <img src="../../../uploads/abook/<?php echo $list[0]->banner; ?>" class="img-fluid"  style="max-height:200px;"/>
                                            
                                        </div>
                                        <div class="col-sm-12 p-2">
                                            <img src="../../../uploads/abook/<?php echo $list[0]->logo; ?>" class="img-fluid mr-3 img-thumbnail" style="width:80px;" />
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
                                            <p><strong><i class="fa fa-user-circle text-primary"></i> <?php if(isset($author) !=''){ echo $author[0]->name; }?> </strong></p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-list-alt text-primary"></i> <?php if(isset($category) && isset($category->title)){ echo $category->title; } ?> </strong></p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-clock-o text-primary"></i> <?php echo $list[0]->daystofinish; ?> Days To Finish</strong></p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-book text-primary"></i> <?php echo $list[0]->noofpages; ?> Pages</p></strong>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-universal-access text-primary"></i> Full Lifetime Access</p></strong>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong><i class="fa fa-tag text-primary"></i> <?php echo $list[0]->offer_text; ?></p></strong>
                                        </div>
                                        <div class="col-sm-12">
                                            
                                            <input type="checkbox"
                                            onchange="return abookstatus(this,'tbl_abook','id','<?php echo $list[0]->id;?>','apprstatus')" <?php if ($list[0]->apprstatus == "true") {
                                                echo "checked";
                                            } ?> class="js-switch"  data-color="#eb5076" data-size="small">
                                            <a href="<?php echo base_url("AdminPanel/ManageAudioBooks/Edit/".$list[0]->id) ?>"
                                            class="btn btn-sm btn-primary waves-effect waves-light">
                                            <i class="fa fa fa-edit"></i>  </a>
                                            <a href="javascript:void(0);"
                                            class="btn btn-sm btn-danger waves-effect waves-light"
                                            onclick="return abookdelete(this,'tbl_abook','id','<?php echo $list[0]->id;?>','abook','abook')">
                                            <i class="fa fa-trash"></i> </a>
                                            <!--
                                            <a href="<?php echo base_url("../uploads/abook/".$list[0]->abook) ?>"
                                            class="btn btn-sm btn-info waves-effect waves-light" target="_blank">
                                            Play Audio Book </a>-->
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <!-- Manage Audio-Books Card End -->
                            
                        </div>
                        
                        
                        <div class="col-sm-8">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#topic" data-toggle="pill" class="nav-link active">Topic</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#description" data-toggle="pill" class="nav-link">Description</a>
                                        </li>
                                        <!--
                                            <li class="nav-item">
                                            <a href="javascript:void();" data-target="#requirement" data-toggle="pill" class="nav-link">Requirement</a>
                                        </li>-->
                                        <!--
                                            <li class="nav-item">
                                            <a href="javascript:void();" data-target="#include" data-toggle="pill" class="nav-link">Include</a>
                                            </li>
                                            <li class="nav-item">
                                            <a href="javascript:void();" data-target="#will_learn" data-toggle="pill" class="nav-link">Will Learn</a>
                                            </li>
                                            <li class="nav-item">
                                            <a href="javascript:void();" data-target="#sample" data-toggle="pill" class="nav-link active">Sample Page</a>
                                        </li>-->
                                    </ul>
                                    <div class="tab-content p-3">
                                        <div class="tab-pane active" id="topic">
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#AddModal"><i
                                            class="fa fa-plus-circle"></i> Add Topic</button><br><br>
                                            <div class="table-responsive">
                                                
                                                <table class="table table-bordered wrap" id="example">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Topic No</th>
                                                            <th>Topic Name </th>
                                                            <th>Topic</th>
                                                            <th>Topic Link</th>
                                                            <th>Description</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            if(count($topicList)){
                                                                foreach ($topicList as $item) {
                                                                    if($item->type=='External'){
                                                                        $topic=$item->topic;
                                                                    }
                                                                    else{
                                                                        $topic=base_url('uploads/topic/'.$item->topic);
                                                                    }
                                                                ?>
                                                                <tr>
                                                                    
                                                                    <td>
                                                                        <input type="checkbox" onchange="return Status(this,'tbl_topic','id','<?php echo $item->id; ?>','status')" <?php if ($item->status == "true") { echo "checked"; }  ?> class="js-switch" data-color="#eb5076" data-size="small">
                                                                        
                                                                        <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger p-1"
                                                                        onclick="return Delete(this,'tbl_topic','id','<?php echo $item->id; ?>','','')">
                                                                        <i class="bi bi-trash"></i> Delete</a>
                                                                        
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item->topic_no; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item->name; ?>
                                                                    </td>
                                                                    <td>
                                                                        <audio controls>
                                                                            <source src="<?=$topic;?>">
                                                                        </audio>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item->topic_link; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item->description; ?>
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
                                        <!--
                                            <div class="tab-pane" id="requirement">
                                            <?php //echo $list[0]->requirement;?>
                                        </div>-->
                                        <!--
                                            <div class="tab-pane" id="include">
                                            <?php echo $list[0]->abook_include;?>
                                            </div>
                                            <div class="tab-pane" id="will_learn">
                                            <?php echo $list[0]->will_learn;?>
                                            </div>
                                            <div class="tab-pane " id="sample">
                                            <iframe style="width:100%;height:430px;"  src="https://docs.google.com/viewerng/viewer?url=<?php echo base_url("uploads/abook/".$list[0]->sample);?>&hl=en&embedded=true"></iframe>
                                        </div>-->
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
                        <!--Modal Start-->
                        <div class="modal fade" id="AddModal">
                            <div class="modal-dialog">
                                <div class="modal-content border-primary">
                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title text-white">Add Topic</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="<?php echo base_url("AdminPanel/ManageAudioBooks/AddTopic/".$list[0]->id); ?>" method="post"
                                    enctype="multipart/form-data" id="addform">
                                        <div class="modal-body">
                                            
                                            
                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" name="author" value="<?php echo $author[0]->id;?>" />
                                            <input type="hidden" name="itemtype" value="Abook" />
                                            <input type="hidden" name="itemid" value="<?=$list[0]->id;?>" />
                                            <div class="form-group">
                                                <label class="col-form-label">Topic No <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="topic_no" placeholder="Topic No" required>
                                                <?php echo form_error("topic_no", "<p class='text-danger' >", "</p>"); ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Topic Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control " name="name" placeholder="Topic Name" required>
                                                <?php echo form_error("name", "<p class='text-danger' >", "</p>"); ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Topic Type <span class="text-danger">*</span></label>
                                                <select class="form-control" name="type" required onchange="topicType(this.value)">
                                                    <option selected disabled>Select</option>
                                                    <option value="External">External</option>
                                                    <option value="Internal" selected>Internal</option>
                                                </select>
                                                <?php echo form_error("type", "<p class='text-danger' >", "</p>"); ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Topic Link <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control " name="topic_link" placeholder="Topic Link" required>
                                                <?php echo form_error("topic_link", "<p class='text-danger' >", "</p>"); ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Topic (Audio)<span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="topic" required placeholder="Topic Link"  accept="audio/mp3">
                                                <?php echo form_error("topic","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Description <span class="text-danger"></span></label>
                                                <textarea class="form-control" name="description" placeholder="Description"></textarea>
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
                        <!--End Dashboard Content-->
                        
                        <!--start overlay-->
                        <div class="overlay toggle-menu"></div>
                        <!--end overlay-->
                        
                    </div>
                    <!-- End container-fluid-->
                    
                </div>
                <!--End content-wrapper-->
                
                <?php include("Footer.php"); ?>
                
                
            </div>
            <!--End wrapper-->
            
            <?php include("FooterLinking.php"); ?>
            <script>
                
                function abookstatus(e, table, where_column, where_value, column) {
                    var status = true;
                    var check = $(e).prop("checked");
                    if (check) {
                        swal({
                            title: "Are you sure?",
                            text: "You want to activate this abook !",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true
                            }).then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: "<?php echo base_url("AdminPanel/UpdateStatus");?>",
                                    type: "post",
                                    data: {
                                        'table': table,
                                        'column': column,
                                        'value': 'true',
                                        'where_column': where_column,
                                        'where_value': where_value
                                    },
                                    success: function(response) {
                                        swal("This abook is activated successfully !", {
                                            icon: "success",
                                        });
                                    }
                                });
                            }
                        });
                        } else {
                        swal({
                            title: "Are you sure?",
                            text: "You want to deactivate this abook !",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true
                            }).then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: "<?php echo base_url("AdminPanel/UpdateStatus");?>",
                                    type: "post",
                                    data: {
                                        'table': table,
                                        'column': column,
                                        'value': 'false',
                                        'where_column': where_column,
                                        'where_value': where_value
                                    },
                                    success: function(response) {
                                        swal("This abook is deactivated successfully !", {
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
                                    url: "<?php echo base_url("AdminPanel/UpdateStatus");?>",
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
                                    url: "<?php echo base_url("AdminPanel/UpdateStatus");?>",
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
                
                function abookdelete(e, table, where_column, where_value, unlink_folder, unlink_column) {
                    var status = true;
                    swal({
                        title: "Are you sure?",
                        text: "You want to delete this abook !",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true
                        }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "<?php echo base_url("AdminPanel/Delete");?>",
                                type: "post",
                                data: {
                                    'table': table,
                                    'where_column': where_column,
                                    'where_value': where_value,
                                    'unlink_folder': unlink_folder,
                                    'unlink_column': unlink_column
                                },
                                success: function(response) {
                                    swal("This abook is deleted successfully !", {
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
                function topicType(type)
                {
                    if(type=='External')
                    {
                        $("input[name='topic']").attr('type','text');
                        $("input[name='topic']").removeAttr('type','file');
                    }
                    else
                    {
                        $("input[name='topic']").removeAttr('type','text');
                        $("input[name='topic']").attr('type','file');
                    }
                }
                function Status(e, table, where_column, where_value, column) {
                    var status = true;
                    var check = $(e).prop("checked");
                    if (check) {
                        swal({
                            title: "Are you sure?",
                            text: "You want to activate this topic !",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true
                            }).then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: "<?php echo base_url("AdminPanel/UpdateStatus"); ?>",
                                    type: "post",
                                    data: {
                                        'table': table,
                                        'column': column,
                                        'value': 'true',
                                        'where_column': where_column,
                                        'where_value': where_value
                                    },
                                    success: function(response) {
                                        swal("This topic is activated successfully !", {
                                            icon: "success",
                                        });
                                    }
                                });
                            }
                        });
                        } else {
                        swal({
                            title: "Are you sure?",
                            text: "You want to deactivate this topic !",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true
                            }).then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: "<?php echo base_url("AdminPanel/UpdateStatus"); ?>",
                                    type: "post",
                                    data: {
                                        'table': table,
                                        'column': column,
                                        'value': 'false',
                                        'where_column': where_column,
                                        'where_value': where_value
                                    },
                                    success: function(response) {
                                        swal("This topic is deactivated successfully !", {
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
                        text: "You want to delete this topic !",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true
                        }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "<?php echo base_url("AdminPanel/Delete"); ?>",
                                type: "post",
                                data: {
                                    'table': table,
                                    'where_column': where_column,
                                    'where_value': where_value,
                                    'unlink_folder': unlink_folder,
                                    'unlink_column': unlink_column
                                },
                                success: function(response) {
                                    swal("This topic is deleted successfully !", {
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
        </body>
        
    </html>                