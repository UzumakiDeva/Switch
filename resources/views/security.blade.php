<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Switch') }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="{{ url('landing/css/custom.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('landing/css/index.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('landing/css/responsive.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('landing/css/common.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('landing/css/security.css') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ url('favicon/favicon-32x32.png') }}">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ url('landing/css/owl.theme.default.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('landing/css/owl.carousel.min.css') }}">
  <script src="https://kit.fontawesome.com/0b29785f9e.js" crossorigin="anonymous"></script>
  <style type="text/css">
    .t-red {
        color: #f00;
        font-weight: 700;
    }
    .t-green {
        color: #157654;
        font-weight: 700;
    }
  </style>
</head>
@if(Session::get('mode') == 'nightmode')
	<body class="dark">
@else
<body class="light">
@endif



  <section class="header-banner-block">

  <div class="header">
    <div class="contain-width">
      <div class="row">

        <div class="col-xl-2 col-lg-2 col-md-12 col-md-12">
          <div class="logo">
            <a href="{{url('/')}}">
                @if(Session::get('mode')=='nightmode')
                <img src="{{ url('landing/img/logo-dark.png') }}" class="dark-logo">
                    @else
                    <img src="{{ url('landing/img/logo.png') }}" class="light-logo">
                        @endif
            </a>
          </div>
        </div>



        <div class="col-xl-10 col-lg-10 col-md-12 col-md-12">

  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="main-menu-close"><a href="#"><i class="fa-solid fa-xmark"></i></a></li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('wallet') }}">Buy Crypto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('market') }}">Markets</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('trade') }}">Trade</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Derivatives</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Earn</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('support') }}">Bonus</a>
        </li>

      </ul>



      @guest
				<ul class="navbar-nav info-menu right-links list-inline list-unstyled">
					<li class="nav-item"><a class="nav-link menu-last btn sitebtn me-2" href="{{route('login')}}">Login</a></li>
					<li class="nav-item last-menu"><a class="nav-item last-menu btn sitebtn" href="{{route('register')}}"><span>Sign Up</span></a></li>
				</ul>
				@else
				<ul class="navbar-nav">
					<li class="dropdown usermenu"> <a href="#" class="nav-link dropdown-bs-toggle" data-bs-toggle="dropdown">{{ Auth::user()->first_name .' '.Auth::user()->last_name}}
						@if(Auth::user()->profileimg)
									<span class="photopic"><img src="{{ url('storage/userprofile') }}/{{Auth::user()->profileimg}}"  alt="user-image" class="img-circle img-inline"></span></a>
									@else
									<span class="photopic"><img src="{{ url('images/profile.svg') }}" class="img-fluid"></span></a>
									@endif
						<div class="dropdown-menu"> 

						 <a class="nav-link dropdown-item" href="{{ route('myprofile') }}"><i class="fa fa-user"></i>My Account</a>
						    <a class="nav-link dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>Logout</a> <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form></div>
					</li>
				</ul>
				@endguest

        

					<ul class="icon-sun">
				@if(Session::get('mode')=='nightmode')
              <li><a href="{{ url('/setmode/daymode') }}"><i class="fa fa-sun-o modeicon" id="showf"  aria-hidden="true"></i></a></li>              
        @else
          <li><a href="{{ url('/setmode/nightmode') }}"><i class="fa fa-moon-o modeicon" id="hidef" aria-hidden="true"></i></a></li>
        @endif
		</ul>
        
    </div>
</nav>
          
        </div>

        <!-- <div class="col-xl-3 col-lg-3 col-md-12 col-md-12 head-sun-moon">
          <div class="settings-icon"><i class="fa-solid fa-ellipsis-vertical"></i></div>


          
        </div> -->
        
      </div>
    </div>
  </div>


  <!-- <div class="banner-right-icon">
    <ul class="banner-icons">
      <li><a href="#"><img src="{{ url('landing/img/ban-icon-1.png') }}"></a></li>
      <li><a href="#"><img src="{{ url('landing/img/ban-icon-2.png') }}"></a></li>
      <li><a href="#"><img src="{{ url('landing/img/ban-icon-3.png') }}"></a></li>
      <li><a href="#"><img src="{{ url('landing/img/ban-icon-4.png') }}"></a></li>
      <li><a href="#"><img src="{{ url('landing/img/ban-icon-5.png') }}"></a></li>
    </ul>
  </div> -->


</section>
<!-- Banner-End -->

