<?php namespace App\Modules\Menu\Controllers;

use Illuminate\Routing\Router;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Menu\Models\Menu;
use Illuminate\Http\Request;
use App\Role;
use Validator;
use DB;

class MenuController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // create new array
        $data       = [];
        /*$query      = Menu::all();
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
        $data           = response()->json($grid);*/
        return view("Menu::index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $roles      = Role::lists('name', 'id');
        $request->merge([
            'set_parent' => (int)$request->old('set_parent', 0)
        ]);

        return view('Menu::create', compact('roles', 'request'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        return redirect()->route('menus.create')->withInput($request->except(['_token']));
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

    public function listParentMenu()
    {
        $menus      = $parents    = Menu::where('parent_id', '=', '0')->get();
        return view('Menu::list_parent_menu', compact('menus'));
    }

    public function routeCollections(Router $router)
    {
        $route_collections      = $router->getRoutes();
        $route_lists            = [];
        $index                  = 0;
        foreach ($route_collections as $route) {
            $prefix         = $route->getPrefix();
            $methods        = $route->getMethods();
            $name           = $route->getName();
            $uri            = $route->getUri();
            $actions        = $route->getAction();
            if(!in_array('GET', (array)$methods)){
                continue;
            }

            if(empty($name)){
                continue;
            }

            if(!preg_match('@^(?:(^\/)?(dashboard))@i', $prefix)) {
                continue;
            }

            $route_lists[$index]    = compact('name', 'uri');
            // dd(get_class_methods($route));
            $index+=1;
        }
        $routes     = collect((array)$route_lists);
        // dd($routes->toJson());
        return view('Menu::route_lists', compact('routes'));
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
