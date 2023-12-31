<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Panther Exchange') }}</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
            rel="stylesheet">
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link
            rel="stylesheet"
            type="text/css"
            href="{{ url('landing/css/custom.css') }}">
        <link
            rel="stylesheet"
            type="text/css"
            href="{{ url('landing/css/index.css') }}">
        <link
            rel="stylesheet"
            type="text/css"
            href="{{ url('landing/css/responsive.css') }}">
        <link
            rel="stylesheet"
            type="text/css"
            href="{{ url('landing/css/common.css') }}">
        <link
            rel="icon"
            type="image/png"
            sizes="32x32"
            href="{{ url('favicon/favicon-32x32.png') }}">
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
            rel="stylesheet">
        <link
            rel="stylesheet"
            type="text/css"
            href="{{ url('landing/css/owl.theme.default.min.css') }}">
        <link
            rel="stylesheet"
            type="text/css"
            href="{{ url('landing/css/owl.carousel.min.css') }}">
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
                                    <button
                                        class="navbar-toggler"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapsibleNavbar">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                                        <ul class="navbar-nav">
                                            <li class="main-menu-close">
                                                <a href="#">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('wallet') }}">Buy Crypto</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('market') }}">Markets</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">P2P</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('trade') }}">Trade</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Game</a>
                                            </li>
                                            <!-- <li class="nav-item">
                                                <a class="nav-link" href="{{ route('support') }}">Bonus</a>
                                            </li> -->

                                        </ul>

                                        @guest
                                        <ul class="navbar-nav info-menu right-links list-inline list-unstyled">
                                            <li class="nav-item">
                                                <a class="nav-link menu-last btn sitebtn me-2" href="{{route('login')}}">Login</a>
                                            </li>
                                            <li class="nav-item last-menu">
                                                <a class="nav-item last-menu btn sitebtn" href="{{route('register')}}">
                                                    <span>Sign Up</span></a>
                                            </li>
                                        </ul>
                                        @else
                                        <ul class="navbar-nav">
                                            <li class="dropdown usermenu">
                                                <a href="#" class="nav-link dropdown-toggless" data-bs-toggle="dropdownss">{{ Auth::user()->first_name .' '.Auth::user()->last_name}}
                                                    @if(Auth::user()->profileimg)
                                                    <span class="photopic"><img
                                                        src="{{ url('storage/userprofile') }}/{{Auth::user()->profileimg}}"
                                                        alt="user-image"
                                                        class="img-circle img-inline"></span></a>
                                                @else
                                                <span class="photopic"><img src="{{ url('images/profile.svg') }}" class="img-fluid"></span></a>
                                            @endif
                                            <div class="dropdown-menu dropdownss">

                                                <a class="nav-link dropdown-item" href="{{ route('myprofile') }}">
                                                    <i class="fa fa-user"></i>My Account</a>
                                                <a
                                                    class="nav-link dropdown-item"
                                                    href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-sign-out"></i>Logout</a>
                                                <form
                                                    id="logout-form"
                                                    action="{{ route('logout') }}"
                                                    method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                    @endguest

                                    <ul class="icon-sun">
                                        @if(Session::get('mode')=='nightmode')
                                        <li>
                                            <a href="{{ url('/setmode/daymode') }}"><img
                                                src="{{ url('landing/img/panther/sun-icon.svg') }}"
                                                class="img-fluid sun-img"
                                                id="showf"
                                                aria-hidden="true">
                                            </a>
                                        </li>

                                        <!-- <i class="fas fa-sun" id="showf" aria-hidden="true"></i> -->
                                        <!-- <i class="fa fa-moon-o modeicon" id="hidef" aria-hidden="true"></i> -->
                                        @else
                                        <li>
                                            <a href="{{ url('/setmode/nightmode') }}"><img
                                                src="{{ url('landing/img/panther/moon-icon.svg') }}"
                                                class="img-fluid moon-img"
                                                id="showf"
                                                aria-hidden="true"></a>
                                        </li>
                                        @endif
                                    </ul>

                                    <!-- <ul class="globle-icon">
                                        @if(Session::get('mode')=='nightmode')
                                        <li>
                                            <i class="fa-solid fa-globe" id="showf" aria-hidden="true"></i>
                                        </li>

                                         <i class="fas fa-sun" id="showf" aria-hidden="true"></i> 
                                         <i class="fa fa-moon-o modeicon" id="hidef" aria-hidden="true"></i> 
                                        @else
                                        <li>
                                            <i class="fa-solid fa-globe" id="showf" aria-hidden="true"></i>
                                        </li>
                                        @endif
                                    </ul> -->

                                </div>
                            </nav>

                        </div>

                        <!-- <div class="col-xl-3 col-lg-3 col-md-12 col-md-12 head-sun-moon"> <div
                        class="settings-icon"><i class="fa-solid fa-ellipsis-vertical"></i></div> </div>
                        -->

                    </div>
                </div>
            </div>

            <!-- <div class="banner-right-icon"> <ul class="banner-icons"> <li><a
            href="#"><img src="{{ url('landing/img/ban-icon-1.png') }}"></a></li> <li><a
            href="#"><img src="{{ url('landing/img/ban-icon-2.png') }}"></a></li> <li><a
            href="#"><img src="{{ url('landing/img/ban-icon-3.png') }}"></a></li> <li><a
            href="#"><img src="{{ url('landing/img/ban-icon-4.png') }}"></a></li> <li><a
            href="#"><img src="{{ url('landing/img/ban-icon-5.png') }}"></a></li> </ul>
            </div> -->

            <div class="banner-content">
                <div class="contain-width">
                    <div class="row">

                        <div class="col-xl-6 col-lg-6 col-md-12 col-md-12">
                            <div class="banner-inner-content">
                                <h1>
                                    <span class="red-span">
                                        Panther Exchange
                                        <br></span>
                                    Buy and Sell Crypto The Easy Way
                                </h1>
                                <div class="para-banner-button">
                                    <p>Panther Exchange is a Centralized Cryptocurrency trading platform designed for the people by the people. It is a reliable and secure way to buy, sell and trade crypto with low fees and unmatched liquidity.</p>
                                    <p>Try Panther Exchange yourself with a demo trading account, apply for free crypto, and play games to earn even more crypto. </p>
                                    <p>Best of all, we give you access to the widest variety of cryptocurrencies on the market.</p>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-12 col-md-12">
                        <div class="banner-right banner-right-image-part">
                            <img
                                src="{{ url('landing/img/panther/banner-right-img.png') }}"
                                class="img-fluid"
                                width="640"
                                height="360"
                                alt="Pnather-Exchange">
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
    <!-- Banner-End -->

    <section class="interested-to-see-bsc">
        <div class="contain-width">
            <h3>Why choose Panther Exchange?
            </h3>
            <p>Panther Exchange is the best place to trade Crypto.</p>
            <div class="row">
                <div class="intelignce-btn" style="margin-top:0px !important">
                    <ul>
                        <li class="nav-item last-menu">
                            <a class="nav-link menu-last" href="{{route('login')}}">
                                <span>Get Started Now</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="modern-tech" id="tech-modern">
        <div class="contain-width">

            <div class="metaverse desktop-token-three-ways">
                <div class="meta-vese-inner">
                    <div class="tabs">
                        <button
                            class="tablinks active"
                            onclick="openCity(event, 'front-end')"
                            id="defaultOpen">
                            <h4 class="meta-head">Hot Spot</h4>
                        </button>
                        <button class="tablinks" onclick="openCity(event, 'back-end')">
                            <h4 class="meta-head">Hot Futures</h4>
                        </button>
                        <button class="tablinks" onclick="openCity(event, 'dbconnect')">
                            <h4 class="meta-head">New Spot</h4>
                        </button>
                        <button class="tablinks" onclick="openCity(event, 'server-req')">
                            <h4 class="meta-head">New Futures</h4>
                        </button>
                        <button class="tablinks" onclick="openCity(event, 'framework')">
                            <h4 class="meta-head">Gainers</h4>
                        </button>
                        <button class="tablinks" onclick="openCity(event, 'volume')">
                            <h4 class="meta-head">24H Volume</h4>
                        </button>
                    </div>
                    <div id="front-end" class="tabcontents" style="display: block;">
                        <div class="inner-tab-content" style="overflow-x:auto;">
                            <table class="table">
                                <thead>
                                    <th>Pair</th>
                                    <th>Last Price</th>
                                    <th>24h Change</th>
                                    <th>Trend</th>
                                    <th>Trade</th>
                                </thead>

                                <tbody>
                                    @forelse($trades as $trade)
                                    <tr>
                                        <td><img
                                            src="{{ url('images/color/'.$trade->coinonedetails['image']) }}"
                                            class="img-fluid"
                                            alt="crypto-coin">
                                            <span>{{ $trade->coinone }}</span><span class="gray-txt">/{{$trade->cointwo}}</span></td>
                                        <td>
                                            <span class="last_price_{{$trade->coinone.$trade->cointwo}}">{{ $trade->close }}</span></td>
                                        <td class="price_change_{{$trade->coinone.$trade->cointwo}}">
                                            <span class="@if($trade->hrchange >= 0 ) green @else red @endif">{{ $trade->hrchange }}%</span></td>
                                        @if($trade->hrchange >= 0 )
                                        <td class="waveimg{{$trade->coinone.$trade->cointwo}}"><img
                                            src="{{ url('landing/img/panther/graph-1.png') }}"
                                            class="img-fluid"
                                            alt="crypto-coin"></td>
                                        @else
                                        <td class="waveimg{{$trade->coinone.$trade->cointwo}}"><img
                                            src="{{ url('landing/img/panther/graph-2.png') }}"
                                            class="img-fluid"
                                            alt="crypto-coin"></td>
                                        @endif
                                        <td>
                                            <a href="{{url('trades/'.$trade->coinone.'_'.$trade->cointwo)}}">
                                                <button class="trade-btn">Trade</button>
                                            </a>
                                        </td>

                                    </tr>
                                    @empty

                                    <tr>
                                        <td data-label="S.No"><img
                                            src="{{ url('landing/img/panther/eth-img.png') }}"
                                            class="img-fluid"
                                            alt="crypto-coin">
                                            <span>ETH</span><span class="gray-txt">/USDT</span></td>
                                        <td data-label="Name">
                                            <span>1,895.64</span></td>
                                        <td data-label="Name">
                                            <span class="red">-0.19%</span></td>
                                        <td data-label="Age"><img
                                            src="{{ url('landing/img/panther/graph-2.png') }}"
                                            class="img-fluid"
                                            alt="crypto-coin"></td>
                                        <td data-label="Marks%">
                                            <button class="trade-btn">Trade</button>
                                        </td>

                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="back-end" class="tabcontents" style="display: none;">
                        <div class="inner-tab-content">
                            <table class="table">
                                <thead>
                                    <th>Pair</th>
                                    <th>Last Price</th>
                                    <th>24h Change</th>
                                    <th>Trend</th>
                                    <th>Trade</th>
                                </thead>
                                <tbody>
                                    @forelse($trades->reverse() as $trade)
                                    <tr>
                                        <td><img
                                            src="{{ url('images/color/'.$trade->coinonedetails['image']) }}"
                                            class="img-fluid"
                                            alt="crypto-coin">
                                            <span>{{ $trade->coinone }}</span><span class="gray-txt">/{{$trade->cointwo}}</span></td>
                                        <td>
                                            <span class="last_price_{{$trade->coinone.$trade->cointwo}}">{{ $trade->close }}</span></td>
                                        <td class="price_change_{{$trade->coinone.$trade->cointwo}}">
                                            <span class="@if($trade->hrchange >= 0 ) green @else red @endif">{{ $trade->hrchange }}%</span></td>
                                        @if($trade->hrchange >= 0 )
                                        <td class="waveimg{{$trade->coinone.$trade->cointwo}}"><img
                                            src="{{ url('landing/img/panther/graph-1.png') }}"
                                            class="img-fluid"
                                            alt="crypto-coin"></td>
                                        @else
                                        <td class="waveimg{{$trade->coinone.$trade->cointwo}}"><img
                                            src="{{ url('landing/img/panther/graph-2.png') }}"
                                            class="img-fluid"
                                            alt="crypto-coin"></td>
                                        @endif
                                        <td>
                                            <a href="{{url('trades/'.$trade->coinone.'_'.$trade->cointwo)}}">
                                                <button class="trade-btn">Trade</button>
                                            </a>
                                        </td>

                                    </tr>
                                    @empty @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div
                        id="dbconnect"
                        class="tabcontents"
                        style=" ">
                    <div class="
                        inner-tab-content" style="
                        overflow-x:auto;"="overflow-x:auto;"">
                        <table class="table">
                            <thead>
                                <th>Pair</th>
                                <th>Last Price</th>
                                <th>24h Change</th>
                                <th>Trend</th>
                                <th>Trade</th>
                            </thead>
                            <tbody>

                                @forelse($trades->reverse() as $trade)
                                <tr>
                                    <td><img
                                        src="{{ url('images/color/'.$trade->coinonedetails['image']) }}"
                                        class="img-fluid"
                                        alt="crypto-coin">
                                        <span>{{ $trade->coinone }}</span><span class="gray-txt">/{{$trade->cointwo}}</span></td>
                                    <td>
                                        <span class="last_price_{{$trade->coinone.$trade->cointwo}}">{{ $trade->close }}</span></td>
                                    <td class="price_change_{{$trade->coinone.$trade->cointwo}}">
                                        <span class="@if($trade->hrchange >= 0 ) green @else red @endif">{{ $trade->hrchange }}%</span></td>
                                    @if($trade->hrchange >= 0 )
                                    <td class="waveimg{{$trade->coinone.$trade->cointwo}}"><img
                                        src="{{ url('landing/img/panther/graph-1.png') }}"
                                        class="img-fluid"
                                        alt="crypto-coin"></td>
                                    @else
                                    <td class="waveimg{{$trade->coinone.$trade->cointwo}}"><img
                                        src="{{ url('landing/img/panther/graph-2.png') }}"
                                        class="img-fluid"
                                        alt="crypto-coin"></td>
                                    @endif
                                    <td>
                                        <a href="{{url('trades/'.$trade->coinone.'_'.$trade->cointwo)}}">
                                            <button class="trade-btn">Trade</button>
                                        </a>
                                    </td>

                                </tr>
                                @empty @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="server-req" class="tabcontents" style="display: none;">
                    <div class="inner-tab-content" style="overflow-x:auto;">
                        <table class="table">
                            <thead>
                                <th>Pair</th>
                                <th>Last Price</th>
                                <th>24h Change</th>
                                <th>Trend</th>
                                <th>Trade</th>
                            </thead>
                            <tbody>
                                @forelse($trades->sortBy('close') as $trade)
                                <tr>
                                    <td><img
                                        src="{{ url('images/color/'.$trade->coinonedetails['image']) }}"
                                        class="img-fluid"
                                        alt="crypto-coin">
                                        <span>{{ $trade->coinone }}</span><span class="gray-txt">/{{$trade->cointwo}}</span></td>
                                    <td>
                                        <span class="last_price_{{$trade->coinone.$trade->cointwo}}">{{ $trade->close }}</span></td>
                                    <td class="price_change_{{$trade->coinone.$trade->cointwo}}">
                                        <span class="@if($trade->hrchange >= 0 ) green @else red @endif">{{ $trade->hrchange }}%</span></td>
                                    @if($trade->hrchange >= 0 )
                                    <td class="waveimg{{$trade->coinone.$trade->cointwo}}"><img
                                        src="{{ url('landing/img/panther/graph-1.png') }}"
                                        class="img-fluid"
                                        alt="crypto-coin"></td>
                                    @else
                                    <td class="waveimg{{$trade->coinone.$trade->cointwo}}"><img
                                        src="{{ url('landing/img/panther/graph-2.png') }}"
                                        class="img-fluid"
                                        alt="crypto-coin"></td>
                                    @endif
                                    <td>
                                        <a href="{{url('trades/'.$trade->coinone.'_'.$trade->cointwo)}}">
                                            <button class="trade-btn">Trade</button>
                                        </a>
                                    </td>

                                </tr>
                                @empty @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="framework" class="tabcontents" style="display: none;">
                    <div class="inner-tab-content" style="overflow-x:auto;">
                        <table class="table">
                            <thead>
                                <th>Pair</th>
                                <th>Last Price</th>
                                <th>24h Change</th>
                                <th>Trend</th>
                                <th>Trade</th>
                            </thead>
                            <tbody>

                                @forelse($trades->sortBy('hrchange') as $trade)
                                <tr>
                                    <td><img
                                        src="{{ url('images/color/'.$trade->coinonedetails['image']) }}"
                                        class="img-fluid"
                                        alt="crypto-coin">
                                        <span>{{ $trade->coinone }}</span><span class="gray-txt">/{{$trade->cointwo}}</span></td>
                                    <td>
                                        <span class="last_price_{{$trade->coinone.$trade->cointwo}}">{{ $trade->close }}</span></td>
                                    <td class="price_change_{{$trade->coinone.$trade->cointwo}}">
                                        <span class="@if($trade->hrchange >= 0 ) green @else red @endif">{{ $trade->hrchange }}%</span></td>
                                    @if($trade->hrchange >= 0 )
                                    <td class="waveimg{{$trade->coinone.$trade->cointwo}}"><img
                                        src="{{ url('landing/img/panther/graph-1.png') }}"
                                        class="img-fluid"
                                        alt="crypto-coin"></td>
                                    @else
                                    <td class="waveimg{{$trade->coinone.$trade->cointwo}}"><img
                                        src="{{ url('landing/img/panther/graph-2.png') }}"
                                        class="img-fluid"
                                        alt="crypto-coin"></td>
                                    @endif
                                    <td>
                                        <a href="{{url('trades/'.$trade->coinone.'_'.$trade->cointwo)}}">
                                            <button class="trade-btn">Trade</button>
                                        </a>
                                    </td>

                                </tr>
                                @empty @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
                <div id="volume" class="tabcontents" style="display: none;">
                    <div class="inner-tab-content" style="overflow-x:auto;">
                        <table class="table">
                            <thead>
                                <th>Pair</th>
                                <th>Last Price</th>
                                <th>24h Change</th>
                                <th>Trend</th>
                                <th>Trade</th>
                            </thead>
                            <tbody>
                                @forelse($trades->sortBy('hrvolume') as $trade)
                                <tr>
                                    <td><img
                                        src="{{ url('images/color/'.$trade->coinonedetails['image']) }}"
                                        class="img-fluid"
                                        alt="crypto-coin">
                                        <span>{{ $trade->coinone }}</span><span class="gray-txt">/{{$trade->cointwo}}</span></td>
                                    <td>
                                        <span class="last_price_{{$trade->coinone.$trade->cointwo}}">{{ $trade->close }}</span></td>
                                    <td class="price_change_{{$trade->coinone.$trade->cointwo}}">
                                        <span class="@if($trade->hrchange >= 0 ) green @else red @endif">{{ $trade->hrchange }}%</span></td>
                                    @if($trade->hrchange >= 0 )
                                    <td class="waveimg{{$trade->coinone.$trade->cointwo}}"><img
                                        src="{{ url('landing/img/panther/graph-1.png') }}"
                                        class="img-fluid"
                                        alt="crypto-coin"></td>
                                    @else
                                    <td class="waveimg{{$trade->coinone.$trade->cointwo}}"><img
                                        src="{{ url('landing/img/panther/graph-2.png') }}"
                                        class="img-fluid"
                                        alt="crypto-coin"></td>
                                    @endif
                                    <td>
                                        <a href="{{url('trades/'.$trade->coinone.'_'.$trade->cointwo)}}">
                                            <button class="trade-btn">Trade</button>
                                        </a>
                                    </td>

                                </tr>
                                @empty @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="crypto-sctn">
    <div class="contain-width">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="cypto-trade">
                    <img
                        src="{{ url('landing/img/panther/cyrpto-trade-img.png') }}"
                        alt="get-fast-whitelabel"
                        class="img-fluid">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                <h4 class="crypto-head">The crypto trading platform that is always with you</h4>
                <p class="crypto-para">Get access to the limitless crypto market in a pocket
                    format, be it mobile or tablet. No bugs, no latency delays and no freezes. You
                    can now trade cryptocurrencies safely and on the go. Real time crypto price
                    reporting and trading
                    <span class="bold-txt">
                        BTC, ETH, XRP, SOL, DOGE</span>
                    - buy and sell digital assets with the lowest fees and blazing fast on boarding.
                    Keep you hand on the pulse of the market with instant price volatility
                    notifications, listing of new crypto assets, important events from the world of
                    top coin markets Get updates on new IEOs, airdrops, free coins, tournaments and
                    competitions. Perform cross exchange price comparisons all in one place, with
                    access to over 100 top coins
                </p>
            </div>
        </div>
    </div>
