@php $title = "Withdraw History"; $atitle ="history";
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
									<li class="nav-item"><a class="nav-link active" href="{{ route('withdrawhistroy') }}">Withdraw History</a></li>
								</ul>
							</div>
							<div class="tab-content">
								<div id="withdraw" class="tab-pane fade in show active">
									
									<div class="table-responsive sitescroll" data-simplebar>
										@if (session('success'))
                              <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ session('success') }}
                            </div>
                            @endif
                            @if (session('fail'))
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ session('fail') }}
                            </div>
                            @endif
										<table class="table sitetable table-responsive-stack" id="table">
											<thead>
												<tr>
													<th>S No</th>
													<th>Date & Time</th>
													<th>TXN ID</th>
													<th>Assets</th>
													<th>Sender</th>
													<th>Receiver</th>
													<!-- <th>@lang('common.withdraw type')</th> -->
													<th>Amount</th>
													<th>Admin Fee</th>
													<th>Description</th>
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
											@forelse($historys as $histroy)
											@php
												$url = $histroy->coindetails['url'];
												if($histroy->status == 0)
												{
													$status = "Pending";
												}
												elseif($histroy->status == 1)
												{
													$status = "Success";
												}
												elseif($histroy->status == 2)
												{
													$status = "Denied";
												}
												else
												{
													$status = "Pending";
												}
											@endphp
												<tr>
													<td>{{ $i }}</td>
												<td>{{ date('d/m/Y H:i:s', strtotime($histroy->created_at)) }}</td>
												<td>{{ $histroy->transaction_id }}</td>
												<td>{{ $histroy->coin_name }}</td>
												<td>{{ $histroy->sender }}</td>
												<td>{{ $histroy->reciever }}</td>
												<!--   <td>{{ $histroy->withdrawtype ? $histroy->withdrawtype : '-' }}</td> -->
												<td>{{ number_format($histroy->amount, 8, '.', '') }}</td>
												<td>{{ $histroy->admin_fee }}</td>
												<td>{{ $histroy->remark ? $histroy->remark :'-' }}</td>
												<td>
												{{ $status }}
												</td>
												<td><a href='{{ $url.$histroy->txid }}' target="_blank">View</a></td>
												</tr>
												@php $i++ ;@endphp
												@empty
												<tr><td colspan="10" class="text-center">No records found!</td></tr>
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