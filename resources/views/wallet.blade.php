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
									<h5 class="t-gray">Asset Balance<span class="h4">
										<span class="estimate_usd">{{ $usdt }}</span>USDT</span>
									</h5>
								</div>
							</div>						
								<div id="spotwalletbalance" class="chartbalancebox"></div>
								<!-- <div class="mypiechart">
                                    <canvas id="myCanvas" width="350" height="350"></canvas>
                                </div>

								<div class="true-text part">

                                <h5 class="eco-1" >BTC 0.00000000</h5>
                                <h5 class="eco-2">ETH 0.00000000</h5>
                                <h5 class="eco-3">TRX 0.00000000</h5>
                                <h5 class="eco-4">BNB 0.00000000</h5>
                                <h5 class="eco-5">USDT 0.00000000 </h5>
                            </div> -->

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
										<th>Total Balance in USDT</th>
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
											@if(isset($balance[$coin->source]['balanceinusdt']) && $balance[$coin->source]['balanceinusdt'] > 0)
											{{ $balanceinusdt = display_format($balance[$coin->source]['balanceinusdt'], $decimal) }}
											@else
											{{ $balanceinusdt = display_format("0", $decimal) }}
											@endif
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
		<script src="{{ url('js/highcharts.js') }}"></script>
		<script type="application/javascript" src="{{ url('js/rpie.js') }}"></script>
		<script rel="stylesheet" href="{{ url('js/pie-chart.js') }}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"
        integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous">
    </script>
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
				if(isset($balance[$coin->source]['balanceinusdt']) && $balance[$coin->source]['balanceinusdt'] > 0){
					$balanceinusdt = display_format($balance[$coin->source]['balanceinusdt'], $decimal);
				}else{
					$balanceinusdt = display_format("0", $decimal);
				}
				@endphp
					{
					name: "{{ $coin->source }} {{ $avil }}",
					y: {{ $balanceinusdt }}
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
    <!-- <script type="text/javascript">
    var obj = {
        values: [40, 20, 20, 100, 20],
        colors: ['#F2A434', '#784700', '#B66C00', '#E3B36F', '#FF9700'],
        animation: true, // Takes boolean value & default behavious is false
        animationSpeed: 10, // Time in miliisecond & default animation speed is 20ms
        fillTextData: true, // Takes boolean value & text is not generate by default 
        fillTextColor: '#fff', // For Text colour & default colour is #fff (White)
        fillTextAlign: 1.30, // for alignment of inner text position i.e. higher values gives closer view to center & default text alignment is 1.85 i.e closer to center
        fillTextPosition: 'inner', // 'horizontal' or 'vertical' or 'inner' & default text position is 'horizontal' position i.e. outside the canvas
        doughnutHoleSize: 50, // Percentage of doughnut size within the canvas & default doughnut size is null
        doughnutHoleColor: '#212121', // For doughnut colour & default colour is #fff (White)
        offset: 1, // Offeset between two segments & default value is null
        pie: 'normal', // if the pie graph is single stroke then we will add the object key as "stroke" & default is normal as simple as pie graph
        isStrokePie: {
            stroke: 20, // Define the stroke of pie graph. It takes number value & default value is 20
            overlayStroke: true, // Define the background stroke within pie graph. It takes boolean value & default value is false
            overlayStrokeColor: '#eee', // Define the background stroke colour within pie graph & default value is #eee (Grey)
            strokeStartEndPoints: 'Yes', // Define the start and end point of pie graph & default value is No
            strokeAnimation: true, // Used for animation. It takes boolean value & default value is true
            strokeAnimationSpeed: 40, // Used for animation speed in miliisecond. It takes number & default value is 20ms
            fontSize: '50px', // Used to define text font size & default value is 60px
            textAlignement: 'center', // Used for position of text within the pie graph & default value is 'center'
            fontFamily: 'Arial', // Define the text font family & the default value is 'Arial'
            fontWeight: 'bold' //  Define the font weight of the text & the default value is 'bold'
        }
    };


    //Generate myCanvas     
    generatePieGraph('myCanvas', obj);
    </script> -->