</section>

<section class="key-feature serv">
    <div class="contain-width inner-key-feature">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12 text-center">
                <h3 class="panther-exg">
                    Why Panther Exchange?
                </h3>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
                <div class="kf-img">
                    <svg
                        width="35"
                        height="35"
                        viewbox="0 0 40 40"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12.0391 19.9179L16.0508 23.9296L16.6211 24.4999C17.2188 25.0976 18.2344 25.0976 18.8321 24.4999L21.9297 21.4022L26.8321 16.4999L27.961 15.371C28.5391 14.7929 28.5821 13.7304 27.961 13.1601C27.336 12.5858 26.3672 12.5429 25.75 13.1601L22.6524 16.2577L17.75 21.1601L16.6211 22.289H18.8321L14.8203 18.2772L14.25 17.7069C13.6719 17.1288 12.6094 17.0858 12.0391 17.7069C11.4649 18.3319 11.4219 19.2968 12.0391 19.9179Z"
                            fill="black"/>
                        <path
                            d="M20.7891 38.4374C22.1094 37.5975 23.4336 36.7616 24.7539 35.9218C25.3516 35.5429 25.957 35.1679 26.5391 34.7616C27.9219 33.7968 29.2188 32.6991 30.3711 31.4647C32.6523 29.0155 34.3867 26.1132 35.4844 22.953C36.3789 20.371 36.7617 17.6483 36.7617 14.9218V9.72255C36.7617 9.02333 36.2734 8.41395 35.6133 8.21474C35.1367 8.0702 34.6641 7.92177 34.207 7.73036C34.332 7.78114 34.457 7.83583 34.582 7.88661C33.7656 7.53895 33 7.09364 32.2969 6.55458L32.6133 6.80067C31.918 6.26161 31.293 5.64052 30.7539 4.9452L31 5.26161C30.4609 4.55849 30.0117 3.78895 29.6641 2.97255C29.7148 3.09755 29.7695 3.22255 29.8203 3.34755C29.7031 3.0663 29.5938 2.77724 29.5 2.48817C29.2891 1.82802 28.6992 1.33974 27.9922 1.33974H13.9727C13.3281 1.33974 12.6797 1.3202 12.0352 1.33974H12.0078C11.2969 1.33974 10.7109 1.82802 10.5 2.48817C10.4063 2.78114 10.3008 3.0663 10.1797 3.34755C10.2305 3.22255 10.2852 3.09755 10.3359 2.97255C9.98828 3.78895 9.53906 4.55458 9 5.26161L9.24609 4.9452C8.70703 5.64052 8.08203 6.26161 7.38672 6.80067L7.70313 6.55458C7 7.09364 6.23047 7.53895 5.41797 7.88661C5.54297 7.83583 5.66797 7.78114 5.79297 7.73036C5.33203 7.92177 4.86328 8.0702 4.38672 8.21474C3.72656 8.41395 3.23828 9.02333 3.23828 9.72255V14.4335C3.23828 15.2616 3.23828 16.0897 3.29688 16.9179C3.42188 18.6015 3.70703 20.2811 4.17969 21.9022C5.11719 25.121 6.74219 28.0858 8.89844 30.6444C10.5742 32.6327 12.5938 34.2421 14.7813 35.6288L19.1055 38.371C19.1406 38.3944 19.1797 38.4179 19.2148 38.4413C19.9063 38.8788 20.9688 38.6093 21.3516 37.8788C21.7578 37.1054 21.5273 36.2108 20.7891 35.7421C20.0859 35.2968 19.3828 34.8515 18.6836 34.4061C17.7852 33.8358 16.8906 33.2694 15.9922 32.6991C15.3633 32.3007 14.75 31.8749 14.1563 31.4218L14.4727 31.6679C12.9961 30.5233 11.668 29.1952 10.5234 27.7186L10.7695 28.035C9.60547 26.5233 8.63672 24.8671 7.89063 23.1093C7.94141 23.2343 7.99609 23.3593 8.04688 23.4843C7.28516 21.6757 6.76563 19.7772 6.50391 17.8319C6.52344 17.9686 6.54297 18.1093 6.55859 18.246C6.39062 16.9804 6.36328 15.7147 6.36328 14.4452V9.73817C5.98047 10.2421 5.59766 10.7421 5.21484 11.246C6.5625 10.8397 7.86719 10.3007 9.01172 9.47645C10.3672 8.49989 11.5234 7.29677 12.3828 5.85927C12.8555 5.0702 13.2344 4.21083 13.5156 3.33583C13.0117 3.71864 12.5117 4.10145 12.0078 4.48427H26.0273C26.6719 4.48427 27.3203 4.49989 27.9648 4.48427H27.9922C27.4883 4.10145 26.9883 3.71864 26.4844 3.33583C27.4648 6.39442 29.6914 9.05458 32.6133 10.4296C33.3164 10.7616 34.0391 11.0194 34.7852 11.246C34.4023 10.7421 34.0195 10.2421 33.6367 9.73817V15.2772C33.6367 16.2694 33.5703 17.2616 33.4414 18.246C33.4609 18.1093 33.4805 17.9686 33.4961 17.8319C33.2305 19.7733 32.7109 21.6757 31.9531 23.4843C32.0039 23.3593 32.0586 23.2343 32.1094 23.1093C31.3633 24.8671 30.3945 26.5233 29.2305 28.035L29.4766 27.7186C28.332 29.1952 27.0039 30.5233 25.5273 31.6679L25.8438 31.4218C24.9688 32.0975 24.0391 32.6796 23.1094 33.2733C22.0781 33.9296 21.0469 34.5819 20.0156 35.2382C19.75 35.4061 19.4805 35.578 19.2148 35.746C18.875 35.9608 18.6055 36.285 18.4961 36.6796C18.3945 37.0546 18.4414 37.5507 18.6523 37.8827C19.0977 38.5702 20.0508 38.9061 20.7891 38.4374Z"
                            fill="black"/>
                    </svg>

                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                <span class="panther-txt">Panther Exchange loves security</span>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                <p>Panther Exchange is a centralised cryptocurrency exchange founded in 2023 in UEA</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
                <div class="kf-img">
                    <svg
                        width="35"
                        height="35"
                        viewbox="0 0 40 40"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.875 16.875V18.125H16.25C16.0842 18.125 15.9253 18.1908 15.8081 18.3081C15.6908 18.4253 15.625 18.5842 15.625 18.75V24.375C15.625 24.5408 15.6908 24.6997 15.8081 24.8169C15.9253 24.9342 16.0842 25 16.25 25H23.75C23.9158 25 24.0747 24.9342 24.1919 24.8169C24.3092 24.6997 24.375 24.5408 24.375 24.375V18.75C24.375 18.5842 24.3092 18.4253 24.1919 18.3081C24.0747 18.1908 23.9158 18.125 23.75 18.125H23.125V16.875C23.125 16.0462 22.7958 15.2513 22.2097 14.6653C21.6237 14.0792 20.8288 13.75 20 13.75C19.1712 13.75 18.3763 14.0792 17.7903 14.6653C17.2042 15.2513 16.875 16.0462 16.875 16.875ZM23.125 19.375V23.75H16.875V19.375H23.125ZM21.875 16.875V18.125H18.125V16.875C18.125 16.3777 18.3225 15.9008 18.6742 15.5492C19.0258 15.1975 19.5027 15 20 15C20.4973 15 20.9742 15.1975 21.3258 15.5492C21.6775 15.9008 21.875 16.3777 21.875 16.875Z"
                            fill="black"/>
                        <g clip-path="url(#clip0_108_15099)"></g>
                        <path
                            d="M33.7501 11.8749C35.0291 11.878 36.2711 11.4462 37.2724 10.6503C38.2736 9.85445 38.9746 8.74182 39.2601 7.49508C39.5456 6.24834 39.3988 4.94156 38.8438 3.78924C38.2888 2.63692 37.3585 1.70754 36.2056 1.15365C35.0527 0.599749 33.7458 0.454252 32.4993 0.741036C31.2529 1.02782 30.141 1.72985 29.3461 2.73188C28.5512 3.73391 28.1206 4.97641 28.1249 6.25543C28.1293 7.53444 28.5684 8.77398 29.3701 9.77057L26.4007 12.9231C24.1692 12.0046 22.1437 10.6495 20.4432 8.93745C20.3237 8.82366 20.165 8.76019 20.0001 8.76019C19.8351 8.76019 19.6764 8.82366 19.5569 8.93745C17.8566 10.6506 15.8312 12.0068 13.5994 12.9262L10.6301 9.7737C11.5365 8.64911 11.978 7.22007 11.8636 5.78016C11.7492 4.34025 11.0878 2.9988 10.0152 2.0314C8.94251 1.064 7.54012 0.544098 6.09608 0.57851C4.65205 0.612922 3.27602 1.19903 2.25067 2.21643C1.22533 3.23383 0.628541 4.60526 0.5829 6.04899C0.537259 7.49271 1.04624 8.8991 2.00527 9.97923C2.9643 11.0594 4.30056 11.7312 5.73954 11.8568C7.17852 11.9823 8.61095 11.552 9.74255 10.6543L12.3263 13.3974C11.4607 13.681 10.5751 13.8996 9.67693 14.0512L8.64693 14.2237C8.48902 14.2502 8.34731 14.3363 8.25102 14.4642C8.15473 14.5921 8.11121 14.7521 8.12943 14.9112C8.59893 19.124 10.2643 23.1145 12.9288 26.4112L9.7713 29.3756C8.64654 28.4683 7.21703 28.0262 5.77643 28.14C4.33584 28.2539 2.99355 28.9152 2.02534 29.988C1.05712 31.0607 0.536491 32.4636 0.570406 33.9083C0.604322 35.353 1.19021 36.7298 2.2077 37.756C3.22519 38.7821 4.59702 39.3797 6.04138 39.4258C7.48573 39.472 8.89292 38.9633 9.97387 38.0042C11.0548 37.0451 11.7274 35.7085 11.8535 34.2689C11.9796 32.8293 11.5497 31.3961 10.6519 30.2637L13.7376 27.3668C14.9423 28.7128 16.2843 29.9292 17.7419 30.9962L19.6301 32.3843C19.7393 32.4641 19.8714 32.5063 20.0066 32.5046C20.1418 32.503 20.2729 32.4574 20.3801 32.3749L22.7363 30.5524C23.9912 29.5851 25.1556 28.5056 26.2151 27.3274L29.3451 30.2649C28.4527 31.3921 28.0257 32.818 28.1519 34.2501C28.278 35.6821 28.9476 37.0115 30.0233 37.9653C31.0989 38.9191 32.4989 39.4248 33.9358 39.3787C35.3726 39.3325 36.7373 38.738 37.7495 37.7172C38.7617 36.6963 39.3446 35.3267 39.3786 33.8895C39.4126 32.4523 38.895 31.0567 37.9321 29.9891C36.9693 28.9216 35.6343 28.2633 34.2012 28.1493C32.7681 28.0353 31.3458 28.4743 30.2263 29.3762L27.0276 26.3762C29.6973 23.0978 31.3767 19.126 31.8688 14.9268V14.9112C31.8879 14.7516 31.8448 14.5908 31.7484 14.4622C31.652 14.3336 31.5098 14.2471 31.3513 14.2206L30.3213 14.0481C29.4231 13.8964 28.5375 13.6779 27.6719 13.3943L30.2557 10.6512C31.2477 11.4441 32.4801 11.8757 33.7501 11.8749ZM7.84755 10.3187C6.8217 10.7271 5.67841 10.7271 4.65255 10.3187V8.12495C4.65255 7.95919 4.7184 7.80022 4.83561 7.68301C4.95282 7.5658 5.11179 7.49995 5.27755 7.49995H7.22255C7.38831 7.49995 7.54728 7.5658 7.66449 7.68301C7.7817 7.80022 7.84755 7.95919 7.84755 8.12495V10.3187ZM5.4688 4.8612C5.4688 4.70668 5.51462 4.55563 5.60047 4.42716C5.68631 4.29868 5.80833 4.19855 5.95108 4.13942C6.09384 4.08029 6.25092 4.06481 6.40247 4.09496C6.55401 4.1251 6.69322 4.19951 6.80248 4.30877C6.91174 4.41803 6.98615 4.55724 7.01629 4.70878C7.04644 4.86033 7.03096 5.01741 6.97183 5.16017C6.9127 5.30292 6.81257 5.42494 6.68409 5.51078C6.55562 5.59663 6.40457 5.64245 6.25005 5.64245C6.0429 5.64228 5.84429 5.55992 5.69781 5.41344C5.55133 5.26696 5.46897 5.06835 5.4688 4.8612ZM9.09755 9.56245V8.12495C9.09566 7.70686 8.95409 7.30139 8.69533 6.97299C8.43657 6.64459 8.07548 6.41209 7.66943 6.31245C7.95826 6.03031 8.15646 5.66848 8.23871 5.27318C8.32096 4.87787 8.28353 4.46702 8.13121 4.09309C7.97888 3.71915 7.71856 3.3991 7.3835 3.17379C7.04843 2.94848 6.65382 2.82815 6.25005 2.82815C5.84628 2.82815 5.45167 2.94848 5.11661 3.17379C4.78154 3.3991 4.52123 3.71915 4.3689 4.09309C4.21657 4.46702 4.17914 4.87787 4.26139 5.27318C4.34364 5.66848 4.54184 6.03031 4.83068 6.31245C4.42463 6.41209 4.06353 6.64459 3.80477 6.97299C3.54602 7.30139 3.40444 7.70686 3.40255 8.12495V9.56245C2.72391 8.98066 2.23977 8.20495 2.01527 7.33971C1.79078 6.47447 1.8367 5.56123 2.14687 4.72288C2.45704 3.88453 3.01656 3.1613 3.75014 2.65053C4.48373 2.13976 5.35617 1.86595 6.25005 1.86595C7.14394 1.86595 8.01638 2.13976 8.74996 2.65053C9.48354 3.1613 10.0431 3.88453 10.3532 4.72288C10.6634 5.56123 10.7093 6.47447 10.4848 7.33971C10.2603 8.20495 9.77619 8.98066 9.09755 9.56245ZM7.84755 37.8168C6.8217 38.2252 5.67841 38.2252 4.65255 37.8168V35.6249C4.65255 35.4592 4.7184 35.3002 4.83561 35.183C4.95282 35.0658 5.11179 34.9999 5.27755 34.9999H7.22255C7.38831 34.9999 7.54728 35.0658 7.66449 35.183C7.7817 35.3002 7.84755 35.4592 7.84755 35.6249V37.8168ZM5.4688 32.3612C5.4688 32.2067 5.51462 32.0556 5.60047 31.9272C5.68631 31.7987 5.80833 31.6985 5.95108 31.6394C6.09384 31.5803 6.25092 31.5648 6.40247 31.595C6.55401 31.6251 6.69322 31.6995 6.80248 31.8088C6.91174 31.918 6.98615 32.0572 7.01629 32.2088C7.04644 32.3603 7.03096 32.5174 6.97183 32.6602C6.9127 32.8029 6.81257 32.9249 6.68409 33.0108C6.55562 33.0966 6.40457 33.1424 6.25005 33.1424C6.0429 33.1423 5.84429 33.0599 5.69781 32.9134C5.55133 32.767 5.46897 32.5683 5.4688 32.3612ZM9.09755 37.0624V35.6249C9.09566 35.2069 8.95409 34.8014 8.69533 34.473C8.43657 34.1446 8.07548 33.9121 7.66943 33.8124C7.95826 33.5303 8.15646 33.1685 8.23871 32.7732C8.32096 32.3779 8.28353 31.967 8.13121 31.5931C7.97888 31.2192 7.71856 30.8991 7.3835 30.6738C7.04843 30.4485 6.65382 30.3281 6.25005 30.3281C5.84628 30.3281 5.45167 30.4485 5.11661 30.6738C4.78154 30.8991 4.52123 31.2192 4.3689 31.5931C4.21657 31.967 4.17914 32.3779 4.26139 32.7732C4.34364 33.1685 4.54184 33.5303 4.83068 33.8124C4.42463 33.9121 4.06353 34.1446 3.80477 34.473C3.54602 34.8014 3.40444 35.2069 3.40255 35.6249V37.0624C2.72391 36.4807 2.23977 35.7049 2.01527 34.8397C1.79078 33.9745 1.8367 33.0612 2.14687 32.2229C2.45704 31.3845 3.01656 30.6613 3.75014 30.1505C4.48373 29.6398 5.35617 29.3659 6.25005 29.3659C7.14394 29.3659 8.01638 29.6398 8.74996 30.1505C9.48354 30.6613 10.0431 31.3845 10.3532 32.2229C10.6634 33.0612 10.7093 33.9745 10.4848 34.8397C10.2603 35.7049 9.77619 36.4807 9.09755 37.0624ZM35.3476 37.8168C34.3217 38.2252 33.1784 38.2252 32.1526 37.8168V35.6249C32.1526 35.4592 32.2184 35.3002 32.3356 35.183C32.4528 35.0658 32.6118 34.9999 32.7776 34.9999H34.7226C34.8883 34.9999 35.0473 35.0658 35.1645 35.183C35.2817 35.3002 35.3476 35.4592 35.3476 35.6249V37.8168ZM32.9688 32.3612C32.9688 32.2067 33.0146 32.0556 33.1005 31.9272C33.1863 31.7987 33.3083 31.6985 33.4511 31.6394C33.5938 31.5803 33.7509 31.5648 33.9025 31.595C34.054 31.6251 34.1932 31.6995 34.3025 31.8088C34.4117 31.918 34.4861 32.0572 34.5163 32.2088C34.5464 32.3603 34.531 32.5174 34.4718 32.6602C34.4127 32.8029 34.3126 32.9249 34.1841 33.0108C34.0556 33.0966 33.9046 33.1424 33.7501 33.1424C33.5429 33.1423 33.3443 33.0599 33.1978 32.9134C33.0513 32.767 32.969 32.5683 32.9688 32.3612ZM33.7501 29.3749C34.6432 29.3743 35.515 29.6474 36.2482 30.1573C36.9814 30.6672 37.5408 31.3896 37.851 32.2271C38.1612 33.0645 38.2074 33.977 37.9833 34.8415C37.7592 35.706 37.2756 36.4811 36.5976 37.0624V35.6249C36.5957 35.2069 36.4541 34.8014 36.1953 34.473C35.9366 34.1446 35.5755 33.9121 35.1694 33.8124C35.4583 33.5303 35.6565 33.1685 35.7387 32.7732C35.821 32.3779 35.7835 31.967 35.6312 31.5931C35.4789 31.2192 35.2186 30.8991 34.8835 30.6738C34.5484 30.4485 34.1538 30.3281 33.7501 30.3281C33.3463 30.3281 32.9517 30.4485 32.6166 30.6738C32.2815 30.8991 32.0212 31.2192 31.8689 31.5931C31.7166 31.967 31.6791 32.3779 31.7614 32.7732C31.8436 33.1685 32.0418 33.5303 32.3307 33.8124C31.9246 33.9121 31.5635 34.1446 31.3048 34.473C31.046 34.8014 30.9044 35.2069 30.9026 35.6249V37.0624C30.2246 36.4811 29.741 35.706 29.5169 34.8415C29.2928 33.977 29.3389 33.0645 29.6491 32.2271C29.9593 31.3896 30.5187 30.6672 31.2519 30.1573C31.9851 29.6474 32.857 29.3743 33.7501 29.3749ZM30.1169 15.2806L30.5544 15.3537C29.7351 20.9424 26.7788 25.8437 21.9763 29.5574L19.9932 31.0924L18.4813 29.9837C13.3907 26.2418 10.2757 21.1931 9.4463 15.3537L9.8838 15.2806C13.6823 14.6505 17.2054 12.8986 20.0001 10.2499C22.7949 12.8987 26.3182 14.6507 30.1169 15.2806ZM35.3476 10.3187C34.3217 10.7271 33.1784 10.7271 32.1526 10.3187V8.12495C32.1526 7.95919 32.2184 7.80022 32.3356 7.68301C32.4528 7.5658 32.6118 7.49995 32.7776 7.49995H34.7226C34.8883 7.49995 35.0473 7.5658 35.1645 7.68301C35.2817 7.80022 35.3476 7.95919 35.3476 8.12495V10.3187ZM32.9688 4.8612C32.9688 4.70668 33.0146 4.55563 33.1005 4.42716C33.1863 4.29868 33.3083 4.19855 33.4511 4.13942C33.5938 4.08029 33.7509 4.06481 33.9025 4.09496C34.054 4.1251 34.1932 4.19951 34.3025 4.30877C34.4117 4.41803 34.4861 4.55724 34.5163 4.70878C34.5464 4.86033 34.531 5.01741 34.4718 5.16017C34.4127 5.30292 34.3126 5.42494 34.1841 5.51078C34.0556 5.59663 33.9046 5.64245 33.7501 5.64245C33.5429 5.64228 33.3443 5.55992 33.1978 5.41344C33.0513 5.26696 32.969 5.06835 32.9688 4.8612ZM33.7501 1.87495C34.6432 1.87433 35.515 2.14737 36.2482 2.6573C36.9814 3.16723 37.5408 3.88956 37.851 4.72705C38.1612 5.56454 38.2074 6.47697 37.9833 7.3415C37.7592 8.20602 37.2756 8.98112 36.5976 9.56245V8.12495C36.5957 7.70686 36.4541 7.30139 36.1953 6.97299C35.9366 6.64459 35.5755 6.41209 35.1694 6.31245C35.4583 6.03031 35.6565 5.66848 35.7387 5.27318C35.821 4.87787 35.7835 4.46702 35.6312 4.09309C35.4789 3.71915 35.2186 3.3991 34.8835 3.17379C34.5484 2.94848 34.1538 2.82815 33.7501 2.82815C33.3463 2.82815 32.9517 2.94848 32.6166 3.17379C32.2815 3.3991 32.0212 3.71915 31.8689 4.09309C31.7166 4.46702 31.6791 4.87787 31.7614 5.27318C31.8436 5.66848 32.0418 6.03031 32.3307 6.31245C31.9246 6.41209 31.5635 6.64459 31.3048 6.97299C31.046 7.30139 30.9044 7.70686 30.9026 8.12495V9.56245C30.2246 8.98112 29.741 8.20602 29.5169 7.3415C29.2928 6.47697 29.3389 5.56454 29.6491 4.72705C29.9593 3.88956 30.5187 3.16723 31.2519 2.6573C31.9851 2.14737 32.857 1.87433 33.7501 1.87495Z"
                            fill="black"/>
                        <defs>
                            <clippath id="clip0_108_15099">
                                <rect width="40" height="40" fill="white"/>
                            </clippath>
                        </defs>
                    </svg>

                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                <span class="panther-txt">Data privacy</span>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                <p>We value each and every member of our community and keep this data safe</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
                <div class="kf-img">
                    <svg
                        width="35"
                        height="35"
                        viewbox="0 0 40 40"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M24.6166 9.78333C24.9993 10.0006 25.4524 10.0577 25.8771 9.9422C26.3017 9.82667 26.6634 9.54788 26.8833 9.16667C27.0652 8.84559 27.3486 8.59399 27.6889 8.4513C28.0292 8.30861 28.4073 8.28292 28.7638 8.37824C29.1203 8.47357 29.4351 8.68452 29.6588 8.97802C29.8826 9.27152 30.0025 9.63097 29.9999 10C29.9999 10.442 29.8244 10.8659 29.5118 11.1785C29.1992 11.4911 28.7753 11.6667 28.3333 11.6667C27.8913 11.6667 27.4673 11.8423 27.1548 12.1548C26.8422 12.4674 26.6666 12.8913 26.6666 13.3333C26.6666 13.7754 26.8422 14.1993 27.1548 14.5118C27.4673 14.8244 27.8913 15 28.3333 15C29.2108 14.9994 30.0728 14.7679 30.8325 14.3287C31.5922 13.8895 32.223 13.2581 32.6614 12.4979C33.0998 11.7377 33.3304 10.8755 33.3301 9.998C33.3297 9.12045 33.0984 8.25845 32.6594 7.49861C32.2204 6.73877 31.5891 6.10786 30.829 5.66927C30.069 5.23068 29.2068 4.99986 28.3293 5C27.4517 5.00014 26.5897 5.23124 25.8297 5.67007C25.0698 6.10891 24.4387 6.74002 23.9999 7.5C23.8897 7.69022 23.8183 7.90037 23.7896 8.11833C23.761 8.3363 23.7758 8.55777 23.8331 8.77C23.8904 8.98224 23.9891 9.18104 24.1236 9.35495C24.2581 9.52886 24.4256 9.67445 24.6166 9.78333ZM31.7833 21.6667C31.3458 21.6099 30.9036 21.7289 30.5537 21.9976C30.2038 22.2662 29.9747 22.6627 29.9166 23.1C29.5669 25.9253 28.1962 28.5252 26.0627 30.41C23.9292 32.2948 21.1801 33.3346 18.3333 33.3333H9.01661L10.0999 32.25C10.4104 31.9377 10.5846 31.5153 10.5846 31.075C10.5846 30.6347 10.4104 30.2123 10.0999 29.9C8.47486 28.2685 7.36892 26.1926 6.92144 23.9338C6.47395 21.6749 6.70493 19.3342 7.58528 17.2064C8.46563 15.0786 9.95598 13.2589 11.8686 11.9765C13.7812 10.6941 16.0306 10.0064 18.3333 10C18.7753 10 19.1992 9.8244 19.5118 9.51184C19.8244 9.19928 19.9999 8.77536 19.9999 8.33333C19.9999 7.8913 19.8244 7.46738 19.5118 7.15482C19.1992 6.84226 18.7753 6.66667 18.3333 6.66667C15.5153 6.67842 12.7577 7.48373 10.3763 8.99032C7.99486 10.4969 6.086 12.6439 4.86839 15.1852C3.65077 17.7265 3.17365 20.5595 3.49169 23.3594C3.80973 26.1594 4.91005 28.8132 6.66661 31.0167L3.81661 33.8167C3.58535 34.051 3.42869 34.3487 3.3664 34.672C3.30411 34.9953 3.33898 35.3298 3.46661 35.6333C3.59165 35.9377 3.80398 36.1982 4.07684 36.3821C4.34971 36.566 4.67091 36.665 4.99995 36.6667H18.3333C21.9857 36.6672 25.5128 35.335 28.253 32.9201C30.9931 30.5052 32.758 27.1735 33.2166 23.55C33.2471 23.3321 33.2341 23.1103 33.1785 22.8974C33.1228 22.6846 33.0255 22.4848 32.8923 22.3097C32.759 22.1347 32.5924 21.9877 32.4021 21.8773C32.2117 21.7669 32.0014 21.6953 31.7833 21.6667ZM28.9666 16.7833C28.6632 16.6491 28.3266 16.6085 27.9999 16.6667L27.6999 16.7667L27.4 16.9167L27.15 17.1333C27 17.2869 26.8812 17.468 26.7999 17.6667C26.7014 17.8746 26.6556 18.1035 26.6666 18.3333C26.6618 18.5556 26.7014 18.7766 26.7833 18.9833C26.8695 19.1834 26.9941 19.3646 27.15 19.5167C27.3057 19.6711 27.4904 19.7933 27.6934 19.8763C27.8965 19.9592 28.1139 20.0013 28.3333 20C28.7753 20 29.1992 19.8244 29.5118 19.5118C29.8244 19.1993 29.9999 18.7754 29.9999 18.3333C30.0056 18.1147 29.9599 17.8978 29.8666 17.7C29.6875 17.2995 29.3671 16.9791 28.9666 16.8V16.7833Z"
                            fill="black"/>
                    </svg>

                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                <span class="panther-txt">Support</span>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                <p>We strive to be there for you 24/7, helping you along every step of your
                    crypto trading journey
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
                <div class="kf-img">
                    <svg
                        width="35"
                        height="35"
                        viewbox="0 0 40 40"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M39.5456 34.0359L35.7581 30.9109C35.7102 30.8725 35.6595 30.8376 35.6065 30.8066C35.6171 30.7466 35.6233 30.6859 35.625 30.625V15C35.625 14.6685 35.4933 14.3505 35.2588 14.1161C35.0244 13.8817 34.7065 13.75 34.375 13.75H33.125V5.625C33.1244 5.1279 32.9267 4.65132 32.5751 4.29981C32.2236 3.94831 31.7471 3.75058 31.25 3.75H8.74996C8.25286 3.75058 7.77628 3.94831 7.42477 4.29981C7.07327 4.65132 6.87554 5.1279 6.87496 5.625V13.75H5.62496C5.29344 13.75 4.9755 13.8817 4.74108 14.1161C4.50666 14.3505 4.37496 14.6685 4.37496 15V30.625C4.37663 30.6859 4.38279 30.7466 4.3934 30.8066C4.34038 30.8376 4.28972 30.8725 4.24183 30.9109L0.454335 34.0359C0.255823 34.1998 0.112728 34.4209 0.0445926 34.6691C-0.0235427 34.9173 -0.0133958 35.1805 0.0736476 35.4227C0.160691 35.6649 0.320387 35.8744 0.530923 36.0225C0.741459 36.1705 0.992571 36.25 1.24996 36.25H38.75C39.0073 36.25 39.2585 36.1705 39.469 36.0225C39.6795 35.8744 39.8392 35.6649 39.9263 35.4227C40.0133 35.1805 40.0235 34.9173 39.9553 34.6691C39.8872 34.4209 39.7441 34.1998 39.5456 34.0359ZM8.12496 5.625C8.12521 5.45932 8.19113 5.30049 8.30829 5.18333C8.42545 5.06618 8.58428 5.00025 8.74996 5H31.25C31.4156 5.00025 31.5745 5.06618 31.6916 5.18333C31.8088 5.30049 31.8747 5.45932 31.875 5.625V8.75H8.12496V5.625ZM5.62496 15H6.87496V28.75C6.87496 28.9158 6.94081 29.0747 7.05802 29.1919C7.17523 29.3092 7.3342 29.375 7.49996 29.375C7.66572 29.375 7.82469 29.3092 7.9419 29.1919C8.05911 29.0747 8.12496 28.9158 8.12496 28.75V10H31.875V28.75C31.875 28.9158 31.9408 29.0747 32.058 29.1919C32.1752 29.3092 32.3342 29.375 32.5 29.375C32.6657 29.375 32.8247 29.3092 32.9419 29.1919C33.0591 29.0747 33.125 28.9158 33.125 28.75V15H34.375V30.625H5.62496V15ZM1.24996 35L5.03746 31.875H34.9625L38.75 35H1.24996Z"
                            fill="black"/>
                        <path
                            d="M30 6.25H28.75C28.5842 6.25 28.4253 6.31585 28.3081 6.43306C28.1908 6.55027 28.125 6.70924 28.125 6.875C28.125 7.04076 28.1908 7.19973 28.3081 7.31694C28.4253 7.43415 28.5842 7.5 28.75 7.5H30C30.1658 7.5 30.3247 7.43415 30.4419 7.31694C30.5592 7.19973 30.625 7.04076 30.625 6.875C30.625 6.70924 30.5592 6.55027 30.4419 6.43306C30.3247 6.31585 30.1658 6.25 30 6.25ZM26.25 6.25H25C24.8342 6.25 24.6753 6.31585 24.5581 6.43306C24.4408 6.55027 24.375 6.70924 24.375 6.875C24.375 7.04076 24.4408 7.19973 24.5581 7.31694C24.6753 7.43415 24.8342 7.5 25 7.5H26.25C26.4158 7.5 26.5747 7.43415 26.6919 7.31694C26.8092 7.19973 26.875 7.04076 26.875 6.875C26.875 6.70924 26.8092 6.55027 26.6919 6.43306C26.5747 6.31585 26.4158 6.25 26.25 6.25ZM30 11.875H18.125C17.9592 11.875 17.8003 11.9408 17.6831 12.0581C17.5658 12.1753 17.5 12.3342 17.5 12.5C17.5 12.6658 17.5658 12.8247 17.6831 12.9419C17.8003 13.0592 17.9592 13.125 18.125 13.125H30C30.1658 13.125 30.3247 13.0592 30.4419 12.9419C30.5592 12.8247 30.625 12.6658 30.625 12.5C30.625 12.3342 30.5592 12.1753 30.4419 12.0581C30.3247 11.9408 30.1658 11.875 30 11.875ZM18.125 15.625H22.8125C22.9783 15.625 23.1372 15.5592 23.2544 15.4419C23.3717 15.3247 23.4375 15.1658 23.4375 15C23.4375 14.8342 23.3717 14.6753 23.2544 14.5581C23.1372 14.4408 22.9783 14.375 22.8125 14.375H18.125C17.9592 14.375 17.8003 14.4408 17.6831 14.5581C17.5658 14.6753 17.5 14.8342 17.5 15C17.5 15.1658 17.5658 15.3247 17.6831 15.4419C17.8003 15.5592 17.9592 15.625 18.125 15.625ZM26.875 14.375H25.3125C25.1467 14.375 24.9878 14.4408 24.8706 14.5581C24.7533 14.6753 24.6875 14.8342 24.6875 15C24.6875 15.1658 24.7533 15.3247 24.8706 15.4419C24.9878 15.5592 25.1467 15.625 25.3125 15.625H26.875C27.0408 15.625 27.1997 15.5592 27.3169 15.4419C27.4342 15.3247 27.5 15.1658 27.5 15C27.5 14.8342 27.4342 14.6753 27.3169 14.5581C27.1997 14.4408 27.0408 14.375 26.875 14.375ZM25.625 18.75C25.625 18.9158 25.6908 19.0747 25.8081 19.1919C25.9253 19.3092 26.0842 19.375 26.25 19.375H27.8125C27.9783 19.375 28.1372 19.3092 28.2544 19.1919C28.3717 19.0747 28.4375 18.9158 28.4375 18.75C28.4375 18.5842 28.3717 18.4253 28.2544 18.3081C28.1372 18.1908 27.9783 18.125 27.8125 18.125H26.25C26.0842 18.125 25.9253 18.1908 25.8081 18.3081C25.6908 18.4253 25.625 18.5842 25.625 18.75ZM10 16.25C10.1658 16.25 10.3247 16.1842 10.4419 16.0669C10.5592 15.9497 10.625 15.7908 10.625 15.625V12.5H14.375C14.5408 12.5 14.6997 12.4342 14.8169 12.3169C14.9342 12.1997 15 12.0408 15 11.875C15 11.7092 14.9342 11.5503 14.8169 11.4331C14.6997 11.3158 14.5408 11.25 14.375 11.25H10C9.83424 11.25 9.67527 11.3158 9.55806 11.4331C9.44085 11.5503 9.375 11.7092 9.375 11.875V15.625C9.375 15.7908 9.44085 15.9497 9.55806 16.0669C9.67527 16.1842 9.83424 16.25 10 16.25ZM18.125 19.375H23.75C23.9158 19.375 24.0747 19.3092 24.1919 19.1919C24.3092 19.0747 24.375 18.9158 24.375 18.75C24.375 18.5842 24.3092 18.4253 24.1919 18.3081C24.0747 18.1908 23.9158 18.125 23.75 18.125H18.125C17.9592 18.125 17.8003 18.1908 17.6831 18.3081C17.5658 18.4253 17.5 18.5842 17.5 18.75C17.5 18.9158 17.5658 19.0747 17.6831 19.1919C17.8003 19.3092 17.9592 19.375 18.125 19.375ZM18.125 21.875H29.6875C29.8533 21.875 30.0122 21.8092 30.1294 21.6919C30.2467 21.5747 30.3125 21.4158 30.3125 21.25C30.3125 21.0842 30.2467 20.9253 30.1294 20.8081C30.0122 20.6908 29.8533 20.625 29.6875 20.625H18.125C17.9592 20.625 17.8003 20.6908 17.6831 20.8081C17.5658 20.9253 17.5 21.0842 17.5 21.25C17.5 21.4158 17.5658 21.5747 17.6831 21.6919C17.8003 21.8092 17.9592 21.875 18.125 21.875ZM10 22.5C10.1658 22.5 10.3247 22.4342 10.4419 22.3169C10.5592 22.1997 10.625 22.0408 10.625 21.875V18.75H14.375C14.5408 18.75 14.6997 18.6842 14.8169 18.5669C14.9342 18.4497 15 18.2908 15 18.125C15 17.9592 14.9342 17.8003 14.8169 17.6831C14.6997 17.5658 14.5408 17.5 14.375 17.5H10C9.83424 17.5 9.67527 17.5658 9.55806 17.6831C9.44085 17.8003 9.375 17.9592 9.375 18.125V21.875C9.375 22.0408 9.44085 22.1997 9.55806 22.3169C9.67527 22.4342 9.83424 22.5 10 22.5ZM30 24.375H18.125C17.9592 24.375 17.8003 24.4408 17.6831 24.5581C17.5658 24.6753 17.5 24.8342 17.5 25C17.5 25.1658 17.5658 25.3247 17.6831 25.4419C17.8003 25.5592 17.9592 25.625 18.125 25.625H30C30.1658 25.625 30.3247 25.5592 30.4419 25.4419C30.5592 25.3247 30.625 25.1658 30.625 25C30.625 24.8342 30.5592 24.6753 30.4419 24.5581C30.3247 24.4408 30.1658 24.375 30 24.375ZM26.875 26.875H18.125C17.9592 26.875 17.8003 26.9408 17.6831 27.0581C17.5658 27.1753 17.5 27.3342 17.5 27.5C17.5 27.6658 17.5658 27.8247 17.6831 27.9419C17.8003 28.0592 17.9592 28.125 18.125 28.125H26.875C27.0408 28.125 27.1997 28.0592 27.3169 27.9419C27.4342 27.8247 27.5 27.6658 27.5 27.5C27.5 27.3342 27.4342 27.1753 27.3169 27.0581C27.1997 26.9408 27.0408 26.875 26.875 26.875ZM15 24.375C15 24.2092 14.9342 24.0503 14.8169 23.9331C14.6997 23.8158 14.5408 23.75 14.375 23.75H10C9.83424 23.75 9.67527 23.8158 9.55806 23.9331C9.44085 24.0503 9.375 24.2092 9.375 24.375V28.125C9.375 28.2908 9.44085 28.4497 9.55806 28.5669C9.67527 28.6842 9.83424 28.75 10 28.75C10.1658 28.75 10.3247 28.6842 10.4419 28.5669C10.5592 28.4497 10.625 28.2908 10.625 28.125V25H14.375C14.5408 25 14.6997 24.9342 14.8169 24.8169C14.9342 24.6997 15 24.5408 15 24.375Z"
                            fill="black"/>
                        <path
                            d="M15.1831 12.3705L13.125 14.4286L12.3169 13.6205C12.199 13.5067 12.0411 13.4437 11.8773 13.4451C11.7134 13.4465 11.5566 13.5122 11.4407 13.6281C11.3249 13.744 11.2591 13.9008 11.2577 14.0646C11.2563 14.2285 11.3193 14.3864 11.4331 14.5043L12.6831 15.7543C12.8003 15.8714 12.9593 15.9373 13.125 15.9373C13.2907 15.9373 13.4497 15.8714 13.5669 15.7543L16.0669 13.2543C16.1807 13.1364 16.2437 12.9785 16.2423 12.8146C16.2409 12.6508 16.1752 12.494 16.0593 12.3781C15.9434 12.2622 15.7866 12.1965 15.6228 12.1951C15.4589 12.1937 15.301 12.2567 15.1831 12.3705ZM15.1831 18.6205L13.125 20.6786L12.3169 19.8705C12.199 19.7567 12.0411 19.6937 11.8773 19.6951C11.7134 19.6965 11.5566 19.7622 11.4407 19.8781C11.3249 19.994 11.2591 20.1508 11.2577 20.3146C11.2563 20.4785 11.3193 20.6364 11.4331 20.7543L12.6831 22.0043C12.8003 22.1214 12.9593 22.1873 13.125 22.1873C13.2907 22.1873 13.4497 22.1214 13.5669 22.0043L16.0669 19.5043C16.1807 19.3864 16.2437 19.2285 16.2423 19.0646C16.2409 18.9008 16.1752 18.744 16.0593 18.6281C15.9434 18.5122 15.7866 18.4465 15.6228 18.4451C15.4589 18.4437 15.301 18.5067 15.1831 18.6205ZM15.1831 24.8705L13.125 26.9286L12.3169 26.1205C12.199 26.0067 12.0411 25.9437 11.8773 25.9451C11.7134 25.9465 11.5566 26.0122 11.4407 26.1281C11.3249 26.244 11.2591 26.4008 11.2577 26.5646C11.2563 26.7285 11.3193 26.8864 11.4331 27.0043L12.6831 28.2543C12.8003 28.3714 12.9593 28.4373 13.125 28.4373C13.2907 28.4373 13.4497 28.3714 13.5669 28.2543L16.0669 25.7543C16.1807 25.6364 16.2437 25.4785 16.2423 25.3146C16.2409 25.1508 16.1752 24.994 16.0593 24.8781C15.9434 24.7622 15.7866 24.6965 15.6228 24.6951C15.4589 24.6937 15.301 24.7567 15.1831 24.8705Z"
                            fill="black"/>
                    </svg>

                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                <span class="panther-txt">Features</span>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                <p>Unmatched liquidity, early access to most wanted altcoins, crypto demo
                    trading, play to earn games, amazing community, and much more…</p>
            </div>
        </div>

    </div>
