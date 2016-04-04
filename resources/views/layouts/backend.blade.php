<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ajaib - @yield('title')</title>

    <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/jquery.webui-popover.css')}}" />
    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="{{asset('/css/dashboard.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/dashboard.style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/dripicon.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/typicons.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/font-awesome.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/theme.css')}}" />

    <!-- pace loader -->

    <link rel="stylesheet" href="{{asset('js/slicknav/slicknav.css')}}" />
    <!-- Slidebars CSS -->
    <link rel="stylesheet" href="{{asset('js/offcanvas/sidetogglemenu.css')}}" />


<body>
<!-- preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<!-- End of preloader -->

<div class="off-canvas-wrap" data-offcanvas>
    <!-- right sidebar wrapper -->
    <div class="inner-wrap">

        @section('sidebar')
                <!-- Right sidemenu -->
            <div id="skin-select" class="fixed-nest ">
                <!--      Toggle sidemenu icon button -->
                <a id="toggle">
                    <span class="fa icon-menu"></span>
                </a>
                <!--      End of Toggle sidemenu icon button -->

                <div class="skin-part fixed-ajaib-sidemenu">
                    <div id="tree-wrap">
                        <!-- Profile -->
                        <div class="profile">
                            <img alt="" class="" src="./img/logo.png">
                            <h3>EDUMIX <small>1.2</small></h3>

                        </div>
                        <!-- End of Profile -->

                        <!-- Menu sidebar begin-->
                        <div class="fixed-nest-sidebar">
                            <div class="side-bar sidebar-fixed">
                                <ul id="menu-showhide" class="topnav slicknav">
                                    <li>
                                        <a id="menu-select" class="tooltip-tip" href="index.html" title="Dashboard">
                                            <i class="icon-monitor"></i>
                                            <span>Dashboard</span>

                                        </a>

                                    </li>
                                    <li>
                                        <a class="tooltip-tip" href="#">
                                            <i class=" icon-window"></i>
                                            <span>Layout<small class="side-menu-noft">New</small></span>

                                        </a>
                                        <ul>


                                            <li>

                                                <a href="sidebar-fixed.html">Sidebar Fixed</a>
                                            </li>
                                            <li>

                                                <a href="all-fixed.html">All Fixed</a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li>
                                        <a class="tooltip-tip" href="#" title="Mail">
                                            <i class=" icon-preview"></i>
                                            <span>Skin</span>

                                        </a>
                                        <ul>

                                            <li>
                                                <a href="blue-skin.html" title="Black Skin">Blue Skin</a>
                                            </li>
                                            <li>

                                                <a href="white-skin.html" title="White Skin">White Skin</a>
                                            </li>
                                            <li>

                                                <a href="green-skin.html" title="Blue Skin">Green Skin</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a class="tooltip-tip" href="#" title="Mail">
                                            <i class=" icon-mail"></i>
                                            <span>mail</span>

                                        </a>
                                        <ul>
                                            <li>
                                                <a href="mail.html" title="Inbox">Inbox
                                                 <div class="noft-blue bg-red" style="display: inline-block; float: none;">256</div>
                                            </a>
                                            </li>
                                            <li>

                                                <a href="compose.html" title="Compose">Compose</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="icon-document-new"></i>
                                            <span>Page&nbsp;
                                    <small class="side-menu-noft bg-blue">hot</small></span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="bootstrap/index.html">Bootstrap<div class="noft-blue bg-red" style="display: inline-block; float: none;"><strong>NEW</strong></div></a>
                                            </li>
                                            <li>
                                                <a href="blog-list.html">Blog List</a>
                                            </li>
                                            <li>
                                                <a href="blog-detail.html">Blog Detail</a>
                                            </li>
                                            <li>
                                                <a href="gallery.html">Gallery</a>
                                            </li>
                                            <li>
                                                <a href="calendar.html" title="Calender">Calendar</a>
                                            </li>
                                            <li>
                                                <a href="master.html" title="Chart">Blank Page</a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li>
                                        <a class="tooltip-tip" href="#" title="UI">
                                            <i class="icon-align-justify"></i>
                                            <span>UI&nbsp;
                                    <small class="side-menu-noft">new</small></span>
                                        </a>
                                        <ul>

                                            <li>
                                                <a href="element.html" title="Element">Element</a>
                                            </li>
                                            <li><a href="button.html" title="Button">
                                            Button
                                        </a>
                                            </li>
                                            <li>
                                                <a href="tab.html" title="Tab & Accordion">Tab & Accordion</a>
                                            </li>
                                            <li>
                                                <a href="typography.html" title="Typography">

                                                Typography
                                            </a>
                                            </li>
                                            <li>
                                                <a href="panel.html" title="panel">Panel</a>
                                            </li>

                                            <li>
                                                <a href="grids.html" title="Grids">Grids</a>
                                            </li>
                                            <li>
                                                <a href="chart.html" title="Chart">Chart</a>
                                            </li>


                                        </ul>
                                    </li>


                                    <li>
                                        <a href="#">
                                            <i class="fontello-doc-1"></i>
                                            <span>Form&nbsp;  <small class="side-menu-noft">new</small></span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="form-element.html" title="Form Elements">Form Elements</a>
                                            </li>
                                            <li>
                                                <a href="andvance-form.html" title="Andvance Form">Andvance Form</a>
                                            </li>
                                            <li>
                                                <a href="text-editor.html" title="Text Editor">Text Editor</a>
                                            </li>
                                            <li>
                                                <a href="file-upload.html" title="File Upload">File Upload</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class=" icon-view-list-large"></i>
                                            <span>Tables</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="table-static.html" title="Table Static">Table Static</a>
                                            </li>
                                            <li>
                                                <a href="table-dynamic.html" title="Table Dynamic">Table Dynamic</a>

                                            </li>

                                        </ul>
                                    </li>
                                    <li>
                                        <a class="tooltip-tip" href="icon.html" title="Icons">
                                            <i class="fontello-print"></i>
                                            <span>Icons</span>

                                        </a>
                                    </li>

                                    <li style="height:400px">
                                        <a class="tooltip-tip" href="#" title="Extra">
                                            <i class="fontello-beaker"></i>
                                            <span>Extra</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="invoice.html" title="Invoice">Invoice</a>
                                            </li>
                                            <li>
                                                <a href="pricing_table.html" title="Pricing Table">Pricing Table</a>
                                            </li>
                                            <li>
                                                <a href="time-line.html" title="Time Line">Time Line</a>
                                            </li>
                                            <li>
                                                <a href="login.html" title="Chart">Login</a>
                                            </li>
                                            <li>
                                                <a href="map.html" title="Lock Screen">Map</a>
                                            </li>
                                            <li>
                                                <a href="404.html" title="404 Error Page">404 Error Page</a>
                                            </li>
                                            <li>
                                                <a href="500.html" title="500 Error Page">500 Error Page</a>
                                            </li>

                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- end of Menu sidebar  -->
                        <ul class="bottom-list-menu">
                            <li>Settings <span class="icon-gear"></span>
                            </li>
                            <li>Help <span class="icon-phone"></span>
                            </li>
                            <li>About Edumix <span class="icon-music"></span>
                            </li>

                        </ul>

                    </div>
                </div>
            </div>
            <!-- end of Rightsidemenu -->

        @show

        <div class="wrap-fluid" id="paper-bg">
            @section('navbar')
            <!-- top nav -->
            <nav class="navbar navbar-default top-bar-nest">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle text-gray" data-toggle="dropdown" role="button" aria-expanded="false"><img alt="" class="admin-pic img-circle" src="http://api.randomuser.me/portraits/thumb/men/28.jpg"> Hi, Dave Mattew <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-nest profile-dropdown" role="menu">
                                    <li><a href="#"><i class="icon-user"></i> Profile<span class="text-aqua fontello-record" ></span></a>
                                    </li>
                                    <li><a href="#">Another action</a>
                                    </li>
                                    <li><a href="#">Something else here</a>
                                    </li>

                                </ul>
                            </li>


                        </ul>
                        <form class="navbar-form navbar-left" style="position:relative" role="search">
                            <!-- Search | has-form wrapper -->
                            <div class="dark"></div>
                            <input class="input-top" type="text" placeholder="search">
                        </form>

                        <ul class="nav navbar-nav navbar-right">
                            <!--  message end -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fontello-chat"></i>&nbsp;&nbsp;<span class="label edumix-msg-noft">999</span><span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-nest" role="menu">
                                    <li class="top-dropdown-nest"><span class="label round bg-green">MESSAGE</span>
                                    </li>
                                    <li class="edumix-sticky-title">
                                        <a href="#">
                                            <h3 class=" text-black"> Big Boss<b class="text-red fontello-record" ></b><span>Just Now<small></small></span>
                                            </h3>
                                            <p class=" text-black">Important task!</p>
                                        </a>
                                    </li>

                                    <li>
                                        <div class="slim-scroll">

                                            <div>
                                                <a href="#">
                                                    <h3>Noel A. Riley<b class="text-green fontello-record" ></b><span>12:23<small>PM</small></span>
                                                    </h3>
                                                    <p>Dua dua sayang adik kakak</p>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#">
                                                    <h3>Shirley J. Carneal<b class="text-gray fontello-record" ></b><span>10:11<small>PM</small></span>
                                                    </h3>
                                                    <p>Tiga tiga sayang kekasihku</p>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#">
                                                    <h3>Paul L. Williamsr<b class="text-gray fontello-record" ></b><span>Yesterday</span>
                                                    </h3>
                                                    <p>Empat empat sayang semuanya</p>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#">
                                                    <h3>William L. Wilcox<b class="text-gray fontello-record" ></b><span>2 Days Ago</span>
                                                    </h3>
                                                    <p>Yang jomblo kasian deh lu</p>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="bg-white pull-right">
                                        <a href="#">
                                            <div class="label bg-white">View All</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- message end -->
                            <!--  notification nest -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fontello-comment"></i>&nbsp;&nbsp;<span class="label edumix-noft">45</span><span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-nest" role="menu">
                                    <li class="top-dropdown-nest"><span class="label round bg-blue">ALERT</span>
                                    </li>

                                    <li>
                                        <div class="slim-scroll">
                                            <div class="unread-notf">

                                                <a href="#">
                                                    <h3>0809272382
                                                    </h3>
                                                    <p>Just Now !</p>
                                                </a>
                                            </div>
                                            <div class="read-notf">

                                                <a href="#">
                                                    <h3>+62 082347823473
                                                    </h3>
                                                    <p>2 Minute Ago</p>
                                                </a>
                                            </div>
                                            <div class="read-notf">

                                                <a href="#">
                                                    <h3>+62 3453454353
                                                    </h3>
                                                    <p>30 Minute ago</p>
                                                </a>
                                            </div>
                                            <div class="read-notf">

                                                <a href="#">
                                                    <h3>+62 34542524553454
                                                    </h3>
                                                    <p>1 Hour ago</p>
                                                </a>
                                            </div>
                                            <div class="read-notf">

                                                <a href="#">
                                                    <h3>+62 656577657657
                                                    </h3>
                                                    <p>2 Days ago</p>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="bg-white pull-right">
                                        <a href="#">
                                            <div class="label bg-white">View All</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- notification nest end -->
                            <li>
                                <button style="margin-top:9px;border" onClick="menu2.toggle()" class="sideviewtoggle btn btn-default btn-xs icon-view-list">
                                </button>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>
            <!-- end of top nav -->
            @show

            @section('breadcrumbs')
            <!-- breadcrumbs -->
            <ul class="breadcrumbs">
                <li><a href="#"><span class="entypo-home"></span></a>
                </li>
                <li>Dashboard
                </li>
                <!--   <ul class="right inline-list">
                    <li>Help Center</a>
                    </li>
                    <li>Mail Support
                    </li>
                </ul> -->
            </ul>
            <!-- end of breadcrumbs -->
            @show

            <!-- Container Begin -->

            <!-- notification -->
            @yield('notification')
            <!-- end of notification -->

            <!-- Content Begin -->
            <div class="row">
                <div class="col-md-4">
                       <!-- Bootstrap Content -->
                       <div>
                            <form class="navbar-form-chat" style="position:relative" role="search">
                                <!-- Search | has-form wrapper -->
                                <div class="dark"></div>
                                <input class="input-chat-search" type="text" placeholder="Cari">
                            </form>

                       </div>

                       <ul class="history-chat">
                       
                        

                         <li class="devider"></li>
                        <li>
                            <img alt="" src="http://api.randomuser.me/portraits/thumb/men/29.jpg">
                            <h4>Putera Kahfi <small>2 Maret 2016</small></h4>
                            <p>Bookmark gan..</p>

                        </li>
                        <li class="devider"></li>
                        <li>
                            <img alt="" src="http://api.randomuser.me/portraits/thumb/women/29.jpg">
                            <h4>Ayu Masahita <small>2 Maret 2016</small></h4>
                            <p>Andi Farid Izdihar atau andi gilang masuk sebagai salah satu daftar men to watch ... sekelas MOTO 3 dan mengikuti mimpinya untuk bertanding di ajang Asia </p>

                        </li>
                         <li class="devider"></li>
                          <li>
                            <img alt="" src="http://api.randomuser.me/portraits/thumb/women/30.jpg">
                            <h4>Ayu Masahita <small>2 Maret 2016</small></h4>
                            <p>Andi Farid Izdihar atau andi gilang masuk sebagai salah satu daftar men to watch ... sekelas MOTO 3 dan mengikuti mimpinya untuk bertanding di ajang Asia </p>

                        </li>
                         <li class="devider"></li>
                          <li>
                            <img alt="" src="http://api.randomuser.me/portraits/thumb/men/31.jpg">
                            <h4>Ayu Masahita <small>2 Maret 2016</small></h4>
                            <p>Andi Farid Izdihar atau andi gilang masuk sebagai salah satu daftar men to watch ... sekelas MOTO 3 dan mengikuti mimpinya untuk bertanding di ajang Asia </p>

                        </li>
                         <li class="devider"></li>
                          <li>
                            <img alt="" src="http://api.randomuser.me/portraits/thumb/men/32.jpg">
                            <h4>Ayu Masahita <small>2 Maret 2016</small></h4>
                            <p>Andi Farid Izdihar atau andi gilang masuk sebagai salah satu daftar men to watch ... sekelas MOTO 3 dan mengikuti mimpinya untuk bertanding di ajang Asia </p>

                        </li>
                         <li class="devider"></li>
                       </ul>



                       <!-- End of Bootstrap Content -->


                    @yield('content')
                </div>
                <div class="col-md-8">
                    <div class="history-chat-detail-nest">
                    <ul class="history-chat-detail">
                      
                        <li>
                            <img alt="" src="http://api.randomuser.me/portraits/thumb/men/29.jpg">
                            <h4>Putera Kahfi <small>2 Maret 2016</small></h4>
                            <p>Bookmark gan..</p>

                        </li>
                        <li class="devider"><span>12 Februari 2016</span></li>
                        <li>
                            <img alt="" src="http://api.randomuser.me/portraits/thumb/women/29.jpg">
                            <h4>Ayu Masahita <small>2 Maret 2016 </small><span>11:20 PM</span></h4>
                            <p>Andi Farid Izdihar atau andi gilang masuk sebagai salah satu daftar men to watch ... sekelas MOTO 3 dan mengikuti mimpinya untuk bertanding di ajang Asia </p>

                        </li>
                        <li>
                            <img alt="" src="http://api.randomuser.me/portraits/thumb/men/29.jpg">
                            <h4>Putera Kahfi <small>2 Maret 2016 </small><span>10:05 PM</span></h4>
                            <p>mengikuti mimpinya untuk bertanding di ajang Asia</p>

                        </li>
                         <li class="devider"><span>11 Februari 2016</span></li>
                        <li>
                            <img alt="" src="http://api.randomuser.me/portraits/thumb/women/29.jpg">
                            <h4>Ayu Masahita <small>2 Maret 2016 </small><span>09:10 PM</span></h4>
                            <p>Andi Farid Izdihar atau andi gilang masuk sebagai salah satu daftar men to watch </p>

                        </li>
                      
                     
                       </ul>
                       </div>
                </div>
            </div>
            <!-- end of content -->

            @section('chatbar')
            <!-- Chat bottom -->
            <div class="chat-bottom">
                <div class="chat-list chat-active chat-blink">
                        <div class="close-box">X</div>
                        <a class="chat-pop-over" data-title="Olivia Zalianti Putri" href="#">Blink</a>
                        <div class="webui-popover-content">

                                <div class="chat-conversation slim-scroll-chat">
                                     <p class="ajaib-devider-chat"><span>Friday, 2 Feb 2016</span></p>
                                    <p class="ajaib-client"><small>Sat 7:19 PM</small>halo, ajaib</p>
                                    <p class="ajaib-operator"><small>Sat 7:21 PM</small>Selamat pagi, ada yang bisa saya bantu?
                                        kami menyediakan jasa untuk pemesanan tiket bioskop, tiket pesawat dan reservasi hotel.</p>
                                    <p class="ajaib-client"><small>Sat 7:19 PM</small>Saya mau pesan tiket bioskop bisa?</p>
                                    <p class="ajaib-operator"><small>Sat 7:19 PM</small>Untuk film apa ?</p>
                                </div>

                            <div class="textarea-nest">
                             
                                <div class="form-group">
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                                    <span class="btn btn-default btn-file-ajaib">
                                        <i class="fontello-attach"></i><input type="file">
                                    </span>
                                  <button type="submit" class="btn pull-right btn-default btn-ajaib">Submit</button>
                            </div>
                            <!-- /input-group -->
                        </div>
                </div>

               <div class="chat-list chat-active">
                        <div class="close-box">X</div>
                        <a class="chat-pop-over" data-title="Olivia Zalianti Putri" href="#">Aktif</a>
                        <div class="webui-popover-content">
                            <div class="chat-conversation slim-scroll-chat">
                                <p class="ajaib-devider-chat"><span>Friday, 2 Feb 2016</span></p>
                                <p class="ajaib-client"><small>Sat 7:19 PM</small>ha</p>
                                <p class="ajaib-operator"><small>Sat 7:21 PM</small>Selamat .</p>
                                <p class="ajaib-client"><small>Sat 7:19 PM</small>Saya </p>
                                <p class="ajaib-operator"><small>Sat 7:19 PM</small>Unt</p>
                                <p class="ajaib-operator"><small>Sat 7:19 PM</small>Unt</p>
                                <p class="ajaib-operator"><small>Sat 7:19 PM</small>Unt</p>
                            </div>
                            <div class="textarea-nest">
                             
                                <div class="form-group">
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                                  <span class="btn btn-default btn-file-ajaib">
                                        <i class="fontello-attach"></i><input type="file">
                                    </span>
                                  <button type="submit" class="btn pull-right btn-default btn-ajaib">Submit</button>
                            </div>

                        </div>
                </div>

                <div class="chat-list chat-idle">
                        <div class="close-box">X</div>
                        <a class="chat-pop-over" data-title="Olivia Zalianti Putri" href="#">Idle</a>
                        <div class="webui-popover-content">
                            <div class="chat-conversation slim-scroll-chat">
                            <p class="ajaib-devider-chat"><span>Friday, 2 Feb 2016</span></p>
                            <p class="ajaib-client"><small>Sat 7:19 PM</small>halo, ajaib</p>
                            <p class="ajaib-operator"><small>Sat 7:21 PM</small>Selamat pagi, ada yang bisa saya bantu?
                                kami menyediakan jasa untuk pemesanan tiket bioskop, tiket pesawat dan reservasi hotel.</p>
                            <p class="ajaib-devider-chat"><span>Friday, 2 Feb 2016</span></p>
                            <p class="ajaib-client"><small>Sat 7:19 PM</small>Saya mau pesan tiket bioskop bisa?</p>
                            <p class="ajaib-operator"><small>Sat 7:19 PM</small>Untuk film apa ?</p>
                            </div>
                            <div class="textarea-nest">
                            
                                <div class="form-group">
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                                    <span class="btn btn-default btn-file-ajaib">
                                        <i class="fontello-attach"></i><input type="file">
                                    </span>
                                
                                  <button type="submit" class="btn pull-right btn-default btn-ajaib">Submit</button>
                            </div>

                        </div>
                </div>

            </div>
            <!-- Chat bottom -->
            @show

            <!-- end of Container Begin -->

            @section('footer')
            <footer>
                <div id="footer">Copyright &copy; 2015 <a href="http://ajaib.co">Ajaib</a> Made with <i class="fontello-heart-1 text-green"></i></div>
            </footer>
            @show

        </div>

        <!-- End of Container Begin -->


    </div>
    <!-- end paper bg -->

