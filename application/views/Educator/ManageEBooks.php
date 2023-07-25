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
                            <h4 class="page-title"> Manage E-Books</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">E-Books</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage E-Books</li>
                            </ol>
                        </div>
                        <div class="col-sm-3">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            
                            <div class="card">
                                <div class="card-header"><i class="fa fa-table"></i> Manage E-Books</div>
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
                                                    <th>Offer Text</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sr = 1;
                                                    foreach ($list as $item) {
                                                        $educatorData=$this->Auth_model->getData('tbl_tutor',$item->author);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sr; ?></td>
                                                        <td> <img
                                                            data-src="<?php echo base_url("uploads/ebook/$item->logo"); ?>"
                                                            src="<?php echo base_url("images/Preloader2.jpg"); ?>"
                                                        class="lazy" style="height:50px;" /> </td>
                                                        <td>
                                                            <label data-toggle="tooltip" data-placement="top"
                                                            title="E-Book ID: <?php echo $item->id; ?>"><?php echo $item->name; ?>
                                                            </label> <br />
                                                            <input type="checkbox"
                                                            onchange="return ebookstatus(this,'tbl_ebook','id','<?php echo $item->id;?>','apprstatus')" <?php if ($item->apprstatus == "true") {
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
                                                                No of Videos: <?php echo $item->noofpages; ?> <br />
                                                                Days to Finish: <?php echo $item->daystofinish; ?>
                                                            </td>
                                                            
                                                            <td>
                                                                <?php echo $item->offer_text; ?>
                                                            </td>
                                                            
                                                            <td>
                                                                
                                                                <div class="btn-group">
                                                                    <a href="<?php echo base_url("Educator/ManageEBooks/Details/$item->id") ?>"
                                                                    class="btn btn-sm btn-outline-success waves-effect waves-light">
                                                                    <i class="fa fa-eye"></i> </a>
                                                                    <a href="<?php echo base_url("Educator/ManageEBooks/Edit/$item->id") ?>"
                                                                    class="btn btn-sm btn-outline-info waves-effect waves-light">
                                                                    <i class="fa fa fa-edit"></i> </a>
                                                                    <a href="javascript:void(0);"
                                                                    class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                                    onclick="return ebookdelete(this,'tbl_ebook','id','<?php echo $item->id;?>','ebook','logo,banner,sample,ebbook')">
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
                                <!-- Manage E-Books Card End -->
                                
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
                
                function ebookstatus(e, table, where_column, where_value, column) {
                    var status = true;
                    var check = $(e).prop("checked");
                    if (check) {
                        swal({
                            title: "Are you sure?",
                            text: "You want to activate this ebook !",
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
                                        swal("This ebook is activated successfully !", {
                                            icon: "success",
                                        });
                                    }
                                });
                            }
                        });
                        } else {
                        swal({
                            title: "Are you sure?",
                            text: "You want to deactivate this ebook !",
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
                                        swal("This ebook is deactivated successfully !", {
                                            icon: "success",
                                        });
                                    }
                                });
                            }
                        });
                    }
                    return status;
                }
                
                function ebookdelete(e, table, where_column, where_value, unlink_folder, unlink_column) {
                    var status = true;
                    swal({
                        title: "Are you sure?",
                        text: "You want to delete this ebook !",
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
                                    swal("This ebook is deleted successfully !", {
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