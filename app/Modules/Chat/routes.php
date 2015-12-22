<?php

Route::group(array('module' => 'Chat', 'namespace' => 'App\Modules\Chat\Controllers'), function() {

    Route::resource('Chat', 'ChatController');
    
});

// API Service Route
Route::group(['prefix'=>'api', 'namespace' => 'App\Modules\Chat\Controllers', 'middleware' => 'oauth'], function(){

    Route::resource('chat','ChatController',['only'=>['index','store']]);

});

// Chat with oauth
