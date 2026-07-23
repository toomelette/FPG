<?php

namespace App\Providers;

use App\Models\QueryLogs;
use App\Swep\Helpers\Helper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::if('canAccess', function ($routeName = null) {
            if(!$routeName){
                $routeName = \Route::currentRouteName();
            }
            return Helper::canAccess($routeName);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
