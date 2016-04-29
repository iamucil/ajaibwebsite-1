@extends('layouts.dashboard')

@section('title')
    List Users
@stop

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('/js/vendor/dhtmlx/grid/skins/web/dhtmlxgrid.css') }}">
    <style type="text/css">
        div.gridbox .objbox {
            /*height: auto !important;*/
        }
    </style>
@stop
@section('content')
<div class="box">

    <div class="box-header bg-transparent">
        <h3 class="box-title">
            <i class="icon-menu"></i>
        <span>
            Users
        </span>
        </h3>

        <div class="pull-right box-tools">
        <span class="box-btn" data-widget="collapse">
            <i class="icon-minus"></i>
        </span>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8">
                <form class="form-inline" name="frm-filter" id="frm-filter">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="src_username" placeholder="Username" name="txt_username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="src_phonenumber" placeholder="Phone Number" name="txt_phone">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="border-radius: 4px;">Filter</button>
                    <button type="reset" class="btn btn-primary" style="border-radius: 4px;">Reset</button>
                </form>
            </div>
            <div class="col-md-4">
                @if (Auth::user()->hasRole(['root', 'admin']))
                <div class="pull-right">
                    <a href="{{ URL::route('user.add') }}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Tambah Data
                    </a>
                </div>
                @endif
            </div>
        </div>
        <div id="recinfoArea"></div>
        <div id="gridbox" style="width: 100%; height: 100%; min-height: 100%; background-color:white;"></div>
        <div><span id="pagingArea"></span>&nbsp;<span id="infoArea"></span></div>
        <div class="table-responsive">
        </div>
    </div>
</div>
@stop

@section('script-bottom')
    @parent
    <script type="text/javascript" src="{{ secure_asset('/js/vendor/dhtmlx/grid/dhtmlxgrid.js') }}"></script>
    <script type="text/javascript">
        var grid, destroyDataProcessor;
        var form_filter = $('form#frm-filter');
        var json_data   = "{{ route('user.json') }}";
        var image_path  = "{{ asset('/js/vendor/dhtmlx/grid/imgs/') }}";
        var skins       = "{{ asset('/js/vendor/dhtmlx/grid/skins/') }}";
        grid            = new dhtmlXGridObject('gridbox');
        grid.enableColSpan(true);
        grid.setImagePath(skins + '/imgs/dhxgrid_web/');
        grid.setHeader("&nbsp;,Username, Phone Number, Email, Role, Register Date, Status,&nbsp,#cspan,#cspan");
        grid.enableAutoWidth(true);
        grid.setInitWidths("40,195,135,215,125,115,65");
        grid.setColAlign("right,left,left,left,left,center, center");
        grid.enableSmartRendering(true);
        grid.enableAutoHeight(true,400);
        grid.setColSorting('na,str,na,na,str,date,na');
        grid.setColTypes("cntr,ro,ro,ro,ro,ro,img,button,button,button");
        // grid.enableAutoHeight(true);
        grid.init();
        grid.load(json_data,'json');

        form_filter.on({
            submit: function(e) {
                var username    = $('input[name="txt_username"]').val();
                var phone       = $('input[name="txt_phone"]').val();
                grid.filterBy(1,username);
                grid.filterBy(2,phone, true);
                grid.selectRow(0);
                e.preventDefault();
            }, reset: function(e) {
                grid.filterBy(0, null);
            }
        });

        function eXcell_button(a){
            this.cell = a;
            this.grid = this.cell.parentNode.grid;
            this.isDisabled = function () {
                return true
            };
            this.edit = function () {
            };
            this.getValue = function () {
                if (this.cell.firstChild.getAttribute) {
                    var b = this.cell.firstChild.getAttribute("target");
                    return this.cell.firstChild.innerHTML + "^" + this.cell.firstChild.getAttribute("href") + (b ? ("^" + b) : "")
                } else {
                    return ""
                }
            };
            this.setValue = function (c) {
                if ((typeof(c) != "number") && (!c || c.toString()._dhx_trim() == "")) {
                    this.setCValue("&nbsp;", b);
                    return (this.cell._clearCell = true)
                }
                var b = c.split("^");
                if (b.length == 1) {
                    b[1] = ""
                } else {
                    if (b.length > 1) {
                        b[1] = "href='" + b[1] + "'";
                        if (b.length == 3) {
                            b[1] += " target='" + b[2] + "'"
                        } else {
                            b[1] += " target='_blank'"
                        }
                    }
                }
                this.setCValue("<a class='btn btn-link' " + b[1] + " onclick='(_isIE?event:arguments[0]).cancelBubble = true;'>" + b[0] + "</a>", b)
            }
        }
        // nests all other methods from the base class
        eXcell_button.prototype = new eXcell;

        function setStatus (state, id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url_setactive   = "{{ route('user.setactive', ['id' => "id"]) }}";
            var url_destroy     = "{{ route('user.destroy', ['id' => "id"]) }}";
            url_setactive       = url_setactive.replace(/id/g, id);
            url_destroy         = url_destroy.replace(/id/g, id);
            // var Form    = document.createElementForm();
            switch (state.toUpperCase()) {
                case 'DEACTIVE':
                    $.ajax({
                        cache: false,
                        url : url_destroy,
                        type: "DELETE",
                        dataType : "json",
                        data : {'id' : id, '_method' : 'DELETE'},
                        context : document.body
                    }).done(function(data,  status, jqXHR) {
                        if (data.status == 201) {
                            alertify.success(data.message);
                            grid.clearAll();
                            grid.load(json_data, 'json');
                            // grid.updateFromJSON(json_data, false, false);
                        } else if (data.status == 500) {
                            alertify.success(data.message);
                        }
                    });
                    break;
                case 'ACTIVATE':
                    $.ajax({
                        cache: false,
                        url : url_setactive,
                        type: "PUT",
                        dataType : "json",
                        data : {'id' : id, '_method' : 'PUT'},
                        context : document.body
                    }).done(function(data,  status, jqXHR) {
                        if (data.status == 201) {
                            alertify.success(data.message);
                            grid.clearAll();
                            grid.load(json_data, 'json');
                        } else if (data.status == 500) {
                            alertify.success(data.message);
                        }
                    });
                    break;
            }
        }

        /*$('button#btn-delete').bind('click', function (event){
            var $form   = this.form;
            event.preventDefault();
            return alertify.confirm("Are you sure you wish to delete this recipe?", function (e) {
                if (e) {
                    $form.submit();
                } else {
                    // nothing happend
                }
            });
        });*/
    </script>
@stop