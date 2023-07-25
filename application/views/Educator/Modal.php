<?php defined("BASEPATH") or exit("No direct scripts allowed here"); ?>
<?php
    if (isset($action)) 
    {
        switch ($action) 
        {
            
            
            case 'EditVideo';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Subject <span class="text-danger">*</span></label>
            <select class="form-control" name="subject" required>
                <option selected disabled>Select</option>
                <?php foreach ($subject as $item) { ?>
                    <option value="<?php echo $item->id;?>" <?php if($list[0]->subject==$item->id){ echo 'selected'; }?>><?php echo $item->name;?></option>
                <?php } ?>
            </select>
            <?php echo form_error("subject", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Video Type <span class="text-danger">*</span></label>
            <select class="form-control" name="type" required onchange="videoType(this.value)">
                <option selected disabled>Select</option>
                <option value="External" <?php if($list[0]->type=='External'){ echo 'selected'; } else{ echo ''; }?>>External</option>
                <option value="Internal" <?php if($list[0]->type=='Internal'){ echo 'selected'; } else{ echo ''; }?>>Internal</option>
            </select>
            <?php echo form_error("type", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group" style="max-height:300px;overflow:scroll;" id="thumbnailInternal1">
            <label class="col-form-label">Thumbnail <span class="text-danger">*</span></label>
            <?php
                $count1=0;
                $newpath='uploads/thumbnail/'.$this->session->userdata("EducatorLoginData")[0]["username"].'/';
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
                                    <input type="radio" id="thumb<?php echo $count1; ?>" name="thumbnail" value="<?php echo $file; ?>"  <?php if($list[0]->type=='External'){ echo ''; } else{ echo 'required'; } ?> <?php if($list[0]->thumbnail==$file){ echo 'checked';} ?>/>
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
                    echo "No Thumbnail Found in Folder, Please Upload using FTP.";
                }
            ?>
            <?php echo form_error("thumbnail", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group" style="max-height:300px;overflow:scroll;display:<?php if($list[0]->type=='External'){ echo 'none'; } else{ echo 'block'; } ?>;" id="videoInternal1">
            <label class="col-form-label">Video <span class="text-danger">*</span></label>
            <?php
                $count1=0;
                $newpath='uploads/video/'.$this->session->userdata("EducatorLoginData")[0]["username"].'/';
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
                                    <input type="radio" id="video<?php echo $count1; ?>" name="video" value="<?php echo $file; ?>"  <?php if($list[0]->type=='External'){ echo ''; } else{ echo 'required'; } ?> <?php if($list[0]->video==$file){ echo 'checked';} ?> />
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
                    echo "No Video Found in Folder, Please Upload using FTP.";
                }
            ?>
            <?php echo form_error("video", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group" id="videoExternal1" style="display:<?php if($list[0]->type=='Internal'){ echo 'none'; } else{ echo 'block'; } ?>;">
            <label class="col-form-label">Video Link <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="link" placeholder="Link" value="<?php echo $list[0]->link;?>">
            <?php echo form_error("link", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Notes<span class="text-danger"></span></label>
            <input type="file" class="form-control" name="notes"  accept="application/pdf">
            <?php echo form_error("notes","<p class='text-danger' >","</p>"); ?>
            <?php if($list[0]->notes!='') { ?>
                <a href="../../../uploads/notes/<?php echo $list[0]->notes; ?>" target="_blank"><?php echo $list[0]->notes; ?></a>
            <?php }?>
        </div>
        
        <div class="form-group">
            <label class="col-form-label">Duration <span class="text-danger">*</span></label>
            <input type="text" class="form-control text-uppercase" name="duration" placeholder="Duration" required value="<?php echo $list[0]->duration;?>">
            <?php echo form_error("duration", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" placeholder="Title" required value="<?php echo $list[0]->title;?>">
            <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control" name="description"
            placeholder="Description" required><?php echo $list[0]->description;?></textarea>
            <?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <script>
            function videoType(type){
                if(type=='External'){
                    $("#videoInternal1").hide();
                    // $("#thumbnailInternal1").hide();
                    $("#videoExternal1").show();
                    $("input[name='video']").removeAttr('required');
                    // $("input[name='thumbnail']").removeAttr('required');
                    $("input[name='link']").attr('required');
                }
                else{
                    $("#videoInternal1").show();
                    // $("#thumbnailInternal1").show();
                    $("#videoExternal1").hide();
                    $("input[name='video']").attr('required');
                    // $("input[name='thumbnail']").attr('required');
                    $("input[name='link']").removeAttr('required');
                }
            }
        </script>
        <?php
            break;
            
            case 'EditVideoAssignment';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
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
                <?php foreach ($video as $item) { ?>
                    <option value="<?php echo $item->id;?>" <?php if($list[0]->video==$item->id){ echo 'selected'; }?>><?php echo $item->title;?></option>
                <?php } ?>
            </select>
            <?php echo form_error("Video", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="col-form-label">Assignment <span class="text-danger"></span></label>
                    <input type="file" class="form-control" name="assignment" title="Upload Assignment">
                    <?php echo form_error("assignment","<p class='text-danger' >","</p>"); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <iframe src="<?php echo base_url('uploads/assignment/'.$list[0]->assignment.'')?>" style="height:100px;width:100%;"></iframe>
            </div>
        </div>
        <div class="form-group">
            <label class="col-form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control summernote" name="description"
            placeholder="Description" required><?php echo $list[0]->description;?></textarea>
            <?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <script>
            $('.summernote').summernote({
                height: 200,
                tabsize: 2
            });
            
        </script>
        <?php
            break;
            
            case 'EditCertificate';
        ?>
        <div class="row">
            <input type="hidden" name="userid" value="<?php echo $certificateData->userid;?>" />
            <input type="hidden" name="enrollid" value="<?php echo $certificateData->enrollid;?>" />
            <input type="hidden" name="itemid" value="<?php echo $certificateData->itemid;?>" />
            <input type="hidden" name="itemtype" value="<?php echo $certificateData->itemtype;?>" />
            <input type="hidden" name="status" value="<?php echo $certificateData->status;?>" />
            <div class="form-group col-sm-6">
                <label class="col-form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" placeholder="Name" required
                value="<?php echo $certificateData->name;?>">
                <?php echo form_error("name", "<p class='text-danger' >", "</p>"); ?>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-form-label">Mobile No <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="mobile" placeholder="Mobile No" required
                value="<?php echo $certificateData->mobile;?>">
                <?php echo form_error("mobile", "<p class='text-danger' >", "</p>"); ?>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-form-label">Email<span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" placeholder="Email" required
                value="<?php echo $certificateData->email;?>">
                <?php echo form_error("email", "<p class='text-danger' >", "</p>"); ?>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-form-label">Grade <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="grade" placeholder="Grade" required
                value="<?php echo $certificateData->grade;?>">
                <?php echo form_error("grade", "<p class='text-danger' >", "</p>"); ?>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-form-label">Duration <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="duration" placeholder="Duration" required
                value="<?php echo $certificateData->duration;?>">
                <?php echo form_error("duration", "<p class='text-danger' >", "</p>"); ?>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-form-label">From Date<span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="from_date" required
                value="<?php echo $certificateData->from_date;?>">
                <?php echo form_error("from_date", "<p class='text-danger' >", "</p>"); ?>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-form-label">To Date<span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="to_date" required
                value="<?php echo $certificateData->to_date;?>">
                <?php echo form_error("to_date", "<p class='text-danger' >", "</p>"); ?>
            </div>
            
            <div class="form-group col-sm-6">
                <label class="col-form-label">Issued On Date<span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="issuedon" required
                value="<?php echo $certificateData->issuedon;?>">
                <?php echo form_error("issuedon", "<p class='text-danger' >", "</p>"); ?>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-form-label">Status <span class="text-danger">*</span></label>
                <select class="form-control" name="status" required>
                    <option  value="true" <?php if($certificateData->status=='true'){ echo 'selected'; } ?>>Yes</option>
                    <option  value="false" <?php if($certificateData->status=='false'){ echo 'selected'; } ?>>No</option>
                    
                </select>
                <?php echo form_error("status", "<p class='text-danger' >", "</p>"); ?>
            </div>
        </div>
        <?php
            break;
            
            case 'EditLiveVideo';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <input type="hidden" name="author" value="<?php echo $this->author;?>" />
        <div class="form-group">
            <label class="col-form-label">Subject <span class="text-danger">*</span></label>
            <input type="text" class="form-control text-uppercase" name="subject" placeholder="Subject"
            required value="<?php echo $list[0]->subject;?>">
            <?php echo form_error("subject", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Tags <span class="text-danger">*</span></label>
            <input type="text" class="form-control text-uppercase" name="tags" placeholder="Tags"
            required value="<?php echo $list[0]->tags;?>">
            <?php echo form_error("tags", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" placeholder="Title" required value="<?php echo $list[0]->title;?>">
            <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Timing <span class="text-danger">*</span></label>
            <input type="datetime-local" class="form-control" name="timing" required value="<?php echo $list[0]->timing;?>">
            <?php echo form_error("timing", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Duration <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="duration" placeholder="Duration" required value="<?php echo $list[0]->duration;?>">
            <?php echo form_error("duration", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group d-none">
            <label class="col-form-label">Link <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="link" placeholder="Link"
            value="<?php echo $list[0]->link;?>">
            <?php echo form_error("link", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group d-none">
            <label class="col-form-label">User ID of Live Session<span class="text-danger"></span></label>
            <input type="text" class="form-control" name="userid" placeholder="User ID"  value="<?php echo $list[0]->userid;?>">
            <?php echo form_error("userid", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group d-none">
            <label class="col-form-label">Password of Live Session<span class="text-danger"></span></label>
            <input type="text" class="form-control" name="password" placeholder="Password"  value="<?php echo $list[0]->password;?>">
            <?php echo form_error("password", "<p class='text-danger' >", "</p>"); ?>
        </div>
        
        <div class="form-group">
            <label  class="col-form-label">Is this Live Session includes certification ? <span class="text-danger">*</span></label>
            <div class="icheck-material-success">
                <input type="radio" id="yesradio1" class="certificationcheck1" value="Yes" name="certificationcheck" <?php if($list[0]->certification=='Yes'){ echo 'checked';}?>/>
                <label for="yesradio1">Yes</label>
            </div>
            <div class="icheck-material-danger">
                <input type="radio" id="noradio1" class="certificationcheck1"  value="No" name="certificationcheck"  <?php if($list[0]->certification=='No'){ echo 'checked';}?> />
                <label for="noradio1">No</label>
            </div>
            <?php echo form_error("certificationcheck","<p class='text-danger' >","</p>"); ?>
        </div>
        <div  id="certificatediv1">
            <div class="form-group">
                <label  class="col-form-label">Certificate Theme  <span class="text-danger">*</span></label>
                <select class="form-control" name="certificate" id="certificateTheme1" onchange="certificateThemePreview(this.value)">
                    <option selected disabled>Select</option>
                    <?php
                        foreach ($this->certificateTheme as $item => $value){
                        ?>
                        <option value="<?php echo $value;?>" <?php if($value==$list[0]->certificate){ echo 'selected'; }?>><?php echo $item;?></option>
                        <?php
                        }
                    ?>
                </select>
                <?php echo form_error("certificate","<p class='text-danger' >","</p>"); ?>
                <p id="certificateThemePreview1"><?php if($list[0]->certification=='Yes'){ echo '<a href="'.base_url("AdminPanel/ManageLiveVideo/Certificate/".$list[0]->id).'" target="_blank" class="text-info">View Certificate</a>';}?></p>
            </div>
            <div class="form-group">
                <label  class="col-form-label">Certificate Hardcopy Charge<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="certificate_charge"  id="certificate_charge1" placeholder="Certificate Charge" value="<?php echo $list[0]->certificate_charge;?>">
                <?php echo form_error("certificate_charge","<p class='text-danger' >","</p>"); ?>
            </div>
            <div class="form-group">
                <label  class="col-form-label">Per KM Delivery Charge<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="km_charge"  id="km_charge1" placeholder="Per KM Charge" value="<?php echo $list[0]->km_charge;?>">
                <?php echo form_error("km_charge","<p class='text-danger' >","</p>"); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control" name="description"
            placeholder="Description" required><?php echo $list[0]->description;?></textarea>
            <?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="col-form-label">Thumbnail <span class="text-danger"></span></label>
                    <input type="file" class="form-control" name="thumbnail" title="Upload Thumbnail">
                    <?php echo form_error("thumbnail","<p class='text-danger' >","</p>"); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <img src="<?php echo base_url('uploads/live_video/'.$list[0]->thumbnail.'')?>" style="height:100px;width:100%;">
            </div>
        </div>
        <script>
            $(document).ready(function(){
                <?php if($list[0]->certification=='Yes'){ echo '$("#certificatediv1").show();$("#certificateTheme1").prop("required",true);$("#certificate_charge1").prop("required",true);$("#km_charge1").prop("required",true);';} else { echo '$("#certificatediv1").hide();$("#certificateTheme1").prop("required",false);$("#certificate_charge1").prop("required",false);$("#km_charge1").prop("required",false);';}?>
                $("#yesradio1").change(function(){
                    var check=$(this).prop("checked");
                    if(check)
                    {
                        $("#certificatediv1").show();
                        $('#certificateTheme1').prop('required',true);
                        $('#certificate_charge1').prop('required',true);
                        $('#km_charge1').prop('required',true);
                    }
                });
                $("#noradio1").change(function(){
                    var check=$(this).prop("checked");
                    if(check)
                    {
                        $("#certificatediv1").hide();
                        $('#certificateTheme1').prop('required',false);
                        $('#certificate_charge1').prop('required',false);
                        $('#km_charge1').prop('required',false);
                    }
                });
                
            });
            
            function certificateThemePreview(certificateTheme){
                $("#certificateThemePreview1").html('<br><a href="<?php echo base_url("AdminPanel/Certificates/Preview/")?>'+certificateTheme+'" target="_blank">View Certificate</a>');
            }
        </script>
        <?php
            break;
            
            case 'StartLiveSession';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Link <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="link" placeholder="Link" value="<?php echo $list[0]->link;?>" required>
            <?php echo form_error("link", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">User ID of Live Session<span class="text-danger"></span></label>
            <input type="text" class="form-control" name="userid" placeholder="User ID"  value="<?php echo $list[0]->userid;?>">
            <?php echo form_error("userid", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Password of Live Session<span class="text-danger"></span></label>
            <input type="text" class="form-control" name="password" placeholder="Password"  value="<?php echo $list[0]->password;?>" >
            <?php echo form_error("password", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Notification Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="notification_title" placeholder="Notification Title"  value="<?php echo $list[0]->notification_title;?>" required>
            <?php echo form_error("notification_title", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Notification Message <span class="text-danger">*</span></label>
            <textarea  class="form-control" name="notification_message" placeholder="Notification Message" required><?php echo $list[0]->notification_message;?></textarea>
            <?php echo form_error("notification_message", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <?php
            break;
            
            case 'EndLiveSession';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Remarks <span class="text-danger"></span></label>
            <textarea  class="form-control" name="remarks" placeholder="Remarks" ><?php echo $list[0]->remarks;?></textarea>
            <?php echo form_error("remarks", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <?php
            break;
            
            
            
            case 'VideosList';
            $output='<option selected disabled>Select</option>';
            foreach($videoslist as $item){
                $output.= '<option value="'.$item->id.'">'.$item->title.'</option>';
            }
            echo $output;
            break;
            
            default:
            echo 'Action is invalid.';
            break;
            
            case 'EditQuestion';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Subject <span class="text-danger">*</span></label>
            <select class="form-control" name="subject_id" required>
                <option selected disabled>Select</option>
                <?php foreach ($subjectList as $item) { ?>
                    <option value="<?php echo $item->id;?>" <?php if($list[0]->subject_id==$item->id){ echo 'selected'; }?>><?php echo $item->name;?></option>
                <?php } ?>
            </select>
            <?php echo form_error("subject_id", "<p class='text-danger' >", "</p>"); ?>
        </div>
		<div class="form-group">
            <label class="col-form-label">Week Bucket <span class="text-danger">*</span></label>
            <input class="form-control" name="week" placeholder="Week Bucket" required value="<?php echo $list[0]->week;?>"/>
            <?php echo form_error("week", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Question <span class="text-danger">*</span></label>
            <textarea class="form-control" name="question" placeholder="Question" required><?php echo $list[0]->question;?></textarea>
            <?php echo form_error("question", "<p class='text-danger' >", "</p>"); ?>
        </div>
		<div class="form-group">
			<label class="col-form-label">Answer Type <span class="text-danger">*</span></label>
			<select class="form-control" name="answer_type" required onchange="AnswerType(this.value)">
				<option <?php if($list[0]->answer_type=='Text'){ echo 'selected'; } ?> value="Text">Text</option>
				<option <?php if($list[0]->answer_type=='Photo'){ echo 'selected'; } ?> value="Photo">Photo</option>
            </select>
			<?php echo form_error("subject_id", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Option A <span class="text-danger">*</span></label>
            <input type="<?php if($list[0]->answer_type=='Photo'){ echo 'file'; } else { echo 'text'; } ?>" class="form-control" name="a" placeholder="Option A" <?php if($list[0]->answer_type=='Photo'){ echo ''; } else { echo 'required'; } ?> value="<?php echo $list[0]->a;?>">
            <?php echo form_error("a", "<p class='text-danger' >", "</p>"); ?>
			<?php if($list[0]->answer_type=='Photo'){ echo '<a href="'.base_url('uploads/question/').$list[0]->a.'">View Photo</a>'; } ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Option B <span class="text-danger">*</span></label>
            <input type="<?php if($list[0]->answer_type=='Photo'){ echo 'file'; } else { echo 'text'; } ?>" class="form-control" name="b" placeholder="Option B" <?php if($list[0]->answer_type=='Photo'){ echo ''; } else { echo 'required'; } ?> value="<?php echo $list[0]->b;?>">
            <?php echo form_error("b", "<p class='text-danger' >", "</p>"); ?>
			<?php if($list[0]->answer_type=='Photo'){ echo '<a href="'.base_url('uploads/question/').$list[0]->b.'">View Photo</a>'; } ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Option C <span class="text-danger">*</span></label>
            <input type="<?php if($list[0]->answer_type=='Photo'){ echo 'file'; } else { echo 'text'; } ?>" class="form-control" name="c" placeholder="Option C" <?php if($list[0]->answer_type=='Photo'){ echo ''; } else { echo 'required'; } ?> value="<?php echo $list[0]->c;?>">
            <?php echo form_error("c", "<p class='text-danger' >", "</p>"); ?>
			<?php if($list[0]->answer_type=='Photo'){ echo '<a href="'.base_url('uploads/question/').$list[0]->c.'">View Photo</a>'; } ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Option D <span class="text-danger">*</span></label>
            <input type="<?php if($list[0]->answer_type=='Photo'){ echo 'file'; } else { echo 'text'; } ?>" class="form-control" name="d" placeholder="Option D" <?php if($list[0]->answer_type=='Photo'){ echo ''; } else { echo 'required'; } ?> value="<?php echo $list[0]->d;?>">
            <?php echo form_error("d", "<p class='text-danger' >", "</p>"); ?>
			<?php if($list[0]->answer_type=='Photo'){ echo '<a href="'.base_url('uploads/question/').$list[0]->d.'">View Photo</a>'; } ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Right Answer<span class="text-danger">*</span></label>
            <select class="form-control" name="answer" required>
                <option selected disabled>Select</option>
                <?php foreach($this->ansList as $key=>$value): ?>
                <option value="<?=$key;?>" <?php if($key==$list[0]->answer){ echo 'selected'; } ?>><?=$value;?></option>
                <?php endforeach; ?>
            </select>
        </div> 
		<script>
			function AnswerType(type) {
				if(type=='Photo')
				{
					$("input[name=a]").attr('type','file');
					$("input[name=b]").attr('type','file');
					$("input[name=c]").attr('type','file');
					$("input[name=d]").attr('type','file');
					
					$("input[name=a]").attr('required',false);
					$("input[name=b]").attr('required',false);
					$("input[name=c]").attr('required',false);
					$("input[name=d]").attr('required',false);
                }
				else{
					$("input[name=a]").attr('type','text');
					$("input[name=b]").attr('type','text');
					$("input[name=c]").attr('type','text');
					$("input[name=d]").attr('type','text');
					
					$("input[name=a]").attr('required',true);
					$("input[name=b]").attr('required',true);
					$("input[name=c]").attr('required',true);
					$("input[name=d]").attr('required',true);
                }
				
            }
        </script>
		<?php 
			break;
			
			case 'EditQuiz';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
		<div class="form-group">
			<label class="col-form-label">Quiz Name <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="name" placeholder="Quiz Name" required value="<?php echo $list[0]->name;?>">
			<?php echo form_error("name", "<p class='text-danger' >", "</p>"); ?>
        </div>
		<div class="form-group">
			<label class="col-form-label">Questions Filter By Subject <span class="text-danger">*</span></label>
			<div class="row skin skin-line" >
				<?php foreach ($subjectList as $item){ ?>
					<fieldset class="col-sm-6">
						<input type="checkbox" name="subject_id" id="subject-<?=$item->id;?>" value="<?=$item->id;?>" >
						<label for="subject-<?=$item->id;?>"><?=$item->name;?></label>
                    </fieldset>
                <?php }  ?>
				<?php echo form_error("subject_id","<p class='text-danger' >","</p>"); ?>
            </div>
			
        </div>
        <div class="form-group">
            <label class="col-form-label">Questions Filter By Week Bucket <span class="text-danger">*</span></label>
            <div class="row skin skin-line" >
                <?php foreach ($weekList as $item){ ?>
                    <fieldset class="col-sm-6">
                        <input type="checkbox" name="week" id="week-<?=$item->week;?>" value="<?=$item->week;?>" required >
                        <label for="week-<?=$item->week;?>"><?=$item->week;?></label>
                    </fieldset>
                <?php }  ?>
                <?php echo form_error("week","<p class='text-danger' >","</p>"); ?>
            </div>
            <button type="button" class="btn btn-dark btn-sm filterBtn"  style="padding:10px;" onclick="getQuestions(this.value)"> <i class="fa fa-check-circle"></i>  Click Here To Filter <i class="fa fa-spin fa-spinner filterSpin"  style="display:none;"></i></button>
        </div>
		<div class="form-group">
			<label class="col-form-label">Questions <span class="text-danger">*</span></label>
			<div class="questionsList">
				<?php $srno=1; foreach ($questionsList as $item){ ?> 
					
                    <fieldset class="col-sm-12"> <input type="checkbox" name="questions[]" id="questions-<?=$item->id;?>" value="<?=$item->id;?>" required checked> <label for="questions-<?=$item->id;?>" ><?=$item->question;?></label></fieldset>
					
                <?php $srno++; } ?>
            </div>
			<?php echo form_error("questions","<p class='text-danger' >","</p>"); ?>
        </div>
		<div class="form-group">
			<label class="col-form-label">Per Question Marks <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="per_question_no" placeholder="Per Question Marks" required value="<?php echo $list[0]->per_question_no;?>">
			<?php echo form_error("per_question_no", "<p class='text-danger' >", "</p>"); ?>
        </div>
		<div class="form-group">
			<label class="col-form-label">Quiz Timing (In Minutes) <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="timing" placeholder="Quiz Timing (In Minutes)" required value="<?php echo $list[0]->timing;?>">
			<?php echo form_error("timing", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Solutions Link <span class="text-danger"></span></label>
            <input type="text" class="form-control" name="solutions" placeholder="Solutions" value="<?php echo $list[0]->solutions;?>">
            <?php echo form_error("solutions", "<p class='text-danger' >", "</p>"); ?>
        </div>
		<div class="form-group">
			<label class="col-form-label">Description <span class="text-danger">*</span></label>
			<textarea class="form-control" name="description" placeholder="Description" required><?php echo $list[0]->description;?></textarea>
			<?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
        </div>
		<?php 
			break;
            
            case 'EditScheduleQuiz';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
			<label class="col-form-label">Quiz <span class="text-danger">*</span></label>
			<select class="form-control" name="quiz_id" required>
				<option selected disabled>Select</option>
				<?php foreach ($quizlist as $item) { ?>
					<option value="<?php echo $item->id;?>" <?php if($item->id==$list[0]->quiz_id){ echo 'selected'; } ?>><?php echo $item->name;?></option>
                <?php } ?>
            </select>
			<?php echo form_error("quiz_id", "<p class='text-danger' >", "</p>"); ?>
        </div>
		<div class="form-group">
			<label class="col-form-label">Course <span class="text-danger">*</span></label>
			<select class="form-control" name="course_id" required>
				<option selected disabled>Select</option>
				<?php foreach ($courselist as $item) { ?>
					<option value="<?php echo $item->id;?>" <?php if($item->id==$list[0]->course_id){ echo 'selected'; } ?>><?php echo $item->name;?></option>
                <?php } ?>
            </select>
			<?php echo form_error("course_id", "<p class='text-danger' >", "</p>"); ?>
        </div>
		
		<div class="form-group">
			<label class="col-form-label">Quiz Date <span class="text-danger">*</span></label>
			<input type="datetime-local" class="form-control" name="timing" required value="<?php echo str_replace(" ","T",$list[0]->timing);?>">
			<?php echo form_error("timing", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <?php
			break;
            
        }
    } 
    else 
    {
        echo 'Action is required.';
    }
?>