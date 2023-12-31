@php $title = "Withdraw Conformation"; @endphp
@include('layouts.header')
	<div class="pagecontent gridpagecontent innerpagegrid">
		<link rel="stylesheet" href="{{ url('css/home.css') }}">
		@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">
					<div class="row formboxbg">
						<div class="col-md-5 col-sm-12 col-12 mx-auto">
							<h2 class="heading-title text-center"><img src="{{ url('images/switch-exchange-logo-dark.svg') }}" alt="" style="height:100px"></h2>
							<h2 class="heading-title text-center">@lang('common.2FA OTP') Withdraw Conform</h2>
							
							<div class="login-form">
								<div class="loginformbox">
								@if (session('faild'))
								<div class="alert alert-danger">
									{{ session('faild') }}
								</div>
								@endif
								@if (session('success'))
								<div class="alert alert-success">
									{{ session('success') }}
								</div>
								@endif
									<div class="formcontentbox">
							<form class="siteformbg"  method="post" action="{{ url('/validateotp') }}">
								{{ csrf_field() }}															

								<div class="form-group cpybtnbg">
									<label >@lang('common.EnterCode')</label>
										<input id="otp" type="number"  class="form-control" name="otp" value="{{ old('otp') }}" required autofocus>
									@if ($errors->has('otp'))
									<span class="help-block">
										<strong>{{ $errors->first('otp') }}</strong>
									</span>
									@endif
								</div>
							
							<div class="col-md-12 text-center">
							<button type="submit" class="blue-btn" >@lang('common.Submit')</button>
							</div>
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