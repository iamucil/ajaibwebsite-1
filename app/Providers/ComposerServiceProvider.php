<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User;
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
                $user->gender   = $user->gender ?: 'male';
                if(is_null($user->photo))
                {
                    if($user->gender == 'female') {
                        $user->photo = secure_asset("/img/avatar_female.png");
                    }else{
                        $user->photo = secure_asset("/img/avatar_male.png");
                    }
                }else{
                    $user->photo = '/profile/photo/'.$id;
                }
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
