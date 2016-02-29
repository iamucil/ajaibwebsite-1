<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Chat - @yield('title')</title>
    <meta name="description" content="Ajaib is personal assistant application">
    <meta name="keywords" content="assistant, personal assistant">
    <meta name="author" content="getajaib.com">
    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/fonts/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/flaticon.css') }}">
    <!-- Slider
    ================================================== -->
    <link href="{{ asset('/css/owl.carousel.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('/css/owl.theme.css') }}" rel="stylesheet" media="screen">
    <!-- Stylesheet
    ================================================== -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/intlTelInput.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700,900,500,400italic' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="{{ asset('/js/modernizr.custom.js') }}"></script>
    <link href="{{ asset('/favicon.ico') }}" type="image/x-icon" rel="icon"/>
    <link href="{{ asset('/favicon.ico') }}" type="image/x-icon" rel="shortcut icon"/>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    {{-- Top Bar Section --}}
    @include('common.navigations')

    {{-- content section --}}
    @yield('content')

    {{-- footer section --}}
    <nav id="footer">
        <div class="container">
            <div class="pull-left fnav">
                <p>All right reserved. Copyright @ 2015. Powered by <a href="#" target="_blank">Jet Company </a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-envelope"></span> &nbsp;&nbsp;info@getajaib.com</p>
            </div>
            <div class="pull-right fnav">
                <ul class="footer-social">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

    @section('script-bottom')
        {{-- place javascript here --}}
        <script type="text/javascript">
        var server      = window.location.host;
        var protocol    = 'https:' == document.location.protocol ? 'https:' : 'http:';
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="{{ asset('/js/intlTelInput.js') }}"></script>
        {{-- Include all compiled plugins (below), or include individual files as needed --}}
        <script src="{{ asset('/js/bootstrap.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/SmoothScroll.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/jquery.isotope.js') }}"></script>
        <script src="{{ asset('/js/owl.carousel.js') }}"></script>
        {{-- Javascripts mail --}}
        <script type="text/javascript" src="{{ asset('/js/main.js') }}"></script>
    @show
</body>

</html>