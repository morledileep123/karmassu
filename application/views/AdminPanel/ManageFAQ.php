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
                        <h4 class="page-title"> Manage FAQ</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javaScript:void();">Website Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage FAQ</li>
                        </ol>
                    </div>
                    <div class="col-sm-3">

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#AddModal"><i
                                        class="fa fa-plus-circle"></i> Add FAQ</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table class="table table-bordered wrap" id="example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Status</th>
                                                <th>Title</th>
                                                <th>Description</th>
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
                                                    <input type="checkbox"
                                                        onchange="return Status(this,'tbl_faq','id','<?php echo $item->id; ?>','status')"
                                                        <?php if ($item->status == "true") {
                                                                                                                                                                                        echo "checked";
                                                                                                                                                                                    } ?> class="js-switch"
                                                        data-color="#eb5076" data-size="small">
                                                </td>
                                                <td>
                                                    <?php echo $item->title; ?>

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
                                                <td>

                                                    <div class="btn-group">
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-sm btn-outline-info waves-effect waves-light"
                                                            onclick="Edit('<?php echo $item->id; ?>')">
                                                            <i class="fa fa fa-edit"></i> </a>
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                            onclick="return Delete(this,'tbl_faq','id','<?php echo $item->id; ?>','','')">
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

                    </div>
                </div>
                <div class="overlay toggle-menu"></div>
            </div>
        </div>

        <?php include("Footer.php"); ?>
        <!--Modal Start-->
        <div class="modal fade" id="AddModal">
            <div class="modal-dialog">
                <div class="modal-content border-primary">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">Add FAQ</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo base_url("AdminPanel/ManageFAQ/Add"); ?>" method="post"
                        enctype="multipart/form-data" id="addform">
                        <div class="modal-body">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>" />
                            
                            <div class="form-group">
                                <label class="col-form-label"> Title<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" placeholder="Enter Title" required>
                                <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control summernote" name="description"
                                    placeholder="Enter  Description" required></textarea>
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
        <div class="modal fade" id="EditModal">
            <div class="modal-dialog">
                <div class="modal-content border-primary">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">Edit FAQ</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="<?php echo base_url("AdminPanel/ManageFAQ/Update"); ?>" method="post"
                        enctype="multipart/form-data" id="updateform">
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer d-block">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>" />
                            <button type="submit" id="updateaction" name="updateaction" class="btn btn-primary"><i
                                    class="icon-lock"></i> Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!--Modal End-->
    </div>

    <?php include("FooterLinking.php"); ?>
    <script>
    function Edit(id) {
        $("#EditModal").modal("show");
        $("#EditModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
        $("#EditModal .modal-body").load("<?php echo base_url('AdminPanel/ManageFAQ/Edit/') ?>" + id);
    }
    </script>
    <script>
    $('.summernote').summernote({
        height: 200,
        tabsize: 2
    });
    </script>

    <script>
    function Status(e, table, where_column, where_value, column) {
        var status = true;
        var check = $(e).prop("checked");
        if (check) {
            swal({
                title: "Are you sure?",
                text: "You want to activate this blog !",
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
                            swal("This blog is activated successfully !", {
                                icon: "success",
                            });
                        }
                    });
                }
            });
        } else {
            swal({
                title: "Are you sure?",
                text: "You want to deactivate this blog !",
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
                            swal("This blog is deactivated successfully !", {
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
            text: "You want to delete this blog !",
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
                        swal("This blog is deleted successfully !", {
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