</section>

<section class="started-section-txt">
    <div class="contain-width">
        <h3 class="start-txt">Get started in minutes</h3>
        <div class="row">
            <div class="col-sm-4 col-md-4 col-xl-4 col-lg-4 step-cnt">
                <div class="start-img">
                    <svg
                        width="110"
                        height="110"
                        viewbox="0 0 110 110"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="55" cy="55" r="55" fill="url(#paint0_linear_108_15280)"/>
                        <path
                            d="M69 27H41C39.4087 27 37.8826 27.6321 36.7574 28.7574C35.6321 29.8826 35 31.4087 35 33V71C35 72.5913 35.6321 74.1174 36.7574 75.2426C37.8826 76.3679 39.4087 77 41 77H51V81C50.9999 81.3169 51.0752 81.6293 51.2195 81.9114C51.3638 82.1935 51.5731 82.4373 51.8302 82.6227C52.0872 82.808 52.3846 82.9297 52.6979 82.9775C53.0112 83.0254 53.3313 82.9981 53.632 82.898L59 81.098L64.368 82.898C64.5719 82.9654 64.7853 82.9998 65 83C65.5304 83 66.0391 82.7893 66.4142 82.4142C66.7893 82.0391 67 81.5304 67 81V77H69C70.5913 77 72.1174 76.3679 73.2426 75.2426C74.3679 74.1174 75 72.5913 75 71V33C75 31.4087 74.3679 29.8826 73.2426 28.7574C72.1174 27.6321 70.5913 27 69 27ZM63 78.226L60.266 77.314C59.4439 77.042 58.5561 77.042 57.734 77.314L55 78.226V69.888C56.2074 70.6156 57.5903 71 59 71C60.4097 71 61.7926 70.6156 63 69.888V78.226ZM55 63C55 62.2089 55.2346 61.4355 55.6741 60.7777C56.1136 60.1199 56.7384 59.6072 57.4693 59.3045C58.2002 59.0017 59.0044 58.9225 59.7804 59.0769C60.5563 59.2312 61.269 59.6122 61.8284 60.1716C62.3878 60.731 62.7688 61.4437 62.9231 62.2196C63.0775 62.9956 62.9983 63.7998 62.6955 64.5307C62.3928 65.2616 61.8801 65.8864 61.2223 66.3259C60.5645 66.7654 59.7911 67 59 67C57.9391 67 56.9217 66.5786 56.1716 65.8284C55.4214 65.0783 55 64.0609 55 63ZM71 71C71 71.5304 70.7893 72.0391 70.4142 72.4142C70.0391 72.7893 69.5304 73 69 73H67V63C67 60.8783 66.1571 58.8434 64.6569 57.3431C63.1566 55.8429 61.1217 55 59 55C56.8783 55 54.8434 55.8429 53.3431 57.3431C51.8429 58.8434 51 60.8783 51 63V73H41C40.4696 73 39.9609 72.7893 39.5858 72.4142C39.2107 72.0391 39 71.5304 39 71V33C39 32.4696 39.2107 31.9609 39.5858 31.5858C39.9609 31.2107 40.4696 31 41 31H69C69.5304 31 70.0391 31.2107 70.4142 31.5858C70.7893 31.9609 71 32.4696 71 33V71Z"
                            fill="black"/>
                        <path
                            d="M65 37H45C44.4696 37 43.9609 37.2107 43.5858 37.5858C43.2107 37.9609 43 38.4696 43 39C43 39.5304 43.2107 40.0391 43.5858 40.4142C43.9609 40.7893 44.4696 41 45 41H65C65.5304 41 66.0391 40.7893 66.4142 40.4142C66.7893 40.0391 67 39.5304 67 39C67 38.4696 66.7893 37.9609 66.4142 37.5858C66.0391 37.2107 65.5304 37 65 37ZM65 45H45C44.4696 45 43.9609 45.2107 43.5858 45.5858C43.2107 45.9609 43 46.4696 43 47C43 47.5304 43.2107 48.0391 43.5858 48.4142C43.9609 48.7893 44.4696 49 45 49H65C65.5304 49 66.0391 48.7893 66.4142 48.4142C66.7893 48.0391 67 47.5304 67 47C67 46.4696 66.7893 45.9609 66.4142 45.5858C66.0391 45.2107 65.5304 45 65 45Z"
                            fill="black"/>
                        <defs>
                            <lineargradient
                                id="paint0_linear_108_15280"
                                x1="-5.40052"
                                y1="5.12199e-07"
                                x2="123.196"
                                y2="45.651"
                                gradientunits="userSpaceOnUse">
                                <stop stop-color="#01FFFF"/>
                                <stop offset="1" stop-color="#019094"/>
                            </lineargradient>
                        </defs>
                    </svg>
                    <div class="line">
                        <svg
                            width="220"
                            height="12"
                            viewbox="0 0 220 12"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.666667 6C0.666667 8.94552 3.05448 11.3333 6 11.3333C8.94552 11.3333 11.3333 8.94552 11.3333 6C11.3333 3.05448 8.94552 0.666667 6 0.666667C3.05448 0.666667 0.666667 3.05448 0.666667 6ZM208.667 6C208.667 8.94552 211.054 11.3333 214 11.3333C216.946 11.3333 219.333 8.94552 219.333 6C219.333 3.05448 216.946 0.666667 214 0.666667C211.054 0.666667 208.667 3.05448 208.667 6ZM6 7H8V5H6V7ZM12 7H16V5H12V7ZM20 7H24V5H20V7ZM28 7H32V5H28V7ZM36 7H40V5H36V7ZM44 7H48V5H44V7ZM52 7H56V5H52V7ZM60 7H64V5H60V7ZM68 7H72V5H68V7ZM76 7H80V5H76V7ZM84 7H88V5H84V7ZM92 7H96V5H92V7ZM100 7H104V5H100V7ZM108 7H112V5H108V7ZM116 7H120V5H116V7ZM124 7H128V5H124V7ZM132 7H136V5H132V7ZM140 7H144V5H140V7ZM148 7H152V5H148V7ZM156 7H160V5H156V7ZM164 7H168V5H164V7ZM172 7H176V5H172V7ZM180 7H184V5H180V7ZM188 7H192V5H188V7ZM196 7H200V5H196V7ZM204 7H208V5H204V7ZM212 7H214V5H212V7Z"
                                fill="black"
                                fill-opacity="0.5"/>
                        </svg>
                    </div>
                </div>
                <p class="step-txt">Step 1</p>
                <h4>Register</h4>
                <p class="start-para">Create Your trade account on Panther Exchange in a few simple clicks</p>
            </div>
            <div class="col-sm-4 col-md-4 col-xl-4 col-lg-4 step-cnt">
                <div class="start-img">
                    <svg
                        width="110"
                        height="110"
                        viewbox="0 0 110 110"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="55" cy="55" r="55" fill="url(#paint0_linear_108_15290)"/>
                        <path
                            d="M73.6666 79.6666H31C29.7628 79.6651 28.5767 79.1729 27.7018 78.2981C26.827 77.4232 26.3348 76.2371 26.3333 74.9999V34.9999C26.3348 33.7627 26.827 32.5766 27.7018 31.7017C28.5767 30.8269 29.7628 30.3348 31 30.3333H73.6666C74.9039 30.3348 76.09 30.8269 76.9648 31.7017C77.8397 32.5766 78.3318 33.7627 78.3333 34.9999V46.9999C78.3333 47.5304 78.1226 48.0391 77.7475 48.4141C77.3725 48.7892 76.8637 48.9999 76.3333 48.9999C75.8029 48.9999 75.2942 48.7892 74.9191 48.4141C74.544 48.0391 74.3333 47.5304 74.3333 46.9999V34.9999C74.3312 34.8238 74.2603 34.6554 74.1358 34.5308C74.0112 34.4062 73.8428 34.3353 73.6666 34.3333H31C30.8238 34.3353 30.6554 34.4062 30.5309 34.5308C30.4063 34.6554 30.3354 34.8238 30.3333 34.9999V74.9999C30.3354 75.1761 30.4063 75.3444 30.5309 75.469C30.6554 75.5936 30.8238 75.6645 31 75.6666H73.6666C73.8428 75.6645 74.0112 75.5936 74.1358 75.469C74.2603 75.3444 74.3312 75.1761 74.3333 74.9999V62.9999C74.3333 62.4695 74.544 61.9608 74.9191 61.5857C75.2942 61.2106 75.8029 60.9999 76.3333 60.9999C76.8637 60.9999 77.3725 61.2106 77.7475 61.5857C78.1226 61.9608 78.3333 62.4695 78.3333 62.9999V74.9999C78.3318 76.2371 77.8397 77.4232 76.9648 78.2981C76.09 79.1729 74.9039 79.6651 73.6666 79.6666Z"
                            fill="black"/>
                        <path
                            d="M59 57.6666C60.4727 57.6666 61.6666 56.4727 61.6666 54.9999C61.6666 53.5272 60.4727 52.3333 59 52.3333C57.5272 52.3333 56.3333 53.5272 56.3333 54.9999C56.3333 56.4727 57.5272 57.6666 59 57.6666Z"
                            fill="black"/>
                        <path
                            d="M80.3333 65H57.6666C55.0145 65 52.4709 63.9464 50.5956 62.0711C48.7202 60.1957 47.6666 57.6522 47.6666 55C47.6666 52.3478 48.7202 49.8043 50.5956 47.9289C52.4709 46.0536 55.0145 45 57.6666 45H68.3333C68.8637 45 69.3724 45.2107 69.7475 45.5858C70.1226 45.9609 70.3333 46.4696 70.3333 47C70.3333 47.5304 70.1226 48.0391 69.7475 48.4142C69.3724 48.7893 68.8637 49 68.3333 49H57.6666C56.0753 49 54.5492 49.6321 53.424 50.7574C52.2988 51.8826 51.6666 53.4087 51.6666 55C51.6666 56.5913 52.2988 58.1174 53.424 59.2426C54.5492 60.3679 56.0753 61 57.6666 61H79.6666V49H76.3333C75.8029 49 75.2942 48.7893 74.9191 48.4142C74.544 48.0391 74.3333 47.5304 74.3333 47C74.3333 46.4696 74.544 45.9609 74.9191 45.5858C75.2942 45.2107 75.8029 45 76.3333 45H80.3333C81.2171 45.0008 82.0645 45.3523 82.6894 45.9772C83.3144 46.6022 83.6658 47.4495 83.6666 48.3333V61.6667C83.6658 62.5505 83.3144 63.3978 82.6894 64.0228C82.0645 64.6477 81.2171 64.9992 80.3333 65Z"
                            fill="black"/>
                        <defs>
                            <lineargradient
                                id="paint0_linear_108_15290"
                                x1="-5.40052"
                                y1="5.12199e-07"
                                x2="123.196"
                                y2="45.651"
                                gradientunits="userSpaceOnUse">
                                <stop stop-color="#01FFFF"/>
                                <stop offset="1" stop-color="#019094"/>
                            </lineargradient>
                        </defs>
                    </svg>
                    <div class="line">
                        <svg
                            width="220"
                            height="12"
                            viewbox="0 0 220 12"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.666667 6C0.666667 8.94552 3.05448 11.3333 6 11.3333C8.94552 11.3333 11.3333 8.94552 11.3333 6C11.3333 3.05448 8.94552 0.666667 6 0.666667C3.05448 0.666667 0.666667 3.05448 0.666667 6ZM208.667 6C208.667 8.94552 211.054 11.3333 214 11.3333C216.946 11.3333 219.333 8.94552 219.333 6C219.333 3.05448 216.946 0.666667 214 0.666667C211.054 0.666667 208.667 3.05448 208.667 6ZM6 7H8V5H6V7ZM12 7H16V5H12V7ZM20 7H24V5H20V7ZM28 7H32V5H28V7ZM36 7H40V5H36V7ZM44 7H48V5H44V7ZM52 7H56V5H52V7ZM60 7H64V5H60V7ZM68 7H72V5H68V7ZM76 7H80V5H76V7ZM84 7H88V5H84V7ZM92 7H96V5H92V7ZM100 7H104V5H100V7ZM108 7H112V5H108V7ZM116 7H120V5H116V7ZM124 7H128V5H124V7ZM132 7H136V5H132V7ZM140 7H144V5H140V7ZM148 7H152V5H148V7ZM156 7H160V5H156V7ZM164 7H168V5H164V7ZM172 7H176V5H172V7ZM180 7H184V5H180V7ZM188 7H192V5H188V7ZM196 7H200V5H196V7ZM204 7H208V5H204V7ZM212 7H214V5H212V7Z"
                                fill="black"
                                fill-opacity="0.5"/>
                        </svg>
                    </div>

                </div>
                <p class="step-txt">Step 2</p>
                <h4>Deposit</h4>
                <p class="start-para">Securely connect your account to deposit funds</p>
            </div>
            <div class="col-sm-4 col-md-4 col-xl-4 col-lg-4 step-cnt">
                <div class="start-img">
                    <svg
                        width="110"
                        height="110"
                        viewbox="0 0 110 110"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="55" cy="55" r="55" fill="url(#paint0_linear_108_15301)"/>
                        <path
                            d="M85 29H25C23.897 29 23 29.897 23 31V79C23 80.103 23.897 81 25 81H85C86.103 81 87 80.103 87 79V31C87 29.897 86.103 29 85 29ZM85 55V79H25V31L85 31.003V55Z"
                            fill="black"/>
                        <path
                            d="M77 33H40C39.448 33 39 33.448 39 34C39 34.552 39.448 35 40 35H77V75H29V35H36C36.552 35 37 34.552 37 34C37 33.448 36.552 33 36 33H29C27.897 33 27 33.897 27 35V75C27 76.103 27.897 77 29 77H77C78.103 77 79 76.103 79 75V55V35C79 33.897 78.103 33 77 33ZM82 52C80.346 52 79 53.346 79 55C79 56.654 80.346 58 82 58C83.654 58 85 56.654 85 55C85 53.346 83.654 52 82 52ZM82 56C81.449 56 81 55.551 81 55C81 54.449 81.449 54 82 54C82.551 54 83 54.449 83 55C83 55.551 82.551 56 82 56Z"
                            fill="black"/>
                        <path
                            d="M64 54H65V56C65 56.552 65.448 57 66 57C66.552 57 67 56.552 67 56V54H68C68.552 54 69 53.552 69 53V47C69 46.448 68.552 46 68 46H67V39C67 38.448 66.552 38 66 38C65.448 38 65 38.448 65 39V46H64C63.448 46 63 46.448 63 47V53C63 53.552 63.448 54 64 54ZM65 48H67V52H65V48ZM48 67H52C52.552 67 53 66.552 53 66V45C53 44.448 52.552 44 52 44H51V40C51 39.448 50.552 39 50 39C49.448 39 49 39.448 49 40V44H48C47.448 44 47 44.448 47 45V66C47 66.552 47.448 67 48 67ZM49 46H51V65H49V46ZM32 60H36C36.552 60 37 59.552 37 59V39C37 38.448 36.552 38 36 38H32C31.448 38 31 38.448 31 39V59C31 59.552 31.448 60 32 60ZM33 40H35V58H33V40ZM56 68H60C60.552 68 61 67.552 61 67V47C61 46.448 60.552 46 60 46H56C55.448 46 55 46.448 55 47V67C55 67.553 55.448 68 56 68ZM57 48H59V66H57V48ZM40 63H41V65C41 65.552 41.448 66 42 66C42.552 66 43 65.552 43 65V63H44C44.552 63 45 62.552 45 62V59C45 58.448 44.552 58 44 58H43V44C43 43.448 42.552 43 42 43C41.448 43 41 43.448 41 44V58H40C39.448 58 39 58.448 39 59V62C39 62.552 39.448 63 40 63ZM41 60H43V61H41V60Z"
                            fill="black"/>
                        <path
                            d="M31 71C31 71.552 31.448 72 32 72H73C73.552 72 74 71.552 74 71V38C74 37.448 73.552 37 73 37C72.448 37 72 37.448 72 38V70H32C31.448 70 31 70.448 31 71Z"
                            fill="black"/>
                        <defs>
                            <lineargradient
                                id="paint0_linear_108_15301"
                                x1="-5.40052"
                                y1="5.12199e-07"
                                x2="123.196"
                                y2="45.651"
                                gradientunits="userSpaceOnUse">
                                <stop stop-color="#01FFFF"/>
                                <stop offset="1" stop-color="#019094"/>
                            </lineargradient>
                        </defs>
                    </svg>

                </div>
                <p class="step-txt">Step 3</p>
                <h4>Trade</h4>
                <p class="start-para">Buy, Sell and Swap Digital assert 24/7</p>
            </div>
        </div>
    </div>
    <div class="intelignce-btn" style="margin-top:0px !important">
        <ul>
            <li class="nav-item last-menu">
                <a class="nav-link menu-last" href="{{route('wallet')}}">
                    <span>Make a Deposit
                    </span>
                </a>
            </li>
        </ul>
    </div>
