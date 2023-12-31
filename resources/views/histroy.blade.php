@php $title = "History"; $atitle ="history";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">
					<div class="innerpagecontent">
						<h2 class="h2">History</h2> </div>
					<div class="profilepaget">
						<div class="panelcontentbox">
							<div class="innerpagetab">
								<ul class="nav nav-tabs tabbanner" role="tablist">
									<li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#trade" data-bs-target="#trade">Trade History</a></li>
									<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#deposit" data-bs-target="#deposit">Deposit History</a></li>
									<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#withdraw" data-bs-target="#withdraw">Withdraw History</a></li>
									
								</ul>
							</div>
							<div class="tab-content">
								<div id="trade" class="tab-pane fade in show active">
									<div class="searchfrmbox">
										<form class="siteformbg" method="post" autocomplete="off">
											<div class="searchfrm row">
												<div class="col-xl-3 col-lg-4 col-md-4">
													<div class="form-group">
														<div class="input-group dateinput">
															<input class="form-control" name="start_date" placeholder="Start Date (YYYY-MM-DD)">
															<div class="input-group-append" data-toggle="datepicker3" data-target-name="start_date"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
														</div>
													</div>
												</div>
												<div class="col-xl-3 col-lg-4 col-md-4">
													<div class="form-group">
														<div class="input-group dateinput">
															<input class="form-control" name="end_date" placeholder="End Date (YYYY-MM-DD)">
															<div class="input-group-append" data-toggle="datepicker3" data-target-name="end_date"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
														</div>
													</div>
												</div>
												
												<div class="col-xl-3 col-lg-4 col-md-4">
													<div class="form-group">
														<select class="form-control" name="side">
															<option value="All">All Side</option>
															<option value="Buy">Buy</option>
															<option value="Sell">Sell</option>
														</select>
													</div>
												</div>
												<div class="col-xl-3 col-lg-4 col-md-4">
													<div class="form-group">
														<select class="form-control">
															<option value="">All Pair</option>
															<option value="">BTC/ECPAY</option>
														</select>
													</div>
												</div>
												<div class="col-xl-3 col-lg-4 col-md-4 clearbtn">
													<div class="form-group">
														<button type="button" class="btn sitebtn btn-sm">Search</button> <a href="" class="btn sitebtn btn-sm">Reset</a></div>
												</div>
											</div>
										</form>
									</div>
									<div class="table-responsive sitescroll" data-simplebar>
										<table class="table sitetable table-responsive-stack" id="table1">
											<thead>
												<tr>
													<th>Date & Time</th>
													<th>Leverage</th>
													<th>Price</th>
													<th>Amount(BTC)</th>
													<th>Remaining</th>
													<th>Cancelled</th>
													<th>Total price</th>
													<th>Trade Fee</th>
													<th>Total</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-green">Buy</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td>2563971</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
													<td>---</td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-green">Buy</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td>2563971</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
													<td>---</td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-green">Buy</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td>2563971</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
													<td>---</td>
												</tr>

												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-green">Buy</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td>2563971</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
													<td>---</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div id="deposit" class="tab-pane fade in">
									
									<div class="table-responsive sitescroll" data-simplebar>
										<table class="table sitetable table-responsive-stack" id="table2">
											<thead>
												<tr>
													<th>Date & Time</th>
													<th>Pair</th>
													<th>Side</th>
													<th>Price</th>
													<th>Filled</th>
													<th>Fee</th>
													<th>Total</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-green">Buy</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-green">Buy</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-warning">Pending</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-green">Buy</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-danger">Canceled</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-green">Buy</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-red">Sell</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-red">Sell</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-red">Sell</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-red">Sell</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div id="withdraw" class="tab-pane fade in">
									
									<div class="table-responsive sitescroll" data-simplebar>
										<table class="table sitetable table-responsive-stack" id="table">
											<thead>
												<tr>
													<th>Date & Time</th>
													<th>Pair</th>
													<th>Side</th>
													<th>Price</th>
													<th>Filled</th>
													<th>Fee</th>
													<th>Total</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-green">Buy</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-green">Buy</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-warning">Pending</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-green">Buy</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-danger">Canceled</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-green">Buy</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-red">Sell</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-red">Sell</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-red">Sell</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
												</tr>
												<tr>
													<td>18/02/2020, 05:05:00</td>
													<td>BTC/ECPAY</td>
													<td><span class="t-red">Sell</span></td>
													<td>2.36589</td>
													<td>0.326985</td>
													<td>0.5%</td>
													<td>2563971</td>
													<td><span class="badge badge-success">Confirm</span></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</article>
			@include('layouts.footermenu')
</div>
@include('layouts.footer')