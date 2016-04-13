<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <title>Ajaib - @yield('title')</title>

    <link rel="stylesheet" type="text/css" href="{{ secure_asset('/css/bootstrap.css') }}" />
    @section('style')
        {{-- append css here --}}
    @show
</head>
    <body>
        @yield('content')
    </body>
</html>