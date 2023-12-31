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
                         <!-- <h6 class="t-red">BETA</h6> -->
				      	</div>
					</div>
					<div class="col-md-6 col-sm-12 col-12">
						<h2 class="heading-title text-center">{{ __('Register') }}</h2>
					  <div class="login-form">
						<div class="loginformbox">
							<div class="formcontentbox">
							@if ($message = Session::get('error'))
						<div class="alert alert-danger alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button> 
							<strong>{{ $message }}</strong>
						</div>
						@endif


						@if ($message = Session::get('status'))
						<div class="alert alert-success alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button> 
							<strong><?php echo $message ;?></strong>
						</div>
						@endif
							<form method="POST" action="{{ route('register') }}">
                                @csrf
									<div class="form-group">										
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
									<div class="form-group">										
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
									<div class="form-group">										
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email ID" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
									<div class="form-group">										
										<div class="input-group">
                                            <input id="password" type="password" class="form-control input-psswd @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
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
                                        <div class="form-group">
                                            <label class="form-label">Referral ID <span>(Optional)</span></label>
                                            @if(isset($referral_code))                          
                                            <input id="referral_code" onchange="referralidcheck()" type="text" class="form-control @error('referralid') is-invalid @enderror" name="referralid" onkeypress="return AvoidSpace(event)"  readonly="readonly" value="{{ $referral_code }}" >
                                            <p style ="color:#17b3b5;font-weight: bold;" >{{ $name }}</p>
                                            @else
                                            <input id="referral_code" onchange="referralidcheck()" type="text" class="form-control @error('referralid') is-invalid @enderror" name="referralid" value="{{ old('referralid') }}" onkeypress="return AvoidSpace(event)" placeholder="" >
                                            @endif
                                            <p style ="color:red;font-weight: bold;" id="refrral_error"></p>
                                            <p style ="color:#17b3b5;font-weight: bold;" id="referral_name"></p>
                                            @if ($message = Session::get('error'))
                                            <p style ="color:red;" id="refrral_error">Invalid referral code!</p>
                                            @endif
                                            @error('referralid')
                                            <span class="invalid-feedback msg-txt" role="alert">
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
										<button type="submit" class="btn bluebtn ybtn mb-4">{{ __('Register') }}</button>
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
    <script src='https://www.google.com/recaptcha/api.js'></script>
<script>
$("body").addClass("loginbanner");
function referralidcheck()
{
    var rid = document.getElementById("referral_code").value;
    var url = "{{ url('/form_referral') }}";

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: url,
        data: 'referral_code='+rid,
        async:true, 
        cache:false, 
        success: function (data) {
            if (data.status == true) {
                $("#refrral_error").html('');
                $("#referral_name").html(data.res);
            }else{
                $("#referral_name").html('');
                $("#refrral_error").html(data.res);
            }
        }
    }); 
}
</script>