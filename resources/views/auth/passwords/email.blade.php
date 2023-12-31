@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
	<link rel="stylesheet" href="{{ url('css/home.css') }}">
	</section>
	<article class="gridparentbox">
		<div class="container sitecontainer">
			<div class="row formboxbg table-content">
				<div class="col-md-6 col-sm-12 col-12 text-center logo">
					<div class="loginlogo">
						<a href="{{url('/')}}">
						@if(Session::get('mode')=='nightmode')
						<img src="{{ url('landing/img/logo.png') }}" class="dark-logo">
						@else
						<img src="{{ url('landing/img/logo-dark.png') }}" class="light-logo">
						@endif
						</a>
				      	</div>
					</div>
					<div class="col-md-6 col-sm-12 col-12">
						<h2 class="heading-title text-center">{{ __('Reset Password') }}</h2>
						<div class="login-form">
							<div class="loginformbox">
								<div class="formcontentbox">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
									<form method="POST" action="{{ route('password.email') }}" id = "resetform">
                                        @csrf
										<div class="form-group">
											<label for="email">{{ __('E-Mail Address') }}</label>
											<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                         </div>
												</p>
												<div class="text-center">
												<div id="captcha" class="form-group g-recaptcha-whl g-recaptcha"> </div>
		                                            <span class="invalid-feedback" role="alert" id="geetesterror" style="display: none;font-size: 14px;" >
		                                            	
		                                            </span>
		                                            <button type="submit" class="btn bluebtn ybtn mb-4" id="submitbtn">{{ __('Send Password Reset Link') }}</button>
												</div>
												<p class="btngray pt-2">Back to Login? <a href="{{ route('login') }}" class="t-blue">Login now</a>
												</p>
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
            <script src='https://www.google.com/recaptcha/api.js'></script>
			<script src="https://static.geetest.com/v4/gt4.js" async defer></script>
<script>
$("body").addClass("loginbanner");
</script>

<script type="text/javascript">
	$(document).ready(function(){
		initGeetest4(
		{
			captchaId: "a5416d9c5b578b1c16d9233b7d9dd1ed",
			language : "en",
		},
		function (captcha) {
			$("#submitbtn").hide();
    // call appendTo to insert CAPTCHA into an element of the page, which can be customized by you
    captcha.appendTo("#captcha");

    captcha.onSuccess(function () {
    	var result = captcha.getValidate();
    	if (!result) {
    		$("#geetesterror").show();
    		$("#geetesterror").html('<strong>Please click to verify</strong>');
    		event.preventDefault();
    	} else{
    		$("#resetform").submit();
    	}
    });	
}
);
	})
</script>