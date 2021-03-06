<!DOCTYPE html>
<html>
<head>
   <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajaib - @yield('title')</title>
    <meta name="description" content="Ajaib is personal assistant application">
    <meta name="keywords" content="assistant, personal assistant">
    <meta name="author" content="getajaib.com">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{secure_asset('/css/dripicon.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{secure_asset('/css/typicons.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{secure_asset('/css/bootstrap.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('/fonts/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('/css/authentication.css') }}">
    <link href="{{ secure_asset('/favicon.ico') }}" type="image/x-icon" rel="icon"/>
    <link href="{{ secure_asset('/favicon.ico') }}" type="image/x-icon" rel="shortcut icon"/>
</head>
<body>
    @yield('content')

    @section('script-bottom')
        {{-- place javascript here --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        {{-- Include all compiled plugins (below), or include individual files as needed --}}
        <script src="{{ secure_asset('/js/bootstrap.js') }}"></script>
    @show
</body>
</html>