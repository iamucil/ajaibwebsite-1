<?php

Route::group(array('module' => 'Roles', 'namespace' => 'App\Modules\Roles\Controllers'), function() {

    Route::resource('roles', 'RolesController');
    Route::get('/start', 'RolesController@generateRoles');

});

Route::group([
    'prefix' => 'roles',
    'module' => 'Role',
    'as' => 'roles::',
    'namespace' => 'App\Modules\Roles\Controllers'], function () {
        Route::get('/start', 'RolesController@generateRoles')->name('start');
});