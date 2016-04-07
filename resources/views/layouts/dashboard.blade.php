<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <title>Ajaib - @yield('title')</title>

    <!-- pace loader -->
    @section('style')
        <link rel="stylesheet" type="text/css" href="{{ secure_asset('/css/bootstrap.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ secure_asset('/css/jquery.webui-popover.css') }}" />
        <!-- Custom styles for this template -->
        <link rel="stylesheet" type="text/css" href="{{ secure_asset('/css/dashboard.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ secure_asset('/css/dashboard.style.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ secure_asset('/css/dripicon.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ secure_asset('/css/typicons.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ secure_asset('/css/font-awesome.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ secure_asset('/css/theme.css') }}" />
        <link rel="stylesheet" href="{{ secure_asset('js/slicknav/slicknav.css') }}" />
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css">
        <!-- Slidebars CSS -->
        <link rel="stylesheet" href="{{ secure_asset('js/offcanvas/sidetogglemenu.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ secure_asset('/js/vendor/alertify.js/themes/alertify.core.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ secure_asset('/js/vendor/alertify.js/themes/alertify.default.css') }}">

        <link href="{{  secure_asset('/favicon.ico') }}" type="image/x-icon" rel="icon"/>
        <link href="{{  secure_asset('/favicon.ico') }}" type="image/x-icon" rel="shortcut icon"/>
    @show

    @section('css')
        {{-- expr --}}
    @show

    <!-- pace loader -->
    @section('script')
        {{-- Main Script --}}
    @show
<body>
<!-- preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<!-- End of preloader -->

<div class="off-canvas-wrap" data-offcanvas>
    <!-- right sidebar wrapper -->
    <div class="inner-wrap">
        @if (Auth::check())
            @include('common.dashboard.leftnav')
        @endif
        <div class="wrap-fluid" id="paper-bg">
            @include('common.dashboard.topbar')

            @section('breadcrumbs')
            <ul class="breadcrumbs">
                @if (Breadcrumbs::exists($routing->getName))
                    {!! Breadcrumbs::renderIfExists() !!}
                @else
                    <li class="active">
                        <i class="fontello-home"></i>
                    </li>
                @endif
            </ul>
            <!-- breadcrumbs -->
            {{-- <ul class="breadcrumbs">
                <li>
                    <a href="{{ route('admin::dashboard') }}">
                        <span class="fontello-home"></span>
                    </a>
                </li>
            </ul>
            <!-- end of breadcrumbs --> --}}
            @show

            <!-- Container Begin -->

            <!-- notification -->
            @yield('notification')
            <!-- end of notification -->
            @include('flash::message')

            <!-- Content Begin -->
            <div class="row">
                <div class="col-md-12">
                    @yield('content')
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
            @include('common.dashboard.rightchatbar')
        </div>

        <!-- End of Container Begin -->


    </div>
    <!-- end paper bg -->

</div>

<!-- end of off-canvas-wrap -->
<!-- end of inner-wrap -->

@section('script-lib')
    {{-- script library --}}
    <script type='text/javascript' src="{{ secure_asset('/js/jquery.js') }}"></script>
    <script type='text/javascript' src="{{ secure_asset('/js/preloader-script.js') }}"></script>
    <!-- bootstrap javascript -->
    <script type='text/javascript' src="{{ secure_asset('/js/bootstrap.js') }}"></script>
    <script type='text/javascript' src="{{ secure_asset('/js/jquery.webui-popover.js') }}"></script>

    <!-- main edumix javascript -->
    <script type='text/javascript' src="{{ secure_asset('/js/slimscroll/jquery.slimscroll.js') }}"></script>
    <script type='text/javascript' src="{{ secure_asset('/js/slicknav/jquery.slicknav.js') }}"></script>
    <script type='text/javascript' src="{{ secure_asset('/js/sliding-menu-fixed.js') }}"></script>
    <script type='text/javascript' src="{{ secure_asset('/js/scriptbreaker-multiple-accordion-1.js') }}"></script>
    <script type='text/javascript' src="{{ secure_asset('/js/app.js') }}"></script>
    <script type='text/javascript' src="{{ secure_asset('/js/vendor/js-cookie/js.cookie.js') }}"></script>
    <script type='text/javascript' src="{{ secure_asset('/js/vendor/alertify.js/lib/alertify.min.js') }}"></script>
    <!-- FLOT CHARTS -->
    <script src="{{secure_asset('/js/offcanvas/sidetogglemenu.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.js"></script>
    <!-- <script src="{{secure_asset('js/offcanvas/jPushMenu.js')}}"></script> -->
@show

@section('script-bottom')
    {{-- script bottom: additional script js --}}
    <script>
        // init user properties
        if(Cookies.get('geoip') === undefined) {
            var url     = '{!! url("/geo-ip") !!}';
            $.getJSON( url, function( data ) {
                Cookies.set('geoip', data, { expires: 1, path : '/'});
            }, 'json');
        }

        // console.log(geo());
        // init pubnub key
        jQuery(function() {
            //$('.chat-pop-over').popover();
            $('.chat-pop-over').webuiPopover({
                placement:'auto-top',
                padding:false,
                width:'300',//can be set with  number
                //height:'300',//can be set with  number
                height:'400',//can be set with  number
                animation:'pop',
                trigger:'click',
                offsetTop:-5,  // offset the top of the popover
                multi:true,//allow other popovers in page at same time
                dismissible:true, // if popover can be dismissed by  outside click or escape key
                closeable:true//display close button or not
            });

                menu2 = new sidetogglemenu({ // initialize second menu example
                id: 'right_chat_menu',
                position: 'right',
                pushcontent: false,
                //source: 'togglemenu.txt',
                revealamt: -5
            });

            setInterval(function(){
                $(".chat-blink").toggleClass("backgroundBlink");
            },1500);

        });
    </script>

@show
</body>
</html>