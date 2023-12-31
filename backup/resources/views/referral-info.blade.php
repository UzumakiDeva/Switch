@php $title = "Referral Info"; $atitle ="history";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
	@include('layouts.headermenu')
</section>
<article class="gridparentbox">
	<div class="container sitecontainer">
		<div class="innerpagecontent">
			<h2 class="h2">Referral Information</h2> </div>
			<div class="profilepaget">
				<div class="panelcontentbox">
					<div class="tab-content">
						<div id="trade" class="tab-pane fade in show active">
							<div class="table-responsive sitescroll" data-simplebar>
								<table class="table sitetable table-responsive-stack" id="table1">
									<thead>
										<tr>
											<th>S.No</th>
											<th>User Name</th>
											<th>Email</th>
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
										@forelse($users as $user)
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $user->first_name }} {{ $user->last_name }}</td>
											<td>{{ $user->email }}</td>
											<td>
												@if($user->kyc_verify == 1)
												<span class="badge badge-success">Verified</span>
												@else
												<span class="badge badge-danger">Unverified</span>
												@endif
											</td>
										</tr>
										@php $i++ ;@endphp
										@empty
										<tr><td colspan="10" style="flex-basis: 9.09091%;"> No referral users found!</td></tr>
										@endforelse
									</tbody>

								</table>
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