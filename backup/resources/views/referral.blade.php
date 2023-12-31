@php $title = "Trade History"; $atitle ="history";
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
									<li class="nav-item"><a class="nav-link active" href="{{ route('tradehistroy') }}">Trade History</a></li>
									<li class="nav-item"><a class="nav-link" href="{{ route('deposithistroy') }}">Deposit History</a></li>
									<li class="nav-item"><a class="nav-link" href="{{ route('withdrawhistroy') }}">Withdraw History</a></li>
									<!-- <li class="nav-item"><a class="nav-link" href="{{ route('p2phistory') }}">P2p Marketplace History</a></li> -->
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
															@forelse($listPairs as $tabtrade)
															<option value="{{$tabtrade->coinone.'_'.$tabtrade->cointwo}}">{{$tabtrade->coinone.'/'.$tabtrade->cointwo}}</option>
															@empty
															<option value="">BTC/ECPAY</option>
															@endforelse
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
													<th>Pair</th>
													<th>Type</th>
													<th>Price</th>
													<th>Amount(BTC)</th>
													<th>Remaining</th>
													<th>Trade Fee</th>
													<th>Total</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											@php
											$i = 1 ;
												if(isset($_GET['page'])){
												$page = $_GET['page'];
												$limit = 15;
												$i = (($limit * $page) - $limit)+1;
												}else{
												$i =1;
												}
											@endphp
											@forelse($historys as $history)
												<tr>
													<td>{{ date('d/m/Y H:i:s', strtotime($history->created_at)) }}</td>
													<td>{{$history->pairDetail['coinone']}} / {{$history->pairDetail['cointwo']}}</td>
													<td><span class="@if($history->trade_type == 'Buy') t-green @else t-red @endif">{{ $history->trade_type }}</span></td>
													<td>{{ $history->order_type == 2 ?  'Market price' : number_format($history->price, 8, '.', '')}}</td>
													<td>{{ number_format($history->volume, 8, '.', '') }}</td>
													<td>{{ number_format($history->remaining, 8, '.', '') }}</td>													
													<td>{{ number_format($history->fees, 8, '.', '') }}</td>
													<td>{{ $history->order_type == 2 ?  '-' : number_format($history->value, 8, '.', '')}}</td>
													<td>@if($history->status == 0 ) Pending @elseif($history->status == 100 ) Cancelled @else Completed @endif</td>
													<td>@if($history->status == 0)<a class="badge badge-warning" href="{{ url('/cancelorder/'.\Crypt::encrypt($history->id) ) }}">Cancel</a>@else --- @endif</td>
												
												</tr>
												@empty
												<tr>
													<td colspan="10" class="text-center">No Record Found!</td>
												</tr>
												@endforelse
											</tbody>
										</table>
									</div>
									@if(count($historys) > 0)
										{!! $historys->appends(Request::only(['fromdate'=>'fromdate', 'todate'=>'todate']))->render() !!} 
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</article>
			@include('layouts.footermenu')
</div>
@include('layouts.footer')