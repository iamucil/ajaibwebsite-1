<?php
Route::group(['module' => 'Oauth', 'namespace' => 'App\Modules\Oauth\Controllers'], function() {

    Route::resource('authorized', 'OauthController');
});
Route::group([
   'prefix' => 'oauth',
   'module' => 'Oauth',
   'as' => 'oauth::',
   'namespace' => 'App\Modules\Oauth\Controllers'], function () {
    Route::get('/client', ['as' => 'client', 'uses' => 'OauthController@client']);
});