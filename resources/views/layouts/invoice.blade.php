<html>
<head>
    <title>ajaib invoice #@yield('title', '00')</title>
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('/css/bootstrap.css') }}">
    <style type="text/css">
        .invoice-title h2, .invoice-title h3 {
            display: inline-block;
        }

        .table > tbody > tr > .no-line {
            border-top: none;
        }

        .table > thead > tr > .no-line {
            border-bottom: none;
        }

        .table > tbody > tr > .thick-line {
            border-top: 2px solid;
        }
    </style>
</head>
<body>
    <div class="container">
    @yield('content')
    </div>
</body>
</html>