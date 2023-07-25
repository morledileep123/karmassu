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
                     <h4 class="page-title"> Manage Sliders</h4>
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javaScript:void();">App Management</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Sliders</li>
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
                              class="fa fa-plus-circle"></i> Add Slider</button>
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                              <table class="table table-bordered" id="example">
                                 <thead>
                                    <tr>
                                       <th>#</th>
                                       <th>Status</th>
                                       <th>Banner 1</th>
                                       <th>Banner 2</th>
                                       <th>Image</th>
                                       <th>Title</th>
                                       <th>Tagline</th>
                                       <th>Button Text</th>
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
                                          <input type="checkbox"
                                             onchange="return Status(this,'tbl_slider','id','<?php echo $item->id; ?>','status')"
                                             <?php if ($item->status == "true") {
                                                echo "checked"; } ?> class="js-switch" data-color="#eb5076" data-size="small">
                                       </td>
                                       <td>
                                          <input type="checkbox"
                                             onchange="return BannersStatus(this,'tbl_slider','<?php echo $item->id; ?>','banner_1','Banner 1')" <?php if ($item->banner_1 == "true") {
                                                echo "checked"; } ?> class="js-switch" data-color="#42a9de" data-size="small">
                                       </td>
                                       <td>
                                          <input type="checkbox"
                                             onchange="return BannersStatus(this,'tbl_slider','<?php echo $item->id; ?>','banner_2','Banner 2')" <?php if ($item->banner_2 == "true") {
                                                echo "checked"; } ?> class="js-switch" data-color="#42a9de" data-size="small">
                                       </td>
                                       <td> <label data-toggle="tooltip" data-placement="top"
                                          title="Slider ID: <?php echo $item->id; ?>"><a
                                          href="<?php echo base_url("uploads/slider/$item->image"); ?>"
                                          target="_blank"><img
                                          data-src="<?php echo base_url("uploads/slider/$item->image"); ?>"
                                          src="<?php echo base_url("images/Preloader2.jpg"); ?>"
                                          class="lazy" style="height:50px;" /> </a></label>
                                       </td>
                                       <td> <?php echo $item->title; ?> </td>
                                       <td> <?php echo $item->tagline; ?> </td>
                                       <td> <?php echo $item->button; ?> </td>
                                       <td> <?php echo $item->parameter; ?> </td>
                                       <td>
                                          <?php
                                             if($item->parameter=='Category'){
                                                 echo $this->Auth_model->getData('tbl_category',$item->link)->title;
                                             }
                                             else if($item->parameter=='Course'){
                                                 echo $this->Auth_model->getData('tbl_course',$item->link)->name;
                                             }
                                             else if($item->parameter=='Ebook'){
                                                 echo $this->Auth_model->getData('tbl_ebook',$item->link)->name;
                                             }
                                             else if($item->parameter=='Abook'){
                                                 echo $this->Auth_model->getData('tbl_abook',$item->link)->name;
                                             }
                                             else if($item->parameter=='Quiz'){
                                                 echo $this->Auth_model->getData('tbl_quiz',$item->link)->name;
                                             }
                                             else if($item->parameter=='LiveSession'){
                                                 echo $this->Auth_model->getData('tbl_live_video',$item->link)->title;
                                             }
                                             else if($item->parameter=='FreeVideo'){
                                                 echo $video=$this->Auth_model->getData('tbl_recommended_videos',$item->link)->video;
                                                 echo $this->Auth_model->getData('tbl_video',$video)->title;
                                             }
                                             else if($item->parameter=='Offer'){
                                                 $couponData=$this->Auth_model->getData('tbl_offer',$item->link);
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
                                             <a href="javascript:void(0);"
                                                class="btn btn-sm btn-outline-info waves-effect waves-light"
                                                onclick="Edit('<?php echo $item->id; ?>')">
                                             <i class="fa fa fa-edit"></i> </a>
                                             <a href="javascript:void(0);"
                                                class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                onclick="return Delete(this,'tbl_slider','id','<?php echo $item->id; ?>','slider','image')">
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
                     <h5 class="modal-title text-white">Add Slider</h5>
                     <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <form action="<?php echo base_url("AdminPanel/ManageAppSliders/Add"); ?>" method="post"
                     enctype="multipart/form-data" id="addform">
                     <div class="modal-body">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                           value="<?= $this->security->get_csrf_hash(); ?>" />
                        <div class="form-group">
                           <label class="col-form-label">Title <span class="text-danger"></span></label>
                           <input type="text" class="form-control" name="title" placeholder="Enter Title">
                           <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
                        </div>
                        <div class="form-group">
                           <label class="col-form-label">Tagline <span class="text-danger"></span></label>
                           <textarea class="form-control" name="tagline" placeholder="Enter Tagline"></textarea>
                           <?php echo form_error("tagline", "<p class='text-danger' >", "</p>"); ?>
                        </div>
                        <div class="form-group">
                           <label class="col-form-label">Button Text <span class="text-danger"></span></label>
                           <input type="text" class="form-control" name="button" placeholder="Enter Button Text">
                           <?php echo form_error("button", "<p class='text-danger' >", "</p>"); ?>
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
                           <label class="col-form-label">Image <span class="text-danger">*</span></label>
                           <input type="file" class="form-control" name="image" title="Upload Slider Image"
                              required accept="image/jpg, image/png, image/jpeg, image/gif">
                           <?php echo form_error("image", "<p class='text-danger' >", "</p>"); ?>
                        </div>
                     </div>
                     <div class="modal-footer d-block">
                        <button type="submit" id="addaction" name="addaction" class="btn btn-primary">
                        <i class="icon-lock"></i> Add Slider</button>
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
                     <h5 class="modal-title text-white">Edit Slider</h5>
                     <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <form action="<?php echo base_url("AdminPanel/ManageAppSliders/Update"); ?>" method="post"
                     enctype="multipart/form-data" id="updateform">
                     <div class="modal-body">
                     </div>
                     <div class="modal-footer d-block">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                           value="<?= $this->security->get_csrf_hash(); ?>" />
                        <button type="submit" id="updateaction" name="updateaction"
                           class="btn btn-primary"><i class="icon-lock"></i> Update Slider</button>
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
             $("#EditModal .modal-body").load("<?php echo base_url('AdminPanel/ManageAppSliders/Edit/') ?>" + id);
         }
      </script>
      <script>
      
        function BannersStatus(e, table, id, column, type) {
             var status = true;
             var check = $(e).prop("checked");
             if (check) {
                 swal({
                     title: "Are you sure?",
                     text: "You want to activate this "+type+" !",
                     icon: "warning",
                     buttons: true,
                     dangerMode: true
                     }).then((willDelete) => {
                     if (willDelete) {
                         $.ajax({
                             url: "<?php echo base_url("AdminPanel/BannersStatus"); ?>",
                             type: "post",
                             data: {
                                 'table': table,
                                 'id': id,
                                 'column': column,
                                 'type': type,
                                 'value': 'true'
                             },
                             success: function(response) {
                                 swal("Activated successfully !", {
                                     icon: "success",
                                 });
                                 location.reload();
                             }
                         });
                     }
                 });
                 } else {
                 swal({
                     title: "Are you sure?",
                     text: "You want to deactivate this "+type+" !",
                     icon: "warning",
                     buttons: true,
                     dangerMode: true
                     }).then((willDelete) => {
                     if (willDelete) {
                         $.ajax({
                             url: "<?php echo base_url("AdminPanel/BannersStatus"); ?>",
                             type: "post",
                             data: {
                                 'table': table,
                                 'id': id,
                                 'column': column,
                                 'type': type,
                                 'value': 'false'
                             },
                             success: function(response) {
                                 
                                 swal("Deactivated successfully !", {
                                     icon: "success",
                                 });
                                 location.reload();
                             }
                         });
                     }
                 });
             }
             return status;
         }
         
         function Status(e, table, where_column, where_value, column) {
             var status = true;
             var check = $(e).prop("checked");
             if (check) {
                 swal({
                     title: "Are you sure?",
                     text: "You want to activate this slider !",
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
                                 swal("This slider is activated successfully !", {
                                     icon: "success",
                                 });
                             }
                         });
                     }
                 });
                 } else {
                 swal({
                     title: "Are you sure?",
                     text: "You want to deactivate this slider !",
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
                                 swal("This slider is deactivated successfully !", {
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
                 text: "You want to delete this slider !",
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
                             swal("This slider is deleted successfully !", {
                                 icon: "success",
                             });
                             location.reload();
                         }
                     });
                 }
             });
             return status;
         }
         function getParameterData(parameter){
             alert(parameter);
             if(parameter=='External'){
                 $(".parameter-data").html('<label class="col-form-label">External Link <span class="text-danger">*</span></label><input type="text" class="form-control" name="data" placeholder="Enter Link " required >');
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