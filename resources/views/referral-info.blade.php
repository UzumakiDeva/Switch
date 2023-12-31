@php $title = "Referral Info"; $atitle ="history";
@endphp
@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">
					<div class="panelcontentbox">
						<h2 class="heading-box">Referral Information</h2>
						<div class="contentpanel">
							<!-- <hr> -->
							<form class="siteformbg" >
								<div class="profiledatainfo">
									<div class="row">															
										<div class="col-md-6">
											<div class="form-group">
												<label>Refer URL<span class="t-red">*</span></label>
												<div class="copy-text">
												<input  name="refferral-url" class="form-control" id="urladdress" type="text" value="{{ $url = url('res/'.Auth::user()->referral_id) }}" readonly>
												<span onclick="myCopyFunc()"><i class="fa fa-clone" id="myTooltip"></i></span>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Refer ID <span class="t-red">*</span></label>
												<input  name="referral_id" class="form-control" type="text" value="{{Auth::user()->referral_id}}" disabled>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>My Role <span class="t-red">*</span></label>
												<input  name="referral_id" class="form-control" type="text" value="{{ isset($info['role']) ? $info['role'] :\Auth::user()->role }}" disabled>
											</div>
										</div>
									</div>
									<div class="row">															
										<div class="col-md-3">
											<div class="form-group">
												<label>My OverAll Stake</label>
												<input class="form-control" id="urladdress" type="text" value="{{ isset($info['overallstake']) ? $info['overallstake'] :0 }}" readonly>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>My Bussiness </label>
												<input class="form-control" type="text" value="{{ isset($info['bussiness']) ? $info['bussiness'] : 0 }}" disabled>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Strong Leg </label>
												<input class="form-control" type="text" value="{{ isset($info['strongleg']) ? $info['strongleg'] : 0 }}" disabled>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Other Leg </label>
												<input class="form-control" type="text" value="{{ isset($info['otherleg']) ? $info['otherleg'] : 0 }}" disabled>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="innerpagecontent">
						<h2 class="h2">Level INFORMATION</h2> </div>
					<div class="profilepaget">
						<div class="panelcontentbox">
							<div class="innerpagetab">
								<ul class="nav nav-tabs tabbanner" role="tablist">
									@foreach ($users as $key => $value)
									<li class="nav-item"><a class="nav-link @if($key == 'Gen1') active @endif" data-bs-toggle="tab" href="#trade" data-bs-target="#{{ $key }}">{{ $key }}</a></li>
									@endforeach
									
								</ul>
							</div>
							<div class="tab-content">
								@foreach ($users as $key => $childs)
								<div id="{{$key}}" class="tab-pane fade in @if($key == 'Gen1') show active @endif">						
									<div class="table-responsive sitescroll" data-simplebar>
										<table class="table sitetable table-responsive-stack">
											<thead>
												<tr>
													<th>S.NO</th>
													<th>Name</th>
													<th>E-Mail</th>
													<th>Over All Stake</th>
													<th>Business</th>
													<th>Total</th>
													<th>Role</th>
													<th>Parent Info</th>
												</tr>
											</thead>
											<tbody>
												@php $i=1; @endphp
												@if(count($childs) > 0)
												@foreach($childs as $childinfo)
												<tr>
													<td>{{$i}}</td>
													<td>{{ $childinfo->name }} @if($info->stronguid == $childinfo->uid)(<span class="t-green">Strong</span>)@endif</td>
													<td>{{ $childinfo->email }}</td>													
													<td>{{ $childinfo->overallstake }}</td>
													<td>{{ $childinfo->bussiness }}</td>
													<td>{{ $childinfo->total_bussiness }}</td>
													<td>
														@if($childinfo->role != "")
															@if($childinfo->role == 'Excutive Manager')
															<span class="badge badge-success">{{ $childinfo->role }}</span>
															@elseif($childinfo->role == 'Senior Manager')
															<span class="badge badge-info">{{ $childinfo->role }}</span>
															@elseif($childinfo->role == 'Club Manager')
															<span class="badge badge-warning">{{ $childinfo->role }}</span>
															@elseif($childinfo->role == 'Cheif Manager')
															<span class="badge badge-danger">{{ $childinfo->role }}</span>@elseif($childinfo->role == 'Personal')
															<span class="badge badge-default">{{ $childinfo->role }}</span>
															@else
															<span class="badge badge-danger">{{ $childinfo->role }}</span>
															@endif
														@else
														 - 
														@endif
													</td>
													<td>@if(isset($childinfo->parent['name'])) {{ $childinfo->parent['name'] }} @endif</td>
												</tr>
												@php $i++; @endphp
												@endforeach
												@endif
											</tbody>
										</table>
									</div>
								</div>
								@endforeach

							</div>
						</div>
					</div>
				</div>
			</article>
			@include('layouts.footermenu')
</div>
@include('layouts.footer')
<script type="text/javascript">
	function myCopyFunc() {
      var copyText = document.getElementById("urladdress");
      copyText.select();
      document.execCommand("Copy");
      var tooltip = document.getElementById("myTooltip");
      tooltip.innerHTML = "<strong class='text-info'>Copied!</strong>";
   }
</script>