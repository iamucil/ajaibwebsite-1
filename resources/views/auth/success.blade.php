{{-- Resource : resources/views/auth/success.blade.php --}}
@extends('layouts.default')
@section('title', 'Register')

@section('content')
    <div id="tf-home" class="text-center">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-offset-6 col-sm-6">
                        <div class="topright-desc">
                            <div class="animated fadeInRight">
                                <p class="lead">
                                    <h3>
                                        <strong class="text-capitalize">
                                            Terimakasih telah mendaftar di Ajaib. Kami akan Melakukan Proses Verifikasi terhadap profil Anda terlebih Dahulu
                                        </strong>
                                    </h3>
                                </p>
                                <p>
                                    Setelah proses verifikasi berhasil, Ajaib akan mengirimkan E-mail ke nomor Anda.
                                </p>
                            </div>
                            <hr style="opacity:0.25">

                            <ul>
                                <li>
                                    <img src="{{ asset('img/playstore.png') }}" class="fadeIn animated">
                                </li>
                                <li>
                                    <img src="{{ asset('img/appstore.png') }}" class="fadeIn animated">
                                </li>
                            </ul>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img class="pic-ajaib-phone animated fadeIn" src="{{ asset('img/ajaib-iphone.png') }}">
    </div>
@endsection