<section class="secure-rules">
      <div class="page-header">
        <h1>SECURITY POLICY</h1>
      </div>
      <div class="contain-width">
        <div class="terms">
          <div class="sub-terms">
            <div>
              <h5>
                <span class="numeric use">1.</span>
                <span class="align-self-center">Privacy policy</span>
              </h5>
            </div>
            <div class="para">
              <span>1.1</span>
              <p>
                Security of assets and user data stored on the website is our
                first priority.
              </p>
            </div>
            <div class="para">
              <span>1.2</span>
              <p>
                To increase security, the service constantly adds new levels of
                protection, improves audit processes and reduces the “attack
                surface” in its infrastructure. Within the frame of the
                intellectual property security and protection, we cannot
                disclose all the information about the protective measures used
                on our platform.
              </p>
            </div>
          </div>

          <div class="sub-terms">
            <div>
              <h5>
                <span class="numeric use">2.</span>
                <span class="align-self-center">User account protection</span>
              </h5>
            </div>
            <div class="para">
              <span>2.1</span>
              <p>
                Not all of the security measures described below are activated
                in the default mode, but you can activate them by yourself in
                the / security section, depending on the required level of
                security. There you can check the security status of your
                account and see recommendations for its protection.
              </p>
            </div>
          </div>

          <div class="sub-terms">
            <div>
              <h5>
                <span class="numeric use">3.</span>
                <span class="align-self-center">Two-factor authentication (2FA)</span>
              </h5>
            </div>
            <div class="para">
              <span>3.1</span>
              <p>
                This level of security is used to secure the most important
                operations conducted in your account, such as authorization,
                creating API keys and withdrawal of funds. You can control
                two-factor authentication using Google Authenticator, Twilio, or
                U2F security key.
              </p>
            </div>
          </div>

          <div class="sub-terms">
            <div>
              <h5>
                <span class="numeric use">4.</span>
                <span class="align-self-center">Advanced verification tools for control of account integrity</span>
              </h5>
            </div>
            <div class="para">
              <span>4.1</span>
              <p>
                All authorization data is stored and verified for suspicious
                activity.
              </p>
            </div>
            <div class="para">
              <span>4.2</span>
              <p>
                The intelligent system tracks IP address changes to avoid
                hacking during a working session.
              </p>
            </div>
            <div class="para">
              <span>4.3</span>
              <p>
                Notifications with authorization reports and a link to a quick
                account freeze in case of suspicious activity are received at
                the specified e-mail inbox.
              </p>
            </div>
          </div>

          <div class="sub-terms">
            <div>
              <h5>
                <span class="numeric use">5.</span>
                <span class="align-self-center">Withdrawal protection</span>
              </h5>
            </div>
            <div class="para">
              <span>5.1</span>
              <p>
                The security system automatically tracks withdrawal operations
                using IP address and other patterns of user actions, and
                initiates a manual check of administrator in case it detects
                suspicious withdrawals.
              </p>
            </div>
            <div class="para">
              <span>5.2</span>
              <p>
                Confirmation procedure of funds withdrawal is resistant to
                malicious modules in the browser.
              </p>
            </div>
            <div class="para">
              <span>5.3</span>
              <p>
                Adding addresses to the white list of addresses will prevent the
                withdrawal of funds to third-party resources.
              </p>
            </div>
          </div>

          <div class="sub-terms">
            <div>
              <h5>
                <span class="numeric use">6.</span>
                <span class="align-self-center">Cryptocurrency repository</span>
              </h5>
            </div>
            <div class="para">
              <span>6.1</span>
              <p>
                Majority of digital assets in the system are stored in
                stand-alone “cold” wallets. Only about 0.5% of the cryptoactives
                are in “hot” wallets for use in everyday operations. To ensure a
                high level of security, you cannot get an access to the “cold”
                wallets from the platform itself and its servers. The right to
                manual access to the funds in the autonomous “cold” wallets is
                only granted to a few chief administrators.
              </p>
            </div>
          </div>

          <div class="sub-terms">
            <div>
              <h5>
                <span class="numeric use">7.</span>
                <span class="align-self-center">System security</span>
              </h5>
            </div>
            <div class="para">
              <span>7.1</span>
              <p>To host the platform, we use the latest Linux systems.</p>
            </div>
            <div class="para">
              <span>7.2</span>
              <p>
                We use the best computer security practices and protect our
                servers with the latest software.
              </p>
            </div>
            <div class="para">
              <span>7.3</span>
              <p>The database is automatically backed up once a day.</p>
            </div>
            <div class="para">
              <span>7.4</span>
              <p>
                Once a day, a backup copy of the trading platform database is
                created, after that it is encrypted and archived.
              </p>
            </div>
          </div>

          <div class="sub-terms">
            <div>
              <h5>
                <span class="numeric use">8.</span>
                <span class="align-self-center">System security</span>
              </h5>
            </div>
            <div class="para">
              <span>8.1</span>
              <p>
                The created backup copy (database, log files, etc.) is
                immediately sent to several remote from each other physical
                servers.
              </p>
            </div>
          </div>

          <div class="sub-terms">
            <div>
              <h5>
                <span class="numeric use">9.</span>
                <span class="align-self-center">DDoS-attacks protection</span>
              </h5>
            </div>
            <div class="para">
              <span>9.1</span>
              <p>
                We use automatic protection against service denial kinds of
                distributed attacks, so that external attacks cannot affect the
                course of trading.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>



    <section class="footer">

