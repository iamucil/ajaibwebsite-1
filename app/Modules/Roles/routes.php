<?php

Route::group(array('module' => 'Roles', 'namespace' => 'App\Modules\Roles\Controllers'), function() {
    Route::get('roles/generate', 'RolesController@generateRoles')->name('generate');
    Route::resource('roles', 'RolesController');
});

// Route::group([
//     'prefix' => 'entrust',
//     'module' => 'Role',
//     'as' => 'roles::',
//     'namespace' => 'App\Modules\Roles\Controllers'], function () {
//         Route::post('/attach-role/{id}', 'RolesController@attachRole')->name('attach');
// });