</section>

<section class="own-your-crypto Fastest-White-Label Market-Leading-Software">
    <div class="contain-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 own-your-crypto-left">
                <h4 class="quick-txt">Quick Exchange</h4>

                <ul class="list-own-crypto">
                    <li>
                        <div class="tick-img-banner"><img
                            src="{{ url('landing/img/panther/banner-list-tick.png') }}"
                            alt="get-fast-whitelabel"></div>
                        #Fast They say time is money, so no need to wait for your order to be completed
                        and have your funds in lock position
                    </li>
                    <li>
                        <div class="tick-img-banner"><img
                            src="{{ url('landing/img/panther/banner-list-tick.png') }}"
                            alt="get-fast-whitelabel"></div>
                        #Convenient The easy intuitive interface allows you to process your exchange in
                        a matter of a few click
                    </li>
                    <li>
                        <div class="tick-img-banner"><img
                            src="{{ url('landing/img/panther/banner-list-tick.png') }}"
                            alt="get-fast-whitelabel"></div>
                        #Vast choice The quick exchange function is available for each and every coin
                        and token that is listed on Panther exchange
                    </li>
                </ul>
                <div class="intelignce-btn" style="margin-top:0px !important">
                    <ul>
                        <li class="nav-item last-menu">
                            <a class="nav-link menu-last" href="{{route('login')}}">
                                <span>Get Start</span></a>
                        </li>
                    </ul>
                </div>
                <!-- <div class="get-started"><a href="#">Get Started <img
                src="img/get-started.svg"></a></div> -->
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 own-your-crypto-right">
                <div class="own-your-crypto-img"><img
                    src="{{ url('landing/img/panther/quick-exchange-left-img.png') }}"
                    alt="own-your-crypto-exchange"
                    class="img-fluid"
                    width="640"
                    height="360"></div>
            </div>
        </div>
    </div>