<div class="contain-width">

    <div class="row">

        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-50">

            <div class="footer-widget">

                <div class="footer-logo">

                    <!-- <h6>Dappfort</h6> -->

                    <div class="logo-part">
                    <a href="{{url('/')}}">
                         @if(Session::get('mode')=='nightmode')
                         <img src="{{ url('landing/img/logo-dark.png') }}" class="dark-logo">
                             @else
                             <img src="{{ url('landing/img/logo.png') }}" class="light-logo">
                                 @endif
                     </a>
                        </div>

                        <div class="social-logo-part">
                            <ul>
                                <li>
                                    <a href="https://www.reddit.com/user/switchEx007" target="_blank" class="icon-web">
                                        <svg
                                            width="29"
                                            height="29"
                                            viewbox="0 0 22 22"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.8186 12.4812C8.8186 13.1694 9.32332 13.731 9.94217 13.731C10.567 13.731 11.0657 13.1692 11.0657 12.4812C11.0783 11.793 10.5666 11.2314 9.94217 11.2314C9.31103 11.2314 8.8186 11.7932 8.8186 12.4812Z"
                                                fill="#222222"/>
                                            <path
                                                d="M12.9657 12.4812C12.9657 13.1694 13.4717 13.731 14.0898 13.731C14.7209 13.731 15.2134 13.1692 15.2134 12.4812C15.226 11.793 14.7142 11.2314 14.0898 11.2314C13.4588 11.2314 12.9657 11.7932 12.9657 12.4812Z"
                                                fill="#222222"/>
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM13.7742 7.27979C14.6769 7.43114 15.5417 7.70285 16.3559 8.07514H16.3582C17.7718 10.1392 18.4738 12.4746 18.2021 15.1636C17.122 15.9526 16.0679 16.4322 15.039 16.7479C14.7862 16.4071 14.5592 16.0408 14.3636 15.6559C14.736 15.5169 15.0901 15.3465 15.4302 15.1446C15.3634 15.0969 15.2993 15.0455 15.2338 14.9929C15.2131 14.9763 15.1923 14.9595 15.1711 14.9428C13.1385 15.8833 10.9098 15.8833 8.852 14.9428C8.76888 15.0119 8.68087 15.0818 8.59287 15.1446C8.93365 15.3465 9.28729 15.5169 9.65958 15.6559C9.464 16.0409 9.237 16.4071 8.98415 16.7479C7.95467 16.4323 6.90681 15.9526 5.82103 15.1636C5.60017 12.8407 6.04203 10.4864 7.67688 8.07514C8.48544 7.70236 9.35015 7.43135 10.2591 7.27979C10.3652 7.47536 10.4987 7.74078 10.5867 7.94893C11.5334 7.80993 12.4867 7.80993 13.4466 7.94893C13.5347 7.74078 13.6604 7.47536 13.7742 7.27979Z"
                                                fill="#222222"/>
                                        </svg>
                                    </i>
                                </a>
                            </li>
                            <li>
                                <a href="https://t.me/switchexchange" target="_blank" class="icon-web">
                                    <svg
                                        width="29"
                                        height="29"
                                        viewbox="0 0 22 22"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 2C6.47761 2 2 6.47761 2 11.9893C2 17.5117 6.47761 22 12 22C17.5224 22 22 17.5117 22 11.9893C22 6.47761 17.5224 2 12 2ZM16.9254 8.27932C16.8614 9.20682 15.145 16.1365 15.145 16.1365C15.145 16.1365 15.0384 16.5416 14.6652 16.5522C14.5373 16.5522 14.3667 16.5416 14.1748 16.3603C13.7804 16.0299 12.8849 15.3902 12.0426 14.8038C12.0107 14.8358 11.9787 14.8678 11.936 14.8998C11.7441 15.0704 11.4563 15.3156 11.1471 15.6141C11.0299 15.7207 10.9019 15.838 10.774 15.9659L10.7633 15.9765C10.6887 16.0512 10.6247 16.1045 10.5714 16.1471C10.1557 16.4883 10.113 16.2004 10.113 16.0512L10.3369 13.6098V13.5885L10.3475 13.5672C10.3582 13.5352 10.3795 13.5245 10.3795 13.5245C10.3795 13.5245 14.7399 9.64392 14.8571 9.22815C14.8678 9.20682 14.8358 9.1855 14.7825 9.20682C14.4947 9.30277 9.47335 12.4797 8.91898 12.8316C8.88699 12.8529 8.79104 12.8422 8.79104 12.8422L6.34968 12.0426C6.34968 12.0426 6.06183 11.9254 6.15778 11.6588C6.1791 11.6055 6.21109 11.5522 6.32836 11.4776C6.87207 11.0938 16.3284 7.69296 16.3284 7.69296C16.3284 7.69296 16.5949 7.60768 16.7548 7.66098C16.8294 7.69296 16.8721 7.72495 16.9147 7.83156C16.9254 7.8742 16.936 7.95949 16.936 8.05544C16.936 8.10874 16.9254 8.17271 16.9254 8.27932Z"
                                            fill="#222222"/>
                                    </svg>
                                </i>
                            </a>
                            </li>
                            <li>
                            <a href="#" target="_blank" class="icon-web">
                                <svg
                                    width="29"
                                    height="29"
                                    viewbox="0 0 22 22"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M15.5168 3C15.8138 5.55428 17.2395 7.07713 19.7181 7.23914V10.112C18.2817 10.2524 17.0234 9.78262 15.56 8.89699V14.2702C15.56 21.096 8.11856 23.2291 5.12686 18.3365C3.2044 15.1882 4.38164 9.66382 10.5486 9.44241V12.4719C10.0788 12.5475 9.5766 12.6663 9.11759 12.8229C7.74594 13.2873 6.96832 14.1568 7.18433 15.6904C7.60014 18.6281 12.9895 19.4975 12.5413 13.7571V3.0054H15.5168V3Z"
                                        fill="#222222"/>
                                </svg>

                            </a>
                            </i>
                            </li>
                            <li>
                         <a href="#" target="_blank" class="icon-web">
                            <svg
                                width="29"
                                height="29"
                                viewbox="0 0 22 22"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22 12.0698C22 17.0832 18.3413 21.2485 13.5627 22.0107V14.9791H15.8987L16.336 12.0698H13.5733V10.1804C13.5733 9.38594 13.9573 8.60225 15.1947 8.60225H16.464V6.13312C16.464 6.13312 15.312 5.93988 14.224 5.93988C11.9413 5.93988 10.4373 7.33548 10.4373 9.84756V12.0698H7.89867V14.9791H10.4373V22.0107C5.65867 21.2378 2 17.0832 2 12.0698C2 6.50886 6.48 2 12.0053 2C17.5307 2 22 6.50886 22 12.0698Z"
                                    fill="#222222"/>
                            </svg>
                            </a>
                            </i>
                            </li>

                            </ul>

        </div>
        <div class="social-logo-part">
            <ul>
                <li>
                    <a href="https://twitter.com/switchEx2023" target="_blank" class="icon-web">
                        <svg
                            width="29"
                            height="29"
                            viewbox="0 0 22 22"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.28726 20.5C15.832 20.5 19.9621 13.965 19.9621 8.30213C19.9621 8.12092 19.9621 7.93971 19.9512 7.74717C20.7534 7.1469 21.4472 6.38807 22 5.52732C21.2629 5.86709 20.4715 6.0936 19.6369 6.20686C20.4824 5.67455 21.1328 4.83644 21.4472 3.82845C20.6558 4.32678 19.7778 4.67788 18.8347 4.87042C18.0867 4.02099 17.0244 3.5 15.8428 3.5C13.5772 3.5 11.7344 5.42538 11.7344 7.79247C11.7344 8.13225 11.7778 8.44937 11.8428 8.76649C8.43902 8.5966 5.41463 6.87508 3.38753 4.28148C3.02981 4.92705 2.83469 5.66322 2.83469 6.4447C2.83469 7.92838 3.56098 9.24217 4.65583 10.0123C3.98374 9.98967 3.35501 9.79714 2.80217 9.48001C2.80217 9.49134 2.80217 9.51399 2.80217 9.53664C2.80217 11.6093 4.22222 13.3534 6.08672 13.7385C5.73984 13.8404 5.38211 13.8857 5.00271 13.8857C4.74255 13.8857 4.48238 13.8631 4.23306 13.8065C4.75339 15.5167 6.271 16.7512 8.07046 16.7851C6.66125 17.9404 4.89431 18.6199 2.97561 18.6199C2.65041 18.6199 2.31436 18.6086 2 18.5633C3.8103 19.7865 5.96748 20.5 8.28726 20.5Z"
                                fill="#222222"/>
                        </svg>

                    </svg>
                </a>
              </li>
              <li>
                <a href="#" target="_blank" class="icon-web">
                    <svg
                        width="29"
                        height="29"
                        viewbox="0 0 22 22"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9.71176 11.9941C10.2872 11.9941 10.756 12.463 10.756 13.0384C10.756 13.6138 10.2872 14.0827 9.71176 14.0827C9.13634 14.0827 8.66748 13.6138 8.66748 13.0384C8.66748 12.463 9.13634 11.9941 9.71176 11.9941Z"
                            fill="#222222"/>
                        <path
                            d="M12.0028 16.0217C12.6847 16.0217 13.6438 15.8619 14.0913 15.4143C14.1979 15.3078 14.3684 15.3078 14.4749 15.4037C14.5815 15.5102 14.5815 15.6807 14.4749 15.7873C13.761 16.5012 12.4077 16.5545 12.0028 16.5545C11.5978 16.5545 10.2445 16.5012 9.5306 15.7979C9.42404 15.6914 9.42404 15.5209 9.5306 15.4143C9.63716 15.3078 9.80766 15.3078 9.91421 15.4143C10.3618 15.8619 11.3208 16.0217 12.0028 16.0217Z"
                            fill="#222222"/>
                        <path
                            d="M13.2495 13.0492C13.2495 12.4737 13.7184 12.0049 14.2938 12.0049C14.8585 12.0049 15.3274 12.4737 15.3381 13.0492C15.3381 13.6246 14.8692 14.0934 14.2938 14.0934C13.7184 14.0934 13.2495 13.6246 13.2495 13.0492Z"
                            fill="#222222"/>
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M12.003 2.00977C6.48328 2.00977 2.00781 6.48523 2.00781 12.005C2.00781 17.5247 6.48328 22.0002 12.003 22.0002C17.5227 22.0002 21.9982 17.5354 21.9982 12.005C21.9876 6.48523 17.5227 2.00977 12.003 2.00977ZM17.7998 13.3369C17.8211 13.4755 17.8318 13.6247 17.8318 13.7738C17.8318 16.0222 15.2211 17.8337 12.003 17.8337C8.78494 17.8337 6.17426 16.0222 6.17426 13.7738C6.17426 13.6247 6.18491 13.4755 6.20622 13.3369C5.69474 13.1132 5.3431 12.6017 5.3431 12.005C5.3431 11.2058 5.99311 10.5451 6.80295 10.5451C7.19722 10.5451 7.54886 10.6943 7.81526 10.95C8.82756 10.2148 10.2235 9.75658 11.7792 9.71395C11.7792 9.69264 12.5145 6.22949 12.5145 6.22949C12.5145 6.16555 12.5571 6.10162 12.6104 6.06965C12.6637 6.02703 12.7383 6.01637 12.8129 6.02703L15.2317 6.54916C15.4022 6.20818 15.7539 5.96309 16.1588 5.96309C16.7342 5.96309 17.2031 6.42129 17.2031 7.00737C17.2031 7.59344 16.7342 8.05164 16.1588 8.05164C15.6047 8.05164 15.1465 7.61475 15.1252 7.06064L12.9514 6.59179L12.2907 9.71395C13.8252 9.76723 15.1998 10.2361 16.1908 10.95C16.4572 10.6943 16.8088 10.5345 17.2031 10.5345C18.0129 10.5345 18.6629 11.1845 18.6629 11.9943C18.6629 12.6017 18.3006 13.1025 17.7998 13.3369Z"
                            fill="#222222"/>
                    </svg>

                </a>
              </li>
              <li>
                <a href="#" target="_blank" class="icon-web">
                    <svg
                        width="29"
                        height="29"
                        viewbox="0 0 22 22"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M12.0001 7.38184C9.44926 7.38184 7.38184 9.44926 7.38184 12.0001C7.38184 14.551 9.44926 16.6184 12.0001 16.6184C14.551 16.6184 16.6184 14.551 16.6184 12.0001C16.6184 9.44926 14.551 7.38184 12.0001 7.38184ZM12.0001 15.0036C10.3441 15.0036 8.99669 13.6561 8.99669 12.0001C8.99669 10.3441 10.3441 8.99669 12.0001 8.99669C13.6561 8.99669 15.0036 10.3441 15.0036 12.0001C15.0036 13.6561 13.6561 15.0036 12.0001 15.0036Z"
                            fill="#222222"/>
                        <path
                            d="M17.8836 7.19719C17.8836 7.79366 17.4001 8.27719 16.8036 8.27719C16.2072 8.27719 15.7236 7.79366 15.7236 7.19719C15.7236 6.60072 16.2072 6.11719 16.8036 6.11719C17.4001 6.11719 17.8836 6.60072 17.8836 7.19719Z"
                            fill="#222222"/>
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M12 3C9.552 3 9.25371 3.01029 8.28686 3.05143C7.33029 3.10286 6.672 3.24686 6.10629 3.47314C5.50971 3.69943 5.016 4.008 4.512 4.512C4.008 5.016 3.69943 5.50971 3.47314 6.10629C3.24686 6.672 3.10286 7.33029 3.05143 8.28686C3.01029 9.25371 3 9.552 3 12C3 14.448 3.01029 14.7463 3.05143 15.7131C3.09257 16.6697 3.24686 17.328 3.47314 17.8937C3.69943 18.4903 4.008 18.984 4.512 19.488C5.016 19.992 5.50971 20.3006 6.10629 20.5269C6.68229 20.7531 7.33029 20.8971 8.28686 20.9486C9.24343 20.9897 9.552 21 12 21C14.448 21 14.7463 20.9897 15.7131 20.9486C16.6697 20.9074 17.328 20.7531 17.8937 20.5269C18.4903 20.3006 18.984 19.992 19.488 19.488C19.992 18.984 20.3006 18.4903 20.5269 17.8937C20.7531 17.3177 20.8971 16.6697 20.9486 15.7131C20.9897 14.7566 21 14.448 21 12C21 9.552 20.9897 9.25371 20.9486 8.28686C20.9074 7.33029 20.7531 6.672 20.5269 6.10629C20.3006 5.50971 19.992 5.016 19.488 4.512C18.984 4.008 18.4903 3.69943 17.8937 3.47314C17.3177 3.24686 16.6697 3.10286 15.7131 3.05143C14.7463 3.01029 14.448 3 12 3ZM12 4.62514C14.4069 4.62514 14.6846 4.63543 15.6411 4.67657C16.5154 4.71771 16.9989 4.86171 17.3074 4.98514C17.7291 5.14971 18.0274 5.34514 18.3463 5.65371C18.6651 5.97257 18.8606 6.27086 19.0149 6.69257C19.1383 7.01143 19.2823 7.48457 19.3234 8.35886C19.3646 9.30514 19.3749 9.59314 19.3749 12C19.3749 14.4069 19.3646 14.6846 19.3234 15.6411C19.2823 16.5154 19.1383 16.9989 19.0149 17.3074C18.8503 17.7291 18.6549 18.0274 18.3463 18.3463C18.0274 18.6651 17.7291 18.8606 17.3074 19.0149C16.9886 19.1383 16.5154 19.2823 15.6411 19.3234C14.6949 19.3646 14.4069 19.3749 12 19.3749C9.59314 19.3749 9.31543 19.3646 8.35886 19.3234C7.48457 19.2823 7.00114 19.1383 6.69257 19.0149C6.27086 18.8503 5.97257 18.6549 5.65371 18.3463C5.33486 18.0274 5.13943 17.7291 4.98514 17.3074C4.86171 16.9886 4.71771 16.5154 4.67657 15.6411C4.63543 14.6949 4.62514 14.4069 4.62514 12C4.62514 9.59314 4.63543 9.31543 4.67657 8.35886C4.71771 7.48457 4.86171 7.00114 4.98514 6.69257C5.14971 6.27086 5.34514 5.97257 5.65371 5.65371C5.97257 5.33486 6.27086 5.13943 6.69257 4.98514C7.01143 4.86171 7.48457 4.71771 8.35886 4.67657C9.31543 4.63543 9.59314 4.62514 12 4.62514Z"
                            fill="#222222"/>
                    </svg>
                </a>

            </li>
            <li>
                <a href="#" target="_blank" class="icon-web">
                    <svg
                        width="29"
                        height="29"
                        viewbox="0 0 22 22"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M19.392 13.9478C19.0378 14.173 18.6265 14.1955 18.3066 14.0154C17.9068 13.7902 17.6783 13.2724 17.6783 12.5407V10.368C17.6783 9.30985 17.2556 8.56687 16.5473 8.36424C15.3477 8.01527 14.4452 9.46745 14.1139 10.0078L12.0003 13.385V9.25356C11.9775 8.30795 11.6576 7.73383 11.0635 7.56498C10.6751 7.4524 10.081 7.49743 9.50979 8.35298L4.78005 15.8503C4.15171 14.6683 3.8204 13.3399 3.8204 12.0003C3.8204 7.48618 7.48766 3.81632 12.0003 3.81632C16.513 3.81632 20.1802 7.48618 20.1802 12.0003C20.1802 12.0116 20.1802 12.0116 20.1802 12.0228C20.1802 12.0341 20.1802 12.0341 20.1802 12.0454C20.2145 12.9234 19.9289 13.6101 19.392 13.9478ZM21.9967 12.0003V11.9778V11.9553C21.9625 6.46177 17.4955 2.00391 12.0003 2.00391C6.4823 2.00391 2.00391 6.48428 2.00391 12.0003C2.00391 17.5164 6.4823 21.9967 12.0003 21.9967C14.5251 21.9967 16.9471 21.0511 18.7979 19.3288C19.1635 18.9911 19.1863 18.4169 18.8436 18.0455C18.5123 17.6852 17.9411 17.6515 17.5755 17.9892L17.564 18.0004C16.0674 19.3963 14.0682 20.1843 12.0003 20.1843C9.58976 20.1843 7.41911 19.1261 5.91108 17.4601L10.1838 10.7057V13.824C10.1838 15.3212 10.7779 15.8053 11.2692 15.9404C11.7604 16.0867 12.5144 15.9854 13.3141 14.7133L15.6562 10.9647C15.7361 10.8408 15.8047 10.7395 15.8618 10.6495V12.5407C15.8618 13.9366 16.433 15.051 17.4155 15.6026C18.3066 16.098 19.4262 16.0529 20.3402 15.4901C21.4598 14.8034 22.0539 13.5313 21.9967 12.0003Z"
                            fill="#222222"/>
                    </svg>

                </a>
            </li>

        </div>
        <div class="social-logo-part">
            <ul>
                <li>
                    <a href="#" target="_blank" class="icon-web">
                        <svg
                            width="29"
                            height="29"
                            viewbox="0 0 22 22"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 2C6.47761 2 2 6.47761 2 12C2 17.5224 6.47761 22 12 22C17.5224 22 22 17.5224 22 12C22 6.47761 17.5117 2 12 2ZM18.1407 16.2644H16.6908C16.1365 16.2644 15.9765 15.8166 14.9851 14.8252C14.1215 13.9936 13.7484 13.8763 13.5352 13.8763C13.2367 13.8763 13.1514 13.951 13.1514 14.3667V15.678C13.1514 16.0299 13.0341 16.2431 12.1066 16.2431C10.5714 16.2431 8.86567 15.3156 7.66098 13.5778C5.84861 11.0405 5.35821 9.12154 5.35821 8.73774C5.35821 8.52452 5.43284 8.33262 5.84861 8.33262H7.31983C7.6823 8.33262 7.83156 8.49254 7.97015 8.89765C8.68443 10.9765 9.88913 12.7889 10.3795 12.7889C10.5608 12.7889 10.6461 12.7036 10.6461 12.2345V10.1023C10.5928 9.11087 10.0704 9.02559 10.0704 8.67377C10.0704 8.5032 10.209 8.33262 10.4328 8.33262H12.7143C13.0235 8.33262 13.1407 8.5032 13.1407 8.86567V11.7548C13.1407 12.064 13.2687 12.1812 13.3646 12.1812C13.5458 12.1812 13.7058 12.064 14.0469 11.7335C15.0917 10.5608 15.838 8.75906 15.838 8.75906C15.9339 8.54584 16.1045 8.35394 16.4776 8.35394H17.9275C18.3646 8.35394 18.4606 8.57783 18.3646 8.88699C18.1834 9.72921 16.4136 12.2239 16.4136 12.2452C16.2537 12.5011 16.2004 12.6077 16.4136 12.8955C16.5736 13.1087 17.0746 13.5458 17.4158 13.9403C18.0341 14.6439 18.5139 15.2409 18.6418 15.6461C18.7591 16.0512 18.5565 16.2644 18.1407 16.2644Z"
                                fill="#222222"/>
                        </svg>

                    </a>
                </li>
                <li>
                    <a href="https://www.youtube.com/channel/UCszUfMKky9fDEA2hxWQSrkA" target="_blank" class="icon-web">
                        <svg
                            width="29"
                            height="29"
                            viewbox="0 0 22 22"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22.5574 6.94689C22.3051 6.04851 21.5602 5.33208 20.6111 5.09327C18.8931 4.66113 12.0091 4.66113 12.0091 4.66113C12.0091 4.66113 5.113 4.66113 3.39499 5.09327C2.44589 5.34345 1.71303 6.04851 1.44872 6.94689C0.992188 8.58444 0.992188 11.996 0.992188 11.996C0.992188 11.996 0.992188 15.4076 1.44872 17.0452C1.70102 17.9549 2.44589 18.66 3.39499 18.8988C5.113 19.3309 11.997 19.3309 11.997 19.3309C11.997 19.3309 18.8811 19.3309 20.5991 18.8988C21.5362 18.66 22.2931 17.9549 22.5454 17.0452C23.0019 15.4076 23.0019 11.996 23.0019 11.996C23.0019 11.996 23.0139 8.58444 22.5574 6.94689ZM9.75042 15.1006V8.90286L15.5051 11.996L9.75042 15.1006Z"
                                fill="#222222"/>
                        </svg>

                    </a>
                </li>

            </div>

        </div>
        

        <div class="select">
    <select>
        <option value="" disabled="disabled">--Select language and coin---</option>
        <option value="eng/usd">English</option>
        <option value="eng/usd">French </option>
    </select>
