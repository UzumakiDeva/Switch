@php $title = "Payment option"; $atitle ="payment option";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">
					<div class="innerpagecontent">
						<h2 class="h2">Payment option</h2> </div>
					<div class="profilepaget">
						<div class="panelcontentbox">
							<div class="innerpagetab">
								<ul class="nav nav-tabs tabbanner" role="tablist">
									<li class="nav-item"><a class="nav-link active" href="{{url('bank')}}" >Bank payment</a></li>
									<li class="nav-item"><a class="nav-link" href="{{url('upi-list')}}" >UPI</a></li>									
								</ul>
								<a  href="{{url('/bank-add')}}" class="btn btn-primary">Add a New Account</a>
							</div>
							<div class="tab-content">
							 @if(Session::has('success'))
                            <div class="alert alert-success">
                             {{ Session::get('success') }}
                           </div>
                            @endif
							@if(Session::has('error'))
                            <div class="alert alert-danger">
                             {{ Session::get('error') }}
                           </div>
                            @endif
								<div id="trade" class="tab-pane fade in show active">
									<div class="table-responsive sitescroll" data-simplebar>
										<table class="table sitetable table-responsive-stack" id="table1">
											<thead>
												<tr>
													<th>Bank Name</th>
													<th>Account Number</th>
													<th>Account Type</th>
													<th>IFSC code</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
                                                @forelse($bank_details as $bank_detail)
												<tr>
													<td>{{$bank_detail->bank_name}} </td>
													<td>{{$bank_detail->account_no}}</td>
													<td>{{$bank_detail->accounttype}}</td>
													<td>{{($bank_detail->swift_code)}}</td>
													<td><a  href="{{url('/delete-bank/'.Crypt::encrypt($bank_detail->id))}}" class="badge badge-danger">Remove</a></td>
												</tr>
                                                @empty
                                                <tr>
													<td colspan="10" class="text-center">No Record Found!</td>
												</tr>
                                                @endforelse											
											</tbody>
										</table>
									</div>
								</div>
								<div id="deposit" class="tab-pane fade in">
								</div>							
							</div>
						</div>
					</div>
				</div>
			</article>
			@include('layouts.footermenu')
</div>
@include('layouts.footer')
