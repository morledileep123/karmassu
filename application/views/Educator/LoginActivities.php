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
                            <h4 class="page-title">Login Activities</h4>
                            <ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="Dashboard">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="./">Profile</a></li>
								<li class="breadcrumb-item active" aria-current="page">Login Activities</li>
							</ol>
						</div>
						<div class="col-sm-3">
							
						</div>
					</div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card profile-card-2 p-3">
								<div class="table-responsive">
									<table id="example" class="table table-bordered table-hover table-striped">
										<thead>
											<tr>
												<th>#</th> 
												<th>Login Details ID</th> 
												<th>IP</th> 
												<!--
													<th>MAC</th> 
												-->
												<th>USER NAME</th> 
												<th>BROWSER NAME</th> 
												<th>OS NAME</th> 
												<th>DATE</th> 
												<th>TIME</th> 
											</tr>
										</thead>
										<tbody>  
											<?php
												$srno=1;
												foreach($login_activities as $item){
												?>
												<tr>
													<td><?=$srno++;?></td>
													<td><?=$item->LoginDetailsID;?></td>
													<td><?=$item->IP;?></td>
													<!--
														<td><?=$item->MAC;?></td>
													-->
													<td><?=$item->UserName;?></td>
													<td><?=$item->BrowserName;?></td>
													<td><?=$item->OSName;?></td>
													<td><?=$item->Date;?></td>
													<td><?=$item->Time;?></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
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