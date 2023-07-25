<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<?php
    if($list[0]->type=='Free'){
        $percentage=0;
    }
    else{
        $dicountedprice=($list[0]->price)-($list[0]->offerprice);
        $percentage=($dicountedprice*100)/$list[0]->price;
        $percentage=round($percentage,2); 
    }
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
                            <h4 class="page-title">Manage Courses</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javaScript:void();">Course</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Course</li>
                            </ol>
                        </div>
                        <div class="col-sm-3">
                            
                            
                        </div>
                    </div>
                    <!-- End Breadcrumb-->
                    
                    <div class="row">
                        <div class="col-sm-12">
                            
                            <!-- Form Card Start -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title"><?php echo $list[0]->name;?></div>
                                    <hr>
                                    <form action="<?php echo base_url("AdminPanel/ManageCourses/Update"); ?>" method="post" enctype="multipart/form-data" id="addform" >
                                        
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />	
                                        <input type="hidden" name="id" value="<?= $list[0]->id;?>" />
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Category <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="category" required>
                                                    <option selected disabled>Select</option>
                                                    <?php
                                                        foreach ($categorylist as $item){
                                                        ?>
                                                        <option value="<?php echo $item->id;?>" <?php if($item->id==$list[0]->category){ echo 'selected'; }?>><?php echo $item->title;?></option>
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                                <?php echo form_error("category","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Author <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="author" required>
                                                    <option selected disabled>Select</option>
                                                    <?php
                                                        foreach ($authorlist as $item){
                                                        ?>
                                                        <option value="<?php echo $item->id;?>" <?php if($item->id==$list[0]->author){ echo 'selected'; }?>><?php echo $item->name;?></option>
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                                <?php echo form_error("category","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Course Name <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="coursename" placeholder="Enter Course Name" required value="<?php echo $list[0]->name;?>">
                                                <?php echo form_error("coursename","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Course Type <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <div class="icheck-material-danger">
                                                    <input type="radio" id="paidradio" value="Paid" name="coursetype" required <?php if($list[0]->type=='Paid'){ echo 'checked';}?>/>
                                                    <label for="paidradio">Paid</label>
                                                </div>
                                                <div class="icheck-material-success">
                                                    <input type="radio" id="freeradio" value="Free" name="coursetype" required <?php if($list[0]->type=='Free'){ echo 'checked';}?>/>
                                                    <label for="freeradio">Free</label>
                                                </div>
                                                <?php echo form_error("coursetype","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row" id="pricediv" >
                                            <label  class="col-sm-2 col-form-label">Course Price <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" id="courseprice" value="<?php echo $list[0]->price;?>" class="form-control" name="courseprice" placeholder="Enter Course Price" >
                                                <?php echo form_error("courseprice","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row" id="checkofferdiv">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-10">
                                                <div class="icheck-material-success">
                                                    <input type="checkbox" id="offercheck" <?php if($list[0]->price!=$list[0]->offerprice){ echo 'checked';}?> />
                                                    <label for="offercheck">Add Offer Price</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row" id="offerpricediv">
                                            <label  class="col-sm-2 col-form-label">Course Offer Price</label>
                                            <div class="col-sm-10">
                                                <input type="number" id="offerprice" class="form-control" name="courseofferprice" placeholder="Enter Course Offer Price" value="<?php echo $list[0]->offerprice;?>">
                                                <br/>
                                                <input type="text" id="discountpercentage" name="discountpercentage" readonly class="form-control form-control-rounded" value="<?php echo $percentage;?> Off"/>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Course Short Description <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="courseshortdescription" placeholder="Enter Course Short Description" required><?php echo $list[0]->shortdesc;?></textarea>
                                                <?php echo form_error("courseshortdescription","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">No of Videos <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="noofvideos" placeholder="Enter No of Videos" required value="<?php echo $list[0]->nooflecture;?>">
                                                <?php echo form_error("noofvideos","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Days to Finish <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="daystofinish" placeholder="Enter Days to Finish" required value="<?php echo $list[0]->daystofinish;?>">
                                                <?php echo form_error("daystofinish","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Launching Time <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="datetime-local" class="form-control" name="timing" placeholder="Launching Time" required value="<?php echo $list[0]->timing;?>">
                                                <?php echo form_error("timing","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Is this course includes certification ? <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <div class="icheck-material-success">
                                                    <input type="radio" id="yesradio" value="Yes" name="certificationcheck" <?php if($list[0]->certification=='Yes'){ echo 'checked';}?>/>
                                                    <label for="yesradio">Yes</label>
                                                </div>
                                                <div class="icheck-material-danger">
                                                    <input type="radio" id="noradio"  value="No" name="certificationcheck" <?php if($list[0]->certification=='No'){ echo 'checked';}?> />
                                                    <label for="noradio">No</label>
                                                </div>
                                                <?php echo form_error("certificationcheck","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        
                                        <div  id="certificatediv">
                                            <div class="form-group row">
                                                <label  class="col-sm-2 col-form-label">Certificate Theme  <span class="text-danger">*</span></label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="certificate" id="certificateTheme" onchange="certificateThemePreview(this.value)">
                                                        <option selected disabled>Select</option>
                                                        <?php
                                                            foreach ($this->certificateTheme as $item => $value){
                                                            ?>
                                                            <option value="<?php echo $value;?>" <?php if($value==$list[0]->certificate){ echo 'selected'; } ?>><?php echo $item;?></option>
                                                            <?php
                                                            }
                                                        ?>
                                                    </select>
                                                    <?php echo form_error("certificate","<p class='text-danger' >","</p>"); ?>
                                                    
                                                    <p id="certificateThemePreview"><?php if($list[0]->certification=='Yes'){ echo '<a href="'.base_url("AdminPanel/ManageCourses/Certificate/".$list[0]->id).'" target="_blank" class="text-info">View Certificate</a>';}?></p>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label  class="col-sm-2 col-form-label">Certificate Hardcopy Charge<span class="text-danger">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" name="certificate_charge"  id="certificate_charge" placeholder="Certificate Charge" value="<?php echo $list[0]->certificate_charge;?>">
                                                    <?php echo form_error("certificate_charge","<p class='text-danger' >","</p>"); ?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label  class="col-sm-2 col-form-label">Per KM Delivery Charge<span class="text-danger">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" name="km_charge"  id="km_charge" placeholder="Per KM Charge" value="<?php echo $list[0]->km_charge;?>">
                                                    <?php echo form_error("km_charge","<p class='text-danger' >","</p>"); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Description <span class="text-danger"></span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control summernote" id="description" name="description" ><?php echo $list[0]->description;?></textarea>
                                                <?php echo form_error("description","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Requirements <span class="text-danger"></span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control summernote" id="" name="requirement" ><?php echo $list[0]->requirement;?></textarea>
                                                <?php echo form_error("requirement","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">What this course include ? <span class="text-danger"></span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control summernote" name="course_include" ><?php echo $list[0]->course_include;?></textarea>
                                                <?php echo form_error("course_include","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">What you will learn ? <span class="text-danger"></span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control summernote"  name="will_learn" ><?php echo $list[0]->will_learn;?></textarea>
                                                <?php echo form_error("will_learn","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Course Logo <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="file" class="form-control" name="courselogo" title="Upload Course Logo" accept="image/jpg, image/png, image/jpeg, image/gif">
                                                <?php echo form_error("courselogo","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <a href="../../../uploads/course/<?php echo $list[0]->logo; ?>" target="_blank"><?php echo $list[0]->logo; ?></a>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Course Banner <span class="text-danger">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="file" class="form-control" name="coursebanner" title="Upload Course Banner" accept="image/jpg, image/png, image/jpeg, image/gif">
                                                <?php echo form_error("coursebanner","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <a href="../../../uploads/course/<?php echo $list[0]->banner; ?>" target="_blank"><?php echo $list[0]->banner; ?></a>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Course Demo Video Link <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="coursedemovideo" placeholder="Enter Course Demo Link (YouTube)" required value="<?php echo $list[0]->demovedio;?>">
                                                <?php echo form_error("coursedemovideo","<p class='text-danger' >","</p>"); ?>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-10">
                                                <div class="icheck-material-danger">
                                                    <input type="checkbox" id="comfirmsubmit" required />
                                                    <label for="comfirmsubmit">Confirm Submission</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-10">
                                                <button type="submit" id="updateaction" name="updateaction" class="btn btn-primary px-5"><i class="icon-lock"></i> Update Course</button>
                                            </div>
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Form Card End -->
                            
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
        
        <?php
            include("FooterLinking.php");
        ?>
        
        <script>
            $(function() {
                $(".knob").knob();
            });
        </script>
        <!-- Index js -->
        <script src="<?php base_url("assets_panel/js/index.js"); ?>"></script>
        <script>
            $(document).ready(function(){
            
            // Apply Summer Note on About Course
            $('.summernote').summernote({
            height: 200,
            tabsize: 2
            });
            
            $("#addaction").attr("disabled",true);
            
            <?php if($list[0]->type=='Paid'){ echo '$("#pricediv").show();$("#checkofferdiv").show();';} else { echo '$("#pricediv").hide();$("#checkofferdiv").hide();';}?>
            <?php if(($list[0]->offerprice)>0){ echo '$("#offerpricediv").show();';} else { echo '$("#offerpricediv").hide();';}?>
            
            $("#paidradio").change(function(){
            var check=$(this).prop("checked");
            if(check)
            {
            $("#pricediv").show();
            $("#checkofferdiv").show();
            }
            });
            $("#freeradio").change(function(){
            var check=$(this).prop("checked");
            if(check)
            {
            $("#pricediv").hide();
            $("#courseprice").val("0");
            $("#checkofferdiv").hide();
            }
            });
            
            $("#offercheck").change(function(){
            var check=$(this).prop("checked");
            if(check)
            {
            $("#offerpricediv").show();
            }
            else
            {
            $("#offerpricediv").hide();
            }
            
            });
            
            $("#offerprice").keyup(function(){
            var courseprice=($("#courseprice").val()=="")?0:$("#courseprice").val();
            var offerprice=$(this).val();
            var dicountedprice=courseprice-offerprice;
            var percentage=(dicountedprice*100)/courseprice;
            var percentage=percentage.toFixed(2);
            $("#discountpercentage").val(percentage+"% Off");
            });
            
            
            
            $("#comfirmsubmit").change(function(){
            
            var check =$(this).prop("checked");
            if(check)
            {
            $("#addaction").attr("disabled",false);
            }
            else{
            $("#addaction").attr("disabled",true);
            }
            
            });
            
            <?php if($list[0]->certification=='Yes'){ echo '$("#certificatediv").show();$("#certificateTheme").prop("required",true);$("#certificate_charge").prop("required",true);$("#km_charge").prop("required",true);';} else { echo '$("#certificatediv").hide();$("#certificateTheme").prop("required",false);$("#certificate_charge").prop("required",false);$("#km_charge").prop("required",false);';}?>
            
            $("#yesradio").change(function(){
                var check=$(this).prop("checked");
                if(check)
                {
                    $("#certificatediv").show();
                    $('#certificateTheme').prop('required',true);
                    $('#certificate_charge').prop('required',true);
                    $('#km_charge').prop('required',true);
                }
            });
            $("#noradio").change(function(){
                var check=$(this).prop("checked");
                if(check)
                {
                    $("#certificatediv").hide();
                    $('#certificateTheme').prop('required',false);
                    $('#certificate_charge').prop('required',false);
                    $('#km_charge').prop('required',false);
                }
            });
            
        });
        
    function certificateThemePreview(certificateTheme){
        $("#certificateThemePreview").html('<br><a href="<?php echo base_url("AdminPanel/Certificates/Preview/")?>'+certificateTheme+'" target="_blank">View Certificate</a>');
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