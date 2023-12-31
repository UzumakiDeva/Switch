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

<section class="secure-rules term">
    <div class="page-header">
        <h1>Terms and conditions of Switch</h1>
    </div>
    <div class="contain-width">
        <div class="terms">
            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">1.</span>
                        Terms and conditions
                    </h5>
                </div>
                <div class="para">
                    <span>1.1</span>
                    <p>
                        In the following content you will find the Terms and Conditions of the website,
                        which along with the Privacy Policy, form a legally binding contract between
                        Switch and the user.
                    </p>
                </div>
                <div class="para">
                    <span>1.2</span>
                    <p>
                        In the following content you will find the Terms and Conditions (or ¨Terms of
                        Use¨) of the website www.dex-trade.com (¨Website¨), which along with the Privacy
                        Policy, form a legally binding contract between switchex.io (EXCHANGE
                        TECHNOLOGIES LTD (UEA), respectively onwards ¨switchex.io¨) and the user
                        (onwards ¨you¨ or the ¨User¨).
                    </p>
                </div>
                <div class="para">
                    <span>1.3</span>
                    <p>
                        In the content of these Terms of Use, all reference to switchex.io, by
                        reference includes it´s owners,directors, administrators, investors, employees
                        or any other natural person or legal person involved. Depending on the context,
                        switchex.io may also refer to the services, products, website, content or
                        any other material, which switchex.io provides on or outsie of the
                        Website.
                    </p>
                </div>
            </div>

            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">2.</span>
                        The Acceptance of the Terms of Use
                    </h5>
                </div>
                <div class="para">
                    <span>2.1</span>
                    API
                    <p>
                        By using or browsing the Website, by registering with a user account on the
                        Website (the ¨Account¨), or by using any of the services provided by
                        switchex.io to the User on th Website, you are accepting and therefore
                        you are obliged to comply with these Terms of Use.
                    </p>
                </div>

                <div class="para">
                    <span>2.2</span>
                    <p>
                        Therefore, before taking any action on or through the Website, it is advised
                        that you carefully read the Terms of Use an the Privacy Policy, and if you do
                        not agree with them, you should refrain from usage.
                    </p>
                </div>

                <div class="para">
                    <span>2.3</span>
                    <p>
                        That is, by opening an Account on the Website and becoming a Registered User,
                        you are expressing a guarantee that:
                    </p>
                </div>

                <div class="para1">
                    <p>
                        You are accepting and therefore you are bound by these Terms of Use and the
                        Privacy Policy, which are binding; and that You have a full capability to accept
                        and be bound by these Terms of Use.
                    </p>
                </div>
            </div>

            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">3.</span>
                        Description of the Website
                    </h5>
                </div>
                <div class="para">
                    <span>3.1</span>
                    <p>
                        The Website corresponds to a web platform, which is intended to offer the
                        service of online exchange of Crytpocurrencies, such as bitcoin, ethereum,
                        bitcoin cash (the ¨Service¨ of the ¨Platform¨), which allows the Registered User
                        to buy and sell Cryptocurrencies (digital assets). In other words, the Website
                        functions as a meeting place for those, who, on one side wish to buy
                        Cryptocurrencies, and on the other, wish to sell them. According to the
                        previous, in order to perform any of those actions you should be registered on
                        the Website and therefore have an Account. switchex.io may, at it´s sole
                        discretion, add other Cryptocurrencies in addition to those currently supported,
                        or cease to support one or more of the Cryptocurrencies currently supported, if
                        estimated appropriate, while it not being an obligation of switchex.io to
                        add other or cease to support of any of the currently supported
                        Cryptocurrencies. Within the services offered by the Website, the Registered
                        Users may exchange between themselves different Cryptocurrencies, exchange
                        Cryptocurrencies for any legal tender, or vice versa, at a rate or price agreed
                        between themselves.
                    </p>
                </div>

                <div class="para">
                    <span>3.2</span>
                    <p>
                        We would like to inform you that Switch is not directly involved in
                        any trading activity on the platform. Switch is a trading platform
                        that provides secure and reliable services for users to place orders. Our
                        platform is designed to connect buyers and sellers and facilitate asset exchange
                        between them. As a platform, we do not make any decisions regarding the assets
                        being traded or take any positions in the market. We simply provide the
                        technology to enable users to place orders and execute trades.
                    </p>
                </div>

                <div class="para">
                    <span>3.3</span>
                    <p>
                        The Market Making service is handled by third-party companies. Also, Market
                        Making is available with the help of API to all users of Switch
                        exchange. The API provided by Switch allows you to programmatically
                        connect your systems to our trading platform, enabling you to automate your
                        trading strategies and operations. The API documentation at
                        https://docs.dex-trade.com provides all the necessary information on how to make
                        API requests, including the available endpoints, required parameters, and
                        expected responses.
                    </p>
                </div>

                <div class="para">
                    <span>3.4</span>
                    <p>
                        We are providing a safe and transparent trading environment and will continue to
                        work hard to ensure that our platform remains a trusted and reliable tool for
                        our users.
                    </p>
                </div>

                <div class="para">
                    <span>3.5</span>
                    <p>
                        You agree that switchex.io may be prevented from offering these services
                        at any moment.
                    </p>
                </div>

                <div class="para">
                    <span>3.6</span>
                    <p>
                        You agree that all of these operations may be subject to a service charge or
                        transcation costs reported by switchex.io
                    </p>
                </div>

                <div class="para">
                    <span>3.7</span>
                    <p>
                        For the purposes of the Website and of the Terms of Use, the term ¨to trade¨
                        and/or ¨transaction¨, mean to pay, buy, sell and withdraw Cryptocurrencies.
                        Despite the Website being aimed at Registered Users of the Republic of Chile,
                        depending on the country of residence, it might be the case that a User does not
                        have the possibility to use all of the functions of the Website. It is your
                        responsibility to respect the regulations and laws of your country of residence,
                        or the country from where you are accessing the Website and the services of
                        switchex.io, including, but not limited to the exchange and transfer
                        regime of each of the countries. In this respect, the User may not use the
                        Website and/or the services of switchex.io to transgress, directly or
                        indirectly, any provision of the legal system.
                    </p>
                </div>
            </div>

            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">4.</span>
                        Registered User´s Accounts, Verification
                    </h5>
                </div>
                <div class="para">
                    <span>4.1</span>
                    <p>
                        By registering as a Registered User on the Website you agree to provide us with
                        true, correct and updated information. Any changes in the provided information
                        are your responsibility and therefore you are required to update it in case of
                        any changes and regularly, since in case it is necessary, we will contact you
                        with accordance to that information. Furthermore, by registering as a User, you
                        authorize switchex.io to, directly or through third parties, perform
                        inquiries, queries, crossings of database, or any other action, which we
                        consider relevant in order to verify your identity, as established in the
                        Privacy Policy, and in order to comply with the regulations regarding the
                        prevention of money laundering, terrorist financing and bribary of public
                        officials, and/or to prevent ourselves from fraud.
                    </p>
                </div>
                <div class="para">
                    <span>4.2</span>
                    <p>
                        What is more, when registering as a Registered User and verifying the Account,
                        you must select an access password, being responsible for maintaining it's
                        confidentiality, and therefore being responsible for the information and the use
                        of your Account. What is more, by registering you accept the responsibility of
                        maintaining control over the security of any information, IDs, passwords or any
                        other code that you use to access the Platform. Any negligence or lack of proper
                        diligence on your part in relation to the handling of the information may result
                        in unauthorized access to your Account by third parties, and the loss or theft
                        of the Cryptocurrencies or funds held therein.Consequently, you agree to be
                        solely responsible for keeping your personal information on your Account, such
                        as email address, homeaddress and phone number, updated, in order for us to be
                        able to receive any alert or to be able to send you notifications.
                        switchex.io will not be liable for any loss or damage that you may suffer
                        as a result of unauthorized access by third parties to your Account, as a result
                        of hacking or loss of passwords, or as a result of not taking action in time
                        after being alerted or notified by us. In case you have reason to believe that
                        the access information to your Account has been compromised, contact us
                        immediately through support@switchex.io
                    </p>
                </div>
                <div class="para">
                    <span>4.3</span>
                    <p>
                        The verification of the Account consists of you providing personal information,
                        in order for switchex.io to be able to verify that whoever claims to be
                        registering on the Website is effectively the person who claims to be and is
                        able to validate that the origin of the funds traded by that person is
                        legitimate and that the funds belong to that person. For this purpose
                        switchex.io provides tools, which allow the User to obtain this result
                        and in particular there will be a difference between those people who wish to
                        trade relevant amounts, through the Website, and those who do not.
                    </p>
                </div>

                <div class="para">
                    <span>4.4</span>
                    <p>
                        switchex.io keeps, as it may apply, at its sole discretion, the amount,
                        which it considers relevant, as well as the denomination of that amount switch
                        Exchange reserves the right to request all the information it considers
                        pertinent and necessary, in order to enable the User to transact or operate any
                        of the services it provides. Switch also retains the exclusive right
                        to decide which Users may trade or operate the services it provides.
                    </p>
                </div>

                <div class="para">
                    <span>4.5</span>
                    <p>
                        In case of finding or suspecting any inappropriate activity related to your
                        Account, switchex.io may request additional information, including
                        document authentication, or freezing of transactions in order to review them.
                        You will be obliged to comply with these requests, otherwise you agree that your
                        Account will be closed. What is more, in case of this situation, you are
                        primarily required to immediately contact switchex.io as indicated in the
                        "Contact" section below.
                    </p>
                </div>

                <div class="para">
                    <span>4.6</span>
                    <p>
                        The Account is personal, unique and non-transferable, and it is prohibited for
                        the same Registered User to register or own more than one account, or to allow
                        third parties to access the services offered by switchex.io, through his
                        account, without the relevant prior authorization byswitchex.io. In the
                        event of switchex.io detecting different accounts that contain matching
                        or related data, it reserves the right to delete, suspend or disable those
                        accounts, without the User obtaining any right to compensation.
                    </p>
                </div>

                <div class="para">
                    <span>4.7</span>
                    <p>
                        The Registered User who violates any of these rules may be removed from the
                        Website, with the consequent closing of his Account, in addition to being liable
                        for losses incurred byswitchex.io.or any other Registered User of the
                        Website, or any other person, and that have been the result of this
                        violation(s).
                    </p>
                </div>

                <div class="para">
                    <span>4.8</span>
                    <p>
                        Despite the strict security controls on the Website, the User declares that he
                        will not use third-party accounts or help third parties obtain access to them,
                        without prior authorization from switchex.io
                    </p>
                </div>

                <div class="para">
                    <span>4.9</span>
                    <p>
                        Unauthorized use of accounts other than your own will result, according to the
                        judgement of switchex.io, in the immediate suspension or closing of all
                        accounts involved, as well as all pending purchase and /or sale orders.
                    </p>
                </div>

                <div class="para">
                    <span>4.10</span>
                    <p>
                        Any attempt to perform the above or to assist third parties (Registered Users or
                        not) in the unauthorized use of accounts, whether by distributing instructions
                        for this purpose, software or providing tools for that purpose, will result,
                        according toswitchex.io's judgement, in the immediate closing of the
                        respective accounts. Closing or termination of accounts is not the only action
                        that switchex.io can take as a result of contravention or violation of
                        what is indicated here, as well as in other sections of the Terms of Use,
                        thereforeswitchex.io reserves the right to take any other action against
                        the persons involved.
                    </p>
                </div>

                <div class="para">
                    <span>4.11</span>
                    <p>
                        The User accepts and declares that he will not use his Account or the Website to
                        carry out illegal or criminal activities of any kind, including, but not limited
                        to, money or asset laundering, terrorist financing, financial terrorism,
                        malicious hacking, transgression of the rules of exchange and transfers, evasion
                        or transgression of tax provisions, etc.
                    </p>
                </div>

                <div class="para">
                    <span>4.12</span>
                    <p>
                        You accept that the sale, transfer or assignment of the Account is prohibited.
                    </p>
                </div>

                <div class="para">
                    <span>4.13</span>
                    <p>
                        switchex.io reserves the right to refuse any registration request or to
                        delete a previously accepted Account, without being obliged to communicate or
                        explain the reasons for its decision and without the User obtaining any right to
                        compensation.
                    </p>
                </div>

                <div class="para">
                    <span>4.14</span>
                    <p>
                        Switch does not technically serve the following countries: the Russian
                        Federation and Crimea, the United States of America, Cuba, Iran, Iraq, North
                        Korea, Sudan, Syria, Pakistan, Sudan and Kazakhstan. Verification for these
                        countries is also not possible, so documents of users from these countries will
                        not be accepted for verification.
                    </p>
                </div>
            </div>

            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">5.</span>
                        Risks related to Cryptocurrencies and the use of the Website
                    </h5>
                </div>
                <div class="para">
                    <span>5.1</span>
                    <p>
                        The exchange of goods or products, real or virtual, as well as money or
                        currencies, carries a significant risk. The prices of these may vary over time
                        and because of the occurrence of different events. As a result of these price
                        variations, the value of your assets can increase or decrease drastically at any
                        time and without prior notice.
                    </p>
                </div>
                <div class="para">
                    <span>5.2</span>
                    <p>
                        By using the Website, you assume, declare and guarantee to be aware that any
                        commodity, whether virtual or not, is subject to significant changes in value,
                        and may even end up with a value equal to zero. That said, there is an inherent
                        risk of loss of money related to the purchase, sale or exchange of goods in the
                        market, both real and virtual, and the same applies to Cryptocurrencies.
                    </p>
                </div>
                <div class="para">
                    <span>5.3</span>
                    <p>
                        Furthermore, you declare and accept that the exchange of Cryptocurrencies may
                        carry special risks, which may not necessarily apply to currencies, assets or
                        products of free exchange.
                    </p>
                </div>

                <div class="para">
                    <span>5.3</span>
                    <p>
                        Therefore, there is no federal reserve, central bank, government or other entity
                        that protects their value, and they are reached exclusively under the balance
                        between supply and demand.
                    </p>
                </div>

                <div class="para">
                    <span>5.3</span>
                    <p>
                        Although it is not our mission or our intention to define exactly what a
                        Cryptocurrency and its' generation system is, we can point out, in a few words,
                        by taking as reference bitcoin and ethereum, which correspond to a global,
                        decentralized and autonomous, self-regulated system, through which a virtual
                        commodity, or digital asset, called Cryptocurrency is generated and circulated,
                        and whose value is based on the trust the users themselves give the system.
                    </p>
                </div>

                <div class="para">
                    <span>5.3</span>
                    <p>
                        In this regard, you declare to know and accept that the trade or exchange of
                        Cryptocurrencies can be susceptible to irrational (or rational) bubbles, can be
                        subject to loss of trust, and in consequence could lead to a collapse of your
                        demand regarding the offer.
                    </p>
                </div>

                <div class="para">
                    <span>5.3</span>
                    <p>
                        Merely by way of example, as the scenarios may vary, the trust in the
                        Cryptocurrencies could collapse as a result of an unexpected change imposed by a
                        software developer, of a prohibition imposed by some government or state, of the
                        creation of a technically superior alternative, or simply of an inflationary or
                        deflationary spiral.
                    </p>
                </div>

                <div class="para">
                    <span>5.3</span>
                    <p>
                        What is more, the trust in Cryptocurrencies could collapse due to possible
                        technical problems, such as when the money of the owners or people who interact
                        or operate with Cryptocurrencies were stolen or lost, or if hackers or
                        governments cause the prevention of transactions being made.
                    </p>
                </div>

                <div class="para">
                    <span>5.3</span>
                    <p>
                        As for the transactions of purchase and sale of Cryptocurrencies, you understand
                        and accept that once the orders are entered into the Platform and they are
                        processed as completed or pending, it is not possible to cancel, reverse or
                        change those orders. Each User is responsible for maintaining an adequate
                        balance of funds /cryptocurrencies in order to avoid situations in which the
                        costs associated with the withdrawal of the Cryptocurrencies or legal tender are
                        greater than the net amount of said withdrawal. Furthermore, Users will be
                        responsible for the information provided for any subscription or withdrawal in
                        Cryptocurrencies to or from their switchex.io Account to or from an
                        external Cryptocurrency wallet. Therefore, if the information provided by the
                        User to carry out such shipments or receipts of Cryptocurrencies to or from
                        wallets of switchex.io is incorrect or does not correspond to the
                        particular type of Cryptocurrency that is being sent or received, you accept
                        that the prior could mean the total loss of those cryptocurrencies sent or
                        received.
                    </p>
                </div>

                <div class="para">
                    <span>5.3</span>
                    <p>
                        switchex.io reserves the right to refuse to process any purchase, sale or
                        withdrawal order of Cryptocurrencies or legal tender, in its sole discretion, if
                        switchex.io suspects that the order involves (or has a high risk of
                        involving) activities related to money laundering, terrorist financing, fraud,
                        or any type of financial crime, or activity that is not in accordance with the
                        rules of these Terms and Conditions; or in case of being required judicially or
                        administratively to do so by some competent authority. In such circumstances,
                        switchex.io will cancel or refuse to process the order, without an
                        obligation to allow a subsequent order at the same price or on the same terms as
                        the order canceled or refused.
                    </p>
                </div>

                <div class="para">
                    <span>5.3</span>
                    <p>
                        Finally, it is necessary to point out that there might be other possible risks
                        not considered or identified in these Terms of Use, which Registered Users are
                        willing to bear, freeing switchex.io from any responsibility for them.
                        Therefore it is crucial that you carefully analyze your financial situation and
                        your risk tolerance before buying or selling Cryptocurrencies on the Website.
                    </p>
                </div>
            </div>

            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">6.</span>
                        Changes in Protocols supporting Cryptocurrencies (Forks)
                    </h5>
                </div>
                <div class="para">
                    <span>6.1</span>
                    <p>
                        switchex.io does not control or have any interference in the base
                        protocols that regulate the operation of the Cryptocurrencies supported by the
                        Website (the "Protocols"). Therefore, switchex.io will not be responsible
                        for the functioning of the Protocols, nor does it guarantee its operation,
                        security or availability. Therefore, you declare to be aware that the Protocols
                        may be subject to modifications to their rules of operation (“Forks”) and that
                        such modifications may materially affect the value, utility and availability of
                        the Cryptocurrency, of which protocol is modified. Consequently, if a Fork
                        occurs, which affects any of the Cryptocurrencies supported by the Platform, you
                        agree that switchex.io may temporarily suspend any operation linked to it
                        (with or without prior notice) and that switchex.io may, at its sole
                        discretion, decide to operate (or cease to operate) the underlying
                        cryptocurrency that the protocol modified through Fork. You acknowledge and
                        agree thatswitchex.io will nottake any responsibility for any damage
                        caused by a Fork not supported by the Platform.
                    </p>
                </div>

                <div class="para">
                    <span>6.2</span>
                    <p>
                        In case that switchex.io pronounces itself negatively about an eventual
                        Fork to one of the supported Protocols, or does not pronounce its position
                        regarding it, and a User wishes to participate in the results of that Fork, the
                        User must withdraw the Cryptocurrencies connected to the affected Protocol from
                        his switchex.io Account to a wallet that supports the Fork before the
                        budgeted date for that Fork.
                    </p>
                </div>

                <div class="para">
                    <span>6.3</span>
                    <p>
                        switchex.io will not take any responsibility in relation to any attempt
                        of use of the Services for Cryptocurrencies, which switchex.io does not
                        support.
                    </p>
                </div>
            </div>

            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">7.</span>
                        Reports and recommendations
                    </h5>
                </div>
                <div class="para">
                    <span>7.1</span>
                    <p>All reports prepared by switchex.io, as well as the data, opinions,
                        estimates, forecasts and recommendations, which they contain, and which are
                        found on the Website or communications which switchex.io may carry out to
                        its Registered and not registered Users, have been created for the purpose of
                        providing general information and are subject to change without prior notice.
                        switchex.io makes no commitment to communicate such changes or update the
                        content of such reports.</p>
                </div>
                <div class="para">
                    <span>7.2</span>
                    <p>
                        Its content does not constitute an offer, invitation or request to buy or sell
                        Cryptocurrencies, or cancellation of existing operations, nor can it serve as a
                        base for any commitment or decision of any kind. Relying on the advice,
                        opinions, declarations or statements, which such reports may contain, will be
                        only at the User's risk.
                    </p>
                </div>
                <div class="para">
                    <span>7.3</span>
                    <p>Neither switchex.io, nor anyone of its directors, administrators,
                        managers, employees or representatives will be responsible for the accuracy,
                        mistakes, omission or use of any content in this report, or for its timeliness,
                        truthfulness or integrity.You should be aware that the operations referred to in
                        some reports may not be suitable for your specific investment objectives, your
                        financial position or your risk profile, since these variables have not been
                        taken into account in the preparation of the reports.</p>
                </div>
                <div class="para">
                    <span>7.4</span>
                    <p>
                        You must make your own purchase or sale, investment and / or speculation
                        decisions taking into account these circumstances.
                    </p>
                </div>

                <div class="para">
                    <span>7.5</span>
                    <p>
                        The content of the reports is based on information that is considered available
                        to the public, obtained from sources that are considered reliable, but the
                        information has not been independently verified by switchex.io, and
                        therefore no warranty, express or implied, is offered regarding its accuracy,
                        completeness or correctness.
                    </p>
                </div>

                <div class="para">
                    <span>7.6</span>
                    <p>
                        switchex.io takes no responsibility for any loss occured in the market,
                        direct or indirect, that may result from the use of the information contained in
                        the reports. Reports are subject to the Limited Right of Use section indicated
                        below.
                    </p>
                </div>
            </div>

            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">8.</span>
                        Financial Regulation and Self-Regulation
                    </h5>
                </div>
                <div class="para">
                    <span>8.1</span>
                    <p>
                        switchex.io and the Website and it's Services do not represent financial
                        services or operations related to financial or exchange activity, nor entities
                        of the financial sector, nor intermediaries of the exchange market. They are
                        aimed at facilitating the Registered Users the purchase and sale of
                        Cryptocurrencies.
                    </p>
                </div>

                <div class="para">
                    <span>8.2</span>
                    <p>
                        The Website, the Service and their use may not be subject to any financial
                        regulations, as Cryptocurrencies may not be a financial asset, or value, in the
                        countries where the Website operates.
                    </p>
                </div>

                <div class="para">
                    <span>8.3</span>
                    <p>
                        Nevertheless, in pursuit of transparency, security and proper functioning of the
                        Website, switchex.io operates with a compliance officer in each of the
                        jurisdictions where it operates, in addition to having strict self-regulation
                        rules.
                    </p>
                </div>
            </div>

            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">9.</span>
                        Single End Mandate of Funds Held at switchex.io
                    </h5>
                </div>
                <div class="para">
                    <span>9.1</span>
                    <p>
                        The Registered User accepts, declares, orders, guarantees and secures that the
                        money, which he enters into his Account, either via bank transfer or other
                        method, and either personally or through a third party, who has previously
                        signed an appropriate mandate, can only be used, exclusively and specifically,
                        to buy Cryptocurrencies on your own account and not for any other purpose.
                    </p>
                </div>

                <div class="para">
                    <span>9.2</span>
                    <p>
                        Accordingly, the Registered User accepts and ensures that the Cryptocurrencies
                        (or other digital asset supported by switchex.io), which he brings
                        forward in his Account, through whatever method, may only be used, exclusively
                        and specifically, to offer on his own account in exchange for legal tender (such
                        as CLP, USD EUR, RUB, etc.) and in exchange for other Cryptocurrencies offered
                        on the Website, and not for any other purpose.
                    </p>
                </div>

                <div class="para">
                    <span>9.3</span>
                    <p>
                        The Registered User also understands, declares, guarantees, assures and accepts
                        that the funds he brings forward in switchex.io, are Cryptocurrencies,
                        they must be withdrawn once the transaction has been made, and that
                        switchex.io is not a deposit or vault, where the funds or the
                        Cryptocurrencies may be left indefinitely.
                    </p>
                </div>
            </div>

            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">10.</span>
                        Closing and Unverified Accounts
                    </h5>
                </div>
                <div class="para">
                    <span>10.1</span>
                    <p>
                        Registered Users may terminate this agreement with switchex.io, at any
                        time and therefore close their Accounts once all pending transactions have been
                        settled.
                    </p>
                </div>

                <div class="para">
                    <span>10.2</span>
                    <p>
                        Furthermore, you accept and agree that switchex.io may, without prior
                        notice, limit, suspend or terminate the service and the Accounts, prohibit
                        access to the Website and its content, services and tools, restrict or remove
                        the stored content, as well as undertake technical and legal actions to maintain
                        Registered Users off the Website if it is suspected that they are infringing the
                        Terms of Use.
                    </p>
                </div>

                <div class="para">
                    <span>10.3</span>
                    <p>
                        switchex.io may, at its sole discretion, suspend or close Registered User
                        Accounts for any of the following reasons, which are introduced as examples
                        only, therefore by opening an Account you ensure that you will not use the
                        services of switchex.io in connection with any of the following
                        activities, practices or businesses:
                    </p>
                </div>

                <ul>
                    <li>
                        <div class="para">
                            <span>10.3.1</span>
                            <p>
                                If a Registered User attempts to access the Website or the Account of another
                                Registered User without authorization, or provides assistance to third parties
                                to do so;
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="para">
                            <span>10.3.2</span>
                            <p>
                                If a Registered User interferes with aspects of the security of the Website,
                                which limit or protect some type of content;
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="para">
                            <span>10.3.3</span>
                            <p>
                                If a Registered User incurs, in switchex.io's judgement, in malicious or
                                fraudulent conducts or acts;
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="para">
                            <span>10.3.4</span>
                            <p>
                                If a Registered User uses the Website to carry out illegal activities, such as
                                money or asset laundering, terrorist financing, or other criminal activities, or
                                to violate the exchange or tax provisions of any country;
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="para">
                            <span>10.3.5</span>
                            <p>
                                If a Registered User violates or contravenes these Terms of Use;
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="para">
                            <span>10.3.6</span>
                            <p>
                                If a Registered User does not pay or unduly pays the transactions made through
                                the Website;
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="para">
                            <span>10.3.7</span>
                            <p>
                                If a Registered User causes operational difficulties on the Website; or
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="para">
                            <span>10.3.8</span>
                            <p>
                                If the identity of the Registered User could not be verified, the origin of the
                                funds paid by the User, or any information he provided would be misleading or
                                false;
                            </p>
                        </div>
                    </li>
                </ul>

                <div class="para">
                    <span>10.4</span>
                    <p>
                        Upon the requirement of any government or state institution or authority, such
                        as the Police, the Financial Analysis Unit, the Financial Information and
                        Analysis Unit, the Investigation Police, the Courts of Justice, judges,
                        superintendencies etc., if it conforms to the respective legal and /or
                        procedural rules that are applicable.
                    </p>
                </div>

                <div class="para">
                    <span>10.5</span>
                    <p>
                        If a Registered User acts as an intermediary, participant or beneficiary of
                        schemes that, at the sole judgement of switchex.io, consist of
                        "Multi-level Marketing" or "Network Marketing" models related to
                        Cryptocurrencies, or others in which there are indications of "Ponzi" or
                        pyramidal schemes;
                    </p>
                </div>

                <div class="para">
                    <span>10.6</span>
                    <p>
                        If a Registered User uses his Account to manage transactions for the benefit of
                        third parties other than the User who owns the Account, or operates his Account
                        with funds owned by third parties, without the corresponding prior authorization
                        of switchex.io.
                    </p>
                </div>

                <div class="para">
                    <span>10.7</span>
                    <p>
                        Furthermore, switchex.io expressly reserves the right to cancel and /or
                        close Accounts, which have not been successfully verified ("Accounts Not
                        Verified" or "Accounts Disabled"). After making reasonable efforts to verify and
                        find the holder of the respective Account for at least 6 months, and without
                        having achieved the objective, switchex.io may donate the goods (CLP,
                        USD, EUR, RUB , Cryptocurrencies, or others) that have been left in the
                        Unverified Account to any NGO, group or association for Cryptocurrencies,
                        without any further responsibility for switchex.io, and against which you
                        agree not to take any action by accepting these Terms of Use.
                    </p>
                </div>

                <div class="para">
                    <span>10.8</span>
                    <p>
                        The suspension or closure of an Account will not affect the payment of service
                        charges accrued and due for past transactions. At the closing of an Account,
                        Registered Users must submit a valid bank account of their ownership so that
                        switchex.io can make the deposit of any amount that it may owe to the
                        said Registered User. The Registered User must be the owner of the bank account,
                        otherwise switchex.io may refrain from making the payment online and in
                        that case the User must contact switchex.io as indicated in the "Contact"
                        section below.
                    </p>
                </div>

                <div class="para">
                    <span>10.9</span>
                    <p>
                        Any balance in Cryptocurrencies can only be transferred to a bank account once
                        converted to a currency that is acceptable by the respective bank, as long as
                        the Cryptocurrency balance is sufficient to cover the transaction costs
                        (commission of switchex.io and network fee) and the possible costs of the
                        subsequent transfer.
                    </p>
                </div>

                <div class="para">
                    <span>10.10</span>
                    <p>
                        switchex.io will transfer the amount due as soon as the Registered User
                        requests it and within the deadlines specified by switchex.io for these
                        purposes. However, after 6 months without having provided a valid bank account
                        or without having contacted switchex.io, so that it may have made the
                        payment, and after switchex.io having made reasonable efforts to contact
                        and return the said money to the Registered User within that period,
                        switchex.io will be exempt from paying the debt and therefore you will
                        not be able to recover the said money. Without affecting the prior, you agree
                        that there may be situations, in which, under a valid law or valid court order,
                        switchex.io may be forced to prevent the withdrawal of balances held in
                        the Account.
                    </p>
                </div>

                <div class="para">
                    <span>10.11</span>
                    <p>
                        Notwithstanding that switchex.io will send you information regarding your
                        Account, you are aware that there are charges for services and other charges
                        that may be applicable for bank transfers, which will be debited automatically
                        from your Account. switchex.io will make reasonable efforts to inform you
                        in advance of these associated costs, however this does not mean that it is
                        obliged to do so.
                    </p>
                </div>

                <div class="para">
                    <span>10.12</span>
                    <p>
                        In the case of closing an Account, if the costs of restitution of any amount due
                        to the User are greater than the amount due, you agree that no refund will be
                        made. In the event of a possible suspension, closing or disabling of a
                        Registered User, all pending operations will be carried out or executed and in
                        no case will the charges or payments that the disabled Registered User have made
                        to Switch be returned or reimbursed for any reason.
                    </p>
                </div>

                <div class="para">
                    <span>10.13</span>
                    <p>
                        In case of canceling or blocking a previously accepted Account,
                        switchex.io reserves the right to require the user to complete a form
                        regarding client knowledge, and request a statement of the origin of funds and
                        any other identity verification that is necessary, in switchex.io's
                        judgemente, before allowing the withdrawal or transfer of funds or
                        Cryptocurrencies that remain in the Account on the date of the cancellation or
                        blocking.
                    </p>
                </div>

                <div class="para">
                    <span>10.14</span>
                    <p>
                        Furthermore, in case of canceling or blocking a previously accepted Account, for
                        any reason, switchex.io will inform or notify you of this decision,
                        except in the case of a requirement or instruction of the contrary made by any
                        governmental or state institution or other authority, if it conforms to the
                        respective legal and or procedural rules that are applicable.
                    </p>
                </div>

                <div class="para">
                    <span>10.15</span>
                    <p>
                        Finally, by creating an Account you agree that the decision to cancel or block
                        the Account may be based on confidential criteria essential for the Compliance
                        and Risk protocols of switchex.io, therefore you understand and accept
                        that switchex.io does not have an obligation to disclose details of these
                        internal protocols.
                    </p>
                </div>

            </div>

            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">11.</span>
                        Service charge, Transaction and Compensation Costs
                    </h5>
                </div>
                <div class="para">
                    <span>11.1</span>
                    <p>
                        switchex.io charges for all transactions that occur within our Platform,
                        whether it is purchase or sale (service charge). What is more, there might exist
                        costs associated with payments and withdrawals in Cryptocurrencies, which are
                        charged by banks, payment methods, transfer service providers, and the networks
                        of each of the Cryptocurrencies supported by the Platform. switchex.io
                        reserves the right to change its service fees at any time.
                    </p>
                </div>

                <div class="para">
                    <span>11.2</span>
                    <p>
                        The service fee is charged in full amount at the time of the transaction,
                        therefore there are no and there will be no subsequent charges associated with
                        them.
                    </p>
                </div>

                <div class="para">
                    <span>11.3</span>
                    <p>
                        You can find all these costs here: Commissions.
                    </p>
                </div>

                <div class="para">
                    <span>11.4</span>
                    <p>
                        switchex.io reports that exist certain transaction costs associated with
                        charges made by networks or the infrastructure behind the Cryptocurrencies, such
                        as withdrawing bitcoins from your Account to your personal Bitcoin wallet. These
                        costs, however adjusted daily by market rules, will be notified to you before
                        requesting the withdrawal. In this regard, any withdrawal in Cryptocurrencies
                        from your switchex.io Account to an external Cryptocurrency wallet must
                        be in an amount at least greater than the network transaction costs, effectively
                        at the time of withdrawal. What is more, switchex.io will automatically
                        charge from your Account all transaction costs, which apply when making
                        transactions. You declare to be fully aware of the above and accept it.
                    </p>
                </div>

                <div class="para">
                    <span>11.5</span>
                    <p>
                        In case that service fees, transaction costs or other charges have been applied,
                        which do not correspond, the Registered User must contact our Customer Service
                        team at support@dex-trade.com. to resolve this situation.
                    </p>
                </div>

                <div class="para">
                    <span>11.6</span>
                    <p>
                        You accept and declare that switchex.io has the right to compensate any
                        amount owed by the User with the amounts that switchex.io may owe,
                        compensation, which will be automatically produced as defined by
                        switchex.io.
                    </p>
                </div>
            </div>

            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">12.</span>
                        Means of Payment
                    </h5>
                </div>
                <div class="para">
                    <span>12.1</span>
                    <p>
                        The only means of payment and credit authorized on the Website, unless expressly
                        stated otherwise, may be, although are not an obligation of switchex.io,
                        the following:
                    </p>
                </div>
                <ul>
                    <li>
                        <div class="para">
                            <span>12.1.1</span>
                            <div>
                                <h6>Bank transfer</h6>
                                <p>
                                    These must be made to the bank account indicated by switchex.io and from
                                    a bank account owned by the holder that makes the respective payment. Transfers
                                    from third-party bank accounts are not accepted and failure to respect this
                                    restriction will result in the total return of the funds, less the charges
                                    established by switchex.io's bank, to the same bank account from which
                                    the funds were sent.
                                </p>
                            </div>

                        </div>
                    </li>
                    <li>
                        <div class="para">
                            <span>12.1.2</span>
                            <div>
                                <h6>Debit cards</h6>
                                <p>
                                    These payments are governed by these Terms of Use and the terms and conditions
                                    established by the bank, which issued the card.
                                </p>
                                <p>Credit cards issued in Chile or abroad, as long as they maintain an
                                    affiliation agreement with switchex.io. The use of the previously
                                    singularized cards will be subject to the rules of these Terms of Use and in
                                    relation to its issuer, and agreed in the respective contracts and regulations
                                    of use. In case of bank cards accepted on the Website, the aspects related to
                                    them, such as the date of issue, expiration date, quota, blockages, password,
                                    deadlines for making returns or cancellations, will be governed by these Terms
                                    of Use and are subject to change, without prior notice and at the discretion of
                                    switchex.io. The Website may indicate certain conditions of purchase
                                    according to the payment method used by the User.</p>
                            </div>

                        </div>
                    </li>
                    <li>
                        <div class="para">
                            <span>12.1.3</span>
                            <div>
                                <h6>Payment intermediaries</h6>
                                <p>
                                    possibly, and subject to the regulations applicable to each market where
                                    switchex.io maintains operations, payments made through payment
                                    intermediaries in particular cases, may be accepted by switchex.io.
                                    Affiliated establishments /platforms will be informed on a case-by-case basis.
                                </p>
                                <p>It is hereby expressed that in compliance with the applicable legislation it
                                    is possible that the advances made by Registered Users be reported to the
                                    respective government agency responsible for controlling money laundering and
                                    terrorist financing.
                                </p>
                                <p>
                                    Furthermore, in case of an error or transgression, made by the user, regarding
                                    the conditions and methods of payment or withdrawal applicable for different
                                    countries, in which switchex.io provides services - be these conditions
                                    or methods established within the same web platform or within these Terms of
                                    Use- switchex.io will proceed to return the funds related to the
                                    transaction subject to error, to the account of the Registered User, who must
                                    bear the possible costs that this refund may generate.
                                </p>
                            </div>

                        </div>

                    </li>
                    <li>
                        <div class="para">
                            <span>12.1.4</span>
                            <div>
                                <h6>Refunds</h6>
                                <p>
                                    In relation to all the means of payment mentioned above, switchex.io
                                    reserves the right to process return or cancel requests and they will only be
                                    considered if the Registered User's Account has not purchased and /or withdrawn,
                                    as the case may be, the funds from his Account before the request is made, in
                                    which case the transaction will be considered successful and it will not be
                                    possible to request a refund or cancellation. The User declares to understand
                                    and accept the above.
                                </p>

                            </div>

                        </div>
                    </li>
                </ul>

            </div>

            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">13.</span>
                        Availability of the Website
                    </h5>
                </div>
                <div class="para">
                    <span>13.1</span>
                    <p>
                        You accept and agree that switchex.io is not responsible for any damage
                        or loss to the Registered User caused by failures in the system, on the server,
                        on the Internet or on the Website.
                    </p>
                </div>
                <div class="para">
                    <span>13.2</span>
                    <p>
                        switchex.io will not be responsible for any virus that could infect the
                        Registered User's equipment as a result of access, use or review of the Website
                        or following any transfer of data, files, images, texts, or audio contained
                        within. Users may NOT impute any responsibility or demand payment for loss of
                        profit or damage, caused by damages resulting from technical difficulties or
                        failures in the system, the Internet or the Website. switchex.io does not
                        guarantee continued or uninterrupted access and use of the Website. The system
                        may possibly not be available due to technical difficulties or Internet
                        failures, or due to any other circumstance, related or unrelated to
                        switchex.io; In such cases, efforts will be made to restore it as quickly
                        as possible, without any responsibility being imposed on it. switchex.io
                        will not be responsible for any error or omission of content on the Website.
                    </p>
                </div>

            </div>
            <div class="sub-terms">
                <div>
                    <h5>
                        <span class="numeric use">14.</span>
                        Limited Right of Use

                    </h5>
                </div>
                <div class="para">
                    <span>14.1</span>
                    <p>
                        Unless stated otherwise, all material on te Website is the property of
                        switchex.io and is protected bycopyright and trademark rights and other
                        international laws that are applicable. The User may review, print and /or
                        download copies of the material on the Website for exclusively personal,
                        informative and non-commercial purposes.
                    </p>
                </div>
                <div class="para">
                    <span>14.2</span>
                    <p>
                        The switchex.io brand and logo used on the Website ("Trade Mark") are
                        properties of switchex.io and their respective owners. The software,
                        texts, reports, images, graphics, information, prices, tradings, videos and
                        audios used on the Website (the "Material") are also the property of
                        switchex.io, unless expressly stated otherwise. The Trademark and the
                        Material must not be copied, reproduced, modified, republished, loaded, posted,
                        transmitted, decomposed (scrapped), collected or distributed commercially,
                        either automatically or manually. The use of any material on another site or
                        computer network, for any purpose other than that of the switchex.io
                        Website, is strictly prohibited; Any unauthorized use will mean a violation of
                        copyright, trademark rights and other international laws that are applicable,
                        and may result in civil or criminal penalties.

                    </div>
                </div>

                <div class="sub-terms">
                    <div>
                        <h5>
                            <span class="numeric use">15.</span>
                            External Websites

                        </h5>
                    </div>
                    <div class="para">
                        <span>15.1</span>
                        <p>
                            You agree that switchex.io reserves the right to give, to some persons
                            (legal or natural) access to specific information through our API (Application
                            Programming Interface) or through Widgets. What is more, you agree that
                            switchex.io reserves the right to provide Widgets for the User to display
                            information from the Website on its own websites. You are free to use these
                            Widgets as switchex.io delivers them; without altering or modifying them.
                        </p>
                    </div>
                </div>

                <div class="sub-terms">
                    <div>
                        <h5>
                            <span class="numeric use">16.</span>
                            API and Widgets

                        </h5>
                    </div>
                    <div class="para">
                        <span>16.1</span>
                        <p>
                            You agree that switchex.io reserves the right to give, to some persons
                            (legal or natural) access to specific information through our API (Application
                            Programming Interface) or through Widgets. What is more, you agree that
                            switchex.io reserves the right to provide Widgets for the User to display
                            information from the Website on its own websites. You are free to use these
                            Widgets as switchex.io delivers them; without altering or modifying them.

                        </p>
                    </div>
                </div>

                <div class="sub-terms">
                    <div>
                        <h5>
                            <span class="numeric use">17.</span>
                            External Websites

                        </h5>
                    </div>
                    <div class="para">
                        <span>17.1</span>
                        <p>
                            Dex-trade.com is not responsible in any way for external or third-party websites
                            that you can access from the Website. In this regard, the Website may
                            occasionally reference or provide links to other websites ("External Websites").
                            switchex.io does not control these External Websites or the information
                            they contain, therefore it is not responsible for your interaction with them,
                            nor do we suggest that you access or use them.
                        </p>
                    </div>

                    <div class="para">
                        <span>17.2</span>
                        <p>

                            The External Websites have policies and terms of use different and independent
                            from those of the Switch Website, so the access and use of them is
                            very different from what may result from this Website and therefore we suggest
                            you review the policies, rules, terms and regulations of each External Website
                            you visit. It is your responsibility to take the necessary precautions to ensure
                            that all access or use of such External Websites is free of viruses, worms,
                            Trojans and other elements of a destructive nature.
                        </p>
                    </div>
                </div>

                <div class="sub-terms">
                    <div>
                        <h5>
                            <span class="numeric use">18.</span>
                            Jurisdiction

                        </h5>
                    </div>
                    <div class="para">
                        <span>18.1</span>
                        <p>
                            These Terms of Use are regulated under the Law of each of the jurisdictions,
                            where switchex.io operates as an incorporated company.
                        </p>
                    </div>
                </div>

                <div class="sub-terms">
                    <div>
                        <h5>
                            <span class="numeric use">19.</span>
                            Responsibility Limitation
                        </h5>
                    </div>
                    <div class="para">
                        <span>19.1</span>
                        <p>
                            switchex.io is not responsible for any damage, loss of benefits, loss of
                            income, loss of business, loss of opportunities, loss of data, indirect or
                            consequential, unless the loss has been caused by serious fault or intent. It is
                            the User who must prove these circumstances.
                        </p>
                    </div>
                    <div class="para">
                        <span>19.2</span>
                        <p>
                            Despite the prior, the greatest responsibility that switchex.io may have
                            under or in connection with the use of the Website is limited to:
                        </p>
                    </div>
                    <ul>
                        <li>
                            <div class="para">
                                <span>19.2.1</span>
                                <div>
                                    <p>
                                        The total amount that the complaining Registered User has effectively and
                                        verifiably in his Account less any amount in service charges owed as a result of
                                        the transactions made through the said Account; or
                                    </p>
                                </div>

                            </div>
                        </li>
                        <li>
                            <div class="para">
                                <span>19.2.2</span>
                                <div>

                                    <p>
                                        100% of the amount of the transaction(s) subject to claim, less any amount in
                                        service charges due as a result of the said transaction(s). Such transactions
                                        must be real and legitimate.
                                    </p>

                                </div>

                            </div>
                        </li>
                    </ul>
                    <div class="para">
                        <span>19.3</span>

                        <div>
                            <p>For these purposes you authorize switchex.io to verify the status,
                                amount or quantity that each Registered User owns in their Account and the
                                procedure through which the transactions subject</p>
                        </div>
                    </div>

                    <div class="sub-terms">
                        <div>
                            <h5>
                                <span class="numeric use">20.</span>
                                Compensation
                            </h5>
                        </div>
                        <div class="para">
                            <span>20.1</span>
                            <p>
                                The Registered User will compensate, maintain undamaged and defend
                                switchex.io, its branches, subsidiaries and controllers, and their
                                respective directors, managers, administrators and employees, for any action,
                                claim or demand of other Registered Users or third parties for their activities
                                on the Website or for their own breach of the Terms of Use and other Policies
                                that are understood to be incorporated into the Terms of Use or for the
                                violation of any laws or rights of third parties, including attorney fees in a
                                reasonable amount.

                            </p>
                        </div>

                    </div>

                    <div class="sub-terms">
                        <div>
                            <h5>
                                <span class="numeric use">21.</span>
                                Other
                            </h5>
                        </div>
                        <div class="para">
                            <span>21.1</span>
                            <p>
                                If we cannot deliver the Service described in these Terms of Use for reasons
                                beyond our control, including but not limited to events or force majeure
                                factors, regulatory changes, changes in law, or penalties, we are not
                                responsible to Users regarding the Service offered under this agreement and for
                                the duration of said event or factor.

                            </p>
                        </div>

                    </div>

                    <div class="sub-terms">
                        <div>
                            <h5>
                                <span class="numeric use">22.</span>
                                Modifications of the Terms of Use
                            </h5>
                        </div>
                        <div class="para">
                            <span>22.1</span>
                            <p>
                                switchex.io reserves the right to modify these Terms of Use, at any time,
                                and those changes will be effective from the moment they are published.
                                switchex.io commits to make reasonable efforts to report material changes
                                in the Terms of Use, through the channels that switchex.io condiders
                                appropriate, but it is the ultimate responsibility of the User to review, on a
                                regular basis, the Terms of Use of the Website.
                            </p>
                        </div>
                        <div class="para">
                            <span>22.2</span>
                            <p>
                                If the Users continue to use and Access the Website after the changes in the
                                Terms of Use are made, it will mean that they accept the changes.

                            </p>
                        </div>
                    </div>

                    <div class="sub-terms">
                        <div>
                            <h5>
                                <span class="numeric use">23.</span>
                                Modifications of the Terms of Use
                            </h5>
                        </div>
                        <div class="para">
                            <span>22.1</span>
                            <p>
                                switchex.io reserves the right to modify these Terms of Use, at any time,
                                and those changes will be effective from the moment they are published.
                                switchex.io commits to make reasonable efforts to report material changes
                                in the Terms of Use, through the channels that switchex.io condiders
                                appropriate, but it is the ultimate responsibility of the User to review, on a
                                regular basis, the Terms of Use of the Website.
                            </p>
                        </div>
                        <div class="para">
                            <span>22.2</span>
                            <p>
                                If the Users continue to use and Access the Website after the changes in the
                                Terms of Use are made, it will mean that they accept the changes.

                            </p>
                        </div>
                    </div>

                    <div class="sub-terms">
                        <div>
                            <h5>
                                <span class="numeric use">25.</span>
                                Information Privacy
                            </h5>
                        </div>
                        <div class="para">
                            <span>25.1</span>
                            <p>
                                To be able to use the Services offered by switchex.io, Registered Users
                                must provide certain personal data. Your personal information is processed and
                                stored on servers or magnetic media, which maintain both physical and
                                technological security and protection standards. For more information regarding
                                the privacy of Personal Data and cases in which personal information will be
                                disclosed, you can consult our Privacy Policies.
                            </p>
                        </div>

                    </div>

                    <div class="sub-terms">
                        <div>
                            <h5>
                                <span class="numeric use">26.</span>
                                Divisibility

                            </h5>
                        </div>
                        <div class="para">
                            <span>26.1</span>
                            <p>
                                If any term or provision contained in these Terms of Use or its application to a
                                person or circumstance is declared invalid or unenforceable, the remainder of
                                it, or the application of it to any person or circumstance, apart from those in
                                respect of which it is said to be invalid, will not be affected by it and will
                                be valid and enforceable to the fullest extent permitted by law, and you and
                                switchex.io will agree to replace that term or provision with other terms
                                and provisions that, to the extent allowed by law, allow the parties to obtain
                                the benefit of the term or provision thus held as invalid or unenforceable.
                            </p>
                        </div>

                    </div>

                    <div class="sub-terms">
                        <div>
                            <h5>
                                <span class="numeric use">27.</span>
                                Contact

                            </h5>
                        </div>
                        <div class="para">
                            <span>27.1</span>
                            <p>
                                In case of any questions, complaints, comments or suggestions regarding the
                                content of the Terms of Use, your rights and obligations arising from the Terms
                                of Use and/ or regarding the use of the Website and it´s Services, or your
                                Account, please contact us at
                                <a href="{{ route('support') }}">support@switchex.io.</a>
                            </p>
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
