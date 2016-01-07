<?php namespace App\Modules\Menu\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Menu\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query      = Menu::all();
        $items      = [];
        if(!$query->isEmpty()){
            foreach ($query as $menu) {
                $parents            = $menu->parents();
                $menu->parent_id    = 0;
                if($parents->exists()){
                    $parent             = $parents->first();
                    $menu->parent_id    = $parent->id;
                    $menu->kode_sistem  = $parent->id.'.'.$menu->id;
                }else{
                    $menu->parent_id    = 0;
                    $menu->kode_sistem  = $menu->id;
                }
                $items[$menu->parent_id][]    = [
                    'id' => $menu->id,
                    'text' => $menu->name,
                    'kode_sistem'   => $menu->kode_sistem
                ];
            }
        }

        $parent_item    = $items[0];
        $grid           = self::_createTree($items, $parent_item);
        $data           = response()->json($grid);
        return view("Menu::index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Create tree node for dhtmlx tree
     * @param  Array &$list  List item
     * @param  Array $parent Parent Item
     * @return Array $tree Array tree
     */
    private function _createTree(&$list, $parent){
        $tree = array();
        foreach ($parent as $k=>$l){
            if(isset($list[$l['id']])){
                $l['item'] = self::_createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }
}
