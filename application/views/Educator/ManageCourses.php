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
                            <h4 class="page-title"> Manage Courses</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">Courses</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Courses</li>
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
                                <div class="card-header"><i class="fa fa-table"></i> Manage Courses</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        
                                        <table class="table table-bordered" id="example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Logo</th>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Duration</th>
                                                    <th>Launching Time</th>
                                                    <th>Certification</th>
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
                                                        <td> <img
                                                            data-src="<?php echo base_url("uploads/course/$item->logo"); ?>"
                                                            src="<?php echo base_url("images/Preloader2.jpg"); ?>"
                                                        class="lazy" style="height:50px;" /> </td>
                                                        <td>
                                                            <label data-toggle="tooltip" data-placement="top"
                                                            title="Course ID: <?php echo $item->id; ?>"><?php echo $item->name; ?>
                                                            </label> <br />
                                                            <input type="checkbox"
                                                            onchange="return coursestatus(this,'tbl_course','id','<?php echo $item->id;?>','apprstatus')" <?php if ($item->apprstatus == "true") {
                                                                echo "checked";
                                                            } ?> class="js-switch"
                                                            data-color="#eb5076" data-size="small">
                                                        </td>
                                                        <td>
                                                            <?php
                                                                if ($item->type == "Paid") {
                                                                ?>
                                                                <span class="p-2 text-danger">Paid</span> <br />
                                                                <?php
                                                                    if (empty($item->offerprice)) {
                                                                    ?>
                                                                    <i class="fa fa-rupee"></i> <?php echo $item->price; ?>
                                                                    <?php
                                                                        } else {
                                                                    ?>
                                                                    <s><i class="fa fa-rupee"></i> <?php echo $item->price; ?></s>
                                                                    <i class="fa fa-rupee"></i> <?php echo $item->offerprice; ?>
                                                                    <?php
                                                                    }
                                                                    } else {
                                                                ?>
                                                                <span class="p-2 text-success">Free</span>
                                                                <?php
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            No of Videos: <?php echo $item->nooflecture; ?> <br />
                                                            Days to Finish: <?php echo $item->daystofinish; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $item->timing; ?>
                                                        </td>
                                                        <td>
                                                           <?php echo $item->certification;?>
                                                           <?php if($item->certification=='Yes') {?>
                                                           <p> <a href="<?php echo base_url("Educator/ManageCourses/Certificate/$item->id") ?>" target="_blank" class="text-info">View Certificate</a></p>
                                                           <p>Certificate Hardcopy Charge: <i class="fa fa-inr"></i> <?php echo $item->certificate_charge; ?></p>
                                                           <p>Per KM Delivery Charge: <i class="fa fa-inr"></i> <?php echo $item->km_charge; ?></p>
                                                           <?php }?>
                                                        </td>
                                                        <td>
                                                            
                                                            <div class="btn-group">
                                                                <a href="<?php echo base_url("Educator/ManageCourses/Details/$item->id") ?>"
                                                                class="btn btn-sm btn-outline-success waves-effect waves-light">
                                                                <i class="fa fa-eye"></i> </a>
                                                                <a href="<?php echo base_url("Educator/ManageCourses/Edit/$item->id") ?>"
                                                                class="btn btn-sm btn-outline-info waves-effect waves-light">
                                                                <i class="fa fa fa-edit"></i> </a>
                                                                <a href="javascript:void(0);"
                                                                class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                                onclick="return coursedelete(this,'tbl_course','id','<?php echo $item->id;?>','course','logo,banner')">
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
            
            
        </div>
        <!--End wrapper-->
        
        <?php include("FooterLinking.php"); ?>
        
        
        <script>
            function certificationChange(e, table, where_column, where_value, column) {
                var status = true;
                var check = $(e).prop("checked");
                if (check) {
                    swal({
                        title: "Are you sure?",
                        text: "It will change course to a Certification Based Course !",
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
                                    'value': 'Yes',
                                    'where_column': where_column,
                                    'where_value': where_value
                                },
                                success: function(response) {
                                    swal("It will changed course to a Certification Based Course !", {
                                        icon: "success",
                                    });
                                }
                            });
                        }
                    });
                    } else {
                    swal({
                        title: "Are you sure?",
                        text: "It will change course to a NON-Certification Based Course !",
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
                                    'value': 'No',
                                    'where_column': where_column,
                                    'where_value': where_value
                                },
                                success: function(response) {
                                    swal("It will changed course to a NON-Certification Based Course !", {
                                        icon: "success",
                                    });
                                }
                            });
                        }
                    });
                }
                return status;
            }
            
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
            
            function coursedelete(e, table, where_column, where_value, unlink_folder, unlink_column) {
                var status = true;
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this course !",
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
                                swal("This course is deleted successfully !", {
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