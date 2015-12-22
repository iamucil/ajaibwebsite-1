<?php

Route::group(array('module' => 'Chat', 'namespace' => 'App\Modules\Chat\Controllers'), function() {

    Route::resource('Chat', 'ChatController');
    
});

// API Service Route
Route::group(['prefix'=>'api/v1', 'namespace' => 'App\Modules\Chat\Controllers'], function(){

    Route::resource('chat','ChatController',array('except'=>array('create','edit')));

});

// Chat with oauth
