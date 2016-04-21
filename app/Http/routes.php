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
use GuzzleHttp\Client;

Route::get('/', function () {
    return view('home');
});

Route::get('/backend', function () {
    return view('dashboard', compact('route'));
});

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

// Route::post('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::post('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@doLogin']);
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
Route::get('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@doLogin']);

Route::get('auth/register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
Route::get('/register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('auth/register', ['as' => 'register', 'uses' => 'Auth\AuthController@doRegister']);
Route::post('/register', ['as' => 'register', 'uses' => 'Auth\AuthController@doRegister']);

/* with restangular */
Route::get('/ajaib/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
Route::post('/ajaib/login', ['as' => 'login', 'uses' => 'Auth\AuthController@doLogin']);
Route::post('/ajaib/register', ['as' => 'register', 'uses' => 'Auth\AuthController@doRegister']);
/* end with restangular */
/**
 * Success Register
 */
Route::get('auth/success', ['as' => 'auth.success.get', 'uses' => 'UserController@confirmation']);
Route::get('/register-success', ['as' => 'auth.success.get', 'uses' => 'UserController@confirmation']);

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

Route::get('/api/random-user', function () {
    $query_string   = request()->query;
    $client         = new Client([
        'base_uri' => 'https://randomuser.me/api',
    ]);

    $response   = $client->request('GET', '?format=json', [
        'header' => [
            'Content-Type' => 'application/json'
        ], 'Accept'     => 'application/json',
    ]);
    $result     = json_decode($response->getBody()->getContents());

    switch ($query_string->get('picture')) {
        case 'thumbnail':
            return $result->results[0]->user->picture->thumbnail;
            break;
        case 'large':
            return $result->results[0]->user->picture->large;
            break;
        case 'medium':
            return $result->results[0]->user->picture->medium;
            break;
        default:
            return $result->results[0]->user->picture->thumbnail;
            break;
    }
});

Route::get('/geo-ip', function (App\Country $country) {
    $url    = 'http://ipinfo.io';
    $client         = new Client([
        'base_uri' => $url,
    ]);
    $response       = $client->request('GET', '/', [
        'header' => [
            'Content-Type' => 'application/json'
        ], 'Accept' => 'application/json'
    ]);
    $result         = json_decode($response->getBody()->getContents());

    $countries      = $country->where('iso_3166_2', '=', $result->country)->first();
    $country_code   = $countries->iso_3166_2;
    $country_name   = $countries->name;
    $ip_address     = $result->ip;
    // $latitude       = $result->latitude;
    // $longitude      = $result->longitude;
    $call_code      = $countries->calling_code;
    $capital        = $countries->capital;
    $country_id     = $countries->id;
    // return response()->json(compact('countries'));
    return response()->json(compact('country_code', 'country_name', 'ip_address', 'call_code', 'capital', 'country_id'));

});

Route::get('/country/{name?}', ['as' => 'country.list', function(App\Country $country, $name = null) {
    $countries      = $country->where(DB::raw('LOWER(name)'), 'LIKE', '%'.strtolower($name).'%')->get();
    return $countries;
}]);

Route::get('/users/{name?}', ['as' => 'member.lists', 'middleware' => ['auth'], function (DB $database, $name = null) {
    $members            = $database::table('users')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->join('roles', function($join) {
            $join->on('role_user.role_id', '=', 'roles.id')
                ->whereIn('roles.name', ['users']);
        })->select('users.id', 'users.name', 'users.phone_number', 'users.email')
        ->where(DB::raw('LOWER(users.name)'), 'LIKE', '%'.strtolower($name).'%')
        ->orWhere(DB::raw('LOWER(users.email)'), 'LIKE', '%'.strtolower($name).'%')
        ->get();

    return $members;
}]);


/**
 * get data with restangular with prefix 'ajaib'
 */
Route::group(['prefix' => 'ajaib'], function() {
    Route::get('/country/{name?}', ['as' => 'country.list', function(App\Country $country, $name = null) {
        $countries      = $country->where(DB::raw('LOWER(name)'), 'LIKE', '%'.strtolower($name).'%')->get();
        return $countries;
    }]);

    Route::get('/user/{name?}', ['as' => 'member.lists', 'middleware' => ['auth'], function (DB $database, $name = null) {
        $members            = $database::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', function($join) {
                $join->on('role_user.role_id', '=', 'roles.id')
                    ->whereIn('roles.name', ['users']);
            })->select('users.id', 'users.name', 'users.phone_number', 'users.email')
            ->where(DB::raw('LOWER(users.name)'), 'LIKE', '%'.strtolower($name).'%')
            ->orWhere(DB::raw('LOWER(users.email)'), 'LIKE', '%'.strtolower($name).'%')
            ->get();

        return $members;
    }]);
});



/**
 * pre-angular method
 */
Route::get('/partials/index', function () {
    return view('partials.index');
});

// if restful 
Route::get('/partials/{category}/{action?}', function ($category, $action = 'index') {
    return view(join('.', ['partials', $category, $action]));
});
Route::get('/partials/{category}/{id}/{action}', function ($category, $action = 'index', $id) {
    return view(join('.', ['partials', $category, $id]));
})->where('id', '[0-9]+');

Route::get('/partials/{category}/{action}/{id}', function ($category, $action = 'index', $id) {
    return view(join('.', ['partials', $category, $action]));
})->where('action', '[A-Za-z]+');
// end if restful

// Catch all undefined routes. Always gotta stay at the bottom since order of routes matters.
// Route::any('{undefinedRoute}', function ($undefinedRoute) {
//     return view('layout');
// })->where('undefinedRoute', '([A-z\d-\/_.]+)?');