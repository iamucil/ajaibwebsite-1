<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <title>Ajaib - @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/jquery.webui-popover.css')}}" />
    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/dashboard.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/dashboard.style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/dripicon.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/typicons.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/theme.css')}}" />
    <!-- pace loader -->
    @section('script')
        {{-- Main Script --}}
        <link rel="stylesheet" href="{{asset('js/slicknav/slicknav.css')}}" />
        <!-- Slidebars CSS -->
        <link rel="stylesheet" href="{{asset('js/offcanvas/sidetogglemenu.css')}}" />
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
            <!-- breadcrumbs -->
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <span class="entypo-home"></span>
                    </a>
                </li>
                <li>
                    Dashboard
                </li>
            </ul>
            <!-- end of breadcrumbs -->
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
                <div id="footer">Copyright &copy; 2015 <a href="http://ajaib.co">Ajaib</a> Made with <i class="fontello-heart-1 text-green"></i></div>
            </footer>
        </div>

        <!-- End of Container Begin -->


    </div>
    <!-- end paper bg -->

</div>
@include('common.dashboard.rightchatbar')
<!-- end of off-canvas-wrap -->
<!-- end of inner-wrap -->

@section('script-lib')
    {{-- script library --}}
    <script type='text/javascript' src="{{asset('/js/jquery.js')}}"></script>
    <script type='text/javascript' src="{{asset('/js/preloader-script.js')}}"></script>
    <!-- bootstrap javascript -->
    <script type='text/javascript' src="{{asset('/js/bootstrap.js')}}"></script>
    <script type='text/javascript' src="{{asset('/js/jquery.webui-popover.js')}}"></script>

    <!-- main edumix javascript -->
    <script type='text/javascript' src="{{asset('/js/slimscroll/jquery.slimscroll.js')}}"></script>
    <script type='text/javascript' src="{{asset('/js/slicknav/jquery.slicknav.js')}}"></script>
    <script type='text/javascript' src="{{asset('/js/sliding-menu.js')}}"></script>
    <script type='text/javascript' src="{{asset('/js/scriptbreaker-multiple-accordion-1.js')}}"></script>
    <script type='text/javascript' src="{{asset('/js/app.js')}}"></script>

    <!-- FLOT CHARTS -->
    <script src="{{asset('/js/offcanvas/sidetogglemenu.js')}}"></script>
    <!-- <script src="{{asset('js/offcanvas/jPushMenu.js')}}"></script> -->
@show

@section('script-bottom')
    {{-- script bottom: additional script js --}}
    <script>
       jQuery(function() {
            //$('.chat-pop-over').popover();
            $('.chat-pop-over').webuiPopover({
                placement:'auto',
                 padding:false,
                width:'300',//can be set with  number
                //height:'300',//can be set with  number
                height:'400',//can be set with  number
                animation:'',
                 offsetTop:-18,  // offset the top of the popover
                multi:true,//allow other popovers in page at same time
                 dismissible:false, // if popover can be dismissed by  outside click or escape key
                 closeable:true//display close button or not
            });

                menu2 = new sidetogglemenu({ // initialize second menu example
                id: 'right_chat_menu',
                position: 'right',
                pushcontent: false,
                //source: 'togglemenu.txt',
                revealamt: -5
            })

        setInterval(function(){
            $(".chat-active").toggleClass("backgroundBlink");
         },1500)

        })


    </script>
@show
</body>
</html>