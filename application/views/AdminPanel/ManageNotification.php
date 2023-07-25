<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <?php include("HeaderLinking.php"); ?>
        <style>
            .chosen-container-multi{
            width: 100% !important;
            }
        </style>
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
                            <h4 class="page-title"> Manage Notification</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Notification</li>
                            </ol>
                        </div>
                        <div class="col-sm-3">
                            
                        </div>
                    </div>
                    <!-- End Breadcrumb-->
                    
                    <div class="row">
                        <div class="col-sm-12">
                            
                            <!-- Manage Courses Card Start -->
                            <div class="card">
                                <div class="card-header">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#AddModal"><i class="fa fa-plus-circle"></i> Add Notification</button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        
                                        <table class="table table-bordered " id="example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Status</th>
                                                    <th>For User</th>
                                                    <th>Title</th>
                                                    <th>Message</th>
                                                    <th>Link</th>
                                                    <th>Image</th>
                                                    <th>Parameter</th>
                                                    <th>Parameter Data</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sr = 1;
                                                    foreach ($list as $item) {
                                                        
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sr; ?></td>
                                                        <td>
                                                            <input type="checkbox" onchange="return Status(this,'tbl_notification','id','<?php echo $item->id; ?>','status')" <?php if ($item->status == "true") {
                                                                echo "checked";
                                                            } ?> class="js-switch" data-color="#eb5076" data-size="small">
                                                        </td>
                                                        <td> <?php echo $item->for_user; ?>  </td> 
                                                        <td>
                                                            <label data-toggle="tooltip" data-placement="top" title="Subject ID: <?php echo $item->id; ?>"><?php echo $item->title; ?>
                                                            </label>
                                                        </td>
                                                        <td> <?php echo $item->message; ?>  </td> 
                                                        <td> <?php echo $item->image; ?> </td>
                                                        <td>
                                                            <?php if(!empty($item->image)) { ?>
                                                                <a href="<?php echo base_url("uploads/notification/".$item->image); ?>" target="_blank">
                                                                <img src="<?php echo base_url("uploads/notification/".$item->image); ?>" style="height:50px;" /> </a>
                                                            <?php } ?> 
                                                        </td>
                                                        <td> <?php echo $item->parameter; ?> </td>
                                                        <td>
                                                            <?php
                                                                if($item->parameter=='Category'){
                                                                    echo $this->Auth_model->getData('tbl_category',$item->data)->title;
                                                                }
                                                                else if($item->parameter=='Course'){
                                                                    echo $this->Auth_model->getData('tbl_course',$item->data)->name;
                                                                }
                                                                else if($item->parameter=='Ebook'){
                                                                    echo $this->Auth_model->getData('tbl_ebook',$item->data)->name;
                                                                }
                                                                else if($item->parameter=='Abook'){
                                                                    echo $this->Auth_model->getData('tbl_abook',$item->data)->name;
                                                                }
                                                                else if($item->parameter=='Quiz'){
                                                                    echo $this->Auth_model->getData('tbl_quiz',$item->data)->name;
                                                                }
                                                                else if($item->parameter=='LiveSession'){
                                                                    echo $this->Auth_model->getData('tbl_live_video',$item->data)->title;
                                                                }
                                                                else if($item->parameter=='FreeVideo'){
                                                                    echo $video=$this->Auth_model->getData('tbl_recommended_videos',$item->data)->video;
                                                                    echo $this->Auth_model->getData('tbl_video',$video)->title;
                                                                }
                                                                else if($item->parameter=='Offer'){
                                                                    $couponData=$this->Auth_model->getData('tbl_offer',$item->data);
                                                                    echo $couponData->coupon.' (Discount: '.$couponData->discount.')'.' (Discount Type: '.$couponData->discount_type.')';
                                                                }
                                                                else{
                                                                    echo $item->link;
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $item->date; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $item->time; ?>
                                                        </td>
                                                        <td>
                                                            
                                                            <div class="btn-group">
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-info waves-effect waves-light" onclick="Edit('<?php echo $item->id; ?>')">
                                                                <i class="fa fa fa-edit"></i> </a>
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger waves-effect waves-light" onclick="return Delete(this,'tbl_notification','id','<?php echo $item->id; ?>','','')">
                                                                <i class="fa fa-trash"></i> </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        $sr++;
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- Manage Courses Card End -->
                            
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
            
            <?php include("Footer.php"); ?>
            
            
            <div class="modal fade" id="AddModal">
                <div class="modal-dialog">
                    <div class="modal-content border-primary">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white">Add Notification</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?php echo base_url("AdminPanel/ManageNotification/Add"); ?>" method="post" enctype="multipart/form-data" id="addform">
                            <div class="modal-body">
                                
                                
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <div class="form-group">
                                    <label  class="col-form-label">For User <span class="text-danger">*</span></label>
                                    <select class="form-control" name="for_user" required onchange="getUsers(this.value)">
                                        <option selected disabled>Select</option>
                                        <option value="AllEducator">All Educators</option>
                                        <option value="Educator">Select Educators</option>
                                        <option value="AllStudent">All Students</option>
                                        <option value="Student">Select Students</option>
                                    </select>
                                    <?php echo form_error("for_user","<p class='text-danger' >","</p>"); ?>
                                </div>
                                <div class="form-group user-data">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" placeholder="Title" required>
                                    <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Message <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="message" placeholder="Message" required></textarea>
                                    <?php echo form_error("message", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Link <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="link" placeholder="Link">
                                    <?php echo form_error("link", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Parameter <span class="text-danger">*</span></label>
                                    <select  class="form-control" name="parameter" required onchange="getParameterData(this.value)">
                                        <option value="None" selected>None</option>
                                        <option value="Category">Category</option>
                                        <option value="Course">Course</option>
                                        <option value="Ebook">E-Book</option>
                                        <option value="Abook">Audio Book</option>
                                        <option value="Quiz">Quiz</option>
                                        <option value="LiveSession">Live Session</option>
                                        <option value="FreeVideo">Free Video</option>
                                        <option value="Offer">Offer</option>
                                        <option value="External">External</option>
                                    </select>
                                    <?php echo form_error("parameter", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                                <div class="form-group parameter-data" style="display:none;">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Image <span class="text-danger"></span></label>
                                    <input type="file" class="form-control" name="image" title="Upload Slider Image" accept="image/jpg, image/png, image/jpeg, image/gif">
                                    <?php echo form_error("image", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                            </div>
                            <div class="modal-footer d-block">
                                <button type="submit" id="addaction" name="addaction" class="btn btn-primary"><i class="icon-lock"></i> Add Notification</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--End Modal -->
            <!--Modal Start-->
            <div class="modal fade" id="EditModal">
                <div class="modal-dialog">
                    <div class="modal-content border-primary">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white">Edit Notification</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <form action="<?php echo base_url("AdminPanel/ManageNotification/Update"); ?>" method="post" enctype="multipart/form-data" id="updateform">
                            <div class="modal-body">
                                
                            </div>
                            <div class="modal-footer d-block">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <button type="submit" id="updateaction" name="updateaction" class="btn btn-primary"><i class="icon-lock"></i> Update Notification</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
            <!--Modal End-->
            
        </div>
        <!--End wrapper-->
        
        <?php include("FooterLinking.php"); ?>
        <script>
            function Edit(id) {
                $("#EditModal").modal("show");
                $("#EditModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
                $("#EditModal .modal-body").load("<?php echo base_url('AdminPanel/ManageNotification/Edit/') ?>" + id);
            }
            
            function selectAll(value) {
                
                // var value=$(".chosen-select").chosen().val();
                // alert(value);
                // if(jQuery.inArray("Select All", value) != -1) {
                    // $('.chosen-select option').prop('selected', true).trigger('chosen:updated');
                // }
                // else if(jQuery.inArray("Deselect All", value) != -1) {
                   // $('.chosen-select option').removeAttr("selected").trigger('liszt:updated'); 
                // }
                if(value=='Select All'){
                    $('.chosen-select option').prop('selected', true).trigger('chosen:updated');
                }
                
            }
            
            function getParameterData(parameter)
            {
                // alert(parameter);
                if(parameter=='External'){
                    $(".parameter-data").html('<label class="col-form-label">External Link <span class="text-danger">*</span></label><input type="text" class="form-control" name="link" placeholder="Enter Link " required >');
                    $('.parameter-data').show();
                }
                else if(parameter=='None'){
                    $(".parameter-data").html('');
                    $('.parameter-data').hide();
                }
                else{
                    
                    $.ajax({
                        url: "<?php echo base_url("AdminPanel/Parameters/"); ?>"+parameter,
                        type: "get",
                        data: { },
                        success: function(response) 
                        {
                            // alert(response);
                            $(".parameter-data").html(response);
                            $('.parameter-data').show(); 
                        }
                    });
                }
                
            }
            
            function getUsers(type)
            {
                $.ajax({
                    url: "<?php echo base_url("AdminPanel/GetUsers/"); ?>"+type,
                    type: "get",
                    data: { },
                    success: function(response) 
                    {
                        // alert(response);
                        $(".user-data").html(response);
                        $('.user-data').show(); 
                    }
                });
                
            }
        </script>
        
        <script>
            function Status(e, table, where_column, where_value, column) {
                var status = true;
                var check = $(e).prop("checked");
                if (check) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to activate this notification !",
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
                                    swal("This notification is activated successfully !", {
                                        icon: "success",
                                    });
                                }
                            });
                        }
                    });
                    } else {
                    swal({
                        title: "Are you sure?",
                        text: "You want to deactivate this notification !",
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
                                    swal("This notification is deactivated successfully !", {
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
                    text: "You want to delete this notification !",
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
                                swal("This notification is deleted successfully !", {
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
                        msg: '<?php echo $this->session->flashdata("msg"); ?>'
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
                        msg: '<?php echo $this->session->flashdata("msg"); ?>'
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
                        msg: '<?php echo $this->session->flashdata("msg"); ?>'
                    });
                });
            </script>
            <?php
            }
        ?>
        
    </body>
    
</html>