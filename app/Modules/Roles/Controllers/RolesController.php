<?php namespace App\Modules\Roles\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Roles\Models\Role;
use App\Modules\Roles\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;

class RolesController extends Controller {

    public function __construct()
    {
        $this->middleWare('auth', ['except' => ['generateRoles']]);
        $this->middleWare('role:root', ['except' => ['generateRoles']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $roles      = Role::orderBy('name', 'asc')->get();
        return view("Roles::index", compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Roles::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator      = Validator::make($request->all(), [
            'name' => 'required|unique:roles|max:50'
        ]);

        if($validator->fails()){
            flash()->error($validator->errors()->first());
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }else{
            $role                   = new Role();
            $role->name             = $request->name;
            $role->display_name     = $request->display_name;
            $role->description      = $request->description;
            $role->save();

            flash()->success('Your data has been saved');
            return redirect()->route('roles.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        $role       = Role::find($id);
        $role_users = $role->users;
        $users      = User::paginate(200);

        if($request->ajax()) {
            return response()->json(['data' => 'json']);
        }else{
            // $u  = User::where('name', '=', '+6285640427774')->first();
            // $u->attachRole($role);
            $title      = 'Detail Roles';
            return view('Roles::show')->with(compact('users', 'role_users', 'role', 'title'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $role       = Role::find($id);
        $title      = 'Edit Role';
        return view('Roles::edit')->with(compact('role', 'title'))->withInput($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $role       = Role::find($id);
        $role->name             = $role->name;
        $role->display_name     = $request->display_name;
        $role->description      = $request->description;

        if(!$role->save()){
            flash()->error('Error Occured when saving your data');
            return redirect()->route('roles.edit', ['id' => $id])->withInput();
        }else{
            flash()->success('Your data has been saved');
            return redirect()->route('roles.index');
        }

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

    public function generateRoles()
    {
        try {
            echo '<br>init with Sentry users seader...';
            \Artisan::call('db:seed', [
                '--class' => 'UsersTableSeeder',
            ]);
            echo '<br>done with Sentry users seeder';

            echo '<br />Initializing with sentry roles seeder...';
            \Artisan::call('db:seed', [
                '--class' => 'RolesTableSeeder',
            ]);
            echo '<br />done with Sentry roles seeder';
            $mRole          = new Role;
            $root           = $mRole->where('name', '=', 'root');
            $administrator  = $mRole->where('name', '=', 'admin');
            $operator       = $mRole->where('name', '=', 'operator');
            $users          = $mRole->where('name', '=', 'users');
            $root_user      = User::where('name', '=', 'root');
            $admin_user     = User::where('name', '=', 'administrator');
            $operator_user  = User::where('name', '=', 'operator');

            if(true === $root->exists()){
                $root       = $root->first();
                if($root_user->exists() AND false === $root_user->first()->hasRole([$root->name], true)){
                    $root_user->first()->attachRole($root);
                }
            }else{
                $root       = null;
            }

            if(true === $administrator->exists()){
                $administrator       = $administrator->first();
                if($admin_user->exists() AND false === $admin_user->first()->hasRole([$administrator->name], true)){
                    $admin_user->first()->attachRole($administrator);
                }
            }else{
                $administrator       = null;
            }

            if(true === $operator->exists()){
                $operator       = $operator->first();
                if($operator_user->exists() AND false === $operator_user->first()->hasRole([$operator->name], true)){
                    $operator_user->first()->attachRole($operator);
                }
            }else{
                $operator       = null;
            }

            if(Auth::check()){
                if(Auth::user()->hasRole('root')){
                    flash()->success('Your Roles has been generated!!');
                    return redirect()->route('roles.index');
                }else{
                    Auth::logout();
                    return redirect()->route('login');
                }
            }else{
                return redirect()->route('login');
            }
        } catch (Exception $e) {
            Response::make($e->getMessage(), 500);
        }
    }

    public function attachRole(Request $request)
    {
        $role       = Role::find($request->role_id);
        $user       = User::find($request->user_id);
        $user->attachRole($role);
        return response()->json(['data' => $request->all()]);
    }
}
