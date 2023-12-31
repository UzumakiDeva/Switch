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
									<li class="nav-item"><a class="nav-link" href="{{url('bank')}}" >Bank payment</a></li>
									<li class="nav-item"><a class="nav-link active" href="{{url('upi-list')}}" >UPI</a></li>									
							</ul>
								<a href="{{url('upi')}}" class="btn btn-primary">Add a New UPI </a>
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
                                                    <th>Alias</th>
													<th>UPI ID</th>
                                                    <th>QR Code</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
                                                @forelse($upi as $upis)
												<tr>
													<td>{{$upis->aliasupi}} </td>
													<td>{{$upis->upiid}}</td>
                                                    <td> <img src="{{$upis->qrcode}}" width="50px;" height="50px;" ></td>
													<td><a  href="{{url('/delete-upi/'.Crypt::encrypt($upis->id))}}" class="badge badge-danger">Remove</a></td>
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
