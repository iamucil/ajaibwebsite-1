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
        // api for get photo user
        Route::get('/user/photo', ['middleware' => 'oauth', 'as' => 'api.user.photo', 'uses' => 'UserController@getPhotoApiService']);
    });

    Route::group(['prefix' => 'dashboard', 'module' => 'User', 'middleware' => ['auth', 'role:admin|root']], function() {
        Route::get('/users', ['as' => 'user.list', 'uses' => 'UserController@getListUsers']);
        Route::put('/users/{user}/setactive', ['as' => 'user.setactive', 'uses' => 'UserController@setActive']);
        Route::delete('/users/{user}', ['as' => 'user.destroy', 'uses' => 'UserController@destroy']);
        // Route::put('/users/{user}', ['as' => 'user.setactive', 'uses' => 'UserController@setActive']);
        Route::get('/users/create', ['as' => 'user.add', 'uses' => 'UserController@create']);
        Route::post('/users/store', ['as' => 'user.store', 'uses' => 'UserController@storeLocal']);
        Route::get('/users/{user}/edit', ['as' => 'user.edit', 'uses' => 'UserController@edit']);
        Route::PUT('/users/{user}', ['as' => 'user.update', 'uses' => 'UserController@updateProfile']);
        Route::get('/users/data', ['as' => 'user.json', 'uses' => 'UserController@getUsers']);
        Route::post('/users/reset-default', ['as' => 'user.password_default', 'uses' => 'UserController@resetPasswordDefault']);
    });

    Route::group(['prefix' => 'dashboard', 'module' => 'User', 'middleware' => ['auth', 'role:operator|admin|root']], function() {
        Route::get('/users/list', ['as' => 'user.list.operator', 'uses' => 'UserController@getListUsersOperator']);
        Route::get('/users/photo/{user}', ['as' => 'user.profile.getphotopath', 'uses' => 'UserController@getPhotoPath']);
        Route::get('/users/reset-password/{id}', ['as' => 'users.reset-password', 'uses' => 'UserController@getResetPassword']);
        Route::post('/users/reset-password', ['as' => 'users.reset-password', 'uses' => 'UserController@postResetPassword']);
    });

    Route::group(['prefix'=>'/profile', 'middleware' => 'auth'], function(){
        Route::get('/{user}', ['as' => 'user.profile', 'uses' => 'UserController@showProfile']);
        Route::post('/upload/photo', ['as' => 'user.profile.uploadphoto', 'uses' => 'UserController@uploadPhoto']);
        Route::get('/photo/{user}', ['as' => 'user.profile.getphoto', 'uses' => 'UserController@getPhoto']);
    });
    // Route::resource('User', 'UserController');

});