</section>

<section class="product-sectn">
    <div class="contain-width">
        <h3 class="product-txt">Products & Services</h3>
        <div class="row">
            <div class="col-sm-4 col-md-4 col-xl-4 col-lg-4">
                <div class="product-card">
                    <div class="card-img">
                        <img
                            src="{{ url('landing/img/panther/card-img-1.png') }}"
                            alt="top-img-pro-2"
                            width="640"
                            height="360"
                            class="img-fluid ">
                    </div>
                    <h4 class="card-head">Spot</h4>
                    <p class="card-para">BTC, ETH and over 100 high quality trading pairs are available here.</p>
                </div>
            </div>
            <div class="col-sm-4 col-md-4 col-xl-4 col-lg-4">
                <div class="product-card">
                    <div class="card-img">
                        <img
                            src="{{ url('landing/img/panther/card-img-2.png') }}"
                            alt="top-img-pro-2"
                            width="640"
                            height="360"
                            class="img-fluid ">
                    </div>
                    <h4 class="card-head">P2P</h4>
                    <p class="card-para">Create a more flexible trading strategy and amplify your
                        profits with up to 100x leverage.</p>
                </div>
            </div>
            <div class="col-sm-4 col-md-4 col-xl-4 col-lg-4">
                <div class="product-card">
                    <div class="card-img">
                        <img
                            src="{{ url('landing/img/panther/card-img-3.png') }}"
                            alt="top-img-pro-2"
                            width="640"
                            height="360"
                            class="img-fluid ">
                    </div>
                    <h4 class="card-head">Referral Program</h4>
                    <p class="card-para">By following professional traders, and customizing leverage
                        to your preference, to invest with ease and profitability.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="download-sctn">
    <div class="contain-width">
        <h3 class="download-txt">Download App, Trade on the Go!</h3>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                <div class="download-img">
                    <img
                        src="{{ url('landing/img/panther/download-left-img.png') }}"
                        alt="top-img-pro-2"
                        width="640"
                        height="360"
                        class="img-fluid ">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                        <div class="inner-block-build">
                            <div class="inner-block-build-img">
                                <img src="{{ url('landing/img/panther/platform-1.png') }}" alt="Web">
                            </div>
                            <h6>Web</h6>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                        <div class="inner-block-build">
                            <div class="inner-block-build-img">
                                <img src="{{ url('landing/img/panther/platform-2.png') }}" alt="Web">
                            </div>
                            <h6>IOS</h6>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                        <div class="inner-block-build">
                            <div class="inner-block-build-img">
                                <img src="{{ url('landing/img/panther/platform-3.png') }}" alt="Web">
                            </div>
                            <h6>Android</h6>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                        <div class="inner-block-build">
                            <div class="inner-block-build-img">
                                <img src="{{ url('landing/img/panther/platform-4.png') }}" alt="Web">
                            </div>
                            <h6>API</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="interested-to-see-bsc">
    <div class="contain-width">
        <h3>Explore the Crypto World with Panther Exchange
        </h3>

        <div class="row">
            <div class="intelignce-btn" style="margin-top:0px !important">
                <ul>
                    <li class="nav-item last-menu">
                        <a class="nav-link menu-last" href="{{route('register')}}">
                            <span>Register Now</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="stack-preferable py-5">
    <div class="contain-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 left-stack">
                <h3>About Panther Exchange
                </h3>
                <p>Panther Exchange is a digital asset exchange that enables buying, exchanging
                    and storing cryptocurrencies and other digital assets. Panther Exchange builds
                    the new generation financial ecosystem or with asset tokenization in the center
                    of its focus.
                </p>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 right-stack">
                <div class="logo-opris-quote-inner">
                    <div class="logo-opris-quote">
                        <img
                            src="{{ url('landing/img/panther/about-img.png') }}"
                            alt="Web"
                            class="img-fluid">
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="mission-sctn">
    <div class="contain-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="mission-img">
                    <img
                        src="{{ url('landing/img/panther/mission-left-img.png') }}"
                        alt="Web"
                        class="img-fluid">
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <h4 class="mission-head">Our Mission</h4>
                <p>Get access to the limitless crypto market in a pocket format, be it mobile or
                    tablet. No bugs, no latency delays and no freezes.
                </p>
                <p>
                    BTC, ETH, XRP, SOL, DOGE - buy and sell digital assets with the lowest fees and
                    blazing fast on boarding.
                </p>
                <div class="proc-dev">
                    <div class="light-pink-img">
                        <img
                            src="{{ url('landing/img/panther/mission-left-img-1.png') }}"
                            alt="Web"
                            class="img-fluid">
                    </div>
                    <div class="light-pink-cont">

                        <h5>Trade on the go</h5>
                        <p>
                            Buy and sell digital assets with the lowest fees and blazing fast on boarding.</p>
                    </div>
                </div>
                <div class="proc-dev">
                    <div class="light-pink-img">
                        <img
                            src="{{ url('landing/img/panther/mission-left-img-2.png') }}"
                            alt="Web"
                            class="img-fluid">
                    </div>
                    <div class="light-pink-cont">

                        <h5>Perform Cross-chain transactions</h5>
                        <p>Perform cross exchange price comparisons all in one place, with access to
                            over 100 top coins</p>
                    </div>
                </div>
                <div class="proc-dev">
                    <div class="light-pink-img">
                        <img
                            src="{{ url('landing/img/panther/mission-left-img-3.png') }}"
                            alt="Web"
                            class="img-fluid">
                    </div>
                    <div class="light-pink-cont">

                        <h5>Get Instant Updates</h5>
                        <p>Keep your hand on the pulse of the market with instant price volatility
                            notifications, listing of new crypto assets, important events from the world of
                            top coin markets</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="interested-to-see-bsc">
    <div class="contain-width">
        <h3>Join the Panther Exchange Community Today
        </h3>
        <p>Always there for you.</p>
        <div class="row">
            <div class="intelignce-btn" style="margin-top:0px !important">
                <ul>
                    <li class="nav-item last-menu">
                        <a class="nav-link menu-last" href="https://twitter.com/PantherEx2023" target="_blank">
                            <span>Twitter</span></a>
                    </li>
                    <li class="nav-item last-menu">
                        <a class="nav-link menu-last" href="https://t.me/pantherexchange" target="_blank">
                            <span>Telegram</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="faq-sectn" id="faq-modern">
    <div class="contain-width">
        <h3>FAQs</h3>
        <div class="faq-cls-sectns">
            <div class="perks-benfits">
                <div class="meta-vese-inners">
                    <div class="tabs">
                        <button
                            class="tablinkss active"
                            onclick="faqsctn(event, 'account')"
                            id="faqopen">
                            <h4 class="meta-head">Account Function</h4>
                        </button>
                        <button class="tablinkss" onclick="faqsctn(event, 'deposit')">
                            <h4 class="meta-head">Deposit and Withdrawal</h4>
                        </button>
                        <button class="tablinkss" onclick="faqsctn(event, 'trade')">
                            <h4 class="meta-head">Trading
                            </h4>
                        </button>

                    </div>
                    <div id="account" class="tabcontentss" style="display: block;">
                        <div class="inner-tab-content">
                            <div class="block-1 coloured">
                                <div class="accrd-panel-head1 active">
                                    <h4>
                                        <span class="numeric 01">01</span>
                                        <span class="align-self-center">How to log in on Panther Exchange ?
                                        </span>
                                    </h4>
                                    <span class="mp-icon">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </div>
                                <div class="accrd-panel-body1 active">
                                    <p>Log in option is available after signing up on Panther Exchange only. You
                                        need to enter your e-mail and password here
                                        <a class="link-faq" href="{{route('login')}}">https://pantherexchange.io/login</a>
                                        and to enter 2FA code into a pop-up window (2FA is required only if you have
                                        previously enabled it)</p>
                                </div>
                            </div>
                            <div class="block-1">
                                <div class="accrd-panel-head1">
                                    <h4>
                                        <span class="numeric">02</span>
                                        <span class="align-self-center">How to sign up on Panther Exchange ?
                                        </span>
                                    </h4>
                                    <span class="mp-icon">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </div>
                                <div class="accrd-panel-body1" style="display:none">
                                    <ol>
                                        <li>Go to
                                            <a class="link-faq" href="{{url('/')}}">https://pantherexchange.io
                                            </a>
                                            and click Sign Up.</li>
                                        <li>
                                            On the registration page, enter your email address, create a password for your
                                            account, and select the time zone you are located</li>
                                        <li>Read and agree to the Terms of Service and click Sign Up.</li>
                                        <li>The system will send a confirmation link to your email. Please, activate
                                            your account within 30 minutes. If you can’t find the email in your inbox,
                                            please check your other mail folders as well.</li>
                                    </ol>
                                    <p>Congratulations, you are successfully registered on Panther Exchange.</p>
                                </div>
                            </div>
                            <div class="block-1">
                                <div class="accrd-panel-head1">
                                    <h4>
                                        <span class="numeric">03</span>
                                        <span class="align-self-center">How to change my password?
                                        </span>
                                    </h4>
                                    <span class="mp-icon">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </div>
                                <div class="accrd-panel-body1" style="display:none">
                                    <ol>
                                        <li>Click on the link:
                                            <a class="link-faq" href="{{url('/')}}">https://pantherexchange.io/account</a>
                                        </li>
                                        <li>In the Account section choose the Change button</li>
                                        <li>Insert your old password and create a new one (note, that a new password
                                            must be inserted twice)</li>
                                        <li>Click Confirm button</li>
                                    </ol>
                                    <p>Please note that after changing your password, withdrawals from your account
                                        will be disabled for 24 hours for security reasons.</p>
                                    <p>Important! To change your password you should enable 2FA first. (How to
                                        enable 2FA)</p>
                                </div>
                            </div>
                            <div class="block-1">
                                <div class="accrd-panel-head1">
                                    <h4>
                                        <span class="numeric">04</span>
                                        <span class="align-self-center">
                                            What is 2FA?
                                        </span>
                                    </h4>
                                    <span class="mp-icon">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </div>
                                <div class="accrd-panel-body1" style="display:none">
                                    <p>
                                        2FA, or two-factor authentication, adds a supplementary layer of security to the
                                        authentication process by making it harder for attackers to gain access to your
                                        account because, even if the victim's password is hacked, a password alone is
                                        not enough to pass the authentication check.
                                    </p>

                                </div>
                            </div>
                            <div class="block-1">
                                <div class="accrd-panel-head1">
                                    <h4>
                                        <span class="numeric">05</span>
                                        <span class="align-self-center">How to enable 2FA?
                                        </span>
                                    </h4>
                                    <span class="mp-icon">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </div>
                                <div class="accrd-panel-body1" style="display:none">
                                    <p>Click on the link
                                        <a class="link-faq" href="{{url('/')}}">https://pantherexchange.io/account/security</a>
                                    </p>
                                    <p>Two kinds of 2FA are available on Panther Exchange : Email Authorization and
                                        Google App Authorization
                                    </p>
                                    <p>This Panther Exchange Masterclass will guide you on how to use Panther
                                        Exchange and give a step-by-step guide from a Panther Exchange employee.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="deposit" class="tabcontentss" style="display: none;">
                        <div class="inner-tab-content">

                            <div class="block-1">
                                <div class="accrd-panel-head1">
                                    <h4>
                                        <span class="numeric">01</span>
                                        <span class="align-self-center">Where can I find information about fees?
                                        </span>
                                    </h4>
                                    <span class="mp-icon">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </div>
                                <div class="accrd-panel-body1" style="display:none">
                                    <p>Full information about the fees can be found here
                                        <a class="link-faq" href="{{url('/')}}">
                                            https://pantherexchange.io/fees</a>
                                    </p>
                                </div>
                            </div>
                            <div class="block-1">
                                <div class="accrd-panel-head1">
                                    <h4>
                                        <span class="numeric">02</span>
                                        <span class="align-self-center">Can I deposit Fiat Currency?
                                        </span>
                                    </h4>
                                    <span class="mp-icon">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </div>
                                <div class="accrd-panel-body1" style="display:none">
                                    <p>At the moment we do not accept fiat money deposits. It means that you can not
                                        buy crypto with a debit or credit card.
                                    </p>
                                </div>
                            </div>
                            <div class="block-1">
                                <div class="accrd-panel-head1">
                                    <h4>
                                        <span class="numeric">03</span>
                                        <span class="align-self-center">
                                            How to make a deposit?
                                        </span>
                                    </h4>
                                    <span class="mp-icon">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </div>
                                <div class="accrd-panel-body1" style="display:none">
                                    <ol>
                                        <li>Please login to your account and find the Wallet button onthe main page</li>
                                        <li>Select from the list the currency you want to replenish and click Deposit</li>
                                        <li>Next, you will see the address of the wallet to make a deposit to. You can
                                            either copy and paste it, or scan the QR code. Pay attention to the network
                                            type!
                                        </li>
                                    </ol>
                                    <p>Please don't forget about MEMO in case it is required and pay attention if
                                        there is a minimum deposit sum.
                                    </p>
                                    <p>If you will have any difficulties, please contact our support team or watch a
                                        YouTube video on our official account:-
                                        <a
                                            class="link-faq"
                                            href="https://www.youtube.com/channel/UCszUfMKky9fDEA2hxW QSrkA"></a>
                                    </p>
                                </div>
                            </div>
                            <div class="block-1">
                                <div class="accrd-panel-head1">
                                    <h4>
                                        <span class="numeric">04</span>
                                        <span class="align-self-center">Why my deposit has not been credited yet?
                                        </span>
                                    </h4>
                                    <span class="mp-icon">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </div>
                                <div class="accrd-panel-body1" style="display:none">
                                    <p>Depositing funds from an external platform to Panther Exchange consists of
                                        three steps:
                                    </p>
                                    <ol>
                                        <li>Withdrawing funds from the external platform
                                        </li>
                                        <li>
                                            Blockchain network confirmation
                                        </li>
                                        <li>Blockchain network confirmation</li>
                                    </ol>
                                    <p>Note, that even if your transaction is marked as “completed” or “success” in
                                        the platform you're withdrawing your crypto from means that the transaction was
                                        successfully broadcast to the blockchain network.
                                    </p>
                                    <p>But still, it may take some time to be fully confirmed and credited to the
                                        platform you’re withdrawing your crypto to. Each blockchain has a different
                                        amount of required network confirmations.
                                    </p>
                                </div>
                            </div>
                            <div class="block-1">
                                <div class="accrd-panel-head1">
                                    <h4>
                                        <span class="numeric">05</span>
                                        <span class="align-self-center">
                                            How to make a withdrawal from Panther Exchange?
                                        </span>
                                    </h4>
                                    <span class="mp-icon">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </div>
                                <div class="accrd-panel-body1" style="display:none">
                                    <ol>
                                        <li>To withdraw funds, please, log in to your account and find the Wallet button
                                            on the main page</li>
                                        <li>
                                            Select from the list the currency you want to withdraw and click Withdraw</li>
                                        <li>Enter the wallet address (the one you want to send your funds to), the
                                            amount of coins, and Memo Tag (if required for withdrawing this particular
                                            coin).</li>
                                        <li>Click the Request Withdraw button.</li>
                                        <li>Confirm the withdrawal by passing the captcha and entering the 2FA code.
                                            After moderation, the funds will be successfully withdrawn.
                                        </li>
                                    </ol>
                                    <p>If you will have any difficulties, please use support or watch a YouTube
                                        video on our official account:
                                        <a
                                            class="link-faq"
                                            href="https://www.youtube.com/channel/UCszUfMKky9fDEA2hxWQSrkA"></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="trade" class="tabcontentss" style="display: none;">
                        <div class="inner-tab-content">

                            <div class="block-1">
                                <div class="accrd-panel-head1">
                                    <h4>
                                        <span class="numeric">01</span>
                                        <span class="align-self-center">How to Trade on Panther Exchange?
                                        </span>
                                    </h4>
                                    <span class="mp-icon">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </div>
                                <div class="accrd-panel-body1" style="display:none">
                                    <ol>
                                        <li>Click on the Trade button and choose Spot Trading.</li>
                                        <li>To find the full list of trading pairs available on Panther Exchange follow
                                            this link
                                            <a class="link-faq" href="{{url('/')}}">
                                                https://pantherexchange.io/markets</a>
                                        </li>
                                        <li>After you choose a trading pair you will be redirected to the page, where
                                            you can place a buy or sell order.
                                        </li>
                                        <li>You can place a limit, market, or stop-limit order.</li>
                                    </ol>
                                    <p>Note, that if you’ve placed a limit order it is not processed immediately.</p>
                                    <p>With market orders, you trade the stock for whatever the going price is and
                                        your order is executed immediately. With limit orders, you can name a price, and
                                        if the stock hits it the trade is usually executed.</p>
                                    <p>Important! To be able to trade you should enable 2FA first.(How to enable 2FA
                                        link)</p>
                                </div>
                            </div>
                            <div class="block-1">
                                <div class="accrd-panel-head1">
                                    <h4>
                                        <span class="numeric">02</span>
                                        <span class="align-self-center">What is the difference between market and limit order?
                                        </span>
                                    </h4>
                                    <span class="mp-icon">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </div>
                                <div class="accrd-panel-body1" style="display:none">
                                    <p>The key difference between a limit order and a market order is that with
                                        market orders, you trade the stock for whatever the going price is and your
                                        order is executed immediately. With limit orders, you can name a price, and if
                                        the stock hits it the trade is usually executed.
                                    </p>
                                    <p>That’s the key difference between the above-mentioned trading types, but each
                                        type can be more appropriate for a given trading situation, and the trader
                                        should consider the pros and cons of each order before placing it</p>

                                </div>
                            </div>

                        </div>
                    </div>
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
                <a href="https://www.reddit.com/user/PantherEx007" target="_blank" class="icon-web">
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
                                <a href="https://t.me/pantherexchange" target="_blank" class="icon-web">
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
                    

            </ul>

        </div>
        <div class="social-logo-part">
            <ul>
                <li>
                    <a href="https://twitter.com/PantherEx2023" target="_blank" class="icon-web">
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
                <a
                    href=" https://instagram.com/pantherexchange873?igshid=ZGUzMzM3NWJiOQ=="
                    target="_blank"
                    class="icon-web">
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
                    <a
                        href="https://www.youtube.com/channel/UCszUfMKky9fDEA2hxWQSrkA"
                        target="_blank"
                        class="icon-web">
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

                <li>
                    <a
                        href=": https://www.facebook.com/groups/983353646159126"
                        target="_blank"
                        class="icon-web">
                        <svg
                            width="30"
                            height="30"
                            viewbox="0 0 22 12"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.9666 7.29219C15.2174 7.39779 15.466 7.50779 15.719 7.60679C15.84 7.65519 15.8862 7.73439 15.9104 7.85979C15.9676 8.14579 15.9214 8.42299 15.8532 8.69799C15.8026 8.90699 15.708 8.98399 15.4968 9.01699C15.433 9.02799 15.3714 9.06539 15.3186 9.10499C15.2724 9.14239 15.2284 9.18419 15.1866 9.22379C15.7014 9.44379 16.2338 9.68799 16.7662 9.96079C17.0214 10.0928 17.2458 10.2556 17.435 10.4514L17.6088 10.6318V11.4964C18.9992 11.4964 20.3896 11.4964 21.78 11.4964C21.6634 10.7088 21.1816 10.2402 20.4556 9.97179C19.9826 9.79799 19.5184 9.59559 19.0586 9.38659C18.9266 9.32499 18.8298 9.19519 18.7132 9.10499C18.6604 9.06539 18.5966 9.02799 18.5372 9.01699C18.3238 8.98399 18.2292 8.90699 18.1786 8.69579C18.1126 8.42079 18.0642 8.14359 18.1214 7.85759C18.1478 7.73219 18.1918 7.65299 18.3128 7.60459C18.5658 7.50559 18.8144 7.39559 19.0652 7.28999C19.2522 7.21079 19.2632 7.14699 19.1972 6.95119C18.9816 6.34179 18.821 5.72139 18.7704 5.07019C18.7374 4.65879 18.7484 4.23859 18.6494 3.83379H18.634C18.6252 3.79639 18.6208 3.75899 18.612 3.72159C18.4294 3.00879 17.666 2.62159 17.0236 2.57979C17.017 2.57979 17.0126 2.57759 17.0082 2.57759C16.9598 2.57539 16.9114 2.58199 16.8652 2.58419C16.5946 2.62159 16.3724 2.79319 16.115 2.86799C15.7806 2.96699 15.5738 3.27499 15.4506 3.60499C15.2746 4.07579 15.3054 4.57959 15.2658 5.06579C15.2152 5.71699 15.0546 6.33739 14.839 6.94679C14.7664 7.14699 14.7796 7.21299 14.9666 7.29219Z"
                                fill="black"/>
                            <path
                                d="M4.67723 10.6379L4.87303 10.4531C5.05123 10.2859 5.26243 10.1385 5.54183 9.98891L5.73763 9.88331C6.01483 9.73371 6.29203 9.58411 6.57803 9.44771C6.72763 9.37731 6.88383 9.31351 7.03783 9.24751C7.00483 9.15731 6.97403 9.06711 6.94543 8.97691C6.90803 8.86031 6.88603 8.74371 6.73643 8.71291C6.69903 8.70411 6.65283 8.64031 6.64623 8.59631C6.61543 8.37191 6.59343 8.14751 6.57803 7.92091C6.57363 7.87471 6.60003 7.81091 6.63303 7.77571C6.82883 7.55571 6.93883 7.30051 6.98283 7.00791C7.00483 6.86271 7.08843 6.72411 7.13023 6.58331C7.18743 6.38971 7.23363 6.19391 7.27763 5.99591C7.29303 5.92551 7.28423 5.84851 7.29523 5.77591C7.31063 5.67031 7.30843 5.58891 7.18083 5.54711C7.14563 5.53611 7.11703 5.45251 7.11703 5.39971C7.11043 5.08511 7.11483 4.77051 7.11263 4.45811C7.11043 4.26671 7.11263 4.07091 7.09943 3.87951C7.07083 3.50991 6.85523 3.25031 6.58463 3.02811C6.18863 2.70251 5.72663 2.39451 5.22723 2.43411C5.21403 2.43411 5.20523 2.43851 5.19423 2.44071C5.18323 2.43851 5.17223 2.43631 5.16123 2.43411C4.66183 2.39451 4.19983 2.70251 3.80603 3.02811C3.53543 3.25251 3.31983 3.50991 3.29123 3.87951C3.27803 4.07091 3.27803 4.26671 3.27803 4.45811C3.27583 4.77271 3.28023 5.08731 3.27363 5.39971C3.27143 5.45251 3.24283 5.53611 3.20763 5.54711C3.08003 5.58671 3.07783 5.67031 3.09323 5.77591C3.10423 5.84851 3.09543 5.92551 3.11083 5.99591C3.15483 6.19171 3.20103 6.38971 3.25823 6.58331C3.30003 6.72631 3.38143 6.86271 3.40563 7.00791C3.44963 7.30051 3.55963 7.55571 3.75763 7.77571C3.79063 7.81311 3.81483 7.87471 3.81043 7.92091C3.79503 8.14751 3.77303 8.37191 3.74223 8.59631C3.73563 8.64031 3.68943 8.70411 3.65203 8.71291C3.50243 8.74371 3.47823 8.86031 3.44303 8.97691C3.39683 9.13091 3.34623 9.28491 3.28683 9.43451C3.26923 9.47851 3.22303 9.52911 3.17683 9.54891C2.91063 9.66551 2.64003 9.77111 2.37163 9.88331C2.08563 10.0021 1.79743 10.1165 1.52023 10.2507C1.23203 10.3871 0.952629 10.5433 0.673229 10.6929C0.506029 10.7809 0.352029 10.8799 0.222229 11.0009V11.4937C1.70723 11.4937 3.19003 11.4937 4.67503 11.4937V10.6357L4.67723 10.6379Z"
                                fill="black"/>
                            <path
                                d="M16.4824 10.5126C15.5034 10.011 14.4914 9.59518 13.4662 9.20138C13.3892 9.17278 13.299 9.11338 13.266 9.04518C13.1824 8.86038 13.1252 8.66458 13.0658 8.47098C13.0284 8.34778 12.9954 8.22898 12.859 8.17178C12.8216 8.15638 12.7908 8.08378 12.7908 8.03758C12.7974 7.58878 12.694 7.11578 13.0284 6.72198C13.0394 6.70878 13.0416 6.69118 13.0504 6.67798C13.2286 6.28418 13.2616 5.83318 13.5146 5.46798C13.5212 5.45918 13.5212 5.44818 13.5234 5.43718C13.552 5.15778 13.5828 4.87838 13.607 4.59898C13.6092 4.56378 13.5784 4.50218 13.5498 4.49118C13.4112 4.44278 13.4178 4.33058 13.42 4.22058C13.42 3.67498 13.42 3.12718 13.4178 2.58158C13.4178 2.26478 13.3232 1.98098 13.0856 1.76538C12.8128 1.52118 12.5312 1.28358 12.2518 1.04378C12.1154 0.92938 12.1044 0.84138 12.232 0.71378C12.2892 0.65878 12.3618 0.61918 12.4234 0.57298C12.4102 0.55098 12.3948 0.53118 12.3838 0.50918C12.298 0.50918 12.2122 0.49818 12.1308 0.51138C11.8206 0.56198 11.5082 0.60598 11.2024 0.67858C10.6194 0.81498 10.054 0.997579 9.581 1.38698C9.2576 1.65538 9.0002 1.96558 8.9672 2.40338C8.9518 2.63438 8.954 2.86538 8.9518 3.09418C8.9496 3.46818 8.954 3.84658 8.9474 4.22058C8.9452 4.28218 8.91 4.38118 8.8682 4.39658C8.7164 4.44498 8.712 4.54178 8.7318 4.66938C8.745 4.75518 8.7362 4.84758 8.7538 4.93338C8.8066 5.16878 8.8616 5.40198 8.9298 5.63298C8.9804 5.80458 9.0772 5.96738 9.1058 6.14338C9.1608 6.49318 9.2884 6.79678 9.526 7.06078C9.5634 7.10478 9.5942 7.17738 9.5898 7.23458C9.5722 7.50298 9.5436 7.77138 9.5062 8.03978C9.4974 8.09258 9.4424 8.16958 9.3984 8.18058C9.2202 8.21798 9.1916 8.35658 9.1498 8.49518C9.0926 8.67998 9.0332 8.86258 8.9606 9.04078C8.9386 9.09578 8.8836 9.15518 8.8286 9.17718C8.5096 9.31578 8.1862 9.44338 7.8672 9.57758C7.5262 9.72058 7.183 9.85698 6.8508 10.0154C6.5076 10.1804 6.1754 10.363 5.8388 10.5434C5.6408 10.649 5.456 10.7656 5.302 10.9108V11.4982C9.1982 11.4982 13.0966 11.4982 16.9928 11.4982V10.8844C16.8454 10.7348 16.6782 10.6116 16.4824 10.5126Z"
                                fill="black"/>
                        </svg>

                    </a>
                </li>

                <li>
                        <a
                            href="https://www.facebook.com/pantherex2023"
                            target="_blank"
                            class="icon-web">

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

            </div>

        </div>

        <div class="select">
            <select>
                <ul class="globle-icon">
                    @if(Session::get('mode')=='nightmode')
                    <li>
                        <i class="fa-solid fa-globe" id="showf" aria-hidden="true"></i>
                    </li>

                    <!-- <i class="fas fa-sun" id="showf" aria-hidden="true"></i> -->
                    <!-- <i class="fa fa-moon-o modeicon" id="hidef" aria-hidden="true"></i> -->
                    @else
                    <li>
                        <i class="fa-solid fa-globe" id="showf" aria-hidden="true"></i>
                    </li>
                    @endif
                </ul>
                <option value="" disabled="disabled">--Select language---</option>
                <option value="eng/usd">English</option>
                <option value="eng/usd">French
                </option>
            </select>
        </div>
    </div>

