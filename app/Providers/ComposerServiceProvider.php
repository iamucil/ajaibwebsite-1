<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Routing\Route;
use App\User;
use App\Country;
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
            $routing    = \Route::current();
            $user       = null;
            $country    = Country::where('iso_3166_2', '=', 'ID')
                ->get(['calling_code', 'id'])
                ->first();
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

            // PAM_PUBNUB_KEY -> using pubnub access manager
            // PUBNUB_KEY -> without access manager

            JavaScript::put([
                'authUser' => $user,
                'authRoles' => $user->roles,
                'pubnub_key' => env('PAM_PUBNUB_KEY'),
                'subnub_key' => env('PAM_SUBNUB_KEY'),
                'skey' => env('PAM_SECRET_KEY'),
                'public_channel' => env('PUBLIC_CHANNEL')
            ]);

            $view->with(['authUser' => $user, 'country' => $country, 'routing' => $routing]);
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
