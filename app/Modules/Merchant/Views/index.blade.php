@extends('layouts.dashboard')

@section('title')
    Daftar Vendor
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('/js/vendor/dhtmlx/grid/skins/web/dhtmlxgrid.css') }}">
    <style type="text/css">
    .not_m_line{
        white-space:normal !important; overflow:hidden;
    }
    </style>
@stop

@section('content')
    <div class="box bg-white">
        <div class="box-header bg-transparent">
            <!-- tools box -->
            <div class="pull-right box-tools">
                <div class="btn-group" role="group" aria-label="...">
                    <a href="{{ route('vendor.create') }}" class="btn btn-default" role="button">
                        Tambah Vendor
                    </a>
                    <a href="{{ route('vendor.category.index') }}" class="btn btn-default" role="button" href="vendor.category.index">
                        Daftar Kategori
                    </a>
                </div>
            </div>
            <h3 class="box-title">
                <i class="fontello-th-large-outline"></i>
                <span>Vendor</span>
            </h3>
        </div>
        <div class="box-body">
            {{-- data table --}}
            <div id="recinfoArea"></div>
            <div id="gridbox" style="width: 100%; height: 100%; min-height: 100%; background-color:white;"></div>
            <div><span id="pagingArea"></span>&nbsp;<span id="infoArea"></span></div>
            {{-- end data table --}}
        </div>
    </div>

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="mySmallModalLabel">Small modal</h4></div>
                <div class="modal-body "> ...</div>
            </div>
        </div>
    </div>
@stop

@section('script-bottom')
    @parent
    <script type="text/javascript" src="{{ secure_asset('/js/vendor/dhtmlx/grid/dhtmlxgrid.js') }}"></script>
    <script type="text/javascript">
        var grid;
        var url_data    = "{{ route('vendor.data') }}";
        var image_path  = "{{ asset('/js/vendor/dhtmlx/grid/imgs/') }}";
        var skins       = "{{ asset('/js/vendor/dhtmlx/grid/skins/') }}";
        grid            = new dhtmlXGridObject('gridbox');
        grid.enableColSpan(true);
        grid.setImagePath(skins + '/web/imgs/dhxgrid_web/');
        grid.setHeader("&nbsp;,#text_filter,#cspan,#cspan,#cspan,#cspan,#cspan");
        grid.attachHeader("#rspan,Nama, Kategori, Deskripsi, Transaksi,&nbsp,#cspan");
        grid.enableAutoWidth(true);
        grid.setInitWidths("40,135,95,*,65,65,65");
        grid.setColAlign("right,left,left,left,center,center,center");
        grid.enableSmartRendering(true);
        grid.setColSorting('na,str,str,na,na,na,na');
        grid.setColTypes("cntr,link,ro,ro,ro,button,button");
        grid.enableAutoHeight(true);
        grid.enableMultiline(true);
        // grid.enableTooltips("false,false,true,true,true,true")
        grid.init();
        grid.load(url_data, function() {
            grid.forEachRow(function(id){
                grid.cells(id,2).cell.className='not_m_line';
                // grid.cells(id,7).cell.className='not_m_line';
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
                        switch (b.length) {
                            case 3:
                                 b[1] += " target='" + b[2] + "'"
                            break;
                            case 4:
                                b[1] += " target='" + b[2] + "' onclick = '(_isIE?event:arguments[0]).cancelBubble = true; " + b[3] + "'";
                            break;
                            default:
                                b[1] += " target='_blank' onclick='(_isIE?event:arguments[0]).cancelBubble = true;'";
                            break;
                        }
                    }
                }
                this.setCValue("<a class='btn btn-link' " + b[1] + ">" + b[0] + "</a>", b)
            }
        }
        // nests all other methods from the base class
        eXcell_button.prototype = new eXcell;

        function doDelete (id) {
            var url     = "{{ route('vendor.destroy', ['id']) }}";
            url         = url.replace(/id/g, id);
            $ajax       = $.ajax({
                cache: false,
                url : url,
                type: "POST",
                dataType : "json",
                data : {'id' : id, '_method' : 'DELETE'},
                context : document.body
            });



            return alertify.confirm('Apakah Anda yakin akan menghapus data Vendor dengan ID '+id+'?', function (e) {
                if(e) {
                    $ajax.done(function(data,  status, jqXHR) {
                        if (data.status == 201) {
                            alertify.success(data.message);
                            grid.clearAll();
                            grid.load(url_data, function() {
                                grid.forEachRow(function(id){
                                    grid.cells(id,2).cell.className='not_m_line';
                                    // grid.cells(id,7).cell.className='not_m_line';
                                    grid.enableAutoHeight(true);
                                });
                            }, 'json');
                        } else if (data.status == 500) {
                            alertify.success(data.message);
                        }
                    });
                }else{
                    alertify.log('Cancel proses hapus!');
                    return false;
                }
            });
        }
    </script>
@stop