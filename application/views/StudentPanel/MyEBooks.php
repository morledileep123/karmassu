<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Karmasu | Student | My E-Books</title>
        <?php include("HeaderLinking.php"); ?>
    </head>
    <body> 
        <?php include("Loader.php"); ?>
        <div id="wrapper">
            
            <?php include("Sidebar.php"); ?>
            
            <?php include("Topbar.php"); ?>
            
            <div class="clearfix"></div>
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 p-2"><h5 class="pull-left">My E-Books</h5></div>
                        <?php
                            if(count($ebookList)){
                                foreach($ebookList as $item){
                                ?>
                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-header p-0">
                                            <a href="<?php echo base_url('Student/EBookDescription/'.$item->item->id);?>"><img src="<?php echo base_url('uploads/ebook/'.$item->item->banner);?>" title="<?php echo $item->item->name;?>" alt="<?php echo $item->item->name;?>" class="card-img-top"></a>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $item->item->name;?></h5>
                                            <h6><i class="fa fa-user-circle"></i> <?php echo $item->item->author->name;?></h6>
                                            <b><?php echo $item->item->noofpages; ?> </b> Pages For <b>
                                            <?php echo $item->item->daystofinish; ?> </b> Days
                                            <p>
												<?php for($i=0;$i<5;$i++){ ?>
													<i class="<?php if($item->rating >= $i){ echo 'fas fa-star text-warning'; } else{ echo 'far fa-star text-warning'; } ?>"  aria-hidden="true" ></i>
                                                <?php } ?>
												(<?php echo $item->totalrating;?>)
                                            </p>
                                            <ul class="list-group list-group-flush list shadow-none p-0">
                                                <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                                                    
                                                    <a href="<?php echo base_url('Student/EBookDescription/'.$item->item->id);?>" class="btn btn-dark p-2"><i class="fa fa-folder-open"></i> Read E-Book</a>
                                                    
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php } } else{ 
                            ?>
                            <div class="col-sm-12">
								<center>
									<img src="<?php echo base_url('image/NoRecordFound.png');?>" title="img not found" alt="img not found" class="img-fluid"/>
									<br><br>
									<a href="<?php echo base_url('Student/EBooks');?>" class="btn btn-dark btn-lg">Purchase Now <i class="fa fa-angle-double-right"></i> </a>
									<br><br><br><br>
                                </center>
                            </div>
                            <?php
                            } ?>
                    </div>
                    <div class="overlay toggle-menu"></div>
                </div>
            </div>
            <?php include("Footer.php"); ?>
            
        </div>
        
        <?php  include("FooterLinking.php");  ?>
        
        <script>
            $(function() {
                $(".knob").knob();
            });
        </script>
        <script src="<?php base_url("assets_panel/js/index.js"); ?>"></script>
        
    </body>
    
</html>