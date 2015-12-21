@section('top-navigation')
    <nav id="tf-menu" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">
                    <img src="{{ asset('/img/ajaib-logo.png') }}">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#tf-services" class="page-scroll">Kategori</a></li>
                    <li class="devider"></li>
                    <li><a href="#tf-team" class="page-scroll">Cara kerja</a></li>
                    <li class="devider"></li>
                    <li><a href="#tf-works" class="page-scroll">Testimoni</a></li>
                    <li class="devider"></li>
                    <li><a href="#" class="page-scroll">Download</a></li>
                    <li class="devider"></li>
                    <li><a href="#tf-contact" class="page-scroll">F.A.Q</a></li>
                    <li class="devider"></li>
                    <li><a href="#" class="page-scroll">Hubungi Kami</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
@show