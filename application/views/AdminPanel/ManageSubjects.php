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
                            <h4 class="page-title"> Manage Subjects</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">Subjects</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Subjects</li>
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
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#AddModal"><i class="fa fa-plus-circle"></i> Add Subject</button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        
                                        <table class="table table-bordered" id="example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Status</th>
                                                    <th>Subject ID</th>
                                                    <th>Name</th>
                                                    <th>No Of Videos</th>
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
                                                            <input type="checkbox" onchange="return Status(this,'tbl_subject','id','<?php echo $item->id; ?>','status')" <?php if ($item->status == "true") {
                                                                echo "checked";
                                                            } ?> class="js-switch" data-color="#eb5076" data-size="small">
                                                        </td>
                                                         <td>
                                                            <?php echo $item->id; ?>
                                                        </td>
                                                        <td>
                                                            <label data-toggle="tooltip" data-placement="top" title="Subject ID: <?php echo $item->id; ?>"><?php echo $item->name; ?>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <?php echo $item->videos; ?>
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
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger waves-effect waves-light" onclick="return Delete(this,'tbl_subject','id','<?php echo $item->id; ?>','','')">
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
                            <h5 class="modal-title text-white">Add Subject</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?php echo base_url("AdminPanel/ManageSubjects/Add"); ?>" method="post" enctype="multipart/form-data" id="addform">
                            <div class="modal-body">
                                
                                
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                
                                <div class="form-group">
                                    <label class="col-form-label">Subject Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Subject Name" required>
                                    <?php echo form_error("name", "<p class='text-danger' >", "</p>"); ?>
                                </div>
                            </div>
                            <div class="modal-footer d-block">
                                <button type="submit" id="addaction" name="addaction" class="btn btn-primary"><i class="icon-lock"></i> Add Subject</button>
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
                            <h5 class="modal-title text-white">Edit Subject</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <form action="<?php echo base_url("AdminPanel/ManageSubjects/Update"); ?>" method="post" enctype="multipart/form-data" id="updateform">
                            <div class="modal-body">
                                
                            </div>
                            <div class="modal-footer d-block">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <button type="submit" id="updateaction" name="updateaction" class="btn btn-primary"><i class="icon-lock"></i> Update Subject</button>
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
                $("#EditModal .modal-body").load("<?php echo base_url('AdminPanel/ManageSubjects/Edit/') ?>" + id);
            }
        </script>
        
        <script>
            function Status(e, table, where_column, where_value, column) {
                var status = true;
                var check = $(e).prop("checked");
                if (check) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to activate this subject !",
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
                                    swal("This subject is activated successfully !", {
                                        icon: "success",
                                    });
                                }
                            });
                        }
                    });
                    } else {
                    swal({
                        title: "Are you sure?",
                        text: "You want to deactivate this subject !",
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
                                    swal("This subject is deactivated successfully !", {
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
                    text: "You want to delete this subject !",
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
                                swal("This subject is deleted successfully !", {
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