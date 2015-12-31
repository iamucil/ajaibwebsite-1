<?php

Route::group(array('module' => 'Chat', 'namespace' => 'App\Modules\Chat\Controllers'), function () {

    // API Service Route
    Route::group(['prefix' => 'api/v1'], function () {

        // api for get data chat
        Route::get('/chat', ['middleware' => 'oauth', 'as' => 'api.chat.index', 'uses' => 'ChatController@index']);
        // api for insert data chat
        Route::post('/chat', ['middleware' => 'oauth', 'as' => 'api.chat.store', 'uses' => 'ChatController@store']);

    });

});

