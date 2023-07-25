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
                            <h4 class="page-title"> Manage Contacts</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">Website Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Contacts</li>
                            </ol>
                        </div>
                        <div class="col-sm-3">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        
                                        <table class="table table-bordered wrap" id="example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Subject</th>
                                                    <th>Message</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                <?php
                                                    $sr = 1;
                                                    foreach ($contactlist as $item) {
                                                        
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sr; ?></td>
                                                        <td><?php echo $item->name; ?></td>
                                                        <td><?php echo $item->email; ?></td>
                                                        <td><?php echo $item->number; ?></td>
                                                        <td><?php echo $item->subject; ?></td>
                                                        <td><?php echo $item->msg; ?></td>
                                                        <td><?php echo $item->date; ?></td>
                                                        <td>
                                                        <a href="javascript:void(0);"
                                                        class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                        onclick="return Delete(this,'tbl_contact','id','<?php echo $item->id; ?>','','')">
                                                        <i class="fa fa-trash"></i> </a>
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
                            
                        </div>
                    </div>
                    <div class="overlay toggle-menu"></div>
                </div>
            </div>
            <?php include("Footer.php"); ?>
        </div>
        <?php include("FooterLinking.php"); ?>
        <script>
            function Status(e, table, where_column, where_value, column) {
                var status = true;
                var check = $(e).prop("checked");
                if (check) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to activate this contact !",
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
                                    swal("This contact is activated successfully !", {
                                        icon: "success",
                                    });
                                }
                            });
                        }
                    });
                    } else {
                    swal({
                        title: "Are you sure?",
                        text: "You want to deactivate this contact !",
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
                                    swal("This contact is deactivated successfully !", {
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
                    text: "You want to delete this contact !",
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
                                swal("This contact is deleted successfully !", {
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