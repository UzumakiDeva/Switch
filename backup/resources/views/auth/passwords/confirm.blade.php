@include('layouts.header')
	<div class="pagecontent gridpagecontent innerpagegrid">
    <link rel="stylesheet" href="{{ url('css/home.css') }}">
			</section>
			<article class="gridparentbox">
				<div class="container sitecontainer">
				<div class="row formboxbg table-content">
				     <div class="col-md-6 col-sm-12 col-12 text-center">
				     	<div class="loginlogo">
							 <a href="{{url('/')}}">
							@if(Session::get('mode')=='nightmode')
							<img src="{{ url('landing/img/logo-dark.png') }}" class="dark-logo">
							@else
							<img src="{{ url('landing/img/logo.png') }}" class="light-logo">
							@endif
							</a>
				      	</div>
					</div>
					<div class="col-md-6 col-sm-12 col-12">
						<h2 class="heading-title text-center">{{ __('Confirm Password') }}</h2>
					  <div class="login-form">
						<div class="loginformbox">
							<div class="formcontentbox">
                            {{ __('Please confirm your password before continuing.') }}
							<form method="POST" action="{{ route('password.confirm') }}">
                                @csrf
									<div class="form-group">										
										<div class="input-group">
                                            <input id="password" type="password" class="form-control space_not input-psswd @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                                            <span class="input-group-text button-psswd passtext"><i class="fa fa-eye"></i></span> 
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
									</div>
									<div class="text-center">
										<div class="form-group g-recaptcha-whl">
                                            {!! app('captcha')->display() !!}
											@if ($errors->has('g-recaptcha-response'))
											<span class="help-block">
											<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
											</span>
											@endif
                                            </div>
										<button type="submit" class="btn bluebtn ybtn mb-4">{{ __('Confirm Password') }}</button>
									</div>
									@if (Route::has('password.request'))
                                    <a class="t-blue" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
									
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
<script>
$("body").addClass("loginbanner");
</script>