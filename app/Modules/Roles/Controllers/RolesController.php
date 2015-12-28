<?php namespace App\Modules\Roles\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Roles\Models\Role;
use App\Modules\Roles\Models\Permission;
use Illuminate\Http\Request;

class RolesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("Oauth::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        die('create');
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

    public function generateRoles()
    {
        $root       = new Role();
        $root->name                 = 'root';
        $root->display_name         = 'Super User'; // optional
        $root->description          = 'User is Super User Applikasi'; // optional
        $root->save();

        $admin      = new Role();
        $admin->name                = 'admin';
        $admin->display_name        = 'User Administrator'; // optional
        $admin->description         = 'User is allowed to manage and edit other users'; // optional
        $admin->save();

        $operator   = new Role();
        $operator->name             = 'operator';
        $operator->display_name     = 'User Operator'; // optional
        $operator->description      = 'User only allowed to manage their data'; // optional
        $operator->save();

        $users      = new Role();
        $users->name             = 'users';
        $users->display_name     = 'End Users'; // optional
        $users->description      = 'User only allowed to manage their data'; // optional
        $users->save();

        return 'Woohoooo!!';
    }

}
