@include('layouts.header')
	<div class="pagecontent gridpagecontent tradepage chartactive">
        @include('layouts.headermenu')
			</section>
			<article class="gridparentbox tradecontentbox">
				<!--new! placeholder-->
				<div class="marketlistsidemenu">
					<ul class="marketlistt">
						<li>
							<div id="sidebarmarketlistCollapse"><i class="fa fa-arrow-left"></i></div>
							<div class="text-left">BTC/ECPAY</div>
						</li>
					</ul>
				</div>
				<!--new!-->
				<div class="container sitecontainer">
					<!--new!-->
					<div class="buyselltabbg buyselltopbox">
						<ul class="nav nav-tabs orderfrmtab buyselltab" role="tablist">
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#buy">Buy</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sell">Sell</a></li>
						</ul>
					</div>
					<!--new!-->
					<div class="grid-box">
						<div class="livepricelist">
							<div class="livepricemobile">
								<ul class="livepricenavbg">
									<li>
										<a class="livepricet coinlisttable"> <img src="{{ url('images/color/btc.svg') }}" class="coinlisticon" />
											<div>BTC/ECPAY</div>
										</a>
									</li>
									<ul class="navbar-nav">
										<li class="dropdown usermenu"> <a href="#" class="nav-link dropdown-bs-toggle" role="button" data-bs-toggle="dropdown">Select market
					     				<span class="d-t"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
										</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" href="#"><img src="{{ url('images/color/lio.svg') }}" class="coinlisticon">LIO/ECPAY</a>
												<a class="dropdown-item" href="#"><img src="{{ url('images/color/btc.svg') }}" class="coinlisticon">BTC/ECPAY</a>
												<a class="dropdown-item" href="#"><img src="{{ url('images/color/eth.svg') }}" class="coinlisticon">ETH/ECPAY</a>
												<a class="dropdown-item" href="#"><img src="{{ url('images/color/bnb.svg') }}" class="coinlisticon">BNB/ECPAY</a>
												<a class="dropdown-item" href="#"><img src="{{ url('images/color/trx.svg') }}" class="coinlisticon">TRX/ECPAY</a>
												<a class="dropdown-item" href="#"><img src="{{ url('images/color/ltc.svg') }}" class="coinlisticon">LTC/ECPAY</a>
											</div>
										</li>
									</ul>
									<li><a class="livepricet">Last price<br><span class="t-red">0.236589</span></a></li>
									<li><a class="livepricet">24H change<br><span class="t-green">0.236589</span></a></li>
									<li><a class="livepricet">24H volume<br><span>0.236589 ECPAY</span></a></li>
								</ul>
							</div>
						</div>
						<div class="mobilegrid tabs-nav">
							<li class="orderlist"><a href="#tab-1">Chart</a></li>
							<li class="orderlist"><a href="#tab-2">Open Orders</a></li>
							<li class="orderlist"><a href="#tab-3">Trade History</a></li>
						</div>
						<div class="marketlist">
							<h2 class="heading-box">Markets</h2>
							<div id="closemarketicon" class="closeiconlist"><i class="fa fa-arrow-right"></i></div>
							<div class="table-responsive" data-simplebar>
								<table class="table sitetable">
									<thead>
										<tr>
											<th>Pair</th>
											<th>Price</th>
											<th>24h change</th>
											<th>24 volume</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><img src="{{ url('images/color/lio.svg') }}" class="coinlisticon">Lio/ECPAY</td>
											<td>256.36259548</td>
											<td><span class="t-green">2.20% <i class="fa fa-arrow-up"></i></span></td>
											<td>6.36259548</td>
										</tr>
										<tr>
											<td><img src="{{ url('images/color/btc.svg') }}" class="coinlisticon">BTC/ECPAY</td>
											<td>256.36259548</td>
											<td><span class="t-green">2.20% <i class="fa fa-arrow-up"></i></span></td>
											<td>6.36259548</td>
										</tr>
										<tr>
											<td><img src="{{ url('images/color/eth.svg') }}" class="coinlisticon">ETH/ECPAY</td>
											<td>256.36259548</td>
											<td><span class="t-green">2.20% <i class="fa fa-arrow-up"></i></span></td>
											<td>6.36259548</td>
										</tr>
										<tr>
											<td><img src="{{ url('images/color/bnb.svg') }}" class="coinlisticon">BNB/ECPAY</td>
											<td>256.36259548</td>
											<td><span class="t-green">2.20% <i class="fa fa-arrow-up"></i></span></td>
											<td>6.36259548</td>
										</tr>
										<tr>
											<td><img src="{{ url('images/color/trx.svg') }}" class="coinlisticon">TRX/ECPAY</td>
											<td>256.36259548</td>
											<td><span class="t-green">2.20% <i class="fa fa-arrow-up"></i></span></td>
											<td>6.36259548</td>
										</tr>
										<tr>
											<td><img src="{{ url('images/color/ltc.svg') }}" class="coinlisticon">LTC/ECPAY</td>
											<td>256.36259548</td>
											<td><span class="t-green">2.20% <i class="fa fa-arrow-up"></i></span></td>
											<td>6.36259548</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="chart">
							<h2 class="heading-box">Chart</h2>
							<div class="tabrightbox">
								<ul class="nav nav-tabs tabbanner charttabbg" role="tablist">
									<li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#tradechart" href="#tradechart">
									Tradingview 
								</a> </li>
									<li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" data-bs-target="#marketdepth" href="#marketdepth">
								MarketDepth
							</a> </li>
								</ul>
							</div>
							<div class="tab-content contentbox">
								<div id="tradechart" class="tab-pane fade in show active tradechartlist">
									<div class="tradingview-widget-container">
										<div id="tradingview_49396"></div>
										<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
										<script type="text/javascript">
										new TradingView.widget({
											"autosize": true,
											"fullscreen": true,
											"symbol": "Binance:BTCUSD",
											"interval": "5",
											"timezone": "UTC",
											"toolbar_bg": "#1d1d1d",
											"theme": "Dark",
											"style": "1",
											"locale": "en",
											"toolbar_bg": "#1d1d1d",
											"enable_publishing": false,
											"allow_symbol_change": false,
											"container_id": "tradingview_49396",
											"withdateranges": true,
											"hide_side_toolbar": false,
											"hide_legend": true
										});
										</script>
									</div>
								</div>
								<div id="marketdepth" class="tab-pane fade in marketchart">
									<div id="chartdiv" class=""></div>
									<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
									<script src="https://www.amcharts.com/lib/3/serial.js"></script>
									<script src="https://www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js"></script>
									<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
									<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
									<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
								</div>
							</div>
						</div>
						<div class="orderbook buysellshow">
							<h2 class="heading-box">Orderbook
					        <div class="tabrightbox">						
						        <ul class="nav nav-tabs tabbanner charttabbg orderchangebg">
							     <li class="nav-item"><a class="nav-link" id="buysellshow"><img src="{{ url('images/chart1.svg') }}"></a></li>
							     <li class="nav-item"><a class="nav-link" id="buyshow"><img src="{{ url('images/chart2.svg') }}"></a></li>					
							     <li class="nav-item"><a class="nav-link" id="sellshow"><img src="{{ url('images/chart3.svg') }}"></a></li>					
						        </ul>
					        </div>					
					         </h2>
							<div class="orderbookscroll">
								<div class="table-responsive sitescroll" data-simplebar>
									<table class="table sitetable">
										<thead>
											<tr>
												<th>Price(ECPAY)</th>
												<th class="text-right">Amount(BTC)</th>
												<th class="text-right">Total(ECPAY)</th>
											</tr>
										</thead>
									</table>
								</div>
								<div class="sellboxorder" id="sellorderbox">
									<div class="table-responsive sitescroll" id="sellpagescroll">
										<div class="sellboxtablebg">
											<table class="table sitetable">
												<thead>
													<tr>
														<th>Price(ECPAY)</th>
														<th class="text-right">Amount(BTC)</th>
														<th class="text-right">Total(ECPAY)</th>
													</tr>
												</thead>
												<tbody class="">
													<tr>
														<td><span class="t-red">0.005198759560</span></td>
														<td class="text-right">0.005198759560</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00520674897</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.25639</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00520674897</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00520674897</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00520674897</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00520674897</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00520674897</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00525</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00525</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00525</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00525</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00525</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00525</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00525</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00525</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.005198759560</span></td>
														<td class="text-right">0.005198759560</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00520674897</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.25639</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00525</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.005198759560</span></td>
														<td class="text-right">0.005198759560</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00520674897</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.25639</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00525</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.005198759560</span></td>
														<td class="text-right">0.005198759560</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00520674897</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.25639</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00525</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.005198759560</span></td>
														<td class="text-right">0.005198759560</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00520674897</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.25639</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00525</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.005198759560</span></td>
														<td class="text-right">0.005198759560</td>
														<td class="text-right">0.005198759560</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00520674897</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.25639</td>
													</tr>
													<tr>
														<td><span class="t-red">0.00525</span></td>
														<td class="text-right">0.25639</td>
														<td class="text-right">0.005198759560</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="livepricebox" id="livepricebox">
									<table class="table sitetable">
										<thead>
											<tr>
												<th><span class="t-green">0.256</span></th>
												<th class="text-right">0.001% <i class="fa fa-signal"></i></th>
											</tr>
										</thead>
									</table>
								</div>
								<div class="buyboxorder" id="buyorderbox">
									<div class="table-responsive sitescroll" data-simplebar>
										<table class="table sitetable">
											<thead>
												<tr>
													<th>Price(ECPAY)</th>
													<th class="text-right">Amount(BTC)</th>
													<th class="text-right">Total(ECPAY)</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.02563</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
												<tr>
													<td><span class="t-green">0.00525</span></td>
													<td class="text-right">0.25639</td>
													<td class="text-right">0.25639</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="orderform">
							<ul class="ruleslist">
								<li><a><i class="fa fa-info-circle" aria-hidden="true"></i> Trading Rules
						   <div class="none rulesnotes">
							<table class="table sitetable">
								<tbody>
									<tr>
										<td>Minimum Trade Amount : </td>
										<td>0.000001 BTC</td>
									</tr>
									<tr>
										<td>Min Price Movement : </td>
										<td>0.000001 ECPAY</td>
									</tr>
									<tr>
										<td>Minimum Order Size : </td>
										<td>0.000001 ECPAY</td>
									</tr>
									<tr>
										<td>Maximum Market Order Amount : </td>
										<td>0.000001 BTC</td>
									</tr>																	
								</tbody>
							</table>
						  </div>
				        	</a> </li>
							</ul>
							<div class="orderformbg">
								<h2 class="heading-box">Orderform</h2>
								<!--new!-->
								<div class="buyselltabbg">
									<ul class="nav nav-tabs orderfrmtab buyselltab" role="tablist">
										<li class="nav-item"><a class="nav-link active" role="tab" data-bs-toggle="tab" href="#buy" data-bs-target="#buy">Buy</a></li>
										<li class="nav-item"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#sell" data-bs-target="#sell">Sell</a></li>
									</ul>
								</div>
								<!--new!-->
								<div class="clostbuytab"> <a href="#"><i class="fa fa-times"></i></a> </div>
								<ul class="nav nav-tabs orderfrmtab limitabbg" role="tablist">
									<li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#limit" data-bs-target="#limit">Limit</a></li>
									<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#market" data-bs-target="#market">Market</a></li>
								</ul>
							</div>
							<div class="tab-content">
								<div id="limit" class="tab-pane fade in show active">
									<div class="orderformbg1">
										<div class="buyorderform">
											<form class="siteformbg">
												<div class="form-group">
													<div class="input-group">
														<!-- <div class="input-group-prepend"> <span class="input-group-text">Price</span> </div> -->
														<input type="text" class="form-control" placeholder="Price">
														<div class="input-group-append"> <span class="input-group-text">ECPAY</span> </div>
													</div>
												</div>
												<div class="form-group">
													<div class="input-group">
														<!-- <div class="input-group-prepend"> <span class="input-group-text">Amount</span> </div> -->
														<input type="text" class="form-control" placeholder="Amount">
														<div class="input-group-append"> <span class="input-group-text">BTC</span> </div>
													</div>
												</div>
												<div class="form-group">
													<div class="input-group">
														<!-- <div class="input-group-prepend"> <span class="input-group-text">Total</span> </div> -->
														<input type="text" class="form-control" placeholder="Total">
														<div class="input-group-append"> <span class="input-group-text">ECPAY</span> </div>
													</div>
												</div>
												<div class="form-group">
													<div class="control-value-box stoplimtboxt">
														<div>limitcount</div>
														<div>
															<div class="row link-div">
																<div class="col activelimit" onclick="calculateBuyAmount('25')">25%</div>
																<div class="col" onclick="calculateBuyAmount('50')">50%</div>
																<div class="col" onclick="calculateBuyAmount('75')">75%</div>
																<div class="col" onclick="calculateBuyAmount('100')">100%</div>
															</div>
														</div>
													</div>
												</div>
												<div class="form-group fee-formbox">
													<div class="input-group"> <span class="input-group-prepend"> <div class="commision"><span class="feeamt">Leverage comission :</span> <span class="feeamt">2%</span></div>
													<div class="commision"><span class="feeamt">Fee</span> <span class="feeamt">0.0000000 BTC</span></div>
													</span>
												</div>
										</div>
										<div class="ratiobtn">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
												<label class="form-check-label" for="flexCheckDefault"> Order Confirmation </label>
											</div>
											<div class="text-center">
												<input type="submit" name="" class="btn btn-block sitebtn green-btn" value="Buy (BTC)" /> </div>
										</div>
										</form>
									</div>
									<div class="sellorderform">
										<form class="siteformbg">
											<div class="form-group">
												<div class="input-group">
													<!-- <div class="input-group-prepend"> <span class="input-group-text">Price</span> </div> -->
													<input type="text" class="form-control" placeholder="Price">
													<div class="input-group-append"> <span class="input-group-text">ECPAY</span> </div>
												</div>
											</div>
											<div class="form-group">
												<div class="input-group">
													<!-- <div class="input-group-prepend"> <span class="input-group-text">Amount</span> </div> -->
													<input type="text" class="form-control" placeholder="Amount">
													<div class="input-group-append"> <span class="input-group-text">BTC</span> </div>
												</div>
											</div>
											<div class="form-group">
												<div class="input-group">
													<!-- <div class="input-group-prepend"> <span class="input-group-text">Total</span> </div> -->
													<input type="text" class="form-control" placeholder="Total">
													<div class="input-group-append"> <span class="input-group-text">ECPAY</span> </div>
												</div>
											</div>
											<div class="form-group">
												<div class="control-value-box stoplimtboxt">
													<div>limitcount</div>
													<div>
														<div class="row link-div">
															<div class="col activelimit" onclick="calculateBuyAmount('25')">25%</div>
															<div class="col" onclick="calculateBuyAmount('50')">50%</div>
															<div class="col" onclick="calculateBuyAmount('75')">75%</div>
															<div class="col" onclick="calculateBuyAmount('100')">100%</div>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group fee-formbox">
												<div class="input-group"> <span class="input-group-prepend"> <div class="commision"><span class="feeamt">Leverage comission :</span> <span class="feeamt">2%</span></div>
												<div class="commision"><span class="feeamt">Fee</span> <span class="feeamt">0.0000000 BTC</span></div>
												</span>
											</div>
									</div>
									<div class="ratiobtn">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault"> Order Confirmation </label>
										</div>
										<div class="text-center">
											<input type="submit" name="" class="btn btn-block sitebtn red-btn" value="Sell (BTC)" /> </div>
									</div>
									</form>
								</div>
							</div>
						</div>
						<div id="market" class="tab-pane fade in">
							<div class="orderformbg1">
								<div class="buyorderform">
									<form class="siteformbg">
										<div class="form-group">
											<div class="input-group">
												<!-- <div class="input-group-prepend"> <span class="input-group-text">Price</span> </div> -->
												<input type="text" class="form-control" placeholder="Price">
												<div class="input-group-append"> <span class="input-group-text">ECPAY</span> </div>
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<!-- <div class="input-group-prepend"> <span class="input-group-text">Amount</span> </div> -->
												<input type="text" class="form-control" placeholder="Amount">
												<div class="input-group-append"> <span class="input-group-text">BTC</span> </div>
											</div>
										</div>
										<div class="form-group">
											<div class="control-value-box stoplimtboxt">
												<div>limitcount</div>
												<div>
													<div class="row link-div">
														<div class="col activelimit" onclick="calculateBuyAmount('25')">25%</div>
														<div class="col" onclick="calculateBuyAmount('50')">50%</div>
														<div class="col" onclick="calculateBuyAmount('75')">75%</div>
														<div class="col" onclick="calculateBuyAmount('100')">100%</div>
													</div>
												</div>
											</div>
										</div>
										<div class="text-center">
											<input type="submit" name="" class="btn btn-block sitebtn green-btn" value="Buy" /> </div>
									</form>
								</div>
								<div class="sellorderform">
									<form class="siteformbg">
										<div class="form-group">
											<div class="input-group">
												<!-- <div class="input-group-prepend"> <span class="input-group-text">Price</span> </div> -->
												<input type="text" class="form-control" placeholder="Price">
												<div class="input-group-append"> <span class="input-group-text">ECPAY</span> </div>
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<!-- <div class="input-group-prepend"> <span class="input-group-text">Amount</span> </div> -->
												<input type="text" class="form-control" placeholder="Amount">
												<div class="input-group-append"> <span class="input-group-text">BTC</span> </div>
											</div>
										</div>
										<div class="form-group">
											<div class="control-value-box stoplimtboxt">
												<div>limitcount</div>
												<div>
													<div class="row link-div">
														<div class="col activelimit" onclick="calculateBuyAmount('25')">25%</div>
														<div class="col" onclick="calculateBuyAmount('50')">50%</div>
														<div class="col" onclick="calculateBuyAmount('75')">75%</div>
														<div class="col" onclick="calculateBuyAmount('100')">100%</div>
													</div>
												</div>
											</div>
										</div>
										<div class="text-center">
											<input type="submit" name="" class="btn btn-block sitebtn red-btn" value="Sell" /> </div>
									</form>
								</div>
							</div>
						</div>
					</div>
				    </div>
				<div class="tradehistory">
					<h2 class="heading-box">Trade History</h2>
					<div class="table-responsive sitescroll" data-simplebar>
						<table class="table sitetable">
							<thead>
								<tr>
									<th>Price(ECPAY)</th>
									<th>Amount(BTC)</th>
									<th>Total(ECPAY)</th>
									<th>Date & Time</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><span class="t-green">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-green">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-green">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-green">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-green">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-green">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-green">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-green">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
								<tr>
									<td><span class="t-red">0.36985936</span></td>
									<td>0.25639</td>
									<td>0.25639</td>
									<td>11-12-19,07:16:16</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="openorder">
					<div class="innerpagetab historytab">
						<ul class="nav nav-tabs tabbanner" role="tablist">
							<li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#openorder" data-bs-target="#openorder">Open Orders</a></li>
							<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#orderhistory" data-bs-target="#orderhistory">My Order History</a></li>
							<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tradehistory" data-bs-target="#tradehistory">My Trade History</a></li>
						</ul>
					</div>
					<div class="tab-content">
						<div id="openorder" class="tab-pane fade in show active">
							<h2 class="heading-box">Open Orders</h2>
							<div class="table-responsive sitescroll" data-simplebar>
								<table class="table sitetable table-responsive-stack" id="table1">
									<thead>
										<tr>
											<th>Order type</th>
											<th>Date & Time</th>
											<th>Order</th>
											<!--<th><span style="visibility:hidden;">Order</span></th>!-->
											<th>Pair</th>
											<th>Amount</th>
											<th>Price</th>
											<th>Remaining</th>
											<th>Trade Fee</th>
											<th>Total</th>
											<th>Status</th>
											<th>Cancel</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Limit</td>
											<td>11-12-2020,07:16:16</td>
											<td><span class="t-green">Buy</span></td>
											<td>BTC/ECPAY</td>
											<td>0.25639</td>
											<td>0.25639</td>
											<td>0.25639</td>
											<td>0.25639</td>
											<td>0.25639</td>
											<td>Completed</td>
											<td><a href="#" class="btn sitebtn viewbtn">Cancel</a></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div id="tradehistory" class="tab-pane fade in">
							<h2 class="heading-box">Trade History</h2>
							<div class="table-responsive sitescroll" data-simplebar>
								<table class="table sitetable table-responsive-stack" id="table2">
									<thead>
										<tr>
											<th>Date</th>
											<th>Pair</th>
											<th>Type</th>
											<th>Amount</th>
											<th>Staus</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>18/02/2020, 05:05:00</td>
											<td>BTC/ECPAY</td>
											<td><span class="t-green">Buy</span></td>
											<td>2563971</td>
											<td>Confirm</td>
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
			<script>
			$("body").addClass("tradepagebg");
			</script>
			<script>
			var chart = AmCharts.makeChart("chartdiv", {
				"type": "serial",
				"theme": "dark",
				"dataLoader": {
					"url": "https://poloniex.com/public?command=returnOrderBook&currencyPair=BTC_ETH&depth=50",
					"format": "json",
					"reload": 30,
					"postProcess": function(data) {
						// Function to process (sort and calculate cummulative volume)
						function processData(list, type, desc) {
							// Convert to data points
							for(var i = 0; i < list.length; i++) {
								list[i] = {
									value: Number(list[i][0]),
									volume: Number(list[i][1]),
								}
							}
							// Sort list just in case
							list.sort(function(a, b) {
								if(a.value > b.value) {
									return 1;
								} else if(a.value < b.value) {
									return -1;
								} else {
									return 0;
								}
							});
							// Calculate cummulative volume
							if(desc) {
								for(var i = list.length - 1; i >= 0; i--) {
									if(i < (list.length - 1)) {
										list[i].totalvolume = list[i + 1].totalvolume + list[i].volume;
									} else {
										list[i].totalvolume = list[i].volume;
									}
									var dp = {};
									dp["value"] = list[i].value;
									dp[type + "volume"] = list[i].volume;
									dp[type + "totalvolume"] = list[i].totalvolume;
									res.unshift(dp);
								}
							} else {
								for(var i = 0; i < list.length; i++) {
									if(i > 0) {
										list[i].totalvolume = list[i - 1].totalvolume + list[i].volume;
									} else {
										list[i].totalvolume = list[i].volume;
									}
									var dp = {};
									dp["value"] = list[i].value;
									dp[type + "volume"] = list[i].volume;
									dp[type + "totalvolume"] = list[i].totalvolume;
									res.push(dp);
								}
							}
						}
						// Init
						var res = [];
						processData(data.bids, "bids", true);
						processData(data.asks, "asks", false);
						//console.log(res);
						return res;
					}
				},
				"graphs": [{
					"id": "bids",
					"fillAlphas": 0.1,
					"lineAlpha": 1,
					"lineThickness": 2,
					"lineColor": "#0f0",
					"type": "step",
					"valueField": "bidstotalvolume",
					"balloonFunction": balloon
				}, {
					"id": "asks",
					"fillAlphas": 0.1,
					"lineAlpha": 1,
					"lineThickness": 2,
					"lineColor": "#f00",
					"type": "step",
					"valueField": "askstotalvolume",
					"balloonFunction": balloon
				}, {
					"lineAlpha": 0,
					"fillAlphas": 0.2,
					"lineColor": "#000",
					"type": "column",
					"clustered": false,
					"valueField": "bidsvolume",
					"showBalloon": false
				}, {
					"lineAlpha": 0,
					"fillAlphas": 0.2,
					"lineColor": "#000",
					"type": "column",
					"clustered": false,
					"valueField": "asksvolume",
					"showBalloon": false
				}],
				"categoryField": "value",
				"chartCursor": {},
				"balloon": {
					"textAlign": "left"
				},
				"valueAxes": [{
					"title": "Volume"
				}],
				"categoryAxis": {
					"title": "Price (BTC/ETH)",
					"minHorizontalGap": 100,
					"startOnAxis": true,
					"showFirstLabel": false,
					"showLastLabel": false
				},
				"export": {
					"enabled": true
				}
			});

			function balloon(item, graph) {
				var txt;
				if(graph.id == "asks") {
					txt = "Ask: <strong>" + formatNumber(item.dataContext.value, graph.chart, 4) + "</strong><br />" + "Total volume: <strong>" + formatNumber(item.dataContext.askstotalvolume, graph.chart, 4) + "</strong><br />" + "Volume: <strong>" + formatNumber(item.dataContext.asksvolume, graph.chart, 4) + "</strong>";
				} else {
					txt = "Bid: <strong>" + formatNumber(item.dataContext.value, graph.chart, 4) + "</strong><br />" + "Total volume: <strong>" + formatNumber(item.dataContext.bidstotalvolume, graph.chart, 4) + "</strong><br />" + "Volume: <strong>" + formatNumber(item.dataContext.bidsvolume, graph.chart, 4) + "</strong>";
				}
				return txt;
			}

			function formatNumber(val, chart, precision) {
				return AmCharts.formatNumber(val, {
					precision: precision ? precision : chart.precision,
					decimalSeparator: chart.decimalSeparator,
					thousandsSeparator: chart.thousandsSeparator
				});
			}
			</script>