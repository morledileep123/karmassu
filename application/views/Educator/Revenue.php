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
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									<h5>Revenue </h5>
								</div>
								<div class="card-header">
									<form action="" method="get">
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label">From Date <span class="text-danger">*</span></label>
													<input type="date" class="form-control" name="from_date" value="<?php echo $from_date;?>">
												</div>
											</div>
											<div class="col-sm-4"> 
												<div class="form-group">
													<label class="col-form-label">To Date <span class="text-danger">*</span></label>
													<input type="date" class="form-control" name="to_date" value="<?php echo $to_date;?>">
												</div>
											</div>
											<div class="col-sm-4"><br>
												<button type="submit"  class="btn btn-primary mt-2"><i class="fa fa-filter"></i> Filter</button>
											</div>
										</div>
									</form>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										
										<table class="table table-bordered" style="width:100%;">
											<thead>
												<tr>
													<th>#</th>
													<th>Item Name</th>
													<th>Item Amount</th>
													<th>Income(%)</th>
													<th>Income(Rs.)</th>
												</tr>
											</thead>
											
											
											<tbody>
												<?php
													$sr = 1;
													$subtotal=0;
													foreach($revenueList as $item) 
													{
														
														$itemTypes=(object) ['Course'=>'tbl_course','Ebook'=>'tbl_ebook','Abook'=>'tbl_abook'];
														$itemtype=$item->itemtype;
														$itemData=$this->Auth_model->getData($itemTypes->$itemtype,$item->itemid);
														$revenue=$this->Auth_model->getRevenue($this->author,$item->couponcode);
														
													?>
													<tr>
														<td><?php echo $sr; ?></td>
														<td><?php echo $itemData->name.' ['.$item->itemtype.']'; ?></td>
														<td><?php echo $item->price; ?></td>
														<td><?php echo $revenue.'%'; ?></td>
														<td><?php echo $income=round($item->price*$revenue/100); ?></td>
													</tr>
													<?php
														$subtotal+=$income;
														$sr++;
													}
												?>
											</tbody>
											<tbody>
												<tr>
													<th colspan="3">{ From: <strong class="text-info"><?php echo date('d M,Y',strtotime($from_date));?></strong> To: <strong class="text-info"><?php echo date('d M,Y',strtotime($to_date));?> </strong>}</th>
													<th>Subtotal</th>
													<th><i class="fa fa-inr"></i> <?php echo $subtotal;?></th>
												</tr>
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