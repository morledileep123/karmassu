<?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Karmasu | Student | Search </title>
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
                        <div class="col-sm-12">
							<div class="card">
								<div class="card-header"><h5>Search</h5> </div>
								<ul class="list-group list-group-flush">
									<li class="list-group-item">
										<div class="media align-items-center">
											<div class="media-body ml-3">
												<div class="form-group">
													<input type="text" class="form-control" name="keyword" placeholder="Enter Keyword" style="height:40px;" onkeyup="getSearchResult(this.value)">
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="row searchResult">
						
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
        <script>
			function getSearchResult(keyword){
				$(".searchResult").html('');
				if(keyword.length>=3){
					$.ajax({
						url: "<?php echo base_url("Student/Search/SearchItems"); ?>",
						type: "post",
						data: {'keyword':keyword},
						success: function(response) {
							$(".searchResult").html(response);
						}
					});
				}
			}
		</script>
	</body>
    
</html>