<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Switch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="Switch" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/index.css?v=1.4') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/form.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pic-chart.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/road-map.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pie-chart.js') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('assets/img/favicon/favicon-16x16.png') }}">


    <!-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/owl.theme.default.min.css') }}"> -->




    <script type="application/javascript" src="{{ url('assets/js/rpie.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"
        integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous">
    </script>

    <style>
    .tab-container {
        border: 1px solid #333;
        background: #555;
    }

    #tab1 {
        background: red;
    }

    #tab2 {
        background: grey;
    }

    #tab3 {
        background: lavender;
    }

    .rust-blockchain-pg-logo {
        display: block;
    }

    h3.map {
        font-style: normal;
        font-weight: 700;
        font-size: 55px;
        line-height: 70px;
        color: #FFFFFF;
        text-align: center;
        margin-bottom: 80px;
    }

    .yaho-logo {
        min-height: 50px;
        vertical-align: middle;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .row.mt-5.hanna {
        justify-content: center;
    }
    </style>
</head>

<body class="homepage-page">

    <!--- Header START -->

    @include('layouts.homeheader')

    <!--- Header end -->


    <!--Banner start-->

    <section class="banner-part">

        <div class="contain-width">

            <div class="row">

                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 my-auto">

                    <h1>EXCHANGE FOR</h1>
                    <h3 class="block">NEW <span>ERA</span></h3>

                    <div class="regul">
                        <h3>compliant</h3>
                        <h6 class="dot">.</h6>
                        <h3>transparent</h3>
                    </div>

                    <div class="regul">
                        <h3>secured</h3>
                        <h6 class="dot">.</h6>
                        <h3>scalable</h3>
                    </div>

                    <!-- <div class="launch">
                        <h5>...Launching on Q3, 23</h5>
                    </div> -->

                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="logo-head">
                        <img src="{{ url('assets/img/banner-right.svg') }}" alt="banner-image">
                    </div>
                </div>

            </div>

            <section class="scroll" id="banner">
                <h6>Explore</h6>
                <a class="mouseDown" href="#technologysection" title="Scroll Down">
                    <svg width="37" height="50" viewBox="0 0 37 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.6464 49.3536C17.8417 49.5488 18.1583 49.5488 18.3536 49.3536L21.5355 46.1716C21.7308 45.9763 21.7308 45.6597 21.5355 45.4645C21.3403 45.2692 21.0237 45.2692 20.8284 45.4645L18 48.2929L15.1716 45.4645C14.9763 45.2692 14.6597 45.2692 14.4645 45.4645C14.2692 45.6597 14.2692 45.9763 14.4645 46.1716L17.6464 49.3536ZM17.5 22L17.5 49L18.5 49L18.5 22L17.5 22Z"
                            fill="white" fill-opacity="0.4" />
                        <circle cx="18.5" cy="18.5" r="18" stroke="#E3B36F" />
                    </svg>

                </a>




            </section>





        </div>

    </section>







    <!-- grid  -->
    <section class="carousel" id="technologysection">
        <div class="contain-width ">

            <h3 class="cifd-eco">About the Switch Exchange</h3>
            <div class="slide" data-aos="fade-up" data-aos-duration="600">

                <div class="four-blocks-service">

                    <div class="blocks-service">
                        <div class="servce"><img src="{{ url('assets/img/servce-1.svg') }}" alt="Technology-icon-1">
                        </div>
                        <p><span>Lightning-Fast Trading Switch:</span> Switch is built on a scalable and high
                            performance architecture, ensuring lightning-fast transaction speeds and minimal
                            latency. This allows users to execute trades swiftly, taking advantage of market
                            opportunities in real-time.
                        </p>
                    </div>

                    <div class="blocks-service">
                        <div class="servce"><img src="{{ url('assets/img/servce-2.svg') }}" alt="Technology-icon-2">
                        </div>
                        <p><span>Enhanced Security:</span> Switch places utmost importance on security. It employs
                            robust security protocols, including two-factor authentication, cold storage for
                            funds, and advanced encryption techniques to safeguard user assets and personal
                            information.
                        </p>
                    </div>

                    <div class="blocks-service">
                        <div class="servce"><img src="{{ url('assets/img/servce-3.svg') }}" alt="Technology-icon-3">
                        </div>
                        <p><span>User-Friendly Interface:</span> Switch offers an intuitive and user-friendly
                            interface, making it easy for both experienced traders and beginners to navigate
                            the platform seamlessly. The user interface is designed to provide a hassle-free
                            trading experience while offering advanced trading tools and charts for more
                            experienced users</p>
                    </div>

                    <div class="blocks-service">
                        <div class="servce"><img src="{{ url('assets/img/servce-4.svg') }}" alt="Technology-icon-4">
                        </div>
                        <p><span>Advanced Order Types:</span> Switch offers a variety of order types, including
                            market orders, limit orders, stop orders, and trailing stop orders. These
                            advanced order types allow users to execute trades based on specific conditions,
                            increasing flexibility and control over their trading strategies.</p>
                    </div>

                </div>

            </div>

            <div class="slide">

                <div class="four-blocks-service">

                    <div class="blocks-service">
                        <div class="servce"><img src="{{ url('assets/img/servce-1.svg') }}" alt="Technology-icon-5">
                        </div>
                        <p>SWITCH is implementing machine learning techniques that understand and analyze code across
                            various programming
                            languages across SWITCH chain, and therefore provides bug detection and quality assurance
                            capabilities that will enhance the security of SET smart contract or any other contract
                            deployed on SWITCH chain. SWITCH AI Machine Learning takes
                            smart contracts as input and learns its patterns and characteristics and helps to automate
                            the code analysis and bug detection.</p>
                    </div>

                    <div class="blocks-service">
                        <div class="servce"><img src="{{ url('assets/img/servce-2.svg') }}" alt="Technology-icon-6">
                        </div>
                        <p>SWITCH is using AI technology to enhance the security of the exchange and wallets in order to
                            ensure the security of funds of investors and users. SWITCH will use the MPC wallets or
                            multi-party computing wallets powered by AI predictive models to create a shield of
                            protection from external hacking and external fraud and corruption. </p>
                    </div>

                    <div class="blocks-service">
                        <div class="servce"><img src="{{ url('assets/img/servce-3.svg') }}" alt="Technology-icon-7">
                        </div>
                        <p>SWITCH AI is responsible for creating customers' hot wallets where the private key will be
                            fractionated into N-number of pieces and stored in anonymous places by AI. No internal
                            developer or managerial employee will be able to know where the private key is stored and
                            how many pieces are fractionalized. Users through SWITCH AI will be sure that their wallets
                            are secured and that their private keys are not revealed to anyone.</p>
                    </div>

                    <div class="blocks-service">
                        <div class="servce"><img src="{{ url('assets/img/servce-4.svg') }}" alt="Technology-icon-8">
                        </div>
                        <p>SWITCH Custodian is powered by AI technology and will create a new MPC model called "AI MPC."
                            SWITCH AI will fractionalize the private keys into N pieces and store them in anonymous
                            places, which will protect users' private keys from internal fraud and corruption, and
                            external hacking. SWITCH AI Custodian will create defensive security predictive models that
                            will stand as a shield against hackers. No one is able to move funds from a cold wallet to
                            any external wallet without the approval of the AI.</p>
                    </div>

                </div>

            </div>

            <div class="slide">

                <div class="four-blocks-service">

                    <div class="blocks-service">
                        <div class="servce"><img src="{{ url('assets/img/servce-1.svg' ) }}" alt="Technology-icon-9">
                        </div>
                        <p>SWITCH is implementing machine learning techniques that understand and analyze code across
                            various programming languages across SWITCH chain, and therefore provides bug detection and
                            quality assurance capabilities that will enhance the security of SET smart contract or any
                            other contract deployed on SWITCH chain. SWITCH AI Machine Learning takes smart contracts as
                            input and learns its patterns and characteristics and helps to automate the code analysis
                            and bug detection.</p>
                    </div>

                    <div class="blocks-service">
                        <div class="servce"><img src="{{ url('assets/img/servce-2.svg' ) }}" alt="Technology-icon-10">
                        </div>
                        <p>SWITCH is using AI technology to enhance the security of the exchange and wallets in order to
                            ensure the security of funds of investors and users. SWITCH will use the MPC wallets or
                            multi-party computing wallets powered by AI predictive models to create a shield of
                            protection from external hacking and external fraud and corruption. </p>
                    </div>

                </div>

            </div>

            <!-- Previous and next buttons; add a dot for each slide and adjust the currentSlide number -->
            <!--  <button class="prev" onclick="changeSlide(-1)">&#10094;</button><button class="next" onclick="changeSlide(1)">&#10095;</button> -->

            <!-- <div class="controls">
                <button class="dotss" onclick="currentSlide(1)"></button>
                <button class="dotss" onclick="currentSlide(2)"></button>
                <button class="dotss" onclick="currentSlide(3)"></button>
            </div> -->

            <!-- Background photos for the slides; add one for each slide -->
            <!-- The odd comments remove spaces between inline-block elements -->
            <!-- <div class="slide-photos">
    <div class="slide-photo" style="background-image:url(https://images.unsplash.com/photo-1549007953-2f2dc0b24019?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80)"></div>

    <div class="slide-photo" style="background-image:url(https://images.unsplash.com/photo-1425934398893-310a009a77f9?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1742&q=80)"></div>

    <div class="slide-photo" style="background-image:url(https://images.unsplash.com/photo-1582979512210-99b6a53386f9?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=774&q=80)"></div>
  </div> -->

        </div>
    </section>




    <section class="roadmap-solar-class" id="roadmap-solar-id">
        <div class="contain-width ">
            <h3 class="cifd-eco">Roadmap</h3>
            <div class="roadmap-left-img"><img src="{{ url('assets/img/road-map-left.png') }}" alt="/road-map-left">
            </div>

            <div class="row">

                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12"> </div>


                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-xs-12" id="ellipse-before">

                    <div class="slider-content-part-whole">

                        <div class="owl-carousel owl-theme">



                            <div class="slider-content item">
                                <div class="inner-slider-content">
                                    <div class="ball-point"><img src="{{ url('assets/img/roadmap-point-circle.png') }}"
                                            alt="road-map-left"></div>
                                    <div class="question-part"><span>Q1</span> 2022 to <span>Q4</span> 2022</div>
                                    <div class="answer-part-lst-aroow-double"><img
                                            src="{{ url('assets/img/arrow-double.png') }}" alt="arrow-double"></div>
                                    <div class="answer-part-lst-outer">
                                        <h6>Research and Development</h6>
                                        <ul class="answer-part-lst-innerer">
                                            <li>Conduct thorough market research to identify the potential demand for a
                                                crypto exchange.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="slider-content item">
                                <div class="inner-slider-content">
                                    <div class="ball-point"><img src="{{ url('assets/img/roadmap-point-circle.png') }}"
                                            alt="/road-map-left"></div>
                                    <div class="question-part"><span>Q1</span> 2023</div>
                                    <div class="answer-part-lst-aroow-double"><img
                                            src="{{ url('assets/img/arrow-double.png') }}" alt="arrow-double"></div>
                                    <div class="answer-part-lst-outer">
                                        <h6>Form a team of experts in blockchain technology, cryptocurrency, and finance
                                            to develop the token and the underlying exchange platform.</h6>
                                        <ul class="answer-part-lst-innerer">
                                            <li>Define the token's purpose, utility, and features that will
                                                differentiate it from other existing tokens.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="slider-content item">
                                <div class="inner-slider-content">
                                    <div class="ball-point"><img src="{{ url('assets/img/roadmap-point-circle.png') }}"
                                            alt="/road-map-left"></div>
                                    <div class="question-part"><span>Q2</span> 2023</div>
                                    <div class="answer-part-lst-aroow-double"><img
                                            src="{{ url('assets/img/arrow-double.png') }}" alt="arrow-double"></div>
                                    <div class="answer-part-lst-outer">
                                        <ul class="answer-part-lst-innerer">
                                            <li> Conduct feasibility studies and technical analysis to ensure the
                                                token's viability and scalabilit</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="slider-content item">
                                <div class="inner-slider-content">
                                    <div class="ball-point"><img src="{{ url('assets/img/roadmap-point-circle.png') }}"
                                            alt="/road-map-left"></div>
                                    <div class="question-part"><span>Q2</span> 2023</div>
                                    <div class="answer-part-lst-aroow-double"><img
                                            src="{{ url('assets/img/arrow-double.png') }}" alt="arrow-double"></div>
                                    <div class="answer-part-lst-outer">
                                        <h6>Token Design and Creation</h6>
                                        <ul class="answer-part-lst-innerer">
                                            <li>- Determine the token's specifications, including the token type
                                                (BEP-20), supply, distribution, and tokenomics.</li>
                                            <li>- Create a smart contract for the token that ensures transparency,
                                                security, and compliance with regulatory requirements.</li>
                                            <li>- Conduct a security audit to identify and fix any vulnerabilities in
                                                the token's smart contract.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>





                            <!-- <div class="slider-content item">
            <div class="inner-slider-content">
             <div class="ball-point"><img src="{{ url('img/roadmap-point-circle.png') }}" alt="/road-map-left"></div> 
             <div class="question-part"><span>Q1</span> 2023</div>
             <div class="answer-part-lst-aroow-double"><img src="{{ url('img/arrow-double.png') }}" alt="arrow-double"></div>
             <div class="answer-part-lst-outer">
              <ul class="answer-part-lst-innerer">
                  <li>Seed round</li>
                  <li>Regulations</li>
              </ul>
             </div>
             </div>
          </div> -->

                        </div>

                    </div>


                </div>

            </div>

        </div>
    </section>


    <section class="total-table-pie" id="tokenomicsection">

        <div class="contain-width ">
            <h3 class="cifd">Tokenomics</h3>
            <p>SET Coin is the engine of the SWITCH Blockchain Ecosystem. Within the SWITCH platform,
                SET functions as a utility coin representing access to the services on the Exchange, as well as, on
                other SWITCH - empowered resources and communities. </p>

            <div class="contain-width team-pi">

                <section class="pie-chart-donut">

                    <div class="contain-width">

                        <div class="row piee">

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 false-For-Bottom-Text">
                                <div class="mypiechart">
                                    <canvas id="myCanvas" width="300" height="300"></canvas>
                                </div>
                            </div>



                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 true-text my-5 part">

                                <p class="set-coin">SET Coin Pool</p>
                                <p class="span-gold">Total supply : <span> 1 million tokens</span></p>
                                <h5 class="eco-1" data-aos="fade-up" data-aos-duration="600">Public Sale : 50%</h5>
                                <h5 class="eco-2" data-aos="fade-up" data-aos-duration="700">Staking rewards : 20%</h5>
                                <h5 class="eco-3" data-aos="fade-up" data-aos-duration="800">Marketing: 10%
                                </h5>
                                <h5 class="eco-4" data-aos="fade-up" data-aos-duration="900">Eco system: 10%
                                </h5>
                                <h5 class="eco-5" data-aos="fade-up" data-aos-duration="1000">Team : 10%
                                </h5>
                                <!-- <h5 class="eco-6" data-aos="fade-up" data-aos-duration="1000">10 % Coin Sale Allocation
                                </h5> -->
                            </div>



                        </div>

                    </div>

                </section>

            </div>

    </section>




    <section class="cifdaq-table-section">
        <div class="contain-width">


            <div class="desktop-table-view">


                <table>

                    <tr>
                        <th>Pool</th>
                        <th>Type</th>
                        <th style="text-align:center">%</th>
                        <th>Vesting Schedule</th>
                    </tr>


                    <tr>
                        <td class="borderrght" rowspan="4">
                            <div class="img-block">
                                <div class="table-img"><img src="{{ url('assets/img/table-1.svg') }}" alt="COIN-SALE">
                                </div><span>COIN
                                    SALE</span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="pad-top-bot-50px bb-1px">Seed</td>
                        <td class="pad-top-bot-50px bb-1px" style="text-align:center">2%</td>
                        <td class="bb-1px">
                            <p>2% release on CGE, 4 Months Cliff,
                                Post Cliff 7% linear release up to 14 months<span>Min 10K USD, price 0.20 USD, untill
                                    15. 04. 23</span></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="pad-top-bot-50px bb-1px">Private</td>
                        <td class="pad-top-bot-50px bb-1px" style="text-align:center">3%</td>
                        <td class="bb-1px">
                            <p>2% release on CGE, 4 Months Cliff,
                                Post Cliff 7% linear release up to 14 months<span>Min 5K USD, price 0.40 USD, until 15.
                                    07. 23</span></p>
                        </td>
                    </tr>

                    <tr style="border-bottom: 1px solid #E3B36F;">
                        <td class="pad-top-bot-50px">Public / IEO / IDO</td>
                        <td class="pad-top-bot-50px" style="text-align:center">45%</td>
                        <td>
                            <p>2% release on CGE, 4 Months Cliff,
                                Post Cliff 7% linear release up to 14 months<span>Price 0.8 USD 17. 07. 23 - 30. 09.
                                    23</span></p>
                        </td>
                    </tr>


                    <tr>
                        <td class="borderrght" rowspan="4">
                            <div class="img-block">
                                <div class="table-img"><img src="{{ url('assets/img/table-2.svg') }}"
                                        alt="Team-Advisors"></div><span>Team &
                                    Advisors</span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="pad-top-bot-50px bb-1px">Founders</td>
                        <td class="pad-top-bot-50px bb-1px" style="text-align:center">3%</td>
                        <td class="bb-1px">1% release on CGE, 4 Months Cliff, Post Cliff 3%
                            for the first month, 4% linear release up to 24 months</td>
                    </tr>
                    <tr>
                        <td class="pad-top-bot-50px bb-1px">Team</td>
                        <td class="pad-top-bot-50px bb-1px" style="text-align:center">5%</td>
                        <td class="bb-1px">1% release on CGE, 4 Months Cliff, Post Cliff 3%
                            for the first month, 4% linear release up to 24 months</td>
                    </tr>

                    <tr style="border-bottom: 1px solid #E3B36F;">
                        <td class="pad-top-bot-50px">Advisors</td>
                        <td class="pad-top-bot-50px" style="text-align:center">2%</td>
                        <td>1% release on CGE, 4 Months Cliff, Post Cliff 3%
                            for the first month, 4% linear release up to 24 months</td>
                    </tr>


                    <tr>
                        <td class="borderrght" rowspan="3">
                            <div class="img-block">
                                <div class="table-img"><img src="{{ url('assets/img/table-3.svg') }}" alt="Ecosystem">
                                </div>
                                <span>Ecosystem</span>
                            </div>
                        </td>
                    </tr>

                    <tr style="border-bottom: 1px solid #E3B36F;">
                        <td class="pad-top-bot-50px bb-1px">Ecosystem growth</td>
                        <td class="pad-top-bot-50px bb-1px" style="text-align:center">5%</td>
                        <td class="bb-1px">6 Months Cliff, Post Cliff 1% for the first month,
                            3% linear release up to 33 months</td>
                    </tr>

                    <tr style="border-bottom: 1px solid #E3B36F;">
                        <td class="pad-top-bot-50px bb-1px">Ecosystem Rewards</td>
                        <td class="pad-top-bot-50px bb-1px" style="text-align:center">5%</td>
                        <td class="bb-1px">6 Months Cliff, Post Cliff 1% for the first month,
                            3% linear release up to 33 months</td>
                    </tr>


                    <tr style="border-bottom: 1px solid #E3B36F;">
                        <td class="borderrght" rowspan="3">
                            <div class="img-block">
                                <div class="table-img"><img src="{{ url('assets/img/table-4.svg') }}"
                                        alt="Liquidity-Reserves"></div>
                                <span>Liquidity & Reserves</span>
                            </div>
                        </td>
                    </tr>

                    <tr style="border-bottom: 1px solid #E3B36F;">
                        <td class="pad-top-bot-50px bb-1px">Liquidity Program</td>
                        <td class="pad-top-bot-50px bb-1px" style="text-align:center">20%</td>
                        <td class="bb-1px">Liquidity provision for both centralized and decentralized exchanges</td>
                    </tr>

                    <tr style="border-bottom: 1px solid #E3B36F;">
                        <td class="pad-top-bot-50px bb-1px">Ecosystem Reserves</td>
                        <td class="pad-top-bot-50px bb-1px" style="text-align:center">10%</td>
                        <td class="bb-1px">4 Months Cliff, Post Cliff 1% for the first month, 3% linear release up to 33
                            months</td>
                    </tr>


                    <tr style="border-bottom: 1px solid #E3B36F;">

                        <td style="text-align:center" class="borderrght">Milestones Event Schedule</td>

                        <td colspan="3">
                            <p><span>CGE: 16-07-23 | Grand physical event will take place in Dubai supported by
                                    worldwide PR.</span>
                                Listing on Tier 1 in Q4 23 and on Top Notch Exchanges Q1 24.
                                We will provide liquidity to support price of 1 USD or above, at the time of listing.
                            </p>
                        </td>

                    </tr>


                </table>


            </div>

        </div>

        <div class="mobile-table">
            <img src="{{ url('assets/img/table-mob.png') }}" alt="table-soruce" class="img-fluid">
        </div>

        <div class="contain-width max-width-1000px unsold-part-section">
            <h4>Unsold coins will be moved from seed, private, IEO / IDO rounds to Ecosystem Reserves.</h4>
            <div class="row">

                <div class="col-xl-1 col-lg-1 col-md-12 col-sm-12"></div>

                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 left-part-unsold">

                    <div class="unsold-coins"><span>Ticker</span> SET</div>
                    <div class="unsold-coins"><span>Coin type</span> Native Coin</div>
                    <div class="unsold-coins"><span>Blockchain</span> BSC</div>
                    <div class="unsold-coins"><span>Total Supply</span> 1 million</div>
                    <div class="unsold-coins"><span>Decimals</span> 9</div>

                </div>


                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 right-part-unsold">
                    <h5 class="cifd-cost">SET Cost Module: </h5>
                    <div class="unsold-coins"><span>Seed Round </span> $0.25 till 31 march 2023</div>
                    <div class="unsold-coins round"><span>Private Round</span> $0.5 till 31 June 2023</div>
                    <div class="unsold-coins"><span>CGE </span> 1 Aug 2023</div>
                    <div class="unsold-coins"><span>Public / IEO / IDO </span> $1 starts from 15 Aug 2023</div>
                    <div class="unsold-coins"><span>Listing on tier 1 exchanges</span> Q3 2023</div>
                    <div class="unsold-coins"><span>Listing on top-notch exchanges</span>2024</div>
                    <p style="font-size: 16px !important;">Working capital and liquidity will be provided accordingly to
                        support the price to be at least $1.0 and above at the time of listing.</p>
                </div>







            </div>


        </div>


    </section>


    <section class="ecosystem-section desktop-ecosystem" id="ecosystemsection">
        <div class="contain-width ">
            <h3 class="cifd-eco">Products planned</h3>
            <p class="cifd-eco-head">SET Coin is the engine of the SWITCH Blockchain Ecosystem.</p>

            <div class="row mar-top-100px">

                <div class="roadmap-linear-bg"><img src="{{ url('assets/img/roadmap-linear-bg.png') }}"
                        alt="roadmap-linear-bg"></div>

                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 left-menu-block-eco">

                    <div class="menus eco-menu-1" data-aos="fade-right" data-aos-duration="600">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH NFT Marketplace</div>
                            <div class="left-arrow-icon"><img src="{{ url('assets/img/left-arrow-icon.png') }}"
                                    alt="arrow"></div>
                            <ul class="menu-sub-list">
                                <li>NFT Staking</li>
                                <li>Minting</li>
                                <li>Buy / Sell </li>
                                <li>NFT Events</li>
                                <li>NFT Community </li>
                                <li>Reward Boxes</li>
                            </ul>
                        </div>
                    </div>

                    <div class="menus eco-menu-2" data-aos="fade-right" data-aos-duration="6500">
                        <div class="menu-sub">
                            <div class="inner-menu">Multifunctional SWITCH Launchpad</div>
                        </div>
                    </div>

                    <div class="menus eco-menu-3" data-aos="fade-right" data-aos-duration="700">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Custodian</div>
                        </div>
                    </div>

                    <div class="menus eco-menu-4" data-aos="fade-right" data-aos-duration="750">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Wallet</div>
                        </div>
                    </div>

                    <div class="menus eco-menu-5" data-aos="fade-right" data-aos-duration="800">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH StableCoin</div>
                        </div>
                    </div>

                    <div class="menus eco-menu-6" data-aos="fade-right" data-aos-duration="850">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Unlearn Educatian Academy</div>
                        </div>
                    </div>

                    <div class="menus eco-menu-7" data-aos="fade-right" data-aos-duration="900">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Pay</div>
                            <div class="left-arrow-icon"><img src="{{ url('assets/img/left-arrow-icon.png') }}"
                                    alt="arrow"></div>
                            <ul class="menu-sub-list">
                                <li>Payment Processor </li>
                                <li>Crypto Card </li>
                                <li>POS Payments</li>
                            </ul>

                        </div>
                    </div>

                    <div class="menus eco-menu-8" data-aos="fade-right" data-aos-duration="950">
                        <div class="menu-sub">
                            <div class="inner-menu">Gamify</div>
                            <div class="left-arrow-icon"><img src="{{ url('assets/img/left-arrow-icon.png') }}"
                                    alt="arrow"></div>
                            <ul class="menu-sub-list">
                                <li>Gaming Platform</li>
                                <li>Sports </li>
                                <li>L2E </li>
                                <li>P2E </li>
                                <li>M2E </li>
                                <li>Binary Options </li>
                                <li>NFT Gaming</li>
                            </ul>
                        </div>
                    </div>



                </div>

                <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                    <h4 class="eco-center">SWITCH
                        Blockchain
                        Ecosystem
                        Products</h4>
                </div>

                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 right-menu-block-eco">



                    <div class="menus eco-menu-9" data-aos="fade-left" data-aos-duration="600">
                        <div class="menu-sub FIRST">
                            <div class="inner-menu">SWITCH CEX</div>
                            <div class="left-arrow-icon"><img src="{{ url('assets/img/right-arrow-icon.png') }}"
                                    alt="arrow"></div>
                            <ul class="menu-sub-list sub-list-menus Spot">
                                <li><span>Spot</span></li>
                                <li><span>Derivatives</span>
                                    <div class="left-arrow-icon"><img src="{{ url('assets/img/right-arrow-icon.png') }}"
                                            alt="arrow"></div><span>Margin /
                                        Futures Perpetuals Options</span>
                                </li>
                                <li><span>OTC P2P</span></li>
                                <li><span>Synthetics</span>
                                    <div class="left-arrow-icon"><img src="{{ url('assets/img/right-arrow-icon.png') }}"
                                            alt="arrow"></div><span>Stocks
                                        Commodities Indices</span>
                                </li>
                                <li><span>AI Bot Trading</span>
                                    <div class="left-arrow-icon"><img src="{{ url('assets/img/right-arrow-icon.png') }}"
                                            alt="arrow"></div>
                                    <span>Copy Trading Portfolio Asset Management SWAP</span>

                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="menus eco-menu-10" data-aos="fade-left" data-aos-duration="650">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Native Coin</div>
                        </div>
                    </div>

                    <div class="menus eco-menu-11" data-aos="fade-left" data-aos-duration="700">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Dex</div>
                            <div class="left-arrow-icon"><img src="{{ url('assets/img/right-arrow-icon.png') }}"
                                    alt="arrow"></div>
                            <ul class="menu-sub-list">
                                <li>Staking</li>
                                <li>Yield Farming </li>
                                <li>Lending/Borrowing </li>
                                <li>Savings</li>
                                <li>SIPs</li>
                                <li>Crypto Loan</li>
                            </ul>
                        </div>
                    </div>

                    <div class="menus eco-menu-12" data-aos="fade-left" data-aos-duration="750">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Metaverse</div>
                            <div class="left-arrow-icon"><img src="{{ url('assets/img/right-arrow-icon.png') }}"
                                    alt="arrow"></div>
                            <ul class="menu-sub-list">
                                <li>Real Estate</li>
                                <li>Digital Twin</li>
                                <li>Avatars</li>
                                <li>VR / AR / XR / MR</li>
                                <li>SWITCH Metaverse For Product Sales </li>
                                <li>SWITCH Metaverse For Marketing </li>
                                <li>SWITCH Metaverse For Events</li>
                            </ul>
                        </div>
                    </div>

                    <div class="menus eco-menu-13" data-aos="fade-left" data-aos-duration="800">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Blockchain<br>“Proof of Trust" consensus<br>powered by AI
                            </div>
                        </div>
                    </div>



                </div>


            </div>

        </div>
    </section>





    <section class="ecosystem-section mobile-ecosystem" id="ecosystemSection">
        <div class="contain-width ">
            <h3 class="cifd-eco">Products planned</h3>

            <h4 class="eco-center">
                SET Coin is the engine of the SWITCH Blockchain Ecosystem.</h4>

            <p class="cifd-eco-head">SWITCH Blockchain Ecosystem Products.</p>

            <div class="row mar-top-100px">

                <div class="roadmap-linear-bg"><img src="{{ url('assets/img/roadmap-linear-bg.png') }}"
                        alt="roadmap-linear-bg"></div>


                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 right-menu-block-eco">



                    <div class="menus eco-menu-9" data-aos="fade-left" data-aos-duration="600">
                        <div class="menu-sub FIRST">
                            <div class="inner-menu">SWITCH CEX</div>
                            <div class="left-arrow-icon"><img src="{{ url('assets/img/right-arrow-icon.png') }}"
                                    alt="arrow"></div>
                            <ul class="menu-sub-list sub-list-menus Spot">
                                <li><span>Spot</span></li>
                                <li><span>Derivatives</span>
                                    <div class="left-arrow-icon"><img src="{{ url('assets/img/right-arrow-icon.png') }}"
                                            alt="arrow"></div><span>Margin /
                                        Futures Perpetuals Options</span>
                                </li>
                                <li><span>OTC P2P</span></li>
                                <li><span>Synthetics</span>
                                    <div class="left-arrow-icon"><img src="{{ url('assets/img/right-arrow-icon.png') }}"
                                            alt="arrow"></div><span>Stocks
                                        Commodities Indices</span>
                                </li>
                                <li><span>AI Bot Trading</span>
                                    <div class="left-arrow-icon"><img src="{{ url('assets/img/right-arrow-icon.png') }}"
                                            alt="arrow"></div>
                                    <span>Copy Trading Portfolio Asset Management SWAP</span>

                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="menus eco-menu-10" data-aos="fade-left" data-aos-duration="650">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Native Coin</div>
                        </div>
                    </div>

                    <div class="menus eco-menu-11" data-aos="fade-left" data-aos-duration="700">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Dex</div>
                            <div class="left-arrow-icon"><img src="{{ url('assets/img/right-arrow-icon.png') }}"
                                    alt="arrow"></div>
                            <ul class="menu-sub-list">
                                <li>Staking</li>
                                <li>Yield Farming </li>
                                <li>Lending/Borrowing </li>
                                <li>Savings</li>
                                <li>SIPs</li>
                                <li>Crypto Loan</li>
                            </ul>
                        </div>
                    </div>

                    <div class="menus eco-menu-12" data-aos="fade-left" data-aos-duration="750">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Metaverse</div>
                            <div class="left-arrow-icon"><img src="{{ url('assets/img/right-arrow-icon.png') }}"
                                    alt="arrow"></div>
                            <ul class="menu-sub-list">
                                <li>Real Estate</li>
                                <li>Digital Twin</li>
                                <li>Avatars</li>
                                <li>VR / AR / XR / MR</li>
                                <li>SWITCH Metaverse For Product Sales </li>
                                <li>SWITCH Metaverse For Marketing </li>
                                <li>SWITCH Metaverse For Events</li>
                            </ul>
                        </div>
                    </div>

                    <div class="menus eco-menu-13" data-aos="fade-left" data-aos-duration="800">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Blockchain <br>“Proof of Trust" consensus<br>powered by AI
                            </div>
                        </div>
                    </div>



                </div>

                <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">

                </div>

                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 left-menu-block-eco">

                    <div class="menus eco-menu-1" data-aos="fade-right" data-aos-duration="600">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH NFT Marketplace</div>
                            <div class="left-arrow-icon"><img src="{{ url('assets/img/left-arrow-icon.png') }}"
                                    alt="arrow"></div>
                            <ul class="menu-sub-list">
                                <li>NFT Staking</li>
                                <li>Minting</li>
                                <li>Buy / Sell </li>
                                <li>NFT Events</li>
                                <li>NFT Community </li>
                                <li>Reward Boxes</li>
                            </ul>
                        </div>
                    </div>

                    <div class="menus eco-menu-2" data-aos="fade-right" data-aos-duration="6500">
                        <div class="menu-sub">
                            <div class="inner-menu">Multifunctional SWITCH Launchpad</div>
                        </div>
                    </div>

                    <div class="menus eco-menu-3" data-aos="fade-right" data-aos-duration="700">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Custodian</div>
                        </div>
                    </div>

                    <div class="menus eco-menu-4" data-aos="fade-right" data-aos-duration="750">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Wallet</div>
                        </div>
                    </div>

                    <div class="menus eco-menu-5" data-aos="fade-right" data-aos-duration="800">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH StableCoin </div>
                        </div>
                    </div>

                    <div class="menus eco-menu-6" data-aos="fade-right" data-aos-duration="850">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Unlearn Educatian Academy</div>
                        </div>
                    </div>

                    <div class="menus eco-menu-7" data-aos="fade-right" data-aos-duration="900">
                        <div class="menu-sub">
                            <div class="inner-menu">SWITCH Pay</div>
                            <div class="left-arrow-icon"><img src="{{ url('assets/img/left-arrow-icon.png') }}"
                                    alt="arrow"></div>
                            <ul class="menu-sub-list">
                                <li>Payment Processor </li>
                                <li>Crypto Card </li>
                                <li>POS Payments</li>
                            </ul>

                        </div>
                    </div>

                    <div class="menus eco-menu-8" data-aos="fade-right" data-aos-duration="950">
                        <div class="menu-sub">
                            <div class="inner-menu">Gamify</div>
                            <div class="left-arrow-icon"><img src="{{ url('assets/img/left-arrow-icon.png') }}"
                                    alt="arrow"></div>
                            <ul class="menu-sub-list">
                                <li>Gaming Platform</li>
                                <li>Sports </li>
                                <li>L2E </li>
                                <li>P2E </li>
                                <li>M2E </li>
                                <li>Binary Options </li>
                                <li>NFT Gaming</li>
                            </ul>
                        </div>
                    </div>



                </div>

            </div>

        </div>
    </section>






    <section class="document" id="docsection">

        <div class="contain-width">

            <h3>Documents</h3>
            <p>Switch aims to revolutionize the crypto currency exchange industry by
                providing a seamless, secure, and user-friendly platform for traders and
                investors. With its lightning-fast trading, enhanced security measures, wide
                range of trading options, and advanced order types, Switch is poised to become a
                leading player in the digital asset trading ecosystem. By prioritizing user
                experience and leveraging cutting-edge technology, Switch aims to empower
                individuals to participate in the crypto revolution with confidence. This white
                paper outlines the concept, technology, and features of Switch, a revolutionary
                crypto currency exchange platform.
            </p>

            <div class="white-label">
                <p class="gold-txt">Download whitelabel </p>

                <a class="mouseDown" href="#" title="Scroll Down">
                    <svg width="37" height="50" viewBox="0 0 37 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.6464 49.3536C17.8417 49.5488 18.1583 49.5488 18.3536 49.3536L21.5355 46.1716C21.7308 45.9763 21.7308 45.6597 21.5355 45.4645C21.3403 45.2692 21.0237 45.2692 20.8284 45.4645L18 48.2929L15.1716 45.4645C14.9763 45.2692 14.6597 45.2692 14.4645 45.4645C14.2692 45.6597 14.2692 45.9763 14.4645 46.1716L17.6464 49.3536ZM17.5 22L17.5 49L18.5 49L18.5 22L17.5 22Z"
                            fill="white" fill-opacity="0.4"></path>
                        <circle cx="18.5" cy="18.5" r="18" stroke="#E3B36F"></circle>
                    </svg>

                </a>

                <div class="white-label-card download">
                    <p>White Paper</p>
                </div>
            </div>


        </div>

    </section>

    <section class="digital-investment">
        <div class="contain-width">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <h4>Make Digital Investment with Ease.</h4>
                    <p>The Future of cryptocurrency exchange is here with Toobit. Instant access, simplified. Trading
                        smoothly, amplified.</p>
                    <p class="bold-invest-head">Get Switch Mobile App Now!</p>
                    <div class="row">
                        
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 app-store">
                        <div class="app-link">
                            <div class="links-store">
                                <a href="#"><i class="fa-brands fa-apple" style="color: #ffffff;"></i> App Store</a>
                            </div>
                        </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 app-store">
                        <div class="app-link">
                            <div class="links-store">
                                <a href="#"><i class="fa-brands fa-google-play" style="color: #ffffff;"></i> Google
                                    Play</a>
                            </div>
                        </div>
                        </div>
                        
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 app-store">
                        <div class="app-link">
                            <div class="links-store">
                                <a href="#"><i class="fa-brands fa-android" style="color: #ffffff;"></i> APK</a>
                            </div>
                        </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 app-store">
                        <div class="app-link">
                            <div class="links-store">
                                <a href="#"><svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M27.5877 4.51786L26.3437 3.2738C26.2966 3.22685 26.238 3.2063 26.1763 3.2063C26.1147 3.2063 26.0561 3.22978 26.0091 3.2738L23.7763 5.50666C22.8055 4.84899 21.6596 4.49835 20.487 4.50026C18.9847 4.50026 17.4825 5.07241 16.3353 6.21966L13.3454 9.20955C13.3017 9.25366 13.2772 9.31324 13.2772 9.37533C13.2772 9.43742 13.3017 9.49698 13.3454 9.5411L21.3175 17.5131C21.3644 17.5601 21.4231 17.5807 21.4847 17.5807C21.5434 17.5807 21.605 17.5571 21.6519 17.5131L24.6419 14.5233C26.6635 12.4987 26.9012 9.368 25.3549 7.08523L27.5877 4.85236C27.6786 4.75847 27.6786 4.60883 27.5877 4.51786ZM17.6468 16.1927C17.6027 16.1492 17.5432 16.1245 17.4811 16.1245C17.4189 16.1245 17.3594 16.1492 17.3153 16.1927L15.3611 18.1469L12.7116 15.4973L14.6687 13.5403C14.7596 13.4494 14.7596 13.2997 14.6687 13.2088L13.6007 12.1408C13.5565 12.0971 13.497 12.0726 13.4349 12.0726C13.3728 12.0726 13.3132 12.0971 13.2691 12.1408L11.312 14.0978L10.0504 12.8361C10.0285 12.8142 10.0023 12.7969 9.9736 12.7853C9.94487 12.7737 9.91408 12.7681 9.88311 12.7687C9.82443 12.7687 9.7628 12.7921 9.71586 12.8361L6.72891 15.826C4.70729 17.8476 4.46963 20.9813 6.01591 23.2641L3.78303 25.4969C3.73936 25.5411 3.71484 25.6006 3.71484 25.6626C3.71484 25.7248 3.73936 25.7843 3.78303 25.8285L5.02711 27.0725C5.07406 27.1196 5.13274 27.14 5.19436 27.14C5.25597 27.14 5.31465 27.1166 5.3616 27.0725L7.59448 24.8397C8.58329 25.5117 9.73347 25.8461 10.8837 25.8461C12.3859 25.8461 13.8882 25.274 15.0355 24.1267L18.0254 21.1369C18.1163 21.0458 18.1163 20.8962 18.0254 20.8052L16.7636 19.5436L18.7208 17.5866C18.8117 17.4955 18.8117 17.3459 18.7208 17.255L17.6468 16.1927Z"
                                            fill="white" />
                                    </svg>
                                    API</a>
                            </div>
                        </div>
                        </div>
                    
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="mobile-img">
                        <div class="invest-img">
                            <img src="{{ url('assets/img/invest-img.png') }}" alt="Phone" class="img-fluid">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="buy-token">
        <div class="contain-width">
            <div class="token-card">

                <div class="card-cnt">
                    <h4>Lorem ipsum dolor sit amet sit amet</h4>
                    <p>Lorem ipsum dolor sit amet consectetur. Ac enim risus amet quam semper sit sed malesuada et. Eget
                        porta laoreet vel velit augue leo. Malesuada id tortor enim.</p>

                    <div class="token-buy">
                        <p class="buy-card">Buy Token</p>
                    </div>

                    <div class="purchase-token">
                        <div class="purchase-way">
                            <p class="gold-txt">Purchase details </p>
                        </div>

                        <div class="token-way">
                            <a class="mouseDown" href="#" title="Scroll Down">
                                <svg width="50" height="38" viewBox="0 0 50 38" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M49.4598 20.2569C49.655 20.0616 49.655 19.745 49.4598 19.5498L46.2778 16.3678C46.0825 16.1725 45.7659 16.1725 45.5707 16.3678C45.3754 16.563 45.3754 16.8796 45.5707 17.0749L48.3991 19.9033L45.5707 22.7317C45.3754 22.927 45.3754 23.2436 45.5707 23.4389C45.7659 23.6341 46.0825 23.6341 46.2778 23.4389L49.4598 20.2569ZM22.1062 20.4033L49.1062 20.4033L49.1062 19.4033L22.1062 19.4033L22.1062 20.4033Z"
                                        fill="white" fill-opacity="0.4" />
                                    <circle cx="18.6062" cy="19.4033" r="18" transform="rotate(-90 18.6062 19.4033)"
                                        stroke="#E3B36F" />
                                </svg>


                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </section>





    <section class="footer-part">
        <div class="contain-width">


            <div class="eco">
                <div class="row">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <h6>SWITCH “The Evolution of Innovative Blockchain Ecosystem powered by AI”</h6>
                        <form>
                            <input type="email" name="email" placeholder="Contact Us" class="contact-foot">
                            <input type="submit" value="Join">
                        </form>
                        <h4>Start working with us! </h4>
                        <ul class="cont">
                            <li><a href="#" style="cursor: pointer;">Partnership request </a></li>
                            <li><a href="#" style="cursor: pointer;">Ambassador request</a></li>
                            <li><a href="#" style="cursor: pointer;">Investing request</a></li>
                            <li><a href="#" style="cursor: pointer;">Career request</a></li>
                        </ul>
                        <ul>
                            <li> <a href="#"><img src="{{ url('assets/img/youtube.png') }}" alt="youtube-SWITCH"
                                        class="img-fluid"> </a>
                            </li>
                            <li> <a href="#"><img src="{{ url('assets/img/inssta.png') }}" alt="instagram-SWITCH"
                                        class="img-fluid"></a></li>
                            <li> <a href="#"><img src="{{ url('assets/img/facebook.png') }}" alt="facebook-SWITCH"
                                        class="img-fluid"></a>
                            </li>
                            <li> <a href="#"><img src="{{ url('assets/img/reddit.png') }}" alt="reddit-SWITCH"
                                        class="img-fluid"></a></li>
                            <li> <a href="#"><img src="{{ url('assets/img/mon.png') }}" alt="medium-SWITCH"
                                        class="img-fluid"></a></li>
                        </ul>
                        <ul class="term">
                            <li>Privacy Policy </li>
                            <li>Terms of Service</li>
                            <li>Security</li>
                            <li>Support</li>
                        </ul>
                        <h5>SWITCH 2022 - ALL rights reserved</h5>
                    </div>


                </div>
            </div>



        </div>
    </section>






    <script type="text/javascript">
    var obj = {
        values: [40, 20, 20, 20, 100],
        colors: ['#F2A434', '#784700', '#B66C00', '#FF9700', '#E3B36F'],
        animation: true, // Takes boolean value & default behavious is false
        animationSpeed: 10, // Time in miliisecond & default animation speed is 20ms
        fillTextData: true, // Takes boolean value & text is not generate by default 
        fillTextColor: '#fff', // For Text colour & default colour is #fff (White)
        fillTextAlign: 1.30, // for alignment of inner text position i.e. higher values gives closer view to center & default text alignment is 1.85 i.e closer to center
        fillTextPosition: 'inner', // 'horizontal' or 'vertical' or 'inner' & default text position is 'horizontal' position i.e. outside the canvas
        doughnutHoleSize: 50, // Percentage of doughnut size within the canvas & default doughnut size is null
        doughnutHoleColor: '#212121', // For doughnut colour & default colour is #fff (White)
        offset: 1, // Offeset between two segments & default value is null
        pie: 'normal', // if the pie graph is single stroke then we will add the object key as "stroke" & default is normal as simple as pie graph
        isStrokePie: {
            stroke: 20, // Define the stroke of pie graph. It takes number value & default value is 20
            overlayStroke: true, // Define the background stroke within pie graph. It takes boolean value & default value is false
            overlayStrokeColor: '#eee', // Define the background stroke colour within pie graph & default value is #eee (Grey)
            strokeStartEndPoints: 'Yes', // Define the start and end point of pie graph & default value is No
            strokeAnimation: true, // Used for animation. It takes boolean value & default value is true
            strokeAnimationSpeed: 40, // Used for animation speed in miliisecond. It takes number & default value is 20ms
            fontSize: '50px', // Used to define text font size & default value is 60px
            textAlignement: 'center', // Used for position of text within the pie graph & default value is 'center'
            fontFamily: 'Arial', // Define the text font family & the default value is 'Arial'
            fontWeight: 'bold' //  Define the font weight of the text & the default value is 'bold'
        }
    };


    //Generate myCanvas     
    generatePieGraph('myCanvas', obj);
    </script>


    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

    <!-- <script type="application/javascript" src="{{ url('assets/js/owl.carousel.js') }}"></script> -->




    <script type="text/javascript">
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].className = tabcontent[i].className.replace(" active", "");
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).className += " active";
        evt.currentTarget.className += " active";
    }
    </script>



    <script type="text/javascript">
    $(".tab_content").hide().first().show();
    $(".tabs li a").on("click", function(event) {
        // keep the anchor from triggering.
        event.preventDefault();
        // get the clicked anchor
        let tabEl = $(this);
        // get its text
        let targetName = tabEl.text();
        // use that text to choose the right tab.
        $(".tab_wrapper [name='" + targetName + "']").show().siblings().hide();
    });
    </script>

    <script type="text/javascript">
    // Timeline Scroll Section
    // --------------------------------------------------------------
    var items = $(".timeline li"),
        timelineHeight = $(".timeline ul").height(),
        greyLine = $('.default-line'),
        lineToDraw = $('.draw-line');

    // sets the height that the greyLine (.default-line) should be according to `.timeline ul` height

    // run this function only if draw line exists on the page
    if (lineToDraw.length) {
        $(window).on('scroll', function() {

            // Need to constantly get '.draw-line' height to compare against '.default-line'
            var redLineHeight = lineToDraw.height(),
                greyLineHeight = greyLine.height(),
                windowDistance = $(window).scrollTop(),
                windowHeight = $(window).height() / 2,
                timelineDistance = $(".timeline").offset().top;

            if (windowDistance >= timelineDistance - windowHeight) {
                line = windowDistance - timelineDistance + windowHeight;

                if (line <= greyLineHeight) {
                    lineToDraw.css({
                        'height': line + 20 + 'px'
                    });
                }
            }

            // This takes care of adding the class in-view to the li:before items
            var bottom = lineToDraw.offset().top + lineToDraw.outerHeight(true);
            items.each(function(index) {
                var circlePosition = $(this).offset();

                if (bottom > circlePosition.top) {
                    $(this).addClass('in-view');
                } else {
                    $(this).removeClass('in-view');
                }
            });
        });
    }
    </script>


    <script src="{{ url('assets/js/vanilla-tilt.min.js') }}"></script>

    <script>
    $(document).ready(function() {
        $(".close-menu").click(function() {
            $("#collapsibleNavbar").removeClass("show");
        });
    });
    </script>


    <script>
    var doc = new jsPDF('l', 'mm', [1200, 1810]);
    var specialElementHandlers = {
        '#editor': function(element, renderer) {
            return true;
        }
    };

    $('.download').click(function() {

        window.open("{{ url('/Whitepaper1.pdf') }}", "_blank");
    })
    </script>




    <script type="text/javascript">
    let slideIndex = 1;
    let numSlides = document.getElementsByClassName("slide").length;
    let translateValue = (numSlides - 1) * -100;
    showSlides(slideIndex);

    // Next/previous controls
    function changeSlide(n) {
        showSlides((slideIndex += n));
    }

    // Thumbnail image controls
    function currentSlide(n) {
        showSlides((slideIndex = n));
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("slide");
        let dots = document.getElementsByClassName("dotss");
        let bgs = document.getElementsByClassName("slide-photo");
        if (n > slides.length) {
            slideIndex = 1;
        }
        if (n < 1) {
            slideIndex = slides.length;
        }

        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }

        translateValue = (slideIndex - 1) * -100;

        for (i = 0; i < bgs.length; i++) {
            bgs[i].style.translate = String(translateValue).concat("%");
        }

        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
    }
    </script>




    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
    AOS.init({
        once: false,
        delay: 50
    });
    </script>

    <script>
    var videoPlayButton,
        videoWrapper = document.getElementsByClassName('video-wrapper')[0],
        video = document.getElementsByTagName('video')[0],
        videoMethods = {
            renderVideoPlayButton: function() {
                if (videoWrapper.contains(video)) {
                    this.formatVideoPlayButton()
                    video.classList.add('has-media-controls-hidden')
                    videoPlayButton = document.getElementsByClassName('video-overlay-play-button')[0]
                    videoPlayButton.addEventListener('click', this.hideVideoPlayButton)
                }
            },

            formatVideoPlayButton: function() {
                videoWrapper.insertAdjacentHTML('beforeend', '\
                <svg class="video-overlay-play-button" viewBox="0 0 200 200" alt="Play video">\
                    <circle cx="100" cy="100" r="90" fill="none" stroke-width="15" stroke="#fff"/>\
                    <polygon points="70, 55 70, 145 145, 100" fill="#fff"/>\
                </svg>\
            ')
            },

            hideVideoPlayButton: function() {
                video.play()
                videoPlayButton.classList.add('is-hidden')
                video.classList.remove('has-media-controls-hidden')
                video.setAttribute('controls', 'controls')
            }
        }

    videoMethods.renderVideoPlayButton()
    </script>


    <!-- 
<script>
            $(document).ready(function() {
              $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                responsiveClass: true,
                autoplay: true,
                responsive: {
                  0: {
                    items: 1,
                    nav: true
                  },
                  600: {
                    items: 2,
                    nav: false
                  },
                  1000: {
                    items: 4,
                    nav: true,
                    loop: true,
                    margin: 20
                  }
                }
              })
            })
          </script> -->

</body>

</html>