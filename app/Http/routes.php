<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/backend', function () {
    return view('dashboard');
});

// Route::get('/admin', function () {
//     return view('admin');
// });



Route::group([
    'prefix' => 'dashboard',
    'module' => 'User',
    'as' => 'admin::',
    'middleware' => ['auth']
], function () {
    Route::get('/', ['as' => 'dashboard', function () {
        return view('admin');
    }]);
});

Entrust::routeNeedsRole('/dashboard/*', ['root', 'admin', 'operator']);

Route::get('auth/login', [
   'as' => 'login',
   'uses' => 'Auth\AuthController@getLogin'
]);
Route::post('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

Route::get('auth/register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('auth/register', ['as' => 'register', 'uses' => 'Auth\AuthController@doRegister']);

/**
 * Success Register
 */
Route::get('auth/success', ['as' => 'auth.success.get', 'uses' => 'UserController@confirmation']);

/**
 * chat client example
 * this is dummy and parameters still hardcoded
 */
Route::get('/chat-client', function () {
    return view('chat-client');
});

Route::get('/chat-client-2', function () {
    return view('chat-client-2');
});

Route::get('/greetings', function () {
    return view('/emails/greeting');
});