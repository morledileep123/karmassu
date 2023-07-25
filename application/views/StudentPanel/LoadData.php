<?php defined("BASEPATH") or exit("No direct scripts allowed here"); ?>
<?php
    if (isset($action)) 
    {
        switch ($action) 
        {
			
            case 'SearchItems';
			if(count($list)){
				foreach($list as $item){
					
				?>
				<div class="col-sm-3">
					<div class="card">
						<div class="card-header p-0">
							<a href="<?php if($item->itemtype=='Course'){ echo base_url('Student/CourseDescription/'.$item->itemid); } else{ echo base_url('Student/EBookDescription/'.$item->itemid); } ?>"><img src="<?php echo base_url('uploads/'.strtolower($item->itemtype).'/'.$item->logo);?>" title="<?php echo $item->name;?>"  class="card-img-top"></a>
							<?php if($item->discountpercent!='0% Off'){ ?>
								<span class="badge badge-warning badge-up p-2" style="border-radius:0%;"><?php echo $item->discountpercent;?></span>
							<?php } ?>
						</div>
						<div class="card-body">
							<h5 class="card-title"><?php echo $item->name.' ('.$item->itemtype.') ';?></h5>
							<h6><i class="fa fa-user-circle"></i> <?php echo $item->author->name;?></h6>
							<p>
								<?php for($i=0;$i<5;$i++){ ?>
									<i class="<?php if($item->rating >= $i){ echo 'fas fa-star text-warning'; } else{ echo 'far fa-star text-warning'; } ?>"  aria-hidden="true" ></i>
								<?php } ?>
								(<?php echo $item->totalrating;?>)
							</p>
							<ul class="list-group list-group-flush list shadow-none p-0">
								<li class="list-group-item d-flex justify-content-between align-items-center p-1">
									<?php if($item->offerprice>0){?>
										<span><i class="fa fa-inr"></i><?php echo $item->offerprice;?></span>
										<?php if($item->price!=$item->offerprice){?>
											<del><i class="fa fa-inr"></i><?php echo $item->price;?></del>
										<?php } ?>
										<?php } else{?>
										<strong><span class="p-2 text-success">Free</span></strong>
									<?php } ?>
									<a href="<?php echo base_url('Student/Checkout/'.$item->itemtype.'/'.$item->itemid);?>" class="btn btn-primary p-2">Enroll Now</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			<?php } } else{ echo '<div class="col-sm-12">No Record Found.</div>';} 
			break;
			
			
            default:
			
			break;
		}
	} 
    else 
    {
		
	}
?>