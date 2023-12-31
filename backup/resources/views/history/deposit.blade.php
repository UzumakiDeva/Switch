@php $title = "Deposit History "; $atitle ="history";
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
									<li class="nav-item"><a class="nav-link active" href="{{ route('deposithistroy') }}">Deposit History</a></li>
									<li class="nav-item"><a class="nav-link" href="{{ route('withdrawhistroy') }}">Withdraw History</a></li>
									
								</ul>
							</div>
							<div class="tab-content">
								<div id="deposit" class="tab-pane fade in show active">
									
									<div class="table-responsive sitescroll" data-simplebar>
										<table class="table sitetable table-responsive-stack" id="table">
											<thead>
												<tr>
												<th>S NO</th>
												<th>Date & Time</th>
												<th>Txn ID</th>
												<th>Assets</th>
												<th>Sender</th>
												<th>Receiver</th>
												<th>Amount</th>
												<th>Status</th>
												<th>Remark</th>
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
											<td>{{ $i }}</td>
											<td>{{ date('d-m-Y H:i:s', strtotime($histroy->created_at)) }}</td>
											<td>{{ $histroy->txid }}</td>
											<td>{{ $histroy->currency }}</td>
											<td>{{ $histroy->from_addr }}</td>
											<td>{{ $histroy->to_addr }}</td>
											<td>{{ display_format($histroy->amount) }}</td>
											<td>

												@if($histroy->from_addr  == 'admindeposit')
												Success
												@else
												@if($histroy->status == 0)
												Waiting for admin approval
												@elseif($histroy->status == 1)
												Pending
												@elseif($histroy->status == 2)
												Success
												@else
												Admin reject user request
												@endif
												@endif
											</td>
											<td>{{$histroy->remark}}</td>
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