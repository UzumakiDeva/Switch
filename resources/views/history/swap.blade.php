@php $title = "Swap History "; $atitle ="history";
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
									<li class="nav-item"><a class="nav-link" href="{{ route('tradehistroy') }}">Trade History</a></li>
									<li class="nav-item"><a class="nav-link" href="{{ route('deposithistroy') }}">Deposit History</a></li>
									<li class="nav-item"><a class="nav-link" href="{{ route('withdrawhistroy') }}">Withdraw History</a></li>
									<li class="nav-item"><a class="nav-link active" href="{{ url('swap-history') }}">Swap History</a></li>
									
								</ul>
							</div>
							<div class="tab-content">
								<div id="deposit" class="tab-pane fade in show active">
									
									<div class="table-responsive sitescroll" data-simplebar>
										<table class="table sitetable table-responsive-stack" id="table">
											<thead>
												<tr>
												<th>S.NO</th>
												<th>Date & Time</th>
												<th>Txn ID</th>
												<th>Spend</th>
												<th>Receive</th>
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
											@forelse($historys as $histroy)
											<tr>
											<td class='swap-thistory-body-table-td'>{{ $i }}</td>
											<td class='swap-thistory-body-table-td'>{{ date('d-m-Y H:i:s', strtotime($histroy->created_at)) }}</td>
											<td class='swap-thistory-body-table-td'>{{ $histroy->order_id }}</td>
											<td class='swap-thistory-body-table-td'>{{ $histroy->spend_coin }}</td>
											<td class='swap-thistory-body-table-td'>{{ $histroy->recive_coin }}</td>
											{{-- <td>{{ display_format($histroy->volume) }}</td> --}}
											</tr>
											@php $i ++; @endphp
											@empty
											<tr><td colspan="9" class="text-center">No records found!</td></tr>
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