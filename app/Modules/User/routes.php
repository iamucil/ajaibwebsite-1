<?php

Route::group(array('module' => 'User', 'namespace' => 'App\Modules\User\Controllers'), function() {

    // API Service Route
    Route::group(['prefix'=>'api/v1'], function(){

        // api for get data user
        Route::get('/user', ['middleware' => 'oauth', 'as' => 'api.user.index', 'uses' => 'UserController@index']);
        // api for insert new data user (register)
        Route::post('/user', ['as' => 'api.user.store', 'uses' => 'UserController@store']);
        // api for update data user
        Route::post('/user/update', ['middleware' => 'oauth', 'as' => 'api.user.update', 'uses' => 'UserController@update']);
    });

    Route::group(['prefix' => 'dasboard', 'module' => 'User'], function() {
        Route::get('/users', ['as' => 'user.list', 'uses' => 'UserController@getListUsers']);
    });

    Route::get('/profile/{user}', [
        'middleware' => 'auth',
        'as' => 'user.profile',
        'uses' => 'UserController@showProfile'
    ]);

    Route::resource('User', 'UserController');

});