</div>
    </div>

</div>


<div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 foot-2">
    <h6>About</h6>
    <ul>
        <li>
            <a href="#">About Us</a>
        </li>
        <li>
            <a href="{{url('termscondition')}}">Terms of Use</a>
        </li>
        <li>
            <a href="#">Privacy Policy</a>
        </li>
        <li>
            <a href="{{url('riskdisclosure')}}">Risk Disclosure</a>
        </li>
    </ul>
</div>

<div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 foot-3">
    <h6>Services</h6>
    <ul>
        <li>
            <a href="#">Comming Soon</a>
        </li>
        <!-- <li>
            <a href="#">Derivatives</a>
        </li>
        <li>
            <a href="#">Copy Trading</a>
        </li>
        <li>
            <a href="#">API</a>
        </li> -->
    </ul>
</div>

<div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 foot-4">
    <h6>Apps</h6>
    <ul>
        <li>
            <a href="#">Google Play</a>
        </li>
        <li>
            <a href="#">App Store</a>
        </li>
        <li>
            <a href="#">Android APK</a>
        </li>
    </ul>
</div>

<div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 foot-5">
    <h6>Support</h6>
    <ul>
        <li>
            <a href="#">Help Center</a>
        </li>
        <li>
            <a href="#">Beginner Guides</a>
        </li>
        <li>
            <a href="#">Announcements</a>
        </li>
        <li>
            <a href="#">Referral</a>
        </li>
        <li>
            <a href="#">User Feedback</a>
        </li>
        <li>
            <a href="#">Rate Policy</a>
        </li>
    </ul>

                </div>

            </div>

  </div>


  <div class="copy-rigt-part">

