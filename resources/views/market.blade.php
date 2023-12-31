@php $title = "Market";
$atitle ="market";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
</section>
<style type="text/css">
.innerpagegrid .sitetable tbody tr td {
	overflow: hidden;
	text-overflow: ellipsis;
	max-width: 90px;
   -webkit-line-clamp: 2;
}
</style>			<article class="gridparentbox">
				<div class="container sitecontainer dashboardpage">
                <div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="marketpriceflex">
								@forelse($tabsTrades as $tabtrade)
								<div class="panelcontentbox">
									<div class="marketpricebox">
										<div class="mrkpricetable">
											<div>
												<h5 class="h5">{{$tabtrade->coinone.'/'.$tabtrade->cointwo}}</h5>
												@if($tabtrade->coinone == 'SET')
												<h4 class="h4 @if($tabtrade->hrchange >= 0 ) t-green @else t-red @endif last_price_{{$tabtrade->symbol}}SET">{{ $tabtrade->close }} </h4>
												@else
												<h4 class="h4 @if($tabtrade->hrchange >= 0 ) t-green @else t-red @endif last_price_{{$tabtrade->symbol}}">{{ $tabtrade->close }} </h4>
												@endif
											</div>
											<div class="text-right"> <img src="images/graph.svg" /> </div>
										</div>
										<hr>
										<h6 class="h6">24h change : <span class="@if($tabtrade->hrchange >= 0 ) t-green @else t-red @endif smllspan price_change_{{$tabtrade->symbol}}">{{ $tabtrade->hrchange }}%</span><br/>Volume : <span class="quote_{{$tabtrade->symbol}}">{{ $tabtrade->hrvolume }} </span>{{$tabtrade->cointwo}}</h6>
									 </div>
								</div>
								@empty
								<div class="panelcontentbox">
									<div class="marketpricebox">
										<div class="mrkpricetable">
											<div>
												<h5 class="h5">LTC/ECPAY</h5>
												<h4 class="h4 t-green">15.2563 <span class="smllspan">$52.36</span></h4> </div>
											<div class="text-right"> <img src="images/graphs.svg" /> </div>
										</div>
										<hr>
										<h6 class="h6">24h change : <span class="t-green smllspan">0.81%</span><br/>Volume : 31256369 ECPAY</h6> </div>
								</div>
								@endforelse	
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="panelcontentbox">
                            <div class="innerpagetab historytab">
							<ul class="nav nav-tabs tabbanner" role="tablist">
							@foreach ($marketpairs as $key => $value)
								<li class="nav-item"><a class="nav-link @if($key == 'USDT') active @endif" data-bs-toggle="tab" href="#{{ $key }}market" data-bs-target="#market{{ $key }}">{{ $key }} Market</a></li>
								@endforeach
								<!-- <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#btcmark" data-bs-target="#btcmark">BTC Market</a></li> -->
							
							</ul>
						</div>
								<div class="tab-content">
								@foreach ($marketpairs as $key => $value)
									<div id="market{{ $key }}" class="tab-pane @if($key == 'USDT') active @endif">
										<div class="table-responsive sitescroll" data-simplebar>
											<table class="table sitetable">
												<thead>
													<tr>
														<th>Pair</th>
														<th>Coin</th>
														<th>Live Price</th>
														<th>24h Change</th>
														<th>24h High</th>
														<th>24h Low</th>
														<th>24h Volume</th>
														<th>Open Price</th>
														<th>Trade</th>
													</tr>
												</thead>
												<tbody>
													@forelse($trades as $trade)
													@if($trade->cointwo == $key)
													<tr>
													<td><img src="{{ url('images/color/'.$trade->coinonedetails['image']) }}" class="coinlisticon">{{$trade->coinone.'/'.$trade->cointwo}}</td>
														<td>{{$trade->coinonedetails['coinname']}}</td>
														@if($trade->coinone =='SET')
														<td class="last_price_{{$trade->symbol}}SET">{{ $trade->close }}</td>
														@else
														<td class="last_price_{{$trade->symbol}}">{{ $trade->close }}</td>
														@endif
														<td><span class="@if($trade->hrchange >= 0 ) t-green @else t-red @endif price_change_{{$trade->symbol}}">{{ $trade->hrchange }}</span></td>
														<td class="high_{{$trade->symbol}}">{{ $trade->high }}</td>
														<td class="low_{{$trade->symbol}}">{{ $trade->low }}</td>
														<td class="quote_{{$trade->symbol}}">{{ $trade->hrvolume }}</td>
														<td class="open_{{$trade->symbol}}">{{display_format( $trade->open ,$trade->cointwo_decimal )}}</td>
														<td><a href="{{url('trades/'.$trade->coinone.'_'.$trade->cointwo)}}" class="btn sitebtn btn-sm bluetrade">Trade</a></td>
													</tr>
													@endif	
													@empty
													<tr>
														<td colspan="7">No Market Available</td>
													</tr>
													@endforelse
																									
												</tbody>
											</table>
										</div>
									</div>
									@endforeach
									<div id="btcmark" class="tab-pane">
										<div class="table-responsive sitescroll" data-simplebar>
											<table class="table sitetable">
												<thead>
													<tr>
														<th>Pair</th>
														<th>Coin</th>
														<th>Last Price</th>
														<th>24h Change</th>
														<th>24h High</th>
														<th>24h Low</th>
														<th>24h Volume</th>
														<th>Lastprice</th>
														<th>Trade</th>
													</tr>
												</thead>
												<tbody>
													<tr>
													<td><img src="images/color/lio.svg" class="coinlisticon">Lio/BTC</td>
														<td>Lio Coin</td>
														<td>2.2593</td>
														<td><span class="t-green">0.32569</span></td>
														<td>0.32569</td>
														<td>2.3966</td>
														<td>$478648M</td>
														<td>5.39689</td>
														<td><a href="#" class="btn sitebtn btn-sm bluetrade">Trade</a></td>
													</tr>	
												</tbody>
											</table>
										</div>
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

