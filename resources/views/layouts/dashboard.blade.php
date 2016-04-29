<!doctype html>
<html class="no-js" lang="en" ng-app="app">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <title>Ajaib - @yield('title')</title>
    <base href="/" />
    <!-- pace loader -->
    @section('style')
        <!--Import Google Icon Font-->
        <link href="{{secure_asset('css/materialize/material-icon.css')}}" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="{{secure_asset('css/materialize/materialize.css')}}" media="screen,projection" />
        <link type="text/css" rel="stylesheet" href="{{secure_asset('css/materialize/jquery.webui-popover.css')}}" media="screen,projection" />
        <link type="text/css" rel="stylesheet" href="{{secure_asset('css/materialize/akram-style.css')}}" media="screen,projection" />
        <link rel="stylesheet" type="text/css" href="{{secure_asset('css/materialize/component.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{secure_asset('/css/materialize/glyphicon.css')}}" />
        <!--Let browser know website is optimized for mobile-->
        <!-- <script src="js/modernizr.custom.js"></script> -->
        <link rel="stylesheet" type="text/css" href="{{secure_asset('/css/font-awesome.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{secure_asset('/css/dripicon.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{secure_asset('/css/typicons.css')}}" />
        <link href="{{ secure_asset('/favicon.ico') }}" type="image/x-icon" rel="icon"/>
        <link href="{{ secure_asset('/favicon.ico') }}" type="image/x-icon" rel="shortcut icon"/>
        <link rel="stylesheet" type="text/css" href="{{elixir('css/main.css')}}">
    @show

    @section('css')
        {{-- expr --}}
    @show

    <!-- pace loader -->
    @section('script')
        {{-- Main Script --}}
        <script>
            document.cookie = 'XSRF-TOKEN={{csrf_token()}}';            
        </script>
    @show
<body>
<!-- preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<!-- End of preloader -->

<ul id="gn-menu" class="gn-menu-main">
    <!-- Left side bar -->
    <li class="gn-trigger">
        @if (Auth::check())
            @include('common.dashboard.leftnav')
        @endif        
    </li>
    <!-- End of Left side bar -->
    <!-- Logo ajaib -->
    @include('common.dashboard.topbar')    
</ul>

@include('common.dashboard.rightchatbar')
<br/>
<br/>
<br/>
<nav ng-controller="BreadcrumbController">
    <div class="nav-wrapper">
        <div class="col s12">
            <a href="#" class="breadcrumb">&nbsp;[['Home' | ucfirst]]</a >
            <a ng-repeat="breadcrumb in breadcrumbs.getAll()" ng-if="!isNumber([[breadcrumb.name]])" ng-class="{'active' : $last}" class="breadcrumb" href="[[breadcrumb.path]]" >[[breadcrumb.name | ucfirst]]</a>
        </div>
    </div>
</nav>
            
            

<!-- Container Begin -->

<!-- notification -->
@yield('notification')
<!-- end of notification -->
@include('flash::message')

<!-- /container -->
<div class="akram-container">
    <span></span>
    <!-- Page Content goes here -->
    <div class="ajaib-slimscroll">
        <!-- Content Begin -->
        <div class="row">
            <div class="col-md-12">
                <div ng-view>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end of content -->
@if (Auth::check())
    @include('common.dashboard.chatbar')
@endif

<!-- end of Container Begin -->
<footer>
    <div id="footer">Copyright &copy; 2015 <a href="http://ajaib.co">Ajaib</a> Made with keyboard and hardwork <i class="fontello-heart-1 text-green"></i></div>
</footer>




<!-- End of Container Begin -->

<!-- end of off-canvas-wrap -->
<!-- end of inner-wrap -->

@section('script-lib')
    {{-- script library --}}
    <script type='text/javascript' src="{{secure_asset('/js/jquery.js')}}"></script>
    <script type='text/javascript' src="{{elixir('js/vendor.js')}}"></script>
    <script type='text/javascript' src="{{elixir('js/main.js')}}"></script>
    <script type='text/javascript' src="{{secure_asset('/js/preloader-script.js')}}"></script>
    <script type="text/javascript" src="{{secure_asset('js/materialize/materialize.js')}}"></script>
    <script type="text/javascript" src="{{secure_asset('js/materialize/jquery.webui-popover.js')}}"></script>
    <script type="text/javascript" src="{{secure_asset('js/materialize/jquery.slimscroll.min.js')}}"></script>
    <script type="text/javascript" src="{{secure_asset('js/materialize/slimscroll.app.js')}}"></script>
    <script type="text/javascript" src="{{secure_asset('js/materialize/materialize.app.js')}}"></script>
    <script src="{{secure_asset('js/materialize/classie.js')}}"></script>
    <script src="{{secure_asset('js/materialize/gnmenu.js')}}"></script>
    <script>
        new gnMenu(document.getElementById('gn-menu'));
    </script>
    <script type='text/javascript' src="{{ secure_asset('/js/vendor/js-cookie/js.cookie.js') }}"></script>
    <script>
    jQuery(function() {
        $('.chat-pop-over').webuiPopover({
            placement: 'auto-top',
            padding: false,
            width: '300', //can be set with  number
            //height:'300',//can be set with  number
            height: '400', //can be set with  number
            animation: 'pop',
            trigger: 'click',
            offsetTop: -5, // offset the top of the popover
            multi: true, //allow other popovers in page at same time
            dismissible: true, // if popover can be dismissed by  outside click or escape key
            closeable: true //display close button or not
        });


        setInterval(function() {
            $(".chat-blink").toggleClass("backgroundBlink");
        }, 1500);

        // init user properties
        if(Cookies.get('geoip') === undefined) {
            var url     = '{!! url("/geo-ip") !!}';
            $.getJSON( url, function( data ) {
                Cookies.set('geoip', data, { expires: 1, path : '/'});
            }, 'json');
        }

    })

    $(document).on('click', '.close-box', function() {
        $(this).parent().fadeTo(300, 0, function() {
            $(this).remove();
        });
    });
    </script>
@show

@section('script-bottom')
    {{-- script bottom: additional script js --}}

@show

<toasty></toasty>
</body>
</html>