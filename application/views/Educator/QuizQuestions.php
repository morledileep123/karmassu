<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
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
                    <div class="row pt-2 pb-2">
                        <div class="col-sm-9">
                            <h4 class="page-title"> Quiz Questions</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page"><?=$list[0]->name;?></li>
							</ol>
						</div>
                        <div class="col-sm-3">
                            
						</div>
					</div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            
                            <div class="card">
                                <div class="card-body">
									<div class="row">
										<div class="col-sm-12 text-center">
											<h4><strong><?= $list[0]->name; ?></strong></h4>
											<h6><strong>Per Question Marks: <?= $list[0]->per_question_no; ?></strong></h6>
											<h6><strong>No of Question: <?= $list[0]->no_of_questions; ?></strong></h6>
											<h6><strong>Quiz Timing: <?= $list[0]->timing; ?> Minutes</strong></h6>
											<p><?= $list[0]->description; ?></p>
											<hr>
										</div>
									</div>
									<?php $srno=1; foreach ($questionslist as $item){ ?>
										<div class="row">
											<div class="col-sm-12">
												<h6><strong>(<?= $srno; ?>). <?= $item->question; ?></strong></h6><br>
												<p>a). <?php if($item->answer_type=='Photo'){ echo '<img src="'.base_url('uploads/question/'.$item->a).'" style="height:50px"/>'; } else{ echo $item->a; }?></p>
												<p>b). <?php if($item->answer_type=='Photo'){ echo '<img src="'.base_url('uploads/question/'.$item->b).'" style="height:50px"/>'; } else{ echo $item->b; }?></p>
												<p>c). <?php if($item->answer_type=='Photo'){ echo '<img src="'.base_url('uploads/question/'.$item->c).'" style="height:50px"/>'; } else{ echo $item->c; }?></p>
												<p>d). <?php if($item->answer_type=='Photo'){ echo '<img src="'.base_url('uploads/question/'.$item->d).'" style="height:50px"/>'; } else{ echo $item->d; }?></p>
												<p><strong>Right Answer: <?= $this->ansList[$item->answer]; ?></strong></p>
											</div>
											<hr>
										</div>
										<br>
									<?php $srno++; } ?>
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
		
	</body>
	
</html>	