</div>
    <div id="right-chat-menu-off" class="sidetogglemenu">
            <!-- Your right Slidebar content. -->
            <!-- Right Menu -->
            <aside class="right-off-canvas-menu" id="right-chat">
                <!-- whatever you want goes here -->
                <ul class="off-canvas-list">
                    <li>
                        <label class="bg-transparent" style="padding:25px 20px"><span class="label round bg-green">online</span>
                        </label>
                    </li>
                    <li>
                        <a href="#"><img alt="" class="chat-pic" src="http://api.randomuser.me/portraits/thumb/men/27.jpg"><b>Walter M. Reed</b>
                            <br>Hi, there...</a>
                    </li>
                    <li>
                        <a href="#"><img alt="" class="chat-pic" src="http://api.randomuser.me/portraits/thumb/women/26.jpg"><b>Evelyn G. Thrailkill</b>
                            <br>Ok, good luck!</a>
                    </li>
                    <li>
                        <a href="#"><img alt="" class="chat-pic" src="http://api.randomuser.me/portraits/thumb/men/27.jpg"><b>Michael L. Merchant</b>
                            <br>Do you receive my email?</a>
                    </li>

                    <li>
                        <a href="#"><img alt="" class="chat-pic" src="http://api.randomuser.me/portraits/thumb/men/29.jpg"><b>James S. Houchin</b>
                            <br>Thak you, you're wellcome</a>
                    </li>

                    <li>
                        <label class="bg-transparent" style="padding:25px 20px"><span class="label round bg-opacity-white">offline</span>
                        </label>

                    </li>

                    <li>
                        <a href="#"><img alt="" class="chat-pic chat-pic-gray" src="http://api.randomuser.me/portraits/thumb/men/30.jpg"><b>Allen M. Plant</b>
                            <br>Hi, there...</a>
                    </li>
                    <li>
                        <a href="#"><img alt="" class="chat-pic chat-pic-gray" src="http://api.randomuser.me/portraits/thumb/men/31.jpg"><b>Arthur S. Galindo</b>
                            <br>Hi, there...</a>
                    </li>
                    <li>
                        <a href="#"><img alt="" class="chat-pic chat-pic-gray" src="http://api.randomuser.me/portraits/thumb/women/32.jpg"><b>Joyce T. True</b>
                            <br>Hi, there...</a>
                    </li>
                    <li>
                        <a href="#"><img alt="" class="chat-pic chat-pic-gray" src="http://api.randomuser.me/portraits/thumb/men/33.jpg"><b>Christopher A. Charpentier</b>
                            <br>Hi, there...</a>
                    </li>
                    <li>
                        <a href="#"><img alt="" class="chat-pic chat-pic-gray" src="http://api.randomuser.me/portraits/thumb/women/34.jpg"><b>Teresa M. Boothe</b>
                            <br>Hi, there...</a>
                    </li>


                </ul>
            </aside>
        </div>
