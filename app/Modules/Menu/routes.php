<?php

Route::group(['module' => 'Menu', 'prefix' => 'dashboard', 'namespace' => 'App\Modules\Menu\Controllers', 'middleware' => ['auth', 'role:admin|root']], function() {

    Route::group(['prefix' => 'menus', ], function() {
        Route::get('route-list', 'MenuController@routeCollections')->name('route-list');
        Route::get('parent', 'MenuController@listParentMenu')->name('parent_menu');
        Route::get('icons-pack', function () {
            return view('Menu::dripicons');
        })->name('icons-pack');
        Route::get('assign-roles', 'MenuController@assignRole')->name('menus.assign-roles');
    });

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