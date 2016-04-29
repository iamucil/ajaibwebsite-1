@extends('layouts.dashboard')
@section('title')
    Menu Management
@stop

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('/js/vendor/dhtmlx/tree/dhtmlxtree.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('/js/vendor/dhtmlx/menu/dhtmlxmenu.css') }}">
    <style type="text/css">
    .dhxtree_dhx_skyblue .standartTreeRow, .dhxtree_dhx_skyblue .standartTreeRow_lor {
        font-family: 'Montserrat', sans-serif!important;
    }
    .dhxtree_dhx_skyblue .selectedTreeRow_lor, .dhxtree_dhx_skyblue .selectedTreeRow {
        font-family: 'Montserrat', sans-serif!important;
        font-weight: bolder;
    }
    </style>
@stop

@section('script')
    @parent
    <script type="text/javascript" src="{{ secure_asset('/js/vendor/dhtmlx/tree/dhtmlxtree.js') }}"></script>
    <script type="text/javascript" src="{{ secure_asset('/js/vendor/dhtmlx/menu/dhtmlxmenu.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-2">
            <div class="bg-complete-profile">
                <a href="{{ route('menus.create') }}">
                    <span class="icon-plus"></span>
                    <h6 class="bg-black text-white"><strong>Add new Menu</strong></h6>
                </a>
            </div>
        </div>
        <div class="col-md-2">
            <div class="bg-complete-profile">
                <a href="{{ route('menus.assign-roles') }}">
                    <span class="icon-user-group"></span>
                    <h6 class="bg-black text-white"><strong>Assign Role Menu</strong></h6>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header bg-transparent">
                    <h3 class="box-title">
                        <i class="icon-graph-pie"></i>
                        <span>Tree Menu</span>
                    </h3>
                </div>
                <div class="box-body">
                    <div id="treeboxbox_tree" style="background: inherit;"></div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script-bottom')
    @parent

    <script type="text/javascript">
    var asset       = "{!! asset('/js/vendor/dhtmlx/tree/skins/skyblue/imgs/dhxtree_skyblue/') !!}";
    var icon_paths  = "{!! asset('/js/vendor/dhtmlx/menu/imgs') !!}";
    var tree_data   = JSON.parse('{!! $data->content() !!}');
    var menu_items  = JSON.parse('{!! $menus->content() !!}');

    menu        = new dhtmlXMenuObject();
    menu.setIconsPath(icon_paths + '/');
    menu.renderAsContextMenu();
    menu.attachEvent("onClick",onButtonClick);
    menu.loadStruct(menu_items);
    tree = new dhtmlXTreeObject("treeboxbox_tree","100%","100%",0);
    var checkBranch    = function(id,state){
        if (state){
            tree.setSubChecked(id,true);
        }else{
            tree.setSubChecked(id,false);
        }
    }
    tree.setSkin('dhx_skyblue');
    tree.setImagePath(asset + '/');
    tree.setDataMode('json');
    tree.enableTreeLines(true);
    tree.setOnCheckHandler(checkBranch);
    tree.openAllItems(0);
    tree.enableContextMenu(menu);
    tree.parse(tree_data, "json");
    // console.log(myTree);
    function onButtonClick(menuitemId,type){
        var id      = tree.contextID;
        var type    = menuitemId;
        if(type.toUpperCase() == 'ABOUT'){
            console.log(type);
        }else if(type.toUpperCase() == 'NEW'){
            var url     = "{{ route('menus.create') }}";
            window.location.assign(url);
        }else if(type.toUpperCase() == 'EDIT'){
            var url     = "{{ route('menus.show', ['id' => "id"]) }}";
            console.log(url.replace('id', id));
        }
    }
    </script>
@stop