<script type="text/javascript">
	$(document).ready(function(){
				
				var conn = new WebSocket("wss://stream.binance.com:9443/ws");
				conn.onopen = function(evt) {
					
					var cpair = 'BTCUSDT';
					
					
					// send Subscribe/Unsubscribe messages here (see below)
					var array_dta = [];
					@forelse($trades as $pairlist)
						@if($pairlist->is_dust == 1 || $pairlist->is_dust == 2)
						@if($pairlist->is_dust == 2)					
							var bpair = "{{ strtolower(trim($pairlist->coinone.'USDT')) }}";
						@else
						var bpair = '{{ strtolower(trim($pairlist->symbol)) }}';
						@endif
							array_dta1 = [bpair+"@ticker"];
							array_dta1.forEach(function (item) {
								array_dta.push(item);
							})
						@endif
					@empty       
					var bpair = 'btcusdt';
					array_dta1 = [bpair+"@ticker"];
					array_dta1.forEach(function (item) {
						array_dta.push(item);
					})
					@endforelse	
					var messageJSON = {
						"method": "SUBSCRIBE",
						"params": array_dta,
						"id": 1
					};
					conn.send(JSON.stringify(messageJSON));
				}
				
				
				conn.onmessage = function(evt) {
					if(evt.data) {
						var get_data = JSON.parse(evt.data);
						if((typeof get_data['e'] == "24hrTicker") || (get_data['e'] != null)) {
							var last_price = get_data['c'];
							var high_price = get_data['h'];
							var low_price = get_data['l'];
							var open_price = get_data['o'];
							var price_change = get_data['P'];
							var quote = get_data['q'];
							var symbol = get_data['s'];
							
							var is_data = "t-red";
							if(price_change > 0) { is_data = "t-green";  }
							
							if((typeof last_price != 'undefined')) {
								$('.last_price_'+symbol).html(parseFloat(last_price.toString()));
							}
							
							if((typeof quote != 'undefined') && (typeof last_price != 'undefined')) {
								$('.quote_'+symbol).html(parseFloat(quote.toString()));
							}
							if((typeof open_price != 'undefined') && (typeof last_price != 'undefined')) {
								$('.open_'+symbol).html(parseFloat(open_price.toString()));
							}
							if((typeof low_price != 'undefined') && (typeof last_price != 'undefined')) {
								$('.low_'+symbol).html(parseFloat(low_price.toString()));
							}
							if((typeof high_price != 'undefined') && (typeof last_price != 'undefined')) {
								$('.high_'+symbol).html(parseFloat(high_price.toString()));
							}
							
							if((typeof price_change != 'undefined') && (typeof last_price != 'undefined')) {
								price_change = price_change * 1;
								price_change = price_change.toFixed(2);
								$('.price_change_'+symbol).html('<span class="'+is_data+'">'+parseFloat(price_change).toFixed(2)+'% </span>');
							}
							
						}
					}
					
				}
				
			});
</script>