@extends('layouts.dashboard')
@section('title')
    Menu Management
@stop

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('/js/vendor/dhtmlx/tree/dhtmlxtree.css') }}">
@stop

@section('script')
    @parent
    <script type="text/javascript" src="{{ secure_asset('/js/vendor/dhtmlx/tree/dhtmlxtree.js') }}"></script>
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
                <a href="{{ route('menus.create') }}">
                    <span class="icon-user-group"></span>
                    <h6 class="bg-black text-white"><strong>Add new Menu</strong></h6>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2>Tree Menu</h2>
            <div id="treeboxbox_tree"></div>
        </div>
    </div>
@stop

@section('script-bottom')
    @parent

    <script type="text/javascript">
    var asset       = "{!! asset('/js/vendor/dhtmlx/tree/skins/web/imgs/dhxtree_web/') !!}";
    // var tree_menu   = JSON.parse('{!! $data->content() !!}');
    var tree_menu   = {id:0, item:[{id:1,text:"1111"},{id:2, text:"222222", item:[{id:"21", text:"child"}]},{id:3,text:"3333"}]};
    console.log(tree_menu);
    myTree = new dhtmlXTreeObject("treeboxbox_tree","100%","100%",0);
    myTree.setImagePath(asset);
    myTree.setDataMode('json');
    myTree.parse(tree_menu, "json");
    // console.log(myTree);
    </script>
@stop