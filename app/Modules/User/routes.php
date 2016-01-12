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

    Route::group(['prefix' => 'dashboard', 'module' => 'User', 'middleware' => ['role:admin|root']], function() {
        Route::get('/users', ['as' => 'user.list', 'uses' => 'UserController@getListUsers']);
        Route::post('/users/{user}/setactive', ['as' => 'user.setactive', 'uses' => 'UserController@setActive']);
        Route::delete('/users/{user}', ['as' => 'user.destroy', 'uses' => 'UserController@destroy']);
        Route::put('/users/{user}', ['as' => 'user.setactive', 'uses' => 'UserController@setActive']);
        Route::get('/users/create', ['as' => 'user.add', 'uses' => 'UserController@create']);
        Route::post('/users/store', ['as' => 'user.store', 'uses' => 'UserController@storeLocal']);
    });

    Route::group(['prefix'=>'/profile', 'middleware' => 'auth'], function(){
        Route::get('/{user}', ['as' => 'user.profile', 'uses' => 'UserController@showProfile']);
        Route::post('/upload/photo', ['as' => 'user.profile.uploadphoto', 'uses' => 'UserController@uploadPhoto']);
        Route::get('/photo/{user}', ['as' => 'user.profile.getphoto', 'uses' => 'UserController@getPhoto']);
    });
    // Route::resource('User', 'UserController');

});