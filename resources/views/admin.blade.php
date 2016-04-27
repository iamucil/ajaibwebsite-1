@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('notification')
    @include('common.alerts')
    @include('common.errors')
    @include('common.info')
    @include('common.success')
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <div class="box-header bg-transparent">
                    <h3 class="box-title">
                        <i class="icon-gear"></i>
                        <span>SYSTEM STATUS</span>
                    </h3>
                </div>
                <div style="display: block;" class="box-body">
                    <div class="events-nest">
                        <div class="bg-green text-black events-maintenance" id="maintenance-off">
                            <h1 class="text-black"><b class="counter-up-fast">25</b></h1>
                            <span>System Alive</span>
                            <p>Monday <i class="fontello-record"></i> Februari 2015</p>
                            <p>
                                <a href="javascript:void(0);" class="btn btn-default" style="border-radius: 4px;" id="set-offline">Set Offline</a>
                            </p>
                        </div>
                        <div class="bg-red text-white events-maintenance" id="maintenance-on">
                            <h1 class="text-black"><b class="counter-up-fast">25</b></h1>
                            <span>Maintenance Mode</span>
                            <p>Monday <i class="fontello-record"></i> Februari 2015</p>
                            <p>
                                <a href="javascript:void(0);" class="btn btn-default" style="border-radius: 4px;" id="set-online">Set Online</a>
                            </p>
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
    $(document).ready(function () {
        var url     = "{{ route('admin::check_maintenance') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        checkStatus();

        $('a#set-online').on ({
            click: function () {
                setOnline();
            }
        });

        $('a#set-offline').on ({
            click: function () {
                setOffline();
            }
        });

        function setOnline () {
            $.ajax({
                cache: false,
                url : url,
                type: "DELETE",
                dataType : "json",
                data : {'_method' : 'DELETE'},
                context : document.body
            }).done(function(data,  status, jqXHR) {
                console.log(data);
                checkStatus();
            });
        }

        function setOffline () {
            $.ajax({
                cache: false,
                url : url,
                type: "POST",
                dataType : "json",
                // data : {'_method' : 'DELETE'},
                context : document.body
            }).done(function(data,  status, jqXHR) {
                console.log(data);
                checkStatus();
            });
        }

        function checkStatus () {
            $('#maintenance-off').show();
            $('#maintenance-on').hide();
            $.ajax({
                cache: false,
                url : url,
                type: "GET",
                dataType : "json",
                context : document.body
            }).done(function(data,  status, jqXHR) {
                if (data.status == 201) {
                    $('#maintenance-on').show();
                    $('#maintenance-off').hide();
                } else{
                    $('#maintenance-off').show();
                    $('#maintenance-on').hide();

                }
            });
        }
    })
    </script>
@stop