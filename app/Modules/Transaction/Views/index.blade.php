@extends('layouts.dashboard')

@section('title')
Transaction
@stop

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('/js/vendor/dhtmlx/grid/skins/web/dhtmlxgrid.css') }}">
    <style type="text/css">
    .not_m_line{
        white-space:normal !important; overflow:hidden;
    }
    </style>
@stop

@section('content')
    <div class="box">
        <div class="box-header bg-transparent">
            <!-- tools box -->
            <div class="pull-right box-tools">
                <div class="btn-group" role="group" aria-label="...">
                    <a href="{{ route('transactions.create') }}" class="btn btn-default" role="button">
                        Tambah Transaksi
                    </a>
                    <a class="btn btn-default" role="button" href="{{ route('transaction.category.index') }}">
                        Daftar Kategori
                    </a>
                </div>
            </div>
            <h3 class="box-title">
                <i class="fontello-th-large-outline"></i>
                <span>Daftar Transaksi</span>
            </h3>
        </div>
        <div class="box-body " style="display: block;">
            {{-- data table --}}
            <div id="recinfoArea"></div>
            <div id="gridbox" style="width: 100%; height: 100%; min-height: 100%; background-color:white;"></div>
            <div><span id="pagingArea"></span>&nbsp;<span id="infoArea"></span></div>
            {{-- end data table --}}
        </div>
    </div>
@stop

@section('script-bottom')
    @parent
    <script type="text/javascript" src="{{ secure_asset('/js/vendor/dhtmlx/grid/dhtmlxgrid.js') }}"></script>
    <script type="text/javascript">
        var grid;
        var url_data    = "{{ route('transactions.data') }}";
        var image_path  = "{{ asset('/js/vendor/dhtmlx/grid/imgs/') }}";
        var skins       = "{{ asset('/js/vendor/dhtmlx/grid/skins/') }}";
        grid            = new dhtmlXGridObject('gridbox');
        grid.enableColSpan(true);
        grid.setImagePath(skins + '/web/imgs/dhxgrid_web/');
        grid.setHeader("Invoice,Tanggal, Kategori, Signer,Phone Number, Email, Deskripsi,&nbsp;,#cspan,#cspan");
        grid.enableAutoWidth(true);
        grid.setInitWidths("95,95,115,115,115,135,*,45,45,45");
        grid.setColAlign("right,center,left,left,left,left,left,center,center,center");
        grid.enableSmartRendering(true);
        grid.setColSorting('str,date,str,str,str');
        grid.setColTypes("link,ro,link,ro,ro,ro,ro,button,button,button,button,button");
        grid.enableAutoWidth(true);
        grid.enableAutoHeight(true);
        grid.enableMultiline(true);
        grid.enableTooltips("false,false,true,true,true,true")
        grid.init();
        grid.load(url_data, function() {
            grid.forEachRow(function(id){
                grid.cells(id,2).cell.className='not_m_line';
                grid.cells(id,7).cell.className='not_m_line';
                grid.enableAutoHeight(true);
            });
        },'json');

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
    </script>
@stop