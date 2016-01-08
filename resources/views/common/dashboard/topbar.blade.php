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
                    <a href="#" class="dropdown-toggle text-gray" data-toggle="dropdown" role="button" aria-expanded="false"><img alt="" class="admin-pic img-circle" src="https://randomuser.me/api/portraits/thumb/men/84.jpg"> Hi, {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-nest profile-dropdown" role="menu">
                        <li>
                            <a href="{{ route('user.profile', AUTH::user()->id) }}"><i class="icon-user"></i> Profile<span class="text-aqua fontello-record" ></span>
                        </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">
                                <i class="icon-upload"></i> Log Out <span class="text-aqua fontello-cd"></span>
                            </a>
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fontello-bell"></i>&nbsp;&nbsp;<span class="label edumix-msg-noft">999</span><span class="caret"></span></a>
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
                <li class="dropdown" id="chat-notification">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fontello-chat-alt"></i>&nbsp;&nbsp;<span class="label edumix-noft">45</span><span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-nest" role="menu">
                        <li class="top-dropdown-nest"><span class="label round bg-blue">ALERT</span>
                        </li>
                        <li>
                            <div class="slim-scroll">

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