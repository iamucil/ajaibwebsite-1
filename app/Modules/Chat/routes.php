<?php

Route::group(array('module' => 'Chat', 'namespace' => 'App\Modules\Chat\Controllers'), function () {

    // API Service Route
    Route::group(['prefix' => 'api/v1'], function () {

        // api for get data chat
        Route::get('/chat', ['middleware' => 'oauth', 'as' => 'api.chat.index', 'uses' => 'ChatController@index']);
        // api for insert data chat
        Route::post('/chat', ['middleware' => 'oauth', 'as' => 'api.chat.store', 'uses' => 'ChatController@store']);
        // add user to channel group
        //Route::post('/chat/addChannelToGroup', ['as'=>'api.chat.addChannelToGroup','uses' => 'ChatController@addChannelToGroup']);
        //Route::post('/chat/removeChannelFromGroup', ['as'=>'api.chat.removeChannelFromGroup','uses' => 'ChatController@removeChannelFromGroup']);
        //Route::post('/chat/grantChannelGroup', ['as'=>'api.chat.grantChannelGroup','uses' => 'ChatController@grantChannelGroup']);
    });

    Route::group(['prefix' => 'dashboard'], function () {
        // logging chat from backend
        Route::get('chat/{user}', ['as'=>'dashboard.chat.history','uses' => 'ChatController@chatLog']);
//        Route::put('chat/{msgid}', ['as' => 'dashboard.chat.update', 'uses' => 'ChatController@update']);
        Route::post('chat/insertlog', ['as'=>'dashboard.chat.insertlog','uses' => 'ChatController@insertLog']);
        Route::resource('chat', 'ChatController',[
            'names' => [
                'insertlog'    => 'dashboard.chat.insertlog',
            ]
        ]);
    });
});

