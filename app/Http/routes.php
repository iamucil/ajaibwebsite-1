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

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/backend', function () {
    return view('dashboard');
});


Route::group([
    'prefix' => 'admin',
    'module' => 'User',
    'as' => 'admin::',
    'middleware' => ['auth']
], function () {
    Route::get('/dashboard', ['as' => 'dashboard', function () {
        return view('admin');
    }]);
});
Route::get('auth/login', [
   'as' => 'login',
   'uses' => 'Auth\AuthController@getLogin'
]);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@doRegister');

/**
 * Success Register
 */
Route::get('auth/success', ['as' => 'auth.success.get', 'uses' => 'UserController@confirmation']);

Route::get('oauth/authorize', ['as' => 'oauth.authorize.get', 'middleware' => ['check-authorization-params', 'auth'], function() {
    $authParams                 = Authorizer::getAuthCodeRequestParams();

    $formParams                 = array_except($authParams,'client');

    $formParams['client_id']    = $authParams['client']->getId();

    $formParams['scope']        = implode(config('oauth2.scope_delimiter'), array_map(function ($scope) {
       return $scope->getId();
    }, $authParams['scopes']));

    return View::make('oauth.authorization-form', ['params' => $formParams, 'client' => $authParams['client']]);
}]);

Route::post('oauth/authorize', ['as' => 'oauth.authorize.post', 'middleware' => ['csrf', 'check-authorization-params', 'auth'], function() {

    $params             = Authorizer::getAuthCodeRequestParams();
    $params['user_id']  = Auth::user()->id;
    $redirectUri = '/';

    // If the user has allowed the client to access its data, redirect back to the client with an auth code.
    if (Request::has('approve')) {
        $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
    }

    // If the user has denied the client to access its data, redirect back to the client with an error message.
    if (Request::has('deny')) {
        $redirectUri = Authorizer::authCodeRequestDeniedRedirectUri();
    }

    return Redirect::to($redirectUri);
}]);

Route::post('api/v1/oauth/access_token', function() {
    $result         = Authorizer::issueAccessToken();

    return Response::json($result);
});

/**
 * chat client example
 * this is dummy and parameters still hardcoded
 */
Route::get('/chat-client', function () {
    return view('chat-client');
});

Route::get('/start', function () {
$subscriber = new Role();
    $subscriber->name = 'Subscriber';
    $subscriber->save();

    $author = new Role();
    $author->name = 'Author';
    $author->save();

    $read = new Permission();
    $read->name = 'can_read';
    $read->display_name = 'Can Read Posts';
    $read->save();

    $edit = new Permission();
    $edit->name = 'can_edit';
    $edit->display_name = 'Can Edit Posts';
    $edit->save();

    $subscriber->attachPermission($read);
    $author->attachPermission($read);
    $author->attachPermission($edit);

    // $user1 = User::find(1);
    // $user2 = User::find(2);

    // $user1->attachRole($subscriber);
    // $user2->attachRole($author);

    return 'Woohoo!';
});