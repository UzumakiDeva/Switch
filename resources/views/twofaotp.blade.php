@php $title = "Two fa verification"; $atitle ="twofa";
@endphp
@include('layouts.header')
	<div class="pagecontent gridpagecontent innerpagegrid">
		<link rel="stylesheet" href="{{ url('css/home.css') }}">
		@include('layouts.headermenu')
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">
					<div class="row formboxbg">
						<div class="col-md-5 col-sm-12 col-12 mx-auto">
							<h2 class="heading-title text-center">{{$data['heading']}}</h2>
							<p class="notesh5 t-gray text-center">Send 2FA code via {{$data['type']}}.</p>
							<div class="login-form">
								<div class="loginformbox">
									@if (session('twofafail'))
				                      <div class="alert alert-danger success-alert alert-dismissible">				                        
				                        {{ session('twofafail') }}
				                      </div>
				                      @endif
									<div class="formcontentbox">
										<form class="siteformbg" action="{{ route('verifyotp') }}" method="POST">
											@csrf
											@if($data['type'] == 'Email')
											<p>Click to <a href="{{ route('resendotp') }}">resend E-mail OTP </a></p>
											@endif
											<div class="form-group">
												<label class="">Enter your Code</label>
												<input type="text" name="OTP" class="form-control form-control-lg" value="" /> 
												@if ($errors->has('OTP'))
											    <span class="help-block">
											      <strong class="text text-danger">{{ $errors->first('OTP') }}</strong>
											    </span>
											     @endif
											</div>
											<div class="form-group text-center">
												<input type="submit" name="" class="btn sitebtn" value="Submit" /> </div>
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