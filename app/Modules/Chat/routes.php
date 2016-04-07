<?php

Route::group(array('module' => 'Chat', 'namespace' => 'App\Modules\Chat\Controllers'), function () {

    // API Service Route
    Route::group(['prefix' => 'api/v1'], function () {

        // api for get data chat
        Route::get('/chat', ['middleware' => 'oauth', 'as' => 'api.chat.index', 'uses' => 'ChatController@index']);
        // api for insert data chat
        Route::post('/chat', ['middleware' => 'oauth', 'as' => 'api.chat.store', 'uses' => 'ChatController@store']);
        // api for update read chat
        Route::put('/chat/{chat}', ['middleware' => 'oauth', 'as' => 'api.chat.oauthUpdateChat', 'uses' => 'ChatController@oauthUpdateChat']);
        // add user to channel group
        //Route::post('/chat/addChannelToGroup', ['as'=>'api.chat.addChannelToGroup','uses' => 'ChatController@addChannelToGroup']);
        //Route::post('/chat/removeChannelFromGroup', ['as'=>'api.chat.removeChannelFromGroup','uses' => 'ChatController@removeChannelFromGroup']);
        //Route::post('/chat/grantChannelGroup', ['as'=>'api.chat.grantChannelGroup','uses' => 'ChatController@grantChannelGroup']);
        Route::post('/chat/attachment/send', ['middleware' => 'oauth','as' => 'dashboard.chat.sendAttachment', 'uses' => 'ChatController@sendAttachment']);
    });

    Route::group(['prefix' => 'dashboard'], function () {
        // logging chat from backend by user id
        Route::get('chat/{user}', ['as'=>'dashboard.chat.history','uses' => 'ChatController@chatLog']);
        // chat history by action => seen & unseen message
        Route::get('chat/public/{read}', ['as'=>'dashboard.chat.public','uses' => 'ChatController@authHistoryPublic']);
        Route::get('chat/private/{read}', ['as'=>'dashboard.chat.private','uses' => 'ChatController@authHistoryPrivate']);
//        Route::put('chat/{msgid}', ['as' => 'dashboard.chat.update', 'uses' => 'ChatController@update']);
        Route::post('chat/update', ['as' => 'dashboard.chat.authUpdateChat', 'uses' => 'ChatController@authUpdateChat']);
        Route::post('chat/insertlog',
            [
                'middleware' => 'auth',
                'as'=>'dashboard.chat.insertlog',
                'uses' => 'ChatController@insertLog'
            ]
        );
        Route::resource('chat', 'ChatController',[
            'names' => [
                'insertlog'    => 'dashboard.chat.insertlog',
                'authUpdateChat' => 'dashboard.chat.authUpdateChat'
            ]
        ]);

        Route::post('chat/attachment/send', ['as' => 'dashboard.chat.sendAttachment', 'uses' => 'ChatController@sendAttachment']);
    });
});

