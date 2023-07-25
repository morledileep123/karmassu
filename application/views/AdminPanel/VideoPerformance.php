<?php defined("BASEPATH") or exit("No direct scripts allowed here"); ?>
<!DOCTYPE html>
<html lang="en"> 
		<?php include("HeaderLinking.php"); ?>
		<style>
			progress {
			vertical-align: baseline
			}
			@-webkit-keyframes progress-bar-stripes {
			from {
			background-position: 1rem 0
			}
			to {
			background-position: 0 0
			}
			}
			
			@keyframes progress-bar-stripes {
			from {
			background-position: 1rem 0
			}
			to {
			background-position: 0 0
			}
			}
			
			.progress {
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			height: 1rem;
			overflow: hidden;
			font-size: .75rem;
			background-color: #e9ecef;
			border-radius: .25rem
			}
			
			.progress-bar {
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			-webkit-box-orient: vertical;
			-webkit-box-direction: normal;
			-ms-flex-direction: column;
			flex-direction: column;
			-webkit-box-pack: center;
			-ms-flex-pack: center;
			justify-content: center;
			color: #fff;
			text-align: center;
			background-color: #007bff;
			transition: width .6s ease
			}
			
			.progress-bar-striped {
			background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
			background-size: 1rem 1rem
			}
			
			.progress-bar-animated {
			-webkit-animation: progress-bar-stripes 1s linear infinite;
			animation: progress-bar-stripes 1s linear infinite
			} 
		</style>
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
							<h4 class="page-title"> Video Performance</h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?= base_url("AdminPanel/ManageVideos"); ?>">Manage Videos</a></li>
								<li class="breadcrumb-item active" aria-current="page">Video Performance</li>
							</ol>
						</div>
						<div class="col-sm-3">
							
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										
										<table class="table table-bordered wrap" id="example" style="width:100%;">
											<thead>
												<tr>
													<th>#</th>
													<th>Course Logo</th>
													<th>Course Name</th>
													<th>Video Performance</th>
													<th>Name</th>
													<th>Mobile</th>
													<th>Email</th>
													<th>Qualification</th>
													<th>Coupon</th>
													<th>Price</th>
													<th>Order ID</th>
													<th>Razorpay Order ID</th>
													<th>Payment ID</th>
													<th>Date</th>
													<th>Time</th>
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
															<img data-src="<?php echo base_url("uploads/course/".$item->item->logo); ?>"  src="<?php echo base_url("images/Preloader2.jpg"); ?>" class="lazy" style="height:50px;" /> 
														</td>
														<td>
															<a href="<?php echo base_url("AdminPanel/ManageCourses/Details/".$item->itemid) ?>"
															class="btn btn-sm btn-info waves-effect waves-light">
															<i class="fa fa-eye"></i> </a>
															<?php echo $item->item->name; ?>
														</td>
														<td>
															<div class="progress">
																<div class="progress-bar" role="progressbar" style="width: <?php echo $item->progress; ?>;"  aria-valuemin="0" aria-valuemax="100"><?php echo $item->progress; ?></div>
															</div>
														</td>
														<td>
															<?php echo $item->firstname.' '.$item->lastname; ?>
															<a href="<?php echo base_url('AdminPanel/ManageStudents/Profile/'.$item->userid);?>" class="btn btn-info p-1"> <i class="fa fa-user-circle"></i> Profile</a>
														</td>
														<td>
															<?php echo $item->mobile; ?>
														</td>
														<td>
															<?php echo $item->email; ?>
														</td>
														<td>
															<?php echo $item->qualification; ?>
														</td>
														<td>
															<?php echo $item->couponcode; ?>
														</td>
														<td>
															<i class="fa fa-inr"></i> <?php echo $item->price; ?>
														</td>
														<td>
															<?php echo $item->orderid; ?>
														</td>
														<td>
															<?php echo $item->rzp_orderid; ?>
														</td>
														<td>
															<?php echo $item->paymentid; ?>
														</td>
														<td>
															<?php echo $item->date; ?>
														</td>
														<td>
															<?php echo $item->time; ?>
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
		</div>
		<?php include("FooterLinking.php"); ?>
	</body>
	
</html>