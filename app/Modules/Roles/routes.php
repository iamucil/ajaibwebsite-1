<?php

Route::group([
      'module' => 'Roles',
      'namespace' =>
      'App\Modules\Roles\Controllers',
      'prefix' => 'dashboard',
      'as' => null
   ], function() {
    Route::group(['prefix' => 'roles', 'module' => 'Roles', 'as' => 'roles.'], function() {
       Route::get('generate', 'RolesController@generateRoles')->name('generate');
       Route::post('/attach-role/{id}', 'RolesController@attachRole')->name('attach');
    });
    Route::resource('roles', 'RolesController', [
        'names' => [
            'create'    => 'roles.create',
            'index'     => 'roles.index',
            'store'     => 'roles.store',
            'edit'      => 'roles.edit',
            'delete'    => 'roles.delete',
            'update'    => 'roles.update',
            'show'      => 'roles.show',
            'destroy'   => 'roles.destroy',
        ]
    ]);
});