<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JavaScript;
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.dashboard', function ($view) {
            $user       = null;
            if(auth()->check()) {
                $user   = auth()->user();
            }
            JavaScript::put([
                'authUser' => $user,
                'authRoles' => $user->roles,
            ]);

            $view->with('authUser', $user);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
