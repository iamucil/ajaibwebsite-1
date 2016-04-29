@extends('layouts.default')

@section('title', 'Landing Page')

@section('content')

    <div id="tf-home" class="text-center" ng-controller="AuthController" ng-init="getCountry()">
        <!-- Modal -->
        <script type="text/ng-template" id="modalRegister.html">    
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="register" style="font-size: 1.1em; font-weight: normal;">
                            Masukan email dan no hp untuk menjadikan Ajaib sebagai asisten Anda! Gratis.
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form ng-submit="actRegister(frm_register.$valid)" name="frm_register" id="form-register" novalidate>
                            <div class="form-group"  ng-class="{'has-error' : frm_register.email.$invalid && submitted }">
                                <label for="exampleInputEmail1" class="control-label">Email address</label>
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    id="exampleInputName2" 
                                    placeholder="Alamat email anda" 
                                    name="email"
                                    ng-model="form.email"
                                    ng-required="true">
                                <p ng-show="frm_register.email.$invalid && submitted" class="help-block pull-left">Email is required.</p>
                            </div>
                            <br/>
                            <div class="form-group" ng-class="{'has-error' : frm_register.phone_number.$invalid && submitted }">
                                <label for="exampleInputPassword1" class="control-label">Phone Number</label>
                                <div class="clearfix"></div>
                                <div class="input-group">                                            
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="exampleInputEmail2" 
                                        placeholder="" 
                                        name="phone_number"
                                        ng-required="true"
                                        ng-model="form.phone_number"
                                        international-phone-number 
                                        default-country="id"
                                        preferred-countries="id,us,gb">
                                </div>
                                <p ng-show="frm_register.phone_number.$invalid && submitted" class="help-block pull-left">Phone Number is required.</p>
                            </div>
                            <br/>

                            <button type="submit" class="btn btn-default btn-block btn-ajaib">Sign Up</button>
                            <button type="button" class="btn btn-default btn-block" ng-click="cancel()">Cancel</button>
                        </form>
                    </div>
                </div>
            
        </script>
        <div class="content">
            <div class="container">
                <div class="row">

                    <!-- right description -->
                    <div class="col-md-6 col-md-offset-6">
                        <div class="topright-desc" style="position: absolute; z-index: 999">
                            <h3><strong>Ajaib</strong> adalah asisten pribadi anda<br>Keperluan apapun yang anda butuhkan kami akan membantu anda.</h3>
                            <hr style="opacity:0.25">
                            <p>
                            <a class="btn btn-default btn-ajaib btn-lg" ng-click="openModal()">Daftar Akun di Ajaib!</a>
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
                <!--     <h2>Diliput<strong>oleh</strong></h2>
                    <div class="text-center line">
                        <hr>
                    </div> -->
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
                            <span>Ceritakan Kebutuhan Anda</span>
                            <br>
                            <i class="flaticon-telephone117"></i>
                           
                            <h3>Kami membantu merekomendasikan yang terbaik untuk anda</h3>
                            <p>Beli tiket nonton, pesawat, kereta api, pesan makanan, hotel, bahkan kebutuhan yang membutuhkan kustomisasi anda, kami akan mewujudkannya dengan cepat dan mudah</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="how-to-work text-center">
                            <span>Proses Pesanan Anda</span>
                            <br>
                            <i class="flaticon-profession12"></i>
                            <i class="flaticon-profession7"></i>
                            <h3>Kami melayani anda hanya dalam beberapa menit</h3>
                            <p>Personalised service that is fast and easyWe do the research to give you the best recommendations</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="how-to-work text-center">
                            <span>Pesanan Anda Terpenuhi</span>
                            <br>
                            <i class="flaticon-restaurant9"></i>
                            <i class="flaticon-package27"></i>
                            <h3>Kami bekerja untuk memastikan semua berjalan dengan sempurna</h3>
                            <p>Menghemat waktu ! Cepat dan pesanan tepat sesuai kebutuhan anda</p>
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
       <!--      <div class="section-title text-center">
                <h2><strong>Frequently Asked Questions</strong></h2>
                <p>Anda punya ertanyaan? Kami mempunyai jawabannya.</p>
                <div class="text-center line">
                    <hr>
                </div>
            </div> -->
            <div class="section-title center text-center">
                        <h3>Frequently Asked Questions</h3>
                        <p>Got questions? We have answers.</p>
                        <div class="clearfix"></div>
            </div>

            {{--<div class="space"></div>--}}
         <!--    <div class="row">
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
            </div> -->
                      <div class="row">
                        {{--<div class="col-md-6">--}}
                            <div class="faq-nest">
                                <h4>Apa itu AJAIB?</h4>
                                <p>Ajaib adalah asisten pribadi yang siap membantu memenuhi kebutuhan anda.</p>
                                <h4>Bagaimana cara menggunakannya?</h4>
                                <p>Pastikan aplikasi ajaib sudah terinstall di device anda. Lakukan chat pada menu chat yang telah disediakan, beri tahu kami apa kebutuhan anda, operator kami akan memberikan rekomendasi terbaik untuk memenuhi kebutuhan anda.</p>
                                <h4>Aplikasi sudah terinstall dan saya sudah register tapi kenapa saya tidak mendapatkan kode konfirmasi baik melalui email maupun sms?</h4>
                                <p>Setiap pengguna yang telah melakukan registrasi maka akan masuk ke antrian untuk menggunakan aplikasi Ajaib, jika anda belum mendapatkan kode konfirmasi maka anda belum diverifikasi oleh admin kami dan mohon untuk dapat menunggu sampai pada antrian anda.</p>
                            </div>
                        {{--</div>--}}
                    </div>
     
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
                <div class="col-md-6 col-md-offset-3">
                    <div class="section-title text-center">
                        <h2>Contact <strong>Us</strong></h2>
                        <div class="text-center line">
                            <hr>
                        </div>
                </div>
          <!--           <div class="row">
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
                    </div> -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="faq-nest text-center">
                                <h3>C&C Building</h3>
                                <p>Jalan Tanah Abang I No 10-D, Jakarta Pusat, Indonesia. 10160.<br>
                                    Kelurahan Petojo, Kecamatan Gambir.<br><br>
                                    phone: +62-21-3140982&nbsp;&nbsp;/&nbsp;&nbsp;
                                    fax: +62-21-31934470&nbsp;&nbsp;/&nbsp;&nbsp;
                                    email: info@getajaib.com
                               
                            </div>
                        </div>
           
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script-bottom')
    @parent
    <script type="text/javascript">
        function animationHover(element, animation){
            element = $(element);
            element.hover(
                function() {
                    element.addClass('animated ' + animation);        
                },
                function(){
                    //wait for animation to finish before removing classes
                    window.setTimeout( function(){
                        element.removeClass('animated ' + animation);
                    }, 2000);         
                });
        }
        $('.fa').each(function() {
        animationHover(this, 'bounce');
        });     

        // $('.intl-tel-input').addClass('input-group');

        var url     = '{!! url("/geo-ip") !!}';
        var telInput = $("#phone"), errorMsg = $("#error-msg"), validMsg = $("#valid-msg");
        telInput.intlTelInput({
            numberType : 'MOBILE',
            separateDialCode : true,
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                $.get(url, function() {}, "jsonp").always(function(resp) {
                    var countryCode     = 'ID';
                    var status          = (resp && resp.status) ? resp.status : 404;
                    if(parseInt(status) == 200){
                        var result      = JSON.parse(resp.responseText);
                        countryCode     = (result && result.country_code) ? result.country_code : "ID";
                    }
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

        var resetValidationMsg  = function (el) {
            var icon        = el.getElementsByClassName('glyphicon form-control-feedback');
            var label       = el.getElementsByClassName('sr-only');

            if( icon.length > 0 ) {
                for (var i = icon.length - 1; i >= 0; i--) {
                    icon[i].parentNode.removeChild(icon[i]);
                };
            }

            if( label.length > 0 ) {
                for (var lb = label.length - 1; lb >= 0; lb--) {
                    label[lb].parentNode.removeChild(label[lb]);
                };
            }
        }
        // on blur: validate
        telInput.on('keyup change blur', function() {
            reset();
            var parent_child    = $(this).parents()[1];
            parent_child.classList.remove('has-success', 'has-error');
            var validationIcon  = document.createElement('span');
            validationIcon.classList.add('glyphicon', 'form-control-feedback');
            validationIcon.setAttribute('aria-hidden', true);
            var elSpanStatus    = document.createElement('span');
            elSpanStatus.classList.add('sr-only');
            elSpanStatus.innerHTML  = '(error)';
            resetValidationMsg(parent_child);

            // parent_child.removeClass('has-success has-error');
            if ($.trim(telInput.val())) {
                if (telInput.intlTelInput("isValidNumber")) {
                    parent_child.classList.add('has-success');
                    validationIcon.classList.remove('glyphicon-remove');
                    validationIcon.classList.add('glyphicon-ok');
                    elSpanStatus.innerHTML  = '(success)';
                    parent_child.appendChild(validationIcon);
                    parent_child.appendChild(elSpanStatus);
                } else {
                    parent_child.classList.add('has-error');
                    validationIcon.classList.remove('glyphicon-ok');
                    validationIcon.classList.add('glyphicon-remove');
                    parent_child.appendChild(validationIcon);
                    parent_child.appendChild(elSpanStatus);
                }
            }
        });

        // on keyup / change flag: reset
        // telInput.on("keyup change", reset());

        // $.getJSON( url, function( data ) {
        //     var form        = document.forms['form-register'];
        //     var call_code   = document.createElement('span');
        //     call_code.style.fontWeight  = 'bold';
        //     call_code.innerHTML         = data.call_code;
        //     var inpCountryId            = document.createElement('input');
        //     inpCountryId.type           = 'hidden';
        //     inpCountryId.value          = data.country_id;
        //     inpCountryId.name           = 'country_id';
        //     //document.getElementById('call-code-label').innerHTML    = '';
        //     //document.getElementById('call-code-label').appendChild(call_code);
        //     form.appendChild(inpCountryId);
        // }, 'json');

        $('.frm-signup').submit(function(evt) {
            var countryData = telInput.intlTelInput("getSelectedCountryData");
            var Form        = this;
            // var action  = '//'+ server + '/auth/register';
            var $action     = Form.action;
            var $data       = {};
            var $errors     = {};
            $data['phone_number']   = telInput.intlTelInput("getNumber").replace(/\+/g,"");
            $data['phone_number']   = $data['phone_number'].replace(/\-/g,"");
            $data['country_code']   = countryData.iso2;
            $data['dial_code']      = countryData.dialCode;

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
                    return true;
                }
            }).done(function(data,  status, jqXHR) {
                if(data.errors != null){
                    // $('#modal__register').modal('hide');
                    $.each(data.errors, function ( index, value) {
                        var elSpanError     = document.createElement('span');
                        elSpanError.classList.add('glyphicon', 'glyphicon-remove', 'form-control-feedback');
                        elSpanError.setAttribute('aria-hidden', true);
                        var elSpanStatus    = document.createElement('span');
                        elSpanStatus.classList.add('sr-only');
                        elSpanStatus.innerHTML  = '(error)';
                        var parentIndex     = $('input[name="'+index+'"]').parent();
                        if(index == 'phone_number' || index == 'ext_phone') {
                            var parentIndex     = $('input[type="tel"]').parent();
                        }
                        parentIndex.children('.control-label').css('font-weight', 'bold');
                        parentIndex.addClass('has-error has-feedback');
                        parentIndex.append(elSpanError, elSpanStatus);
                    });
                    evt.preventDefault();
                    return false;
                }else{
                    window.location.href = '{!! route("auth.success.get") !!}';
                }
            });

            evt.preventDefault();
            return true;
        });
    </script>
    {{-- expr --}}
@stop