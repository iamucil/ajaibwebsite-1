<?php

Route::group(['module' => 'Menu', 'prefix' => 'dashboard', 'namespace' => 'App\Modules\Menu\Controllers', 'middleware' => ['auth', 'role:admin|root']], function() {

    Route::resource('menus', 'MenuController', [
        'names' => [
            'create'    => 'menus.create',
            'index'     => 'menus.index',
            'store'     => 'menus.store',
            'edit'      => 'menus.edit',
            'delete'    => 'menus.delete',
            'update'    => 'menus.update',
            'show'      => 'menus.show',
            'destroy'   => 'menus.destroy',
        ]
    ]);

});