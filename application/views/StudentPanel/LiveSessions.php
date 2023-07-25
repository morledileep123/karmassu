<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en"> 
    <head>
        <title>Karmasu | Student | Live Sessions </title>
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
                        <div class="col-sm-12 p-2"><h5 class="pull-left">Live Sessions</h5></div>
                        <?php
							if(count($list)){
								foreach($list as $item){
								?>
								<div class="col-sm-4">
									<div class="card">
										<img src="<?php echo base_url('uploads/live_video/'.$item->thumbnail);?>" title="live-session" alt="digital-marketing" class="card-img-top video-size">
										<div class="card-body">
											<strong class="text-primary"><?php echo $item->subject;?></strong>&ensp;
											<strong class="text-info"><?php echo $item->tags;?></strong>
											<h5 class="card-title"><br><?php echo $item->title;?></h5>
											
											<p>Started at <?php echo $item->timing;?>, <?php echo $item->duration;?></p>
											<p><?php echo $item->description;?></p>
											<p><i class="fa fa-user-circle"></i> <?php echo $item->author->name;?></p>
											<?php
												if($item->joined=='true'){
													?>
													<hr>
													<p><strong>Link :  </strong> <a href="<?php echo $item->link;?>" target="_blank"><b id="clipboardl<?php echo $item->id;?>"><?php echo $item->link;?></b></a> <a href="javascript:void(0);" onclick="copyToClipboard('clipboardl<?php echo $item->id;?>')" class="text-danger"><i class="fa fa-copy"></i></a></p>
													<?php if(!empty($item->userid)){ ?>
													<p><strong>User ID :  </strong> <b id="clipboardu<?php echo $item->id;?>"><?php echo $item->userid;?></b> <a href="javascript:void(0);" onclick="copyToClipboard('clipboardu<?php echo $item->id;?>')" class="text-danger"><i class="fa fa-copy"></i></a> </p>
													
													<p><strong>Password :  </strong> <b id="clipboardp<?php echo $item->id;?>"><?php echo $item->password;?></b> <a href="javascript:void(0);" onclick="copyToClipboard('clipboardp<?php echo $item->id;?>')" class="text-danger"><i class="fa fa-copy"></i></a></p>
													<?php } ?>
													<?php
												}
												else{
													?>
													<p><a href="<?php echo base_url('Student/LiveSessions/Join/'.$item->id);?>" class="btn btn-info p-2"> <i class="fa fa-check-circle"></i> Attend Session</a></p>
													<?php
												}
											?>
											
										</div>
									</div>
								</div>
							<?php } } else{ echo 'No Record Found.';} ?>
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
		<script>
			function copyToClipboard(containerid) {
				var range = document.createRange();
				range.selectNode(document.getElementById(containerid));
				window.getSelection().removeAllRanges(); 
				window.getSelection().addRange(range); 
				document.execCommand("copy");
				window.getSelection().removeAllRanges();
			}
		</script>
	</body>
    
</html>