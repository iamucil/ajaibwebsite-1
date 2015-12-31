<?php
Route::group(['module' => 'Oauth', 'namespace' => 'App\Modules\Oauth\Controllers'], function() {

    Route::group(['prefix' => 'api/v1/oauth', 'as' => 'oauth::'], function () {
        Route::post('/grant_access', ['as' => 'grant_access', 'uses' => 'OauthController@grantAccess']);

        Route::post('/access_token', function() {
            $result         = Authorizer::issueAccessToken();
            return Response::json($result);
        });
    });

    Route::group(['prefix' => 'oauth', 'as' => 'api.auth.'], function () {
        Route::get('/authorize', ['as' => 'oauth.authorize.get', 'middleware' => ['check-authorization-params', 'auth'], function() {
            $authParams                 = Authorizer::getAuthCodeRequestParams();

            $formParams                 = array_except($authParams,'client');

            $formParams['client_id']    = $authParams['client']->getId();

            $formParams['scope']        = implode(config('oauth2.scope_delimiter'), array_map(function ($scope) {
                return $scope->getId();
            }, $authParams['scopes']));

            return View::make('Oauth::authorization-form', ['params' => $formParams, 'client' => $authParams['client']]);
        }]);

        Route::post('authorize', ['as' => 'oauth.authorize.post', 'middleware' => ['csrf', 'check-authorization-params', 'auth'], function() {

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

    });
});