<div class="contain-width">


<div class="row">

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 copy-left">
    <ul class="foot-links">

    <li class="nav-item">
      <a class="nav-link footer" href="{{url('security')}}">Security </a>
      <a class="nav-link footer" href="{{url('termscondition')}}">Term of Use</a>
      <a class="nav-link footer" href="{{url('amlpolicy')}}">AML & KYC Policy </a>
      <a class="nav-link" href="{{url('riskdisclosure')}}">Risk Disclosure Statement</a>
    </li>
    </ul>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 ppts-right">
    © 2023 Switch. All rights reserved.
  </div>

</div>


</div>

</div>

        </div>

    </section>

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="{{ url('landing/js/owl.carousel.js') }}"></script>
<script>
            $(document).ready(function() {
              $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                responsiveClass: true,
                items: 4,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                responsive: {
                  0: {
                    items: 1,
                    nav: true
                  },
                  600: {
                    items: 3,
                    nav: false
                  },
                  1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 20
                  }
                }
              })
            })
          </script>



<script type="text/javascript">
  
$(document).ready(function(){

$('li.main-menu-close a').click(function(){

$('.navbar-collapse').removeClass('show');

});


$('.settings-icon').click(function(){

$('ul.right-menu-head-mobile').addClass('open-side-menu');

});

$('li.close-icon-setting a').click(function(){

$('ul.right-menu-head-mobile').removeClass('open-side-menu');

});



})

