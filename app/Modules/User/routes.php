<?php

Route::group(array('module' => 'User', 'namespace' => 'App\Modules\User\Controllers'), function() {

    Route::resource('User', 'UserController');
    
});

// API Service Route
Route::group(array('prefix'=>'api/v1', 'namespace' => 'App\Modules\User\Controllers'), function(){
    // api for get data user
    //$access_token = Request::header('Authorization');
    //Request::input('access_token', $access_token);
    Route::get('/user', ['middleware' => 'oauth', 'as' => 'api.user.index', 'uses' => 'UserController@index']);
    // api for insert new data user (register)
    Route::post('/user', ['as' => 'api.user.store', 'uses' => 'UserController@store']);
    // api for update data user
    Route::post('/user/update', ['middleware' => 'oauth', 'as' => 'api.user.update', 'uses' => 'UserController@update']);

});