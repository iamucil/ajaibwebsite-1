<?php
Route::group(['module' => 'Oauth', 'namespace' => 'App\Modules\Oauth\Controllers'], function() {

    Route::resource('authorized', 'OauthController');
});
Route::group([
   'prefix' => 'oauth',
   'module' => 'Oauth',
   'as' => 'oauth::',
   'namespace' => 'App\Modules\Oauth\Controllers'], function () {
    Route::get('/grant_access', ['as' => 'grant_access', 'uses' => 'OauthController@grantAccess']);
});