<!-- end of off-canvas-wrap -->

<!-- end of inner-wrap -->

<!-- main javascript library -->
<script type='text/javascript' src="{{asset('/js/jquery.js')}}"></script>
<script type='text/javascript' src="{{asset('/js/preloader-script.js')}}"></script>
<!-- bootstrap javascript -->
<script type='text/javascript' src="{{asset('/js/bootstrap.js')}}"></script>
<script type='text/javascript' src="{{asset('/js/jquery.webui-popover.js')}}"></script>

<!-- main edumix javascript -->
<script type='text/javascript' src="{{asset('/js/slimscroll/jquery.slimscroll.js')}}"></script>
<script type='text/javascript' src="{{asset('/js/slicknav/jquery.slicknav.js')}}"></script>
<script type='text/javascript' src="{{asset('/js/sliding-menu-fixed.js')}}"></script>
<script type='text/javascript' src="{{asset('/js/scriptbreaker-multiple-accordion-1.js')}}"></script>
<script type='text/javascript' src="{{asset('/js/app.js')}}"></script>

<!-- FLOT CHARTS -->
<script type='text/javascript' src="{{asset('js/offcanvas/sidetogglemenu.js')}}"></script>


<script>
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
            id: 'right-chat-menu-off',
            position: 'right',
            pushcontent: false,
            //source: 'togglemenu.txt',
            revealamt: -5
        })

         setInterval(function(){
                $(".chat-blink").toggleClass("backgroundBlink");
             },1500);

            })

           $(document).on('click','.close-box',function(){
            $(this).parent().fadeTo(300,0,function(){
                  $(this).remove();
            });
});


</script>

</body>
</html>