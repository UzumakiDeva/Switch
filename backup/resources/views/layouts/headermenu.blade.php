<?php
  
if(isset($atitle)){ 
    switch($atitle){
      case 'dashboard':
      $active = "dashboard";
      break;
      case 'trade':
      $active = "trade";
      break;
      case 'wallet':
      $active = "wallet";
      break;
      case 'market':
      $active = "market";
      break;
      case 'support':
      $active = "support";
      break;
      case 'kyc':
      $active = "kyc";
      break;
      case 'history':
      $active = "history";
      break;
      case 'presale':
      $active = "presale";
      break;
	  case 'market-place':
		$active = "market-place";
		break;
      case 'login':
      $active = "login";
      break;
      case 'register':
      $active = "register";
      break;
      default:
      $active = "profile";
      break;
    }
}else{
	$active = "";
}
?>
<section class="headermenu">
	<nav class="navbar navbar-expand-lg navbar-dark headbg">
		<div class="container">
		<a href="{{url('/')}}">
						@if(Session::get('mode')=='nightmode')
		<img src="{{ url('landing/img/logo-dark.png') }}" class="dark-logo">
		@else
	<img src="{{ url('landing/img/logo.png') }}" class="light-logo">
			@endif
						</a>
			<!-- <h6 class="t-red"></h6> -->
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar"> <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true"></i></span> </button>
			<li class="mobiletoggle">
				<button type="button" id="sidebarCollapse" class="btn sidebtntoggle"><img src="{{ url('images/menubar.svg') }}"></button>
			</li>
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav">
				</ul>
				<ul class="navbar-nav mx-auto">
				<li class="nav-item"><a href="{{ route('trade') }}" class="nav-link @if($active == 'trade') active @endif">Trade</a></li>
				<li class="nav-item"><a href="{{ route('market') }}" class="nav-link @if($active == 'market') active @endif">Market</a></li>
				<li  class="nav-item"><a href="{{ route('wallet') }}" class="nav-link @if($active == 'wallet') active @endif">Wallet</a></li>
				<li  class="nav-item"><a href="{{ route('tradehistroy') }}" class="nav-link @if($active == 'history') active @endif">History</a></li>
				<li  class="nav-item"><a href="{{route('marketplace')}}" class="nav-link @if($active == 'market-place') active @endif">P2P Marketplace</a></li>	
				<li  class="nav-item"><a href="#" class="nav-link @if($active == 'presale') active @endif">Staking</a></li>
				 
				<li class="nav-item"><a href="{{ route('support') }}" class="nav-link @if($active == 'support') active @endif">Support</a></li>
				</ul>
				<div class="sun-moon-icon">
					<ul>
				@if(Session::get('mode')=='nightmode')
				<li><a href="{{ url('/setmode/daymode') }}"><img src="{{ url('landing/img/panther/sun-icon.svg') }}" class="img-fluid sun-img" id="showf"  aria-hidden="true">   </a></li>                 
        @else
		<li><a href="{{ url('/setmode/nightmode') }}"><img src="{{ url('landing/img/panther/moon-icon.svg') }}" class="img-fluid moon-img" id="showf"  aria-hidden="true"></a></li>
        @endif
		</ul>
		</div>
				<!-- <div class="container-mode">
					<div class="sun sun-logo">
						<svg viewBox="0 0 512 512" width="20" height="50" title="sun" class="sun">
							<path
								d="M256 160c-52.9 0-96 43.1-96 96s43.1 96 96 96 96-43.1 96-96-43.1-96-96-96zm246.4 80.5l-94.7-47.3 33.5-100.4c4.5-13.6-8.4-26.5-21.9-21.9l-100.4 33.5-47.4-94.8c-6.4-12.8-24.6-12.8-31 0l-47.3 94.7L92.7 70.8c-13.6-4.5-26.5 8.4-21.9 21.9l33.5 100.4-94.7 47.4c-12.8 6.4-12.8 24.6 0 31l94.7 47.3-33.5 100.5c-4.5 13.6 8.4 26.5 21.9 21.9l100.4-33.5 47.3 94.7c6.4 12.8 24.6 12.8 31 0l47.3-94.7 100.4 33.5c13.6 4.5 26.5-8.4 21.9-21.9l-33.5-100.4 94.7-47.3c13-6.5 13-24.7.2-31.1zm-155.9 106c-49.9 49.9-131.1 49.9-181 0-49.9-49.9-49.9-131.1 0-181 49.9-49.9 131.1-49.9 181 0 49.9 49.9 49.9 131.1 0 181z"/>
						</svg>
					</div>
					<div class="moon moon-logo">
						<svg viewBox="0 0 512 512" width="20" height="50" title="moon" class="moon">
							<path
								d="M283.211 512c78.962 0 151.079-35.925 198.857-94.792 7.068-8.708-.639-21.43-11.562-19.35-124.203 23.654-238.262-71.576-238.262-196.954 0-72.222 38.662-138.635 101.498-174.394 9.686-5.512 7.25-20.197-3.756-22.23A258.156 258.156 0 0 0 283.211 0c-141.309 0-256 114.511-256 256 0 141.309 114.511 256 256 256z"/>
						</svg>
					</div>
				</div> -->



				@guest
				<ul class="navbar-nav info-menu right-links list-inline list-unstyled">
					<li class="nav-item"><a class="nav-link btn sitebtn me-2" href="{{route('login')}}">Login</a></li>
					<li class="nav-item"><a class="nav-link btn sitebtn" href="{{route('register')}}">Sign up</a></li>
				</ul>
				@else
				<ul class="navbar-nav">
					<li class="dropdown usermenu"> <a href="#" class="nav-link dropdown-bs-toggle" data-bs-toggle="dropdown">{{ Auth::user()->first_name .' '.Auth::user()->last_name}}
						@if(Auth::user()->profileimg)
									<span class="photopic"><img src="{{ url('storage/userprofile') }}/{{Auth::user()->profileimg}}"  alt="user-image" class="img-circle img-inline"></span></a>
									@else
									<span class="photopic"><img src="{{ url('images/profile.svg') }}"></span></a>
									@endif
						<div class="dropdown-menu"> 

						 <a class="nav-link dropdown-item" href="{{ route('myprofile') }}"><i class="fa fa-user"></i>My Account</a>
						 <a class="nav-link dropdown-item" href="{{route('bank')}} "><i class="fa fa-university"></i>Payment Option</a> 
						    <a class="nav-link dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>Logout</a> <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form></div>
					</li>
				</ul>
				@endguest
			</div>
		</div>
	</nav>
</section>