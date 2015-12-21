<?php

Route::group(array('module' => 'User', 'namespace' => 'App\Modules\User\Controllers'), function() {

    Route::resource('User', 'UserController');
    
});

// API Service Route
Route::group(array('prefix'=>'api/v1', 'namespace' => 'App\Modules\User\Controllers'), function(){

    Route::resource('user','UserController',array('except'=>array('create','edit')));

});