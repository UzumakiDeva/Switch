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
						<h2 class="heading-title text-center">{{ __('Reset Password') }}</h2>
					  <div class="login-form">
						<div class="loginformbox">
							<div class="formcontentbox">
							<form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
									
									<div class="form-group">										
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="E-mail ID" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
									<div class="form-group">										
										<div class="input-group">
                                            <input id="password" type="password" class="form-control space_not input-psswd @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                                            <span class="input-group-text button-psswd passtext"><i class="fa fa-eye"></i></span> 
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
									</div>
									<div class="form-group">
									
										<div class="input-group">
                                            <input id="password-confirm" type="password" class="form-control space_not input-psswd1" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
											<span class="input-group-text button-psswd1 passtext"><i class="fa fa-eye"></i></span> 
                                        </div>
									</div>
									<div class="text-center">
										{!! app('captcha')->display() !!}
											@if ($errors->has('g-recaptcha-response'))
											<span class="help-block">
											<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
											</span>
											@endif
										<button type="submit" class="btn bluebtn ybtn mb-4">{{ __('Reset Password') }}</button>
									</div>
									<span class="noteshow">Your password must contain at least 8 characters, one uppercase (ex: A, B, C, etc), one lowercase letter, one numeric digit (ex: 1, 2, 3, etc) and one special character (ex: @, #, $, etc)</span>
									<p class="btngray pt-4">Already have an account? <a href="{{ route('login') }}" class="t-blue">Sign in</a></p>
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