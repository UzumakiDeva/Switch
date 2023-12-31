@php $title = "Email conformation"; $atitle ="email";
@endphp
@include('layouts.header')
	<div class="pagecontent gridpagecontent innerpagegrid">
		<link rel="stylesheet" href="{{ url('css/home.css') }}">
		<style type="text/css">
			i.fa.fa-check-circle.tick-green {
			    font-size: 50px;
			    color: #018e9d;
			}
		</style>
		
			</section>
			<article class="gridparentbox">
			@include('layouts.headermenu')
				<div class="container sitecontainer">
					<div class="row formboxbg">
						<div class="col-md-5 col-sm-12 col-12 mx-auto">
							<h2 class="heading-title text-center">
								<a href="{{url('/')}}">
								@if(Session::get('mode')=='nightmode')
								<img src="{{ url('landing/img/logo-dark.png') }}" class="dark-logo"  style="height:100px">
								@else
								<img src="{{ url('landing/img/logo.png') }}" class="light-logo"  style="height:100px">
								@endif
								</a>
							</h2>
							
							<div class="login-form">
								<div class="loginformbox">
									<div class="formcontentbox">
										<form class="siteformbg">
											<h2 class="heading-title text-center">@lang('common.Success')!</h2>
											<div class="form-group">
												<p class="text-center text-success"><i class="fa fa-check-circle tick-green" aria-hidden="true"></i></p>
												<p class="notesh5 t-gray text-center">@lang('common.Successtxt')</p>
												@php
							$successemail = \Session::get('successemail');
						@endphp </div>
						<div class="mt-20 btnsnfg text-center"><a class="btn yellow-btn btn-block btn-lg" href="{{ url('reconfirm_account/'.$successemail)  }}">@lang('common.successemail')</a></div>
						<br/>
											<div class="form-group text-center">
												<a href="{{ url('/login') }}" class="btn sitebtn text-uppercase m-btn">@lang('common.Next')</a> </div>
										</form>
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
		<script>
		$("body").addClass("loginbanner");
		</script>