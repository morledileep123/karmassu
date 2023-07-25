<?php defined("BASEPATH") or exit("No direct scripts allowed here"); ?>
<?php
    if (isset($action)) 
    {
        switch ($action) 
        {
            
            case 'EditSlider';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" placeholder="Enter Slider Title" required
            value="<?php echo $list[0]->title;?>">
            <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Link <span class="text-danger"></span></label>
            <input type="text" class="form-control" name="link" placeholder="Enter Slider Link" 
            value="<?php echo $list[0]->link;?>">
            <?php echo form_error("link", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="col-form-label">Image <span class="text-danger"></span></label>
                    <input type="file" class="form-control" name="image" title="Upload Slider Image" accept="image/jpg, image/png, image/jpeg, image/gif">
                    <?php echo form_error("image","<p class='text-danger' >","</p>"); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <img src="<?php echo base_url('uploads/slider/'.$list[0]->image.'')?>" style="height:100px;width:100%;">
            </div>
        </div>
        <?php
            break;
            
            case 'EditTestimonial';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" placeholder="Enter Name" required
            value="<?php echo $list[0]->name;?>">
            <?php echo form_error("name", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Designation <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="designation" placeholder="Enter Designation" required
            value="<?php echo $list[0]->designation;?>">
            <?php echo form_error("designation", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Review <span class="text-danger">*</span></label>
            <textarea class="form-control" name="review" placeholder="Enter  Review"
            required><?php echo $list[0]->review;?></textarea>
            <?php echo form_error("review", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="col-form-label">Photo <span class="text-danger"></span></label>
                    <input type="file" class="form-control" name="photo" title="Upload Photo" accept="image/jpg, image/png, image/jpeg, image/gif">
                    <?php echo form_error("photo","<p class='text-danger' >","</p>"); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <img src="<?php echo base_url('uploads/testimonial/'.$list[0]->photo.'')?>" style="height:100px;width:100%;">
            </div>
        </div>
        <?php
            break;
            
            case 'EditTutor';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" placeholder="Enter Name" required value="<?php echo $list[0]->name;?>">
            <?php echo form_error("name", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Designation <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="designation" placeholder="Enter Designation" required value="<?php echo $list[0]->designation;?>">
            <?php echo form_error("designation", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Position <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="position" placeholder="Enter Team Member Position" required value="<?php echo $list[0]->position;?>">
            <?php echo form_error("position", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">About <span class="text-danger">*</span></label>
            <textarea class="form-control" name="about" placeholder="Enter  About" required><?php echo $list[0]->about;?></textarea>
            <?php echo form_error("about", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Social Link <span class="text-danger"></span></label>
            <input type="text" class="form-control" name="social_link" placeholder="Enter Social Link"
            value="<?php echo $list[0]->social_link;?>">
            <?php echo form_error("social_link", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="col-form-label">Photo <span class="text-danger"></span></label>
                    <input type="file" class="form-control" name="photo" title="Upload Photo" accept="image/jpg, image/png, image/jpeg, image/gif">
                    <?php echo form_error("photo","<p class='text-danger' >","</p>"); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <img src="<?php echo base_url('uploads/tutor/'.$list[0]->photo.'')?>" style="height:100px;width:100%;">
            </div>
        </div>
        <?php
            break;
            
            case 'LoginData';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Email<span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" placeholder="Email Address" required
            value="<?php echo $list[0]->email;?>">
            <?php echo form_error("email", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Mobile No<span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="mobile" placeholder="Mobile No" required
            value="<?php echo $list[0]->mobile;?>" maxlength="10"  minlength="10">
            <?php echo form_error("mobile", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Password<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="password" placeholder="Password" required
            value="<?php echo $list[0]->password;?>"   minlength="6">
            <?php echo form_error("password", "<p class='text-danger' >", "</p>"); ?>
        </div>
        
        <?php
            break;
            
            case 'EditTeam';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" placeholder="Enter Name" required
            value="<?php echo $list[0]->name;?>">
            <?php echo form_error("name", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Designation <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="designation" placeholder="Enter Designation" required
            value="<?php echo $list[0]->designation;?>">
            <?php echo form_error("designation", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Position <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="position" placeholder="Enter Team Member Position" required
            value="<?php echo $list[0]->position;?>">
            <?php echo form_error("position", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="col-form-label">Photo <span class="text-danger"></span></label>
                    <input type="file" class="form-control" name="photo" title="Upload Photo" accept="image/jpg, image/png, image/jpeg, image/gif">
                    <?php echo form_error("photo","<p class='text-danger' >","</p>"); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <img src="<?php echo base_url('uploads/team/'.$list[0]->photo.'')?>" style="height:100px;width:100%;">
            </div>
        </div>
        <?php
            break;
            
            case 'EditBlog';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Educator <span class="text-danger">*</span></label>
            <select class="form-control" name="author" required>
                <option selected disabled>Select</option>
                <?php foreach ($authorlist as $item) { ?>
                    <option value="<?php echo $item->id;?>" <?php if($item->id==$list[0]->author){ echo 'selected';} ?>><?php echo $item->name;?></option>
                <?php } ?>
            </select>
            <?php echo form_error("author", "<p class='text-danger' >", "</p>"); ?>
        </div>
        
        <div class="form-group">
            <label class="col-form-label">Category <span class="text-danger">*</span></label>
            <select class="form-control" name="category" required>
                <option selected disabled>Select</option>
                <?php foreach ($categorylist as $item) { ?>
                    <option value="<?php echo $item->id;?>" <?php if($item->id==$list[0]->category){ echo 'selected';} ?> ><?php echo $item->title;?></option>
                <?php } ?>
            </select>
            <?php echo form_error("category", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label"> Title<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" placeholder="Enter Title" required value="<?php echo $list[0]->title;?>">
            <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label"> Tags<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="tags" placeholder="Enter Tags" required value="<?php echo $list[0]->tags;?>">
            <?php echo form_error("tags", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label"> Summary<span class="text-danger">*</span></label>
            <textarea  class="form-control" name="summary" placeholder="Enter Summary" required><?php echo $list[0]->summary;?></textarea>
            <?php echo form_error("summary", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control summernote" name="description" placeholder="Enter  Description" required><?php echo $list[0]->description;?></textarea>
            <?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="col-form-label">Photo <span class="text-danger"></span></label>
                    <input type="file" class="form-control" name="photo" title="Upload Photo" accept="image/jpg, image/png, image/jpeg, image/gif">
                    <?php echo form_error("photo","<p class='text-danger' >","</p>"); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <img src="<?php echo base_url('uploads/blog/'.$list[0]->photo.'')?>" style="height:100px;width:100%;">
            </div>
        </div>
        <script>
            $('.summernote').summernote({
                height: 200,
                tabsize: 2
            });
        </script>
        <?php
            break;
            
            case 'EditCategory';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" placeholder="Enter Category Title" required value="<?php echo $list[0]->title;?>">
            <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control" name="description" placeholder="Enter Category Description" required><?php echo $list[0]->description;?></textarea>
            <?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <!--
        <div class="form-group">
            <label class="col-form-label">Color <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="color" placeholder="Enter  Color Code" required value="<?php echo $list[0]->color;?>">
            <?php echo form_error("color", "<p class='text-danger' >", "</p>"); ?>
        </div>
        -->
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="col-form-label">Icon <span class="text-danger"></span></label>
                    <input type="file" class="form-control" name="icon" title="Upload Icon" accept="image/jpg, image/png, image/jpeg, image/gif">
                    <?php echo form_error("icon","<p class='text-danger' >","</p>"); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <img src="<?php echo base_url('uploads/category/'.$list[0]->icon.'')?>" style="height:100px;width:100%;">
            </div>
        </div>

        <?php
            break;
            
            case 'EditShopCategory';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" placeholder="Enter Category Title" required value="<?php echo $list[0]->title;?>">
            <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Url <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="url" placeholder="Enter Category Url" required value="<?php echo $list[0]->url;?>">
            <?php echo form_error("url", "<p class='text-danger' >", "</p>"); ?>
        </div>

        <div class="form-group">
            <label class="col-form-label">Image <span class="text-danger"></span></label>
            <input type="file" class="form-control" name="image" title="Upload Image" accept="image/jpg, image/png, image/jpeg, image/gif, image/webp">
            <?php echo form_error("image","<p class='text-danger' >","</p>"); ?><br>
        </div>

        <?php
            break;
            
            case 'EditSpirituality';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-form-label">Image <span class="text-danger"></span></label>
                    <input type="file" class="form-control" name="image" title="Upload Image" accept="image/jpg, image/png, image/jpeg, image/gif">
                    <?php echo form_error("image","<p class='text-danger' >","</p>"); ?><br>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Link <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="link" placeholder="Enter Category Url" required value="<?php echo $list[0]->link;?>">
                    <?php echo form_error("link", "<p class='text-danger' >", "</p>"); ?>
                </div>
            </div><br>
            <div class="col-sm-4">
                <img src="<?php echo base_url('uploads/spirituality/'.$list[0]->image.'')?>" style="height:100px;width:100%;">
            </div>
        </div>
        
        <?php
            break;
            
            case 'EditSubject';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Subject Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" placeholder="Subject Name" required value="<?php echo $list[0]->name;?>">
            <?php echo form_error("name", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <?php
            break;
            
            
            case 'EditOffer';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Coupon <span class="text-danger">*</span></label>
            <input type="text" class="form-control text-uppercase" name="coupon" placeholder="Coupon Code" required value="<?php echo $list[0]->coupon;?>">
            <?php echo form_error("coupon", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Discount <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="discount" placeholder="Discount" required pattern="/^-?\d+\.?\d*$/" value="<?php echo $list[0]->discount;?>">
            <?php echo form_error("discount", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Discount Type<span class="text-danger">*</span></label>
            <select class="form-control" name="discount_type"  required>
                <option value="Percentage" <?php if($list[0]->discount_type=='Percentage'){ echo 'selected';} ?>>Percentage</option>
                <option value="Amount" <?php if($list[0]->discount_type=='Amount'){ echo 'selected';} ?>>Amount</option>
            </select>
            <?php echo form_error("discount_type", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">UPTO <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="upto" placeholder="UPTO" required pattern="/^-?\d+\.?\d*$/" value="<?php echo $list[0]->upto;?>">
            <?php echo form_error("upto", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Expiry Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="expiry_date" required value="<?php echo $list[0]->expiry_date;?>">
            <?php echo form_error("expiry_date", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">No Of Coupon <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="no_of_coupon" placeholder="No Of Coupon"  required pattern="/^-?\d+\.?\d*$/" value="<?php echo $list[0]->no_of_coupon;?>">
            <?php echo form_error("no_of_coupon", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control" name="description" placeholder="Enter offer Description" required><?php echo $list[0]->description;?></textarea>
            <?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="col-form-label">Banner <span class="text-danger"></span></label>
                    <input type="file" class="form-control" name="banner" title="Upload Banner" accept="image/jpg, image/png, image/jpeg, image/gif">
                    <?php echo form_error("banner","<p class='text-danger' >","</p>"); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <img src="<?php echo base_url('uploads/offer/'.$list[0]->banner.'')?>" style="height:100px;width:100%;">
            </div>
        </div>
        <?php
            break;
            
            case 'EditAppSlider';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Title <span class="text-danger"></span></label>
            <input type="text" class="form-control" name="title" placeholder="Enter Title" value="<?php echo $list[0]->title;?>">
            <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Tagline <span class="text-danger"></span></label>
            <textarea class="form-control" name="tagline" placeholder="Enter Tagline"><?php echo $list[0]->tagline;?></textarea>
            <?php echo form_error("tagline", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Button Text <span class="text-danger"></span></label>
            <input type="text" class="form-control" name="button" placeholder="Enter Button Text" value="<?php echo $list[0]->button;?>">
            <?php echo form_error("button", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Parameter <span class="text-danger">*</span></label>
            <select  class="form-control" name="parameter" required onchange="getParameterData(this.value)">
                <option value="None" selected>None</option>
                <option value="Category" <?php if($list[0]->parameter=='Category'){ echo 'selected';} ?>>Category</option>
                <option value="Course" <?php if($list[0]->parameter=='Course'){ echo 'selected';} ?>>Course</option>
                <option value="Ebook" <?php if($list[0]->parameter=='Ebook'){ echo 'selected';} ?>>E-Book</option>
                <option value="Abook" <?php if($list[0]->parameter=='Abook'){ echo 'selected';} ?>>Audio Book</option>
                <option value="Quiz" <?php if($list[0]->parameter=='Quiz'){ echo 'selected';} ?>>Quiz</option>
                <option value="LiveSession" <?php if($list[0]->parameter=='LiveSession'){ echo 'selected';} ?>>Live Session</option>
                <option value="FreeVideo" <?php if($list[0]->parameter=='FreeVideo'){ echo 'selected';} ?>>Free Video</option>
                <option value="FreeVideo" <?php if($list[0]->parameter=='Offer'){ echo 'selected';} ?>>Offer</option>
                <option value="External" <?php if($list[0]->parameter=='External'){ echo 'selected';} ?>>External</option>
                
            </select>
            <?php echo form_error("parameter", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group parameter-data" style="display:<?php if($list[0]->parameter=='External'){ echo 'block';} else { echo 'none;'; } ?>;">
            <?php if($list[0]->parameter=='External'){ ?>
            <label class="col-form-label">External Link <span class="text-danger">*</span></label><input type="text" class="form-control" name="data" placeholder="Enter Link " required value="<?php echo $list[0]->link; ?>" >
            <?php }?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="col-form-label">Image <span class="text-danger"></span></label>
                    <input type="file" class="form-control" name="image" title="Upload Slider Image" accept="image/jpg, image/png, image/jpeg, image/gif">
                    <?php echo form_error("image","<p class='text-danger' >","</p>"); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <img src="<?php echo base_url('uploads/slider/'.$list[0]->image.'')?>" style="height:100px;width:100%;">
            </div>
        </div>
        <?php
            break;
            
            case 'EditNotification';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" placeholder="Title" required value="<?php echo $list[0]->title;?>">
            <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Message <span class="text-danger">*</span></label>
            <textarea class="form-control" name="message" placeholder="Message" required ><?php echo $list[0]->message;?></textarea>
            <?php echo form_error("message", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Link <span class="text-danger"></span></label>
            <input type="text" class="form-control" name="link" placeholder="Link"  value="<?php echo $list[0]->link;?>">
            <?php echo form_error("link", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label  class="col-form-label">Parameter <span class="text-danger">*</span></label>
            <select  class="form-control" name="parameter" required onchange="getParameterData(this.value)">
                <option value="None" selected>None</option>
                <option value="Category" <?php if($list[0]->parameter=='Category'){ echo 'selected';} ?>>Category</option>
                <option value="Course" <?php if($list[0]->parameter=='Course'){ echo 'selected';} ?>>Course</option>
                <option value="Ebook" <?php if($list[0]->parameter=='Ebook'){ echo 'selected';} ?>>E-Book</option>
                <option value="Abook" <?php if($list[0]->parameter=='Abook'){ echo 'selected';} ?>>Audio Book</option>
                <option value="Quiz" <?php if($list[0]->parameter=='Quiz'){ echo 'selected';} ?>>Quiz</option>
                <option value="LiveSession" <?php if($list[0]->parameter=='LiveSession'){ echo 'selected';} ?>>Live Session</option>
                <option value="FreeVideo" <?php if($list[0]->parameter=='FreeVideo'){ echo 'selected';} ?>>Free Video</option>
                <option value="Offer" <?php if($list[0]->parameter=='Offer'){ echo 'selected';} ?>>Free Video</option>
                <option value="External" <?php if($list[0]->parameter=='External'){ echo 'selected';} ?>>External</option>
                
            </select>
            <?php echo form_error("parameter", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group parameter-data" style="display:none;"></div>
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="col-form-label">Image <span class="text-danger"></span></label>
                    <input type="file" class="form-control" name="image" title="Upload Image" accept="image/jpg, image/png, image/jpeg, image/gif">
                    <?php echo form_error("image","<p class='text-danger' >","</p>"); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <img src="<?php echo base_url('uploads/notification/'.$list[0]->image.'')?>" style="height:100px;width:100%;">
            </div>
        </div>  
        <?php
            break;
            
            case 'EditLiveVideo';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Educator <span class="text-danger">*</span></label>
            <select class="form-control" name="author" required>
                <option selected disabled>Select</option>
                <?php foreach ($author as $item) { ?>
                    <option value="<?php echo $item->id;?>" <?php if($list[0]->author==$item->id){ echo 'selected'; }?>><?php echo $item->name;?></option>
                <?php } ?>
            </select>
            <?php echo form_error("author", "<p class='text-danger' >", "</p>"); ?>
        </div>
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
            <label  class="col-form-label">For User <span class="text-danger">*</span></label>
            <select class="form-control" name="for_user" required onchange="getUsers(this.value)" value="<?php echo $list[0]->for_user;?>">
                <option selected disabled>Select</option>
                <option value="AllEducator">All Educators</option>
                <option value="Educator">Select Educators</option>
                <option value="AllStudent">All Students</option>
                <option value="Student">Select Students</option>
            </select>
            <?php echo form_error("for_user","<p class='text-danger' >","</p>"); ?>
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
        <!-- <div class="form-group">
            <label class="col-form-label">User ID of Live Session<span class="text-danger"></span></label>
            <input type="text" class="form-control" name="userid" placeholder="User ID"  value="<?php //echo $list[0]->id;?>">
            <?php //echo form_error("userid", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Password of Live Session<span class="text-danger"></span></label>
            <input type="text" class="form-control" name="password" placeholder="Password"  value="<?php //echo $list[0]->password;?>" >
            <?php// echo form_error("password", "<p class='text-danger' >", "</p>"); ?>
        </div> -->
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
        <script>
        $(document).ready(function(){
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
        });
        </script>
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
            case 'EditVideo';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Educator <span class="text-danger">*</span></label>
            <select class="form-control" name="author" required>
                <option selected disabled>Select</option>
                <?php foreach ($authorlist as $item) { ?>
                    <option value="<?php echo $item->id;?>" <?php if($item->id==$list[0]->author){ echo 'selected';} ?>><?php echo $item->name;?></option>
                <?php } ?>
            </select>
            <?php echo form_error("author", "<p class='text-danger' >", "</p>"); ?>
        </div>
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
                $newpath='uploads/thumbnail/';
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
                $newpath='uploads/video/';
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
            
            case 'EditFAQ';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" placeholder="Enter Slider Title" required
            value="<?php echo $list[0]->title;?>">
            <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <script>
            $('.summernote').summernote({
                height: 200,
                tabsize: 2
            });
            
        </script>
        <div class="form-group">
            <label class="col-form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control summernote" name="description"
            placeholder="Enter  Description" required><?php echo $list[0]->description;?></textarea>
            <?php echo form_error("description", "<p class='text-danger' >", "</p>"); ?>
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
            
            case 'EditRecommendedVideo';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Author <span class="text-danger">*</span></label>
            <select class="form-control" name="author" required>
                <option selected disabled>Select</option>
                <?php foreach ($authorlist as $item) { ?>
                    <option value="<?php echo $item->id;?>" <?php if($item->id==$list[0]->author){ echo 'selected';} ?> ><?php echo $item->name;?></option>
                <?php } ?>
            </select>
            <?php echo form_error("author", "<p class='text-danger' >", "</p>"); ?>
        </div>           
        <div class="form-group">
            <label class="col-form-label">Subject <span class="text-danger">*</span></label>
            <select class="form-control" name="subject" required>
                <option selected disabled>Select</option>
                <?php foreach ($subjectlist as $item) { ?>
                    <option value="<?php echo $item->id;?>" <?php if($item->id==$list[0]->subject){ echo 'selected';} ?> ><?php echo $item->name;?></option>
                <?php } ?>
            </select>
            <?php echo form_error("subject", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Video <span class="text-danger">*</span></label>
            <select class="form-control" name="video" required>
                <option selected disabled>Select</option>
                <?php foreach ($videolist as $item) { ?>
                    <option value="<?php echo $item->id;?>" <?php if($item->id==$list[0]->video){ echo 'selected';} ?> ><?php echo $item->title;?></option>
                <?php } ?>
            </select>
            <?php echo form_error("video", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control summernote" name="description" placeholder="Enter  Description" required><?php echo $list[0]->description;?></textarea>
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
            
            case 'EditFreeAndShortVideo';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label  class="col-form-label">Type <span class="text-danger">*</span></label>
            <select class="form-control" name="type" required>
                <option selected disabled>Select</option>
                <option value="FreeVideos" <?php if($list[0]->type=='FreeVideos'){ echo 'selected';} ?>>Free Videos</option>
                <option value="ShortTricks" <?php if($list[0]->type=='ShortTricks'){ echo 'selected';} ?>>Short Tricks</option>
            </select>
        </div>
        <div class="form-group">
            <label class="col-form-label">Author <span class="text-danger">*</span></label>
            <select class="form-control" name="author" required>
                <option selected disabled>Select</option>
                <?php foreach ($authorlist as $item) { ?>
                    <option value="<?php echo $item->id;?>" <?php if($item->id==$list[0]->author){ echo 'selected';} ?> ><?php echo $item->name;?></option>
                <?php } ?>
            </select>
            <?php echo form_error("author", "<p class='text-danger' >", "</p>"); ?>
        </div>           
        <div class="form-group">
            <label class="col-form-label">Subject <span class="text-danger">*</span></label>
            <select class="form-control" name="subject" required>
                <option selected disabled>Select</option>
                <?php foreach ($subjectlist as $item) { ?>
                    <option value="<?php echo $item->id;?>" <?php if($item->id==$list[0]->subject){ echo 'selected';} ?> ><?php echo $item->name;?></option>
                <?php } ?>
            </select>
            <?php echo form_error("subject", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Video <span class="text-danger">*</span></label>
            <select class="form-control" name="video" required>
                <option selected disabled>Select</option>
                <?php foreach ($videolist as $item) { ?>
                    <option value="<?php echo $item->id;?>" <?php if($item->id==$list[0]->video){ echo 'selected';} ?> ><?php echo $item->title;?></option>
                <?php } ?>
            </select>
            <?php echo form_error("video", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control summernote" name="description" placeholder="Enter  Description" required><?php echo $list[0]->description;?></textarea>
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
            
            case 'TrackHDCOrder';
            // var_dump($list[0]);
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Order Status<span class="text-danger">*</span></label>
            <select class="form-control" name="order_status" required onchange="TrackingElement(this.value)">
                <option value="Order Placed" <?php if($list[0]->order_status=='Order Placed'){ echo 'selected'; } ?>>Order Placed</option>
                <option value="Order Packed" <?php if($list[0]->order_status=='Order Packed'){ echo 'selected'; } ?> >Order Packed</option>
                <option value="Order Shipped" <?php if($list[0]->order_status=='Order Shipped'){ echo 'selected'; } ?>>Order Shipped</option>
                <option value="Out for Delivery" <?php if($list[0]->order_status=='Out for Delivery'){ echo 'selected'; } ?>>Out for Delivery</option>
                <option value="Order Delivered" <?php if($list[0]->order_status=='Order Delivered'){ echo 'selected'; } ?>>Order Delivered</option>
            </select>
            
            <?php echo form_error("order_status", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group expected_date " style="display:<?php if($list[0]->order_status=='Order Delivered'){ echo 'none'; } else { echo 'block'; } ?>">
            <label class="col-form-label">Expected Date<span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="expected_date" <?php if($list[0]->order_status=='Order Delivered'){ echo ''; } else { echo 'required'; } ?>
            value="<?php echo $list[0]->expected_date;?>">
            <?php echo form_error("expected_date", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group delivery_date " style="display:<?php if($list[0]->order_status=='Order Delivered'){ echo 'block'; } else { echo 'none'; } ?>" >
            <label class="col-form-label">Delivery Date<span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="delivery_date"  <?php if($list[0]->order_status=='Order Delivered'){ echo 'required'; } else { echo ''; } ?>  value="<?php echo $list[0]->delivery_date;?>">
            <?php echo form_error("delivery_date", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <script>
            function TrackingElement(element)
            {
                if(element=='Order Delivered'){
                    $('.expected_date').hide();
                    $('.delivery_date').show();
                    $('input[name="delivery_date"]').prop('required',true);
                    $('input[name="expected_date"]').prop('required',false);
                }
                else{
                    $('.expected_date').show();
                    $('.delivery_date').hide();
                    $('input[name="delivery_date"]').prop('required',false);
                    $('input[name="expected_date"]').prop('required',true);
                }
                
            }
        </script>
        <?php
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
            
            case 'Parameters';
            $output='<label class="col-form-label">'.$Parameter.' <span class="text-danger">*</span></label><select class="form-control" name="data" required><option selected disabled>Select</option>';
            foreach($ParameterData as $item){
                $output.= '<option value="'.$item->data->id.'">'.$item->data->name.'</option>';
            }
            $output.='</select>';
            echo $output;
			break;
            
            case 'EditAppSplashScreen';
        ?>
        <input type="hidden" name="id" value="<?php echo $list[0]->id;?>" />
        <div class="form-group">
            <label class="col-form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" placeholder="Enter Title" required value="<?php echo $list[0]->title;?>">
            <?php echo form_error("title", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Subtitle <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="subtitle" placeholder="Enter Subtitle" required value="<?php echo $list[0]->subtitle;?>">
            <?php echo form_error("subtitle", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="form-group">
            <label class="col-form-label">Splash Type <span class="text-danger">*</span></label>
            <select  class="form-control" name="type" required>
                <option value="Image" <?php if($list[0]->type=='Image'){ echo 'selected'; } ?>>Image</option>
                <option value="Video" <?php if($list[0]->type=='Video'){ echo 'selected'; } ?>>Video</option>
                
            </select>
            <?php echo form_error("type", "<p class='text-danger' >", "</p>"); ?>
        </div>
        <div class="">
            <div class="form-group">
                <label class="col-form-label">Splash Screen <span class="text-danger"></span></label>
                <input type="file" class="form-control" name="screen" title="Upload Splash Screen" accept="image/jpg, image/png, image/jpeg, image/gif,video/mp4">
                <?php echo form_error("screen","<p class='text-danger' >","</p>"); ?>
            </div>
            <a href="<?php echo base_url('uploads/splash_screen/'.$list[0]->screen.'')?>" target="_blank" >View Splash Screen</a>
        </div>
        <?php
            break;
            
            case 'GetUsers';
            $output='<label class="col-form-label">'.$type.' <span class="text-danger">*</span></label><select class="form-control chosen-select"  multiple name="users[]" required onchange="selectAll(this.value)">';
            foreach($userData as $item){
                $output.= '<option value="'.$item->data->id.'">'.$item->data->name.' ('.$item->data->mobile.')</option>';
            }
            $output.='</select>';
            echo $output;
        ?>
        <script>$('.chosen-select').chosen();</script>
        <?php
			break;
        }
    } 
    else 
    {
        echo '';
    }
?>