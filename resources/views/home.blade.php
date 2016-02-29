@extends('layouts.default')

@section('title', 'Landing Page')

@section('content')

    <div id="tf-home" class="text-center">
        <div class="content">
            <div class="container">
                <div class="row">

                    <!-- right description -->
                    <div class="col-md-6 col-md-offset-6">
                        <div class="topright-desc" style="position: absolute; z-index: 999">
                            <h3><strong>Ajaib</strong> adalah asisten pribadi anda<br>Keperluan apapun yang anda butuhkan kami akan membantu anda.</h3>
                            <hr style="opacity:0.25">
                            <p>
                            <a class="btn btn-default btn-ajaib btn-lg" data-toggle="modal" data-target="#modal__register">Daftar Akun di Ajaib!</a>
                            </p>
                            <!--
                            <p>Masukan email dan no hp untuk menjadikan Ajaib
                                <br> sebagai asisten anda.</p>
                            <form class="form-inline frm-signup" method="POST" action="/auth/register" novalidate name="form-register" id="form-register">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="email" class="form-control" id="exampleInputName2" placeholder="Alamat email anda" name="email">
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" id="call-code-label"><strong>62</strong></div>
                                        <input type="text" class="form-control" id="exampleInputEmail2" placeholder="" name="phone_number">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-default btn-ajaib">Sign Up</button>
                            </form>
                            -->
                            <ul>
                                <li><img src="{{ secure_asset('img/playstore.png') }}"></li>
                                <li><img src="{{ secure_asset('img/appstore.png') }}"></li>
                            </ul>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                    <!-- end of right description -->
                </div>
            </div>
        </div> <img class="pic-ajaib-phone" src="{{ secure_asset('img/ajaib-iphone.png') }}">
    </div>
    <!-- About Us Page
    ==========================================-->
    <div id="tf-about">
        <!--     <div class="triangle-top"></div> -->
        <div class="overlay">
            <div class="container">
                <div class="section-title text-center">
                    <h2>Diliput<strong>oleh</strong></h2>
                    <div class="text-center line">
                        <hr>
                    </div>
                </div>
                <ul class="client-item">
                    <li><img src="{{ secure_asset('/img/client/client_01.png') }}"></li>
                    <li><img src="{{ secure_asset('/img/client/client_02.png') }}"></li>
                    <li><img src="{{ secure_asset('/img/client/client_03.png') }}"></li>
                    <li><img src="{{ secure_asset('/img/client/client_04.png') }}"></li>
                    <li><img src="{{ secure_asset('/img/client/client_05.png') }}"></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Services Section
    ==========================================-->
    <div id="tf-services" class="text-center">
        <div class="container">
            <div class="section-title text-center">
                <h2>Apa <strong>kebutuhan</strong> anda ?</h2>
                <div class="text-center line">
                    <hr>
                </div>
                <p>Pesan makanan, booking tiket pesawat atau keperluan lainnya?
                    <br>pakai <strong>Ajaib</strong> saja!</p>
            </div>
            <div class="space"></div>
            <div class="row">
                <div class="col-md-2 col-sm-6 service">
                    <i class="fa flaticon-aeroplane10"></i>
                    <h4>Tiket Pesawat</h4>
                </div>
                <div class="col-md-2 col-sm-6 service">
                    <i class="fa flaticon-cinema61"></i>
                    <h4>Tiket ticket</h4>
                </div>
                <div class="col-md-2 col-sm-6 service">
                    <i class="fa flaticon-fastfood47"></i>
                    <h4>Pesan makanan & minuman</h4>
                </div>
                <div class="col-md-2 col-sm-6 service">
                    <i class="fa flaticon-money412"></i>
                    <h4>Beli pulsa voucher & bayar tagihan</h4>
                </div>
                <div class="col-md-2 col-sm-6 service">
                    <i class="fa flaticon-gymnast38"></i>
                    <h4>Elektronik, fashion dan yang lainnya</h4>
                </div>
                <div class="col-md-2 col-sm-6 service">
                    <i class="fa flaticon-automobile5"></i>
                    <h4>Sewa mobil atau kendaraan</h4>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2 col-sm-6 service">
                    <i class="fa flaticon-hotels1"></i>
                    <h4>Paket Hotel dan traveling</h4>
                </div>
                <div class="col-md-2 col-sm-6 service">
                    <i class="fa flaticon-drummer1"></i>
                    <h4>Tiket konser, event, musikal</h4>
                </div>
                <div class="col-md-2 col-sm-6 service">
                    <i class="fa flaticon-sweet111"></i>
                    <h4>Pesan Bunga dan Hadiah Ulang Tahun</h4>
                </div>
                <div class="col-md-2 col-sm-6 service">
                    <i class="fa flaticon-condiments"></i>
                    <h4>Kebutuhan sehari-hari</h4>
                </div>
                <div class="col-md-2 col-sm-6 service">
                    <i class="fa flaticon-coffeeshop37"></i>
                    <h4>Reservasi restaurant, spa dll</h4>
                </div>
                <div class="col-md-2 col-sm-6 service">
                    <i class="fa flaticon-magicwand2"></i>
                    <h4>Dan yang lainnya</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Cara Kerja Page
    ==========================================-->
    <div id="tf-team" class="text-center">
        <div class="overlay">
            <div class="container">
                <div class="section-title text-center">
                    <h2>Cara <strong>Kerja</strong></h2>
                    <div class="text-center line">
                        <hr>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="how-to-work text-center">
                            <span>Describe Your Needs</span>
                            <br>
                            <i class="flaticon-telephone117"></i>
                            <h3>Purchase tickets, food delivery, hotel reservations, all in just a text message!</h3>
                            <p>Personalised service that is fast and easy We do the research to give you the best recommendations</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="how-to-work text-center">
                            <span>Process Your Request</span>
                            <br>
                            <i class="flaticon-profession12"></i>
                            <i class="flaticon-profession7"></i>
                            <h3>We will serve you in a matter of minutes!</h3>
                            <p>Personalised service that is fast and easyWe do the research to give you the best recommendations</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="how-to-work text-center">
                            <span>Mission Accomplished!</span>
                            <br>
                            <i class="flaticon-restaurant9"></i>
                            <i class="flaticon-package27"></i>
                            <h3>We work behind the scenes to ensure your request is placed and delivere</h3>
                            <p>Time saving! Goods received fast and in the best condition</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testmoni Section
    ==========================================-->
    <div id="tf-works">
        <div class="container">
            <!-- Container -->
            <div class="section-title text-center">
                <h2><strong>Testimonal</strong></h2>
                <div class="text-center line">
                    <hr>
                </div>
            </div>
            <div class="space"></div>
            <div class="row">
                <div class="col-md-4">
                    <div class="testi-chat">
                        <span>Startup is really a great template to get strarted with. With its awesome features and easy customization with unbounce. This template made my day. Very recommended.</span>
                        <br>
                        <img src="img/isyana.jpg">
                        <h4>Isyana Sarasvati</h4>
                        <p>Founder and CEO of Square Inc</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testi-chat">
                        <span>Startup is really a great template to get strarted with. With its awesome features and easy customization with unbounce. This template made my day. Very recommended.</span>
                        <br>
                        <img src="img/raisa.jpg">
                        <h4>Raisa Andriana</h4>
                        <p>Artist and musician</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testi-chat">
                        <span>Startup is really a great template to get strarted with. With its awesome features and easy customization with unbounce. This template made my day. Very recommended.</span>
                        <br>
                        <img src="img/al-ghazali.jpg">
                        <h4>Al Ghazali</h4>
                        <p>Founder and CEO of Square Inc</p>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
    </div>
    <!-- Faq Section
    ==========================================-->
    <div id="tf-contact">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="section-title center text-center">
                        <h3>Frequently Asked Questions</h3>
                        <p>Got questions? We have answers.</p>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="faq-nest">
                                <h4>How does the free trial work?</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                <h4>Can I switch plans later?</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="faq-nest">
                                <h4>Do I need to choose plan now?</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                <h4>What payment types do you accept?</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="modal__register" tabindex="-1" role="dialog" aria-labelledby="register">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="register" style="font-size: 1.1em; font-weight: normal;">
                    Masukan email dan no hp untuk menjadikan Ajaib sebagai asisten Anda! Gratis.
                </h4>
            </div>
            <div class="modal-body">
                <form class="frm-signup" method="POST" action="/auth/register" novalidate name="form-register" id="form-register">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="inpEmailRegister" style="float: none !important; font-weight: 400;">Email</label>
                        <input type="email" class="form-control" id="inpEmailRegister" placeholder="Eg: name@example.com" name="email">
                    </div>
                    <div class="form-group has-feedback">
                        <label for="inpPhoneRegister" style="float: none !important; font-weight: 400;">Nomor Telephon</label>
                        {{-- <div class="input-group"> --}}
                            <input type="tel" id="phone" class="form-control">
                            <span id="valid-msg" class="hide">✓ Valid</span>
                            <span id="error-msg" class="hide">Invalid number</span>
                        {{-- </div> --}}
                    </div>
                    <p>
                        <button type="submit" class="btn btn-default btn-ajaib btn-lg btn-block">Sign Up</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-bottom')
    @parent
    <script type="text/javascript">
        // $('.intl-tel-input').addClass('input-group');

        var url     = '{!! url("/geo-ip") !!}';
        var telInput = $("#phone"), errorMsg = $("#error-msg"), validMsg = $("#valid-msg");
        telInput.intlTelInput({
            numberType : 'MOBILE',
            separateDialCode : true,
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                $.get(url, function() {}, "jsonp").always(function(resp) {
                    var result      = JSON.parse(resp.responseText);
                    var countryCode = (result && result.country_code) ? result.country_code : "";
                    callback(countryCode);
                });
            },
            utilsScript: protocol + '//' + server + '/js/utils.js' // just for formatting/placeholders etc
        });

        var reset = function() {
            telInput.removeClass("error");
            errorMsg.addClass("hide");
            validMsg.addClass("hide");
        };

        // on blur: validate
        telInput.on('keyup change blur', function() {
            reset();
            var parent_child    = $(this).parents()[1];
            // parent_child.removeClass('has-success has-error');
            if ($.trim(telInput.val())) {
                if (telInput.intlTelInput("isValidNumber")) {
                    parent_child.addClass('has-success');
                    // validMsg.removeClass("hide");
                } else {
                    parent_child.addClass('has-error');
                    // telInput.addClass("error");
                    // errorMsg.removeClass("hide");
                }
            }
        });

        // on keyup / change flag: reset
        telInput.on("keyup change", reset());

        $.getJSON( url, function( data ) {
            var form        = document.forms['form-register'];
            var call_code   = document.createElement('span');
            call_code.style.fontWeight  = 'bold';
            call_code.innerHTML         = data.call_code;
            var inpCountryId            = document.createElement('input');
            inpCountryId.type           = 'hidden';
            inpCountryId.value          = data.country_id;
            inpCountryId.name           = 'country_id';
            //document.getElementById('call-code-label').innerHTML    = '';
            //document.getElementById('call-code-label').appendChild(call_code);
            form.appendChild(inpCountryId);
        }, 'json');

        $('.frm-signup').submit(function(evt) {
            var Form    = this;
            // var action  = '//'+ server + '/auth/register';
            var $action     = Form.action;
            var $data       = {};
            var $errors     = {};
            var countryData = telInput.intlTelInput("getNumber");
            console.log(countryData);
            $.each(this.elements, function(i, v){
                var input = $(v);
                $data[input.attr("name")] = input.val();
                delete $data["undefined"];
            });

            $.ajax({
                cache: false,
                url : $action,
                type: "POST",
                dataType : "json",
                data : $data,
                context : Form,
                beforeSend: function (jqXHR, settings) {
                    // var countryData = $("#phone").intlTelInput("getSelectedCountryData");
                    // console.log(settings.data);
                    // var formData    = new FormData(Form);
                    // $data.append('phone_number', 'xxx');
                    return true;
                }
            }).done(function(data) {
                console.log(data);
                // if(data.errors != null){
                // }
            });

            evt.preventDefault();
            // return true;
        });
    </script>
    {{-- expr --}}
@stop