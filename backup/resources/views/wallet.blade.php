@php $title = "Wallet"; $atitle ="wallet";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
</section>
			<article class="gridparentbox">
				<div class="container sitecontainer walletpagebg">
					
					
					
					<div class="flexboxtable profilepage">						
					<div class="panelcontentbox">
			
								<div class="wlletboxt">		
								<div class="balanceshowt">
								<div>
									<h5 class="t-gray">Asset Balance<span class="h4"></h5>
								</div>
							</div>						
								<div id="spotwalletbalance" class="chartbalancebox"></div>
							</div>
							</div>
						<div class="panelcontentbox">						
						
						<h2 class="heading-box">Wallet Balance</h2>
						<div class="table-responsive sitescroll" data-simplebar>
							@if (session('success'))
                              <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ session('success') }}
                            </div>
                            @endif
                            @if (session('adminwalletbank'))
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ session('adminwalletbank') }}
                            </div>
                            @endif
							<table class="table sitetable table-responsive-stack" id="table1">
								<thead>
									<tr>
										<th>Coin</th>
										<th>Available Balance</th>
										<th>In Order</th>
										<th>Total Balance</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@forelse($coins as $coin)
									@php $decimal = $coin->point_value; @endphp
									<tr>
										<td><img src="{{ url('images/color/'.$coin->image) }}" class="coinlisticon">{{$coin->source}}<br/><small>{{$coin->coinname}}</small></td>
										<td>
											@if(isset($balance[$coin->source]['balance']) && $balance[$coin->source]['balance'] > 0)
												{{ $avil = display_format($balance[$coin->source]['balance'], $decimal) }}
											@else
												{{ $avil = display_format("0", $decimal) }}
											@endif
										</td>
										<td>
											@if(isset($balance[$coin->source]['escrow']) && $balance[$coin->source]['escrow'] > 0)
											{{ $escrow = display_format($balance[$coin->source]['escrow'], $decimal) }}
											@else
											{{ $escrow = display_format("0", $decimal) }}
											@endif
										</td>
										<td>
											{{ ncAdd($avil, $escrow, $decimal) }}
										</td>
										<td>
											@if($coin->is_deposit == 1)
											<a href="{{ url('deposit/'.$coin->source) }}" class="btn btn-sm green-btn mr-2">Deposit</a>
											@endif
											@if($coin->is_withdraw == 1)
											<a href="{{ url('withdraw/'.$coin->source) }}" class="btn btn-sm red-btn mr-2">Withdraw</a>
											@endif
											
											@if($coin->source != 'USDT')
											<a href="{{url('trades/'.$coin->source.'_USDT')}}" class="btn sitebtn btn-sm">Trade</a></td>
											@else
											<a href="{{url('trade')}}" class="btn sitebtn btn-sm">Trade</a></td>
											@endif
									</tr>
									@empty
									<tr>
										<td><img src="{{ url('images/color/ecpay.svg') }}" class="coinlisticon">ECPAY<br/><small>EC Pay</small></td>
										<td>0.293985</td>
										<td>0.32569</td>
										<td>0.00254789</td>
										<td><a href="#" class="btn btn-sm green-btn mr-2">Deposit</a>
										<a href="#" class="btn btn-sm red-btn mr-2">Withdraw</a>
										<a href="#" class="btn sitebtn btn-sm">Trade</a></td>
									</tr>
									@endforelse
									
											
								</tbody>
							</table>
						</div>
						</div>
					
						
					</div>
					</div>
			</article>
			@include('layouts.footermenu')
</div>
@include('layouts.footer')
		
	<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>
		<script src="https://code.highcharts.com/modules/accessibility.js"></script>
		<script>
		Highcharts.chart("spotwalletbalance", {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: !1,
				type: "pie",
				outline: !1
			},
			title: {
				text: ""
			},
			tooltip: {
				pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>"
			},
			accessibility: {
				point: {
					valueSuffix: "%"
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: !0,
					cursor: "pointer",
					dataLabels: {
						enabled: !1
					},
					showInLegend: !0
				}
			},
			series: [{
				name: "Crypto",
				colorByPoint: !0,
				innerSize: "60%",
				data: [
				@forelse($coins as $coin)
				@php 
				$decimal = $coin->point_value;
				if(isset($balance[$coin->source]['balance']) && $balance[$coin->source]['balance'] > 0){
					$avil = display_format($balance[$coin->source]['balance'], $decimal);
				} else{
					$avil = display_format("0", $decimal);
				}
				@endphp
					{
					name: "{{ $coin->source }} {{ $avil }}",
					y: .369
					},
				@empty
				{
					name: "LIO 0.00310630",
					y: .369
				}, {
					name: "EC pay 106.63694432",
					y: .369
				}, {
					name: "BTC  0.00000839",
					y: .369
				}, {
					name: "ETH  0.00000025",
					y: .369
				}, {
					name: "BNB  0.00000025",
					y: .369
				},{
					name: "TRX  0.00000025",
					y: .369
				},
				{
					name: "LTC  0.00000025",
					y: .369
				}
				@endforelse
				]
			}],
			legend: {
				
				itemMarginTop: 5,
				itemMarginBottom: 5
			}
		});
		</script>