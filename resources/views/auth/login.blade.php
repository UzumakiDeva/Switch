@include('layouts.header')
<div class="pagecontent gridpagecontent innerpagegrid">
    <link rel="stylesheet" href="{{ url('css/home.css') }}">
    </section>
    <article class="gridparentbox">
        <div class="container sitecontainer">
            <div class="row formboxbg table-content">
                <div class="col-md-6 col-sm-12 col-12 ">
                    <div class="loginlogo text-center">
                        <a href="{{ url('/') }}">
                            @if (Session::get('mode') == 'nightmode')
                                <img src="{{ url('landing/img/logo.png') }}" class="dark-logo">
                            @else
                                <img src="{{ url('landing/img/logo-dark.png') }}" class="light-logo">
                            @endif
                        </a>

                        <!-- <h6 class="t-red"></h6> -->
                    </div>

                </div>
                <div class="col-md-6 col-sm-12 col-12">
                    <h2 class="heading-title text-center">Sign In</h2>

                    <div class="login-form">
                        <div class="loginformbox">
                            <div class="formcontentbox">
                                @if ($message = Session::get('error'))
                                    <div class="alert alert-danger alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{!! $message !!}</strong>
                                    </div>
                                @endif

                                @if ($message = Session::get('status'))
                                    <div class="alert alert-success alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{!! $message !!}</strong>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}" id = "signinform">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">{{ __('E-Mail Address') }}</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">{{ __('Password') }}</label>
                                        <div class="input-group">
                                            <input id="password" type="password"
                                                class="form-control space_not input-psswd @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password">
                                            <span class="input-group-text button-psswd passtext"><i
                                                    class="fa fa-eye"></i></span>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="btngray text-end">
                                        @if (Route::has('password.request'))
                                            <a class="t-blue" href="{{ route('password.request') }}">
                                                {{ __('Reset Your Password?') }}
                                            </a>
                                        @endif
                                    </p>
                                    <div class="text-center">
                                        <!-- <div class="form-group g-recaptcha-whl">
  {!! app('captcha')->display() !!}
              @if ($errors->has('g-recaptcha-response'))
<span class="help-block">
              <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
              </span>
@endif
  </div> -->

                                        <div id="captcha" class="form-group g-recaptcha-whl g-recaptcha"> </div>
                                        <span class="invalid-feedback" role="alert" id="geetesterror"
                                            style="display: none;font-size: 14px;">

                                        </span>

                                        <button type="submit" class="btn bluebtn ybtn mb-4"
                                            id="submitbtn">{{ __('Login') }}</button>
                                    </div>
                                    <p class="btngray pt-2">Don't have an account? <a href="{{ route('register') }}"
                                            class="t-blue">Register now</a>
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
<!-- <script src='https://www.google.com/recaptcha/api.js'></script> -->
<script src="https://static.geetest.com/v4/gt4.js" async defer></script>
<script>
    $("body").addClass("loginbanner");
</script>


<script type="text/javascript">
    $(document).ready(function() {
        initGeetest4({
                captchaId: "a5416d9c5b578b1c16d9233b7d9dd1ed",
                language: "en",
            },
            function(captcha) {
                $("#submitbtn").hide();
                // call appendTo to insert CAPTCHA into an element of the page, which can be customized by you
                captcha.appendTo("#captcha");

                captcha.onSuccess(function() {
                    var result = captcha.getValidate();
                    if (!result) {
                        $("#geetesterror").show();
                        $("#geetesterror").html('<strong>Please click to verify</strong>');
                        event.preventDefault();
                    } else {
                        $("#signinform").submit();
                    }
                });
            }
        );
    })
</script>
