<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \LucaDegasperi\OAuth2Server\Middleware\OAuthExceptionHandlerMiddleware::class,
        // \App\Http\Middleware\VerifyCsrfToken::class,
        \App\Http\Middleware\ForceSSL::class,
        \App\Http\Middleware\AuthTimeOut::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        /**
         * Entrust
         */
        // 'role'          => 'Zizaco\Entrust\Middleware\EntrustRole',
        // 'permission'    => 'Zizaco\Entrust\Middleware\EntrustPermission',
        // 'ability'       => 'Zizaco\Entrust\Middleware\EntrustAbility',
        'role'          => \Zizaco\Entrust\Middleware\EntrustRole::class,
        'permission'    => \Zizaco\Entrust\Middleware\EntrustPermission::class,
        'ability'       => \Zizaco\Entrust\Middleware\EntrustAbility::class,
        /**
         * Oauth
         */
        'oauth'         => \LucaDegasperi\OAuth2Server\Middleware\OAuthMiddleware::class,
        'oauth-user'    => \LucaDegasperi\OAuth2Server\Middleware\OAuthUserOwnerMiddleware::class,
        'oauth-client'  => \LucaDegasperi\OAuth2Server\Middleware\OAuthClientOwnerMiddleware::class,
        'check-authorization-params' => \LucaDegasperi\OAuth2Server\Middleware\CheckAuthCodeRequestMiddleware::class,
        'csrf'          => \App\Http\Middleware\VerifyCsrfToken::class,
        /**
         * Force SSL
         */
        'force.ssl' => \App\Http\Middleware\ForceSSL::class,
    ];
}
