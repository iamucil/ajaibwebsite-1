<?php

Route::group(['module' => 'Menu', 'prefix' => 'ajaib', 'namespace' => 'App\Modules\Menu\Controllers', 'middleware' => ['auth', 'role:admin|root']], function() {

    Route::group(['prefix' => 'menus', ], function() {
        Route::get('route_list', 'MenuController@routeCollections')->name('route-list');
        Route::get('parent', 'MenuController@listParentMenu')->name('parent_menu');        
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