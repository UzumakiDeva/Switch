<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1">  
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@if(isset($title))
<title>{{ $title.'|'.config('app.name', $title.'|'.'Switch | Crypto Asset Exchange') }}</title>
@else
	<title>{{ config('app.name', 'Switch | Crypto Asset Exchange') }}</title>
@endif
<link rel="icon" type="image/png" sizes="32x32" href="{{ url('favicon/favicon-32x32.png') }}">
<link rel="stylesheet" href="{{ url('css/bootstrap1.min.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ url('font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ url('css/datepicker.min.css') }}">	 
<link rel="stylesheet" href="{{ url('css/user_new.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> 	 
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>


@if(Session::get('mode') == 'nightmode')
	<body class="pagewrapperbox darkmode">
@else
<body class="pagewrapperbox light">
@endif