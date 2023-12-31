@php $title = "Staking-history"; $atitle ="staking-history";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
			</section>
			<article class="gridparentbox stacking-history">
			<div class="stacking-back">
			<div class="container sitecontainer stacking">

  <section class="stacking-banner">

	
  <div class="container sitecontainer">
  <div class="innerpagecontent">
  <h4>Staking History</h4>
  <p>Simple & Secure. Search popular coins and start earning.</p>
  </div>

  <div class="stackingbannerright">
  <div class="stacking-card">
    <div toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></div>
    <div class="card">
      <div class="xchange-rate">
        <h4>Est. Total Value</h4>
        <h5><span>{{$stake_wallet}}</span> BTC</h5>
        <!-- <p>≈ $ 0.00</p> -->
        <a href="{{ url('staking-account') }}"><h3>Account</h3></a>
      </div>
      <div class="xchange-rate ryt">
        <h4>30-Day Profit</h4>
        <h5><span>{{ $lastmonthprofit }}</span> BTC</h5>
        <!-- <p>≈ $ 0.00</p> -->
        <a href="{{ url('/staking-history') }}">History</a>
      </div>
      </div>
    </div>
  </div>


</div>
</section>




	</div>
	</div>

				<div class="container sitecontainer">
					<div class="innerpagecontent staking-history-banner">
						<!-- <h2 class="h2">Staking History</h2>  -->
						<!-- <div class="left-buttons">
							<button class="view-staking common">View DeFi Staking</button>
							<button class="export common"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15" fill="none">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M8.02894 0.794434H5.79955V5.95917L5.57438 5.95694L2.48372 5.98667L6.9239 10.4276L11.3641 5.98741L8.26079 5.97998L8.02894 5.97849V0.794434ZM0.597656 8.96884H2.82704V11.9414H11.0014V8.96884H13.2308V14.1707H0.597656V8.96884Z" fill="#D2D2D2"/>
								</svg><div class="div-btn">Export</div></button>
						</div> -->
					</div>
					<div class="profilepaget">
						<div class="panelcontentbox">
							<div class="innerpagetab">
								<ul class="nav nav-tabs tabbanner" role="tablist">
									<li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#trade" data-bs-target="#trade">History</a></li>
									
								</ul>
							</div>
							<div class="tab-content">
								<div id="trade" class="tab-pane fade in show active">
									<div class="searchfrmbox">
										<form class="siteformbg" method="post" autocomplete="off">
											<!-- <div class="searchfrm row">
												<div class="col-xl-3 col-lg-4 col-md-4">
													<div class="form-group">
														<div class="input-group dateinput">
															<input class="form-control" name="start_date" placeholder="Start Date (YYYY-MM-DD)">
															<div class="input-group-append" data-toggle="datepicker3" data-target-name="start_date"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
														</div>
													</div>
												</div>
												<div class="col-xl-3 col-lg-4 col-md-4">
													<div class="form-group">
														<div class="input-group dateinput">
															<input class="form-control" name="end_date" placeholder="End Date (YYYY-MM-DD)">
															<div class="input-group-append" data-toggle="datepicker3" data-target-name="end_date"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
														</div>
													</div>
												</div>
												
												<div class="col-xl-3 col-lg-4 col-md-4">
													<div class="form-group">
														<select class="form-control" name="side">
															<option value="All">All Side</option>
															<option value="Buy">Buy</option>
															<option value="Sell">Sell</option>
														</select>
													</div>
												</div>
												<div class="col-xl-3 col-lg-4 col-md-4">
													<div class="form-group">
														<select class="form-control">
															<option value="">All Pair</option>
															<option value="">BTC/ECPAY</option>
														</select>
													</div>
												</div>
												<div class="col-xl-3 col-lg-4 col-md-4 clearbtn">
													<div class="form-group">
														<button type="button" class="btn sitebtn btn-sm">Search</button> <a href="" class="btn sitebtn btn-sm">Reset</a></div>
												</div>
											</div> -->
										</form>
									</div>
									<div class="table-responsive sitescroll" data-simplebar>
										<table class="table sitetable table-responsive-stack" id="table1">
											<thead>
											<tr>
													<th>Date & Time</th>
													<th>Deposit Coin</th>
													<th>Interest Type</th>
													<th>Interest Amount</th>
													<th>Period</th>
													<th>Amount Staked</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											@if(count($interest) >0)
												@foreach($interest as $value)
												<tr>
													<td>{{ date('d/m/Y H:i:s', strtotime($value->created_at)) }}</td>
													<td>{{ $value->coin }}</td>
													<td><span class="t-green">{{ $value->interest_type }}</span></td>
													<td>{{ $value->interest_amt }}</td>
													<td>{{ $value->period }}</td>
													<td>{{ $value->amount_staked }}</td>
													<td>---</td>
												</tr>
												@endforeach
												@else
												<tr id="norecord">
													<td>No record found!</td>
												</tr>
												@endif
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