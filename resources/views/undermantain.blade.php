<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Switch | UnderConstruction</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="Switch" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('assets/img/favicon/favicon-16x16.png') }}">


    <style>
        section.underconstruction .logo-part {
            background: #000;
            padding: 25px 0;
            text-align: center;
        }

        section.underconstruction {
            height: 100vh;
            background-image: url(../assets/img/Under-bg.svg);
            /* padding-bottom: 90px; */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        section.underconstruction .under-text h1 span {
            font-style: normal;
            font-weight: 700;
            font-size: 90px !important;
            line-height: 138.5%;
            background: linear-gradient(50deg, #A3743C 0%, rgba(250, 197, 121, 0.90) 49.27%, #A3743C 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        section.underconstruction .under-text h1 {
            color: #FFF;
            font-size: 96.207px;
            font-style: normal;
            font-weight: 600;
            line-height: 0.2;
        }

        .under-text {
            display: flex;
            align-items: flex-start;
            position: absolute;
            bottom: 200px;
            flex-direction: column;
            gap: 50px;
        }

        @media (max-width:1199.98px) {
            section.underconstruction {
                background: none;
            }

            section.underconstruction.mobile {
                height: 100vh;
                background-image: url(../assets/img/under-bg-mobile.svg) !important;
                /* padding-bottom: 90px; */
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }

            .under-text {
                bottom: 100px;
                margin-left: 50px;
            }

            section.underconstruction .under-text h1 {
                font-size: 50px !important;
            }

            section.underconstruction .under-text h1 span {
                font-size: 60px !important;
            }
        }
    </style>

</head>

<body class="homepage-page">


    <section class="underconstruction mobile">
        <div class="logo-part">
            <a href="/">
                <img src="{{ url('assets/img/logo-header.svg') }}" alt="switch-logo" class="join-button">
            </a>
        </div>
        <div class="contain-width">

            <div class="under-text">
                <h1><span>UNDER</span> <br>construction </h1>

                <div class="token-buy">
                    <a href="/"> <img src="{{ url('assets/img/Stay-tune.svg') }}" alt="Stay-tune"
                            class="img-fluid sign-up" style="cursor: pointer;"></a>
                </div>
            </div>



        </div>
    </section>

</body>

</html>