</script>

<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontents");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    document.getElementById("defaultOpen").click();
    </script>

<script>
    function faqsctn(evt, cityName) {
        var i, tabcontent1, tablinks1;
        tabcontent1 = document.getElementsByClassName("tabcontentss");
        for (i = 0; i < tabcontent1.length; i++) {
         tabcontent1[i].style.display = "none";
        }
        tablinks1 = document.getElementsByClassName("tablinkss");
        for (i = 0; i < tablinks1.length; i++) {
         tablinks1[i].className = tablinks1[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    document.getElementById("faqopen").click();
    </script>

<script>
    $(document).ready(function() {

        $('.accrd-panel-head').click(function() {

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).siblings('.accrd-panel-body').slideUp(200);
                $(this).parent('.block-1').removeClass('coloured');
            } else {
                $('.accrd-panel-head').removeClass('active');
                $(this).addClass('active');
                $('.accrd-panel-head').siblings('.accrd-panel-body').slideUp(200);
                $(this).siblings('.accrd-panel-body').slideDown(200);
                $('.accrd-panel-head').parent('.block-1').removeClass('coloured');
                $(this).parent('.block-1').addClass('coloured');
            }

        });


                $('.accrd-panel-head1').click(function() {

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).siblings('.accrd-panel-body1').slideUp(200);
                $(this).parent('.block-1').removeClass('coloured');
            } else {
                $('.accrd-panel-head1').removeClass('active');
                $(this).addClass('active');
                $('.accrd-panel-head1').siblings('.accrd-panel-body1').slideUp(200);
                $(this).siblings('.accrd-panel-body1').slideDown(200);
                $('.accrd-panel-head1').parent('.block-1').removeClass('coloured');
                $(this).parent('.block-1').addClass('coloured');
            }

        });

        $('.accrd-panel-head-cdp').mouseover(function() {

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                // $(this).parent('.block-cdp').removeClass('slide-cls');
                // $(this).siblings('.accrd-panel-body-cdp').slideUp(200);
                $(this).parent('.block-1').removeClass('coloured');
            } else {
                $('.accrd-panel-head-cdp').removeClass('active');
                $(this).addClass('active');
                $('.accrd-panel-head-cdp').siblings('.accrd-panel-body-cdp').slideUp(200);
                $(this).siblings('.accrd-panel-body-cdp').slideDown(200);
                $('.accrd-panel-head-cdp').parent('.block-1').removeClass('coloured');
                $(this).parent('.block-1').addClass('coloured');
                $('.accrd-panel-head-cdp').parent('.block-cdp').removeClass('slide-cls');
                $(this).parent('.block-cdp').addClass('slide-cls');
            }

        });

        $('.accrd-panel-head-sdl').mouseover(function() {

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                // $(this).parent('.block-sdl').removeClass('slide-cls');
                // $(this).siblings('.accrd-panel-body-sdl').slideUp(200);
                $(this).parent('.block-1').removeClass('coloured');
            } else {
                $('.accrd-panel-head-sdl').removeClass('active');
                $(this).addClass('active');
                $('.accrd-panel-head-sdl').siblings('.accrd-panel-body-sdl').slideUp(200);
                $(this).siblings('.accrd-panel-body-sdl').slideDown(200);
                $('.accrd-panel-head-sdl').parent('.block-1').removeClass('coloured');
                $(this).parent('.block-1').addClass('coloured');
                $('.accrd-panel-head-sdl').parent('.block-sdl').removeClass('slide-cls');
                $(this).parent('.block-sdl').addClass('slide-cls');
            }

        });

        $('.accrd-panel-head-sps').mouseover(function() {

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                // $(this).parent('.block-sps').removeClass('slide-cls');
                // $(this).siblings('.accrd-panel-body-sps').slideUp(200);
                $(this).parent('.block-1').removeClass('coloured');
            } else {
                $('.accrd-panel-head-sps').removeClass('active');
                $(this).addClass('active');
                $('.accrd-panel-head-sps').siblings('.accrd-panel-body-sps').slideUp(200);
                $(this).siblings('.accrd-panel-body-sps').slideDown(200);
                $('.accrd-panel-head-sps').parent('.block-1').removeClass('coloured');
                $(this).parent('.block-1').addClass('coloured');
                $('.accrd-panel-head-sps').parent('.block-sps').removeClass('slide-cls');
                $(this).parent('.block-sps').addClass('slide-cls');
            }

        });



        $('.inner-risk-head').click(function() {
            $(this).addClass('active');
            $(this).siblings('.inner-risk-body').slideDown(200);
            $(this).parent('.inner-risk').addClass('top-bordered');
        });

    });
    </script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>
