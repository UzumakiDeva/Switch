@php $title = "Success History "; $atitle ="p2phistory";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">
					<div class="innerpagecontent">
						<h2 class="h2">P2PMarketplace History</h2> </div>
					<div class="profilepaget">
						<div class="panelcontentbox">
							<div class="innerpagetab">
								<ul class="nav nav-tabs tabbanner" role="tablist">
									<li class="nav-item"><a class="nav-link" href="{{ route('p2phistory') }}">Outstanding</a></li>
									<li class="nav-item"><a class="nav-link active" href="{{ route('success') }}">Successful</a></li>
									<li class="nav-item"><a class="nav-link" href="{{ route('failure') }}">Unsuccessful</a></li>
									
								</ul>
							</div>
							<div class="tab-content">
								<div id="deposit" class="tab-pane fade in show active">
									
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
													<td>{{ $history->pairDetails['coinone'].'/'. $history->pairDetails['cointwo']}}</td>
													<td><span class="@if($history->trade_type == 'Buy') t-green @else t-red @endif">{{ $history->trade_type }}</span></td>
													<td>{{ $history->order_type == 2 ?  'Market price' : number_format($history->price, 8, '.', '')}}</td>
													<td>{{ number_format($history->volume, 8, '.', '') }}</td>
													<td>{{ number_format($history->remaining, 8, '.', '') }}</td>													
													<td>{{ number_format($history->fees, 8, '.', '') }}</td>
													<td>{{ $history->order_type == 2 ?  '-' : number_format($history->value, 8, '.', '')}}</td>
													<td>{{$history->status_text}}</td>
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