</div>

<div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 foot-2">
    <h6>About</h6>
    <ul>
        <li>
            <a href="{{ url('/page/aboutus') }}">About Us</a>
        </li>
        <li>
            <a href="{{ url('/page/termsofuse') }}">Terms of Use</a>
        </li>
        <li>
            <a href="{{ url('/page/privacy-policy') }}">Privacy Policy</a>
        </li>
        <li>
            <a href="{{ url('/page/riskdisclosure') }}">Risk Disclosure</a>
        </li>
    </ul>
</div>

<div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 foot-3">
    <h6>Services</h6>
    <ul>
        <li>
            <a href="#">Coming Soon</a>
        </li>
        <!-- <li> <a href="#">Derivatives</a> </li> <li> <a href="#">Copy Trading</a>
        </li> <li> <a href="#">API</a> </li> -->
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
            <a href="{{ url('/page/helpcenter') }}">Help Center</a>
        </li>
        <li>
            <a href="{{ url('/page/beginnerguides') }}">Beginner Guides</a>
        </li>
        <li>
            <a href="{{ url('/page/announcements') }}">Announcements</a>
        </li>
        <li>
            <a href="{{ url('/page/referral') }}">Referral</a>
        </li>
        <li>
            <a href="{{ url('/page/userfeedback') }}">User Feedback</a>
        </li>
        <li>
            <a href="{{ url('/page/ratepolicy') }}">Rate Policy</a>
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
                <a class="nav-link footer" href="{{ url('/page/security') }}">Security
                </a>
                <a class="nav-link footer" href="{{ url('/page/terms-conditions') }}">Term of Use</a>
                <a class="nav-link footer" href="{{ url('/page/aml') }}">AML & KYC Policy
                </a>
                <a class="nav-link" href="{{ url('/page/riskdisclosure') }}">Risk Disclosure Statement</a>
            </li>
        </ul>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 ppts-right">
        © 2023 Panther Exchange. All rights reserved.
    </div>

</div>

</div>

</div>

</div>

</section>

<script
src="https://code.jquery.com/jquery-3.6.4.min.js"
integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
crossorigin="anonymous"></script>
<script src="{{ url('landing/js/owl.carousel.js') }}"></script>
<script>
$(document).ready(function () {
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

$(document).ready(function () {

$('li.main-menu-close a').click(function () {

$('.navbar-collapse').removeClass('show');

});

$('.settings-icon').click(function () {

$('ul.right-menu-head-mobile').addClass('open-side-menu');

});

$('li.close-icon-setting a').click(function () {

$('ul.right-menu-head-mobile').removeClass('open-side-menu');

});

})
</script>
<script type="text/javascript">
$(document).ready(function () {

var conn = new WebSocket("wss://stream.binance.com:9443/ws");
conn.onopen = function (evt) {

var cpair = 'BTCUSDT';

// send Subscribe/Unsubscribe messages here (see below)
var array_dta = [];
@forelse($trades as $pairlist)
@if($pairlist -> is_dust == 1 || $pairlist -> is_dust == 2)
@if($pairlist -> is_dust == 2)
var bpair = "{{ strtolower(trim($pairlist->coinone.'USDT')) }}";
@else
var bpair = '{{ strtolower(trim($pairlist->coinone.$pairlist->cointwo)) }}';
@endif
array_dta1 = [bpair + "@ticker"];
array_dta1.forEach(function (item) {
array_dta.push(item);
})
@endif
@empty
var bpair = 'btcusdt';
array_dta1 = [bpair + "@ticker"];
array_dta1.forEach(function (item) {
array_dta.push(item);
})
@endforelse
var messageJSON = {
"method": "SUBSCRIBE",
"params": array_dta,
"id": 1
};
conn.send(JSON.stringify(messageJSON));
}

conn.onmessage = function (evt) {
if (evt.data) {
var get_data = JSON.parse(evt.data);
if ((typeof get_data['e'] == "24hrTicker") || (get_data['e'] != null)) {
    var last_price = get_data['c'];
    var high_price = get_data['h'];
    var low_price = get_data['l'];
    var open_price = get_data['o'];
    var price_change = get_data['P'];
    var quote = get_data['q'];
    var symbol = get_data['s'];

    var is_data = "t-red";
    var waveimg = "{{ url('landing/img/red-wave.png') }}";
    if (price_change > 0) {
        is_data = "t-green";
        waveimg = "{{ url('landing/img/green-wave.png') }}";
    }

    if ((typeof last_price != 'undefined')) {
        $('.last_price_' + symbol).html(last_price);
    }

    if ((typeof quote != 'undefined') && (typeof last_price != 'undefined')) {
        $('.quote_' + symbol).html(quote);
    }
    if ((typeof open_price != 'undefined') && (typeof last_price != 'undefined')) {
        $('.open_' + symbol).html(open_price);
    }
    if ((typeof low_price != 'undefined') && (typeof last_price != 'undefined')) {
        $('.low_' + symbol).html(low_price);
    }
    if ((typeof high_price != 'undefined') && (typeof last_price != 'undefined')) {
        $('.high_' + symbol).html(high_price);
    }

    if ((typeof price_change != 'undefined') && (typeof last_price != 'undefined')) {
        price_change = price_change * 1;
        price_change = price_change.toFixed(2);
        $('.price_change_' + symbol).html(
            '<span class="' + is_data + '">' + parseFloat(price_change).toFixed(2) + '% </s' +
            'pan>'
        );
        $('.waveimg' + symbol).html('<img src="' + waveimg + '">');
    }

}
}

}

});
</script>

<script>
function openCity(evt, cityName) {
var i,
tabcontent,
tablinks;
tabcontent = document.getElementsByClassName("tabcontents");
for (i = 0; i < tabcontent.length; i++) {
tabcontent[i].style.display = "none";
}
tablinks = document.getElementsByClassName("tablinks");
for (i = 0; i < tablinks.length; i++) {
tablinks[i].className = tablinks[i]
.className
.replace(" active", "");
}
document
.getElementById(cityName)
.style
.display = "block";
evt.currentTarget.className += " active";
}

document
.getElementById("defaultOpen")
.click();
</script>

<script>
function faqsctn(evt, cityName) {
var i,
tabcontent1,
tablinks1;
tabcontent1 = document.getElementsByClassName("tabcontentss");
for (i = 0; i < tabcontent1.length; i++) {
tabcontent1[i].style.display = "none";
}
tablinks1 = document.getElementsByClassName("tablinkss");
for (i = 0; i < tablinks1.length; i++) {
tablinks1[i].className = tablinks1[i]
.className
.replace(" active", "");
}
document
.getElementById(cityName)
.style
.display = "block";
evt.currentTarget.className += " active";
}

document
.getElementById("faqopen")
.click();
</script>

<script>
$(document).ready(function () {

$('.accrd-panel-head').click(function () {

if ($(this).hasClass('active')) {
$(this).removeClass('active');
$(this)
    .siblings('.accrd-panel-body')
    .slideUp(200);
$(this)
    .parent('.block-1')
    .removeClass('coloured');
} else {
$('.accrd-panel-head').removeClass('active');
$(this).addClass('active');
$('.accrd-panel-head')
    .siblings('.accrd-panel-body')
    .slideUp(200);
$(this)
    .siblings('.accrd-panel-body')
    .slideDown(200);
$('.accrd-panel-head')
    .parent('.block-1')
    .removeClass('coloured');
$(this)
    .parent('.block-1')
    .addClass('coloured');
}

});

$('.accrd-panel-head1').click(function () {

if ($(this).hasClass('active')) {
$(this).removeClass('active');
$(this)
    .siblings('.accrd-panel-body1')
    .slideUp(200);
$(this)
    .parent('.block-1')
    .removeClass('coloured');
} else {
$('.accrd-panel-head1').removeClass('active');
$(this).addClass('active');
$('.accrd-panel-head1')
    .siblings('.accrd-panel-body1')
    .slideUp(200);
$(this)
    .siblings('.accrd-panel-body1')
    .slideDown(200);
$('.accrd-panel-head1')
    .parent('.block-1')
    .removeClass('coloured');
$(this)
    .parent('.block-1')
    .addClass('coloured');
}

});

$('.accrd-panel-head-cdp').mouseover(function () {

if ($(this).hasClass('active')) {
$(this).removeClass('active');
// $(this).parent('.block-cdp').removeClass('slide-cls');
// $(this).siblings('.accrd-panel-body-cdp').slideUp(200);
$(this)
    .parent('.block-1')
    .removeClass('coloured');
} else {
$('.accrd-panel-head-cdp').removeClass('active');
$(this).addClass('active');
$('.accrd-panel-head-cdp')
    .siblings('.accrd-panel-body-cdp')
    .slideUp(200);
$(this)
    .siblings('.accrd-panel-body-cdp')
    .slideDown(200);
$('.accrd-panel-head-cdp')
    .parent('.block-1')
    .removeClass('coloured');
$(this)
    .parent('.block-1')
    .addClass('coloured');
$('.accrd-panel-head-cdp')
    .parent('.block-cdp')
    .removeClass('slide-cls');
$(this)
    .parent('.block-cdp')
    .addClass('slide-cls');
}

});

$('.accrd-panel-head-sdl').mouseover(function () {

if ($(this).hasClass('active')) {
$(this).removeClass('active');
// $(this).parent('.block-sdl').removeClass('slide-cls');
// $(this).siblings('.accrd-panel-body-sdl').slideUp(200);
$(this)
    .parent('.block-1')
    .removeClass('coloured');
} else {
$('.accrd-panel-head-sdl').removeClass('active');
$(this).addClass('active');
$('.accrd-panel-head-sdl')
    .siblings('.accrd-panel-body-sdl')
    .slideUp(200);
$(this)
    .siblings('.accrd-panel-body-sdl')
    .slideDown(200);
$('.accrd-panel-head-sdl')
    .parent('.block-1')
    .removeClass('coloured');
$(this)
    .parent('.block-1')
    .addClass('coloured');
$('.accrd-panel-head-sdl')
    .parent('.block-sdl')
    .removeClass('slide-cls');
$(this)
    .parent('.block-sdl')
    .addClass('slide-cls');
}

});

$('.accrd-panel-head-sps').mouseover(function () {

if ($(this).hasClass('active')) {
$(this).removeClass('active');
// $(this).parent('.block-sps').removeClass('slide-cls');
// $(this).siblings('.accrd-panel-body-sps').slideUp(200);
$(this)
    .parent('.block-1')
    .removeClass('coloured');
} else {
$('.accrd-panel-head-sps').removeClass('active');
$(this).addClass('active');
$('.accrd-panel-head-sps')
    .siblings('.accrd-panel-body-sps')
    .slideUp(200);
$(this)
    .siblings('.accrd-panel-body-sps')
    .slideDown(200);
$('.accrd-panel-head-sps')
    .parent('.block-1')
    .removeClass('coloured');
$(this)
    .parent('.block-1')
    .addClass('coloured');
$('.accrd-panel-head-sps')
    .parent('.block-sps')
    .removeClass('slide-cls');
$(this)
    .parent('.block-sps')
    .addClass('slide-cls');
}

});

$('.inner-risk-head').click(function () {
$(this).addClass('active');
$(this)
.siblings('.inner-risk-body')
.slideDown(200);
$(this)
.parent('.inner-risk')
.addClass('top-bordered');
});

});
</script>

<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
crossorigin="anonymous"></script>

<script>
$(function () { // Dropdown toggle
$('.dropdown-toggless').click(function () {
$(this)
.next('.dropdownss')
.slideToggle();
});

$(document).click(function (e) {
var target = e.target;
if (!$(target).is('.dropdown-toggless') && !$(target).parents().is('.dropdown-toggless'))
//{ $('.dropdown').hide(); }
{
$('.dropdownss').slideUp();
}
});
});
</script>

<script type="text/javascript">
$(document).ready(function () {

var conn = new WebSocket("wss://stream.binance.com:9443/ws");
conn.onopen = function (evt) {

var cpair = 'BTCUSDT';

// send Subscribe/Unsubscribe messages here (see below)
var array_dta = [];
@forelse($trades as $pairlist)
@if($pairlist -> is_dust == 1 || $pairlist -> is_dust == 2)
@if($pairlist -> is_dust == 2)
var bpair = "{{ strtolower(trim($pairlist->coinone.'USDT')) }}";
@else
var bpair = '{{ strtolower(trim($pairlist->coinone.$pairlist->cointwo)) }}';
@endif
array_dta1 = [bpair + "@ticker"];
array_dta1.forEach(function (item) {
array_dta.push(item);
})
@endif
@empty
var bpair = 'btcusdt';
array_dta1 = [bpair + "@ticker"];
array_dta1.forEach(function (item) {
array_dta.push(item);
})
@endforelse
var messageJSON = {
"method": "SUBSCRIBE",
"params": array_dta,
"id": 1
};
conn.send(JSON.stringify(messageJSON));
}

conn.onmessage = function (evt) {
if (evt.data) {
var get_data = JSON.parse(evt.data);
if ((typeof get_data['e'] == "24hrTicker") || (get_data['e'] != null)) {
    var last_price = get_data['c'];
    var high_price = get_data['h'];
    var low_price = get_data['l'];
    var open_price = get_data['o'];
    var price_change = get_data['P'];
    var quote = get_data['q'];
    var symbol = get_data['s'];

    var is_data = "t-red";
    var waveimg = "{{ url('landing/img/panther/graph-1.png') }}";
    if (price_change > 0) {
        is_data = "t-green";
        waveimg = "{{ url('landing/img/panther/graph-2.png') }}";
    }

    if ((typeof last_price != 'undefined')) {
        $('.last_price_' + symbol).html(last_price);
    }

    if ((typeof quote != 'undefined') && (typeof last_price != 'undefined')) {
        $('.quote_' + symbol).html(quote);
    }
    if ((typeof open_price != 'undefined') && (typeof last_price != 'undefined')) {
        $('.open_' + symbol).html(open_price);
    }
    if ((typeof low_price != 'undefined') && (typeof last_price != 'undefined')) {
        $('.low_' + symbol).html(low_price);
    }
    if ((typeof high_price != 'undefined') && (typeof last_price != 'undefined')) {
        $('.high_' + symbol).html(high_price);
    }

    if ((typeof price_change != 'undefined') && (typeof last_price != 'undefined')) {
        price_change = price_change * 1;
        price_change = price_change.toFixed(2);
        $('.price_change_' + symbol).html(
            '<span class="' + is_data + '">' + parseFloat(price_change).toFixed(2) + '% </s' +
            'pan>'
        );
        $('.waveimg' + symbol).html('<img src="' + waveimg + '">');
    }

}
}

}

});
</script>

</body>

</html>