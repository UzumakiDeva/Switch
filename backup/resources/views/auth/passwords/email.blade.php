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
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
									<form method="POST" action="{{ route('password.email') }}">
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
													<div class="form-group g-recaptcha-whl">
		                                                {!! app('captcha')->display() !!}
@if ($errors->has('g-recaptcha-response'))
<span class="help-block">
<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
</span>
@endif
		                                            </div>
													<button type="submit" class="btn bluebtn ybtn mb-4">{{ __('Send Password Reset Link') }}</button>
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
<script>
$("body").addClass("